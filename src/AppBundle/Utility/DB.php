<?php

/**
 * Created by PhpStorm.
 * User: Raffaele
 * Date: 18/11/2016
 * Time: 08:28
 */
namespace AppBundle\Utility;

class DB
{
    private $host;
    private $username;
    private $password;
    private $dbname;
    private $port;
    private static $instance = null;

    private function __construct()
    {
        $this->host = getenv("YOURTEAM_DB_HOST");
        $this->username = getenv("YOURTEAM_DB_USER");
        $this->password = getenv("YOURTEAM_DB_PASSWORD");
        $this->dbname = getenv("YOURTEAM_DB_NAME");
        $this->port = getenv("YOURTEAM_DB_PORT");

        /*
         * Nel caso in cui non siano state settate le variabili di ambiente, vengono utilizzati i valori di default.
         */
        if (!($this->host && $this->username && $this->password && $this->dbname && $this->port)) {
            $this->host = "mysql3.gear.host";
            $this->username = "yourteam";
            $this->password = "P@ssw0rd";
            $this->dbname = "yourteam";
            $this->port = 3306;
        }
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function connect()
    {
        $conn = new \mysqli($this->host, $this->username, $this->password, $this->dbname, $this->port);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        } else {
            return $conn;
        }
    }

    public function close($con)
    {
        $con->close();
    }
}