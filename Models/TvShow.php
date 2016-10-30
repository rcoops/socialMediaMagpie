<?php

/**
 * Created by PhpStorm.
 * User: rcooper
 * Date: 30/10/2016
 * Time: 00:49
 */
class TvShow {

    protected $showName, $hashtag;

    public function __construct($dbrow) {
        $this->id = $dbrow['id'];
        $this->showName = $dbrow['name'];
        $this->hashtag = $dbrow['hashtag'];
    }

    public function getId() {
        return $this->id;
    }

    public function getShowName() {
        return $this->showName;
    }

    public function getHashtag() {
        return $this->hashtag;
    }

}