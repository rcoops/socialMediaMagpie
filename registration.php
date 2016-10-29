<?php
require_once 'models/MembersTable.php';
require_once 'models\Member.php';
/**
 * Registration page for members to register with website. Users are unable to rent
 * movies until registered and logged in.
 * User: Tim Tyler
 * Date: 01/12/2015
 */
session_start();
$view = new StdClass();
$view->pageTitle = 'Registration - TTDVD';

$validator = new StdClass();
$validator->isValid = true;
$validator->saved = false;
$validator->already_registered = false;

if (isset($_POST['submit'])) {

    // Validate input and set isValid to false with appropriate error msg if any errors found.
    if (strlen($_POST['firstName']) < 1) {
        $validator->isValid = false;
        $validator->firstName = "First name field is empty, try again.";
    }
    if (strlen($_POST['lastName']) < 1) {
        $validator->isValid = false;
        $validator->lastName = "Last name field is empty, try again.";
    }
    if (strlen($_POST['street']) < 1) {
        $validator->isValid = false;
        $validator->street = "Street name field is empty, try again.";
    }
    if (strlen($_POST['city']) < 1) {
        $validator->isValid = false;
        $validator->city = "City field is empty, try again.";
    }
    if (strlen(str_replace(' ', '', $_POST['postcode'])) < 5 || strlen(str_replace(' ', '', $_POST['postcode'])) > 7) {
        $validator->isValid = false;
        $validator->postcode = "Postcode should be between 5 and 6 characters, try again.";
    }
    if (strlen($_POST['password1']) < 6) {
        $validator->isValid = false;
        $validator->password = "Password length is less than 6 characters, try again.";
    }
    if ($_POST['password1'] !== $_POST['password2']) {
        $validator->isValid = false;
        $validator->password = "Password doesn't match, try again.";
    }
    if (!is_numeric($_POST['mobile']) || strlen($_POST['mobile']) !== 11) {
        $validator->isValid = false;
        $validator->mobile = "Mobile number is not valid, enter an 11 digit number.";
    }
    if (!is_numeric($_POST['house'])) {
        $validator->isValid = false;
        $validator->house = "House number is not valid, enter a number.";
    }
    if (strpos($_POST['email'], '@') === FALSE || strlen($_POST['email']) < 3) {
        $validator->isValid = false;
        $validator->house = "Email address is not valid, enter a valid email address.";
    }

    // Validation passed.
    if ($validator->isValid === true) {
        $members_table = new MembersTable();
        $digest = password_hash($_POST['password1'], PASSWORD_BCRYPT); // Encrypt with random salt

        $member = new Member($_POST['email'], $_POST['title'], $_POST['firstName'],
            $_POST['lastName'], $digest, str_replace(' ', '', $_POST['mobile']),
            $_POST['house'], $_POST['street'], $_POST['city'], str_replace(' ', '', $_POST['postcode']));

        // Check whether email address already registered.
        if ($members_table->login_member($member) < 2){
            $validator->already_registered = true;
        } else {
            if ($members_table->create_member($member)) {
                $validator->saved = true;
                $_SESSION['member'] = $member;
                $_SESSION['basket'] = array();
            } else {
                // registration failed
                $validator->saved = false;
            }
        }
    }
}

require_once 'views/registration.phtml';