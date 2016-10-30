<?php
/**
 * Created by PhpStorm.
 * User: rcooper
 * Date: 30/10/2016
 * Time: 00:30
 */

require_once __DIR__ . '/TableAbstract.php';

class TweetTable extends TableAbstract {

    protected $name = 'tweets';

    public function fetchAllTweets() {
        $results = $this->fetch_all();
        $tweetArray = array();
        while ($row = $results->fetch()) {
            $tweetArray[] = new Tweet($row);
        }
        return $tweetArray;
    }
}