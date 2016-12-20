<?php

/**
 * Created by PhpStorm.
 * User: Carmine
 * Date: 20/12/2016
 * Time: 11:48
 */
class GestioneContenuti
{

    private $conn;
    private $db;

    public function __construct()
    {
        $this->db=new DB();
        $this->conn=$this->db->connect();
    }

    public function inserisciContenuto(Contenuto $contenuto){

    }
}