<?php

/**
 * Created by PhpStorm.
 * User: rcooper
 * Date: 30/10/2016
 * Time: 01:23
 */
class User
{
    protected $userName, $password;

    public function __construct($dbrow) {
        $this->id = $dbrow['id'];
        $this->userName = $dbrow['user_name'];
        $this->password = $dbrow['password'];;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function getPassword()
    {
        return $this->password;
    }


}