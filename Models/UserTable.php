<?php

/**
 * Created by PhpStorm.
 * User: rcooper
 * Date: 30/10/2016
 * Time: 01:10
 */

require_once __DIR__ . '/TableAbstract.php';

class UserTable extends TableAbstract
{
    protected $name = 'users';

    public function fetchAllUsers() {
        $results = $this->fetch_all();
        $userArray = array();
        while ($row = $results->fetch()) {
            $userArray[] = new User($row);
        }
        return $userArray;
    }
}