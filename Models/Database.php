<?php

/**
 * Database connection class (singleton) invoked by TableAbstract.php.
 * User: Tim Tyler
 * Date: 01/12/2015
 */
class Database
{
    protected static $instance = null;
    protected $dbh;

    /*
    // Local Connection on XAMPP
    private $username = 'ttdvd';
    private $password = 'ttdvd';
    private $host = 'localhost';
    private $dbname = 'ttdvd';
    // University Helios server
    private $username = 'stb082';
    private $password = 'ttdvd4ever';
    private $host = 'helios.csesalford.com';
    private $dbname = 'stb082_ssp_assignment_1';
    */

    private function __construct($username, $password, $host, $dbname){
        try {
            // creates the database handler with connection info
            $this->dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // Further prevent SQL injection.
        } catch (PDOException $e) {
            echo($e->getMessage());
        }
    }

    public static function getInstance(){
        $username = 'stb082';
        $password = 'ttdvd4ever';
        $host = 'helios.csesalford.com';
        $dbname = 'stb082_ssp_assignment_1';


        if (self::$instance === null) { //checks if the object exists
            // creates new instance if not, sending in connection info
            self::$instance = new self($username, $password, $host, $dbname);
        }

		return self::$instance;
	}

    public function getDbh() {
        return $this->dbh; // returns the database handler to be used elsewhere
    }

    public function __destruct() {
        $this->dbh = null; // destroys the database handler when no longer needed
    }

}