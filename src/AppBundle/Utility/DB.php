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


    public  function connect()
    {
        $conn = new \mysqli("localhost","root", "", "yourteam");

    // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }else{
        return $conn;
        }
    }
    public function close($con){
        $con->close();
    }

}