<?php
require_once 'models\MoviesTable.php';
require_once 'models\Member.php';

/**
 * Home page of website, displays Bootstrap carousel of newest movies in database.
 * User: Tim Tyler
 * Date: 01/12/2015
 */

session_start();
$movies_table = new MoviesTable();

if (!isset($_SESSION['basket'])){
    $_SESSION['basket'] = array();
}
$view = new stdClass();
$view->pageTitle = 'Homepage - TTDVD';

$view->carousel = $movies_table->filter_latest_movies();
usort($view->carousel, "cmp_year");

/* The SQL query already sorts Movie objects by year of release in descending order but the
 comparator assigns a new index in order from zero, required for carousel identifier features. */
function cmp_year($a, $b)
{
    return strcmp($b->getYear(), $a->getYear());
}

require_once('Views/index.phtml');
