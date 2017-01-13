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


    public function connect()
    {
        //$conn = new \mysqli("mysql3.gear.host", "yourteam", "P@ssw0rd", "yourteam");

        $host = getenv("YOURTEAM_DB_HOST");
        $username = getenv("YOURTEAM_DB_USER");
        $password = getenv("YOURTEAM_DB_PASSWORD");
        $dbname = getenv("YOURTEAM_DB_NAME");
        $port = getenv("YOURTEAM_DB_PORT");

        //var_dump($host);
        //var_dump($username);
        //var_dump($password);
        //var_dump($dbname);
        //var_dump($port);

        //$host, $username, $passwd, $dbname, $port, $socket
        //$conn = new \mysqli("127.0.0.1", "root", "root", "yourteam", 3306);
        $conn = new \mysqli($host, $username, $password, $dbname, $port);
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