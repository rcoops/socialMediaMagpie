<?php
require_once 'Models/MembersTable.php';
require_once 'Models/MoviesTable.php';
require_once 'Models/Member.php';
/**
 * Member login page, can display login issues message on page and offers link to register for new members.
 * User: Tim Tyler
 * Date: 01/12/2015
 */

session_start();

$view = new StdClass;
$movies_table = new MoviesTable();
$members_table = new MembersTable();

// Member not logged in and session not setup yet.
if (!isset($_SESSION['member'])){
    $view->login_error_code = -1;
    $view->pageTitle = 'Login - TTDVD';
}
// Logout button hit
else if (isset($_POST['logout'])){
    unset($_SESSION['member']);
    unset($_SESSION['basket']);
    $view->login_error_code = -1;
    $view->pageTitle = 'Login - TTDVD';
}
// Member logged in and requires the standard 'you are logged in' message setting.
else {
    $view->pageTitle = 'Member\'s Area - TTDVD';
    $member = $_SESSION['member'];
    $view->loginMsg = 'You are logged in as ' . $member->getFirstName()
        . ' ' . $member->getLastName() . ', to log out hit the "Log Out" button.';
    if (isset($_GET['movie_id'])){
        $movies_table->update_movie_rental_status(null, $_GET['movie_id']);
    }
    $view->rentals = $movies_table->fetch_current_rentals_by_member($member->getEmail());
}
// Attempt new login
if (isset($_POST['login'])) {
    /* NOTE: password is saved in DB as a hash - this new member object is a temp placeholder to allow model access to
    user entered fields.*/
    $member = new Member($_POST['email'], null, null, null, $_POST['password'],
        null, null, null, null, null);

    // Query whether email address is registered and password matches the recorded hash.
    $view->login_error_code = $members_table->login_member($member);
    if ($view->login_error_code == 0) {
        $member = $members_table->fetch_member($member->getEmail()); // Properly constructed Member object.
        $_SESSION['member'] = $member;
        $_SESSION['basket'] = array();
        $_SESSION['paid'] = false;
        $view->rentals = $movies_table->fetch_current_rentals_by_member($member->getEmail());
        $view->loginMsg = 'Welcome back ' . $member->getFirstName()
            . ' ' . $member->getLastName() . ', we missed you! To log out hit the "Log Out" button.';
        // Set cookie for 1 year if box is checked
        if (isset($_POST['remember'])){
            setcookie('username', $_POST['email'], time() + 31536000);
            setcookie('password', $_POST['password'], time() + 31536000);
        }
    } elseif ($view->login_error_code == 1) {
        $view->loginMsg = 'The username and password do not match, please try again.';
    } elseif ($view->login_error_code == 2){
        $view->loginMsg = 'The username was not found, please try again or register as new member.';
    }
}

require_once 'views/login.phtml';