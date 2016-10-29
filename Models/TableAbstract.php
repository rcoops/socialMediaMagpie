<?php
require_once 'Database.php';
require_once 'Movie.php';
/**
 * Abstract superclass for all table classes - most commonly used function is return_movie_object($movie_id).
 * User: Tim Tyler
 * Date: 16/12/2015
 */
abstract class TableAbstract {

    protected $name;
    protected $primaryKey = 'id';
    protected $dbh, $db;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->dbh = $this->db->getDbh();
    }

    public function fetch_all() {
        $sql = 'SELECT * FROM ' . $this->name;
        $results = $this->dbh->prepare($sql);
        $results->execute();
        return $results->fetchAll();
    }

    public function fetch_by_primaryKey($key) {
        $sql = 'SELECT * FROM ' . $this->name . ' WHERE ' . $this->primaryKey . ' = :id LIMIT 1';
        $results = $this->dbh->prepare($sql);
        $results->execute(array(':id' => $key));
        return $results->fetch();
    }

    /* For building and returning a movie object from the database. */
    function return_movie_object($movie_id){
        $params = array(':movie_id' => $movie_id);

        $sql = "SELECT * FROM movies WHERE movie_id = :movie_id";
        $result_from_movies = $this->dbh->prepare($sql);
        $result_from_movies->execute($params);
        $movie = $result_from_movies->fetchAll();

        $sql = "SELECT actor_name FROM cast WHERE movie_id = :movie_id";
        $result_from_cast = $this->dbh->prepare($sql);
        $result_from_cast->execute($params);
        $cast = $result_from_cast->fetchAll();

        $sql = "SELECT genre_type FROM genre WHERE movie_id = :movie_id";
        $result_from_genres = $this->dbh->prepare($sql);
        $result_from_genres->execute($params);
        $genres = $result_from_genres->fetchAll();

        if ($result_from_movies->errorCode() == 00000
            && $result_from_cast->errorCode() == 00000
            && $result_from_genres->errorCode() == 00000)
        {
            return new Movie($movie_id, $movie[0]['title'],$movie[0]['director'],$movie[0]['year'],
                $movie[0]['synopsis'],$movie[0]['price_band'],$movie[0]['cover'],
                $movie[0]['imdb'],$movie[0]['rental_status'],$movie[0]['running_time'],$cast,$genres);
        } else {
            return null;
        }
    }
}
