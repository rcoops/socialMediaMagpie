<?php

/**
 * Created by PhpStorm.
 * User: rcooper
 * Date: 30/10/2016
 * Time: 00:50
 */

require_once __DIR__ . '/TableAbstract.php';

class TvShowTable extends TableAbstract {

    protected $name = 'tvshows';

    public function fetchAllTvShows() {
        $results = $this->fetch_all();
        $tvshowArray = array();
        while ($row = $results->fetch()) {
            $tvshowArray[] = new TvShow($row);
        }
        return $tvshowArray;
    }

}