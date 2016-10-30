<?php

/**
 * Created by PhpStorm.
 * User: rcooper
 * Date: 30/10/2016
 * Time: 00:47
 */
class Tweet
{
    protected $tweet, $tvShow;

    public function __construct($dbrow) {
        $this->id = $dbrow['id'];
        $this->tweet = $dbrow['tweet'];
        $this->tvShow = $dbrow['tvshow'];
    }

    public function getId() {
        return $this->id;
    }

    public function getTweet() {
        return $this->tweet;
    }

    public function getTvShow() {
        return $this->tvShow;
    }

}