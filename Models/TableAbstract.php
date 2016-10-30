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
        return $results;
    }

    public function fetch_by_primaryKey($key) {
        $sql = 'SELECT * FROM ' . $this->name . ' WHERE ' . $this->primaryKey . ' = :id LIMIT 1';
        $results = $this->dbh->prepare($sql);
        $results->execute(array(':id' => $key));
        return $results->fetch();
    }
}
