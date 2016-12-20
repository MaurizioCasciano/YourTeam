<?php
namespace AppBundle\it\unisa\contenuti;

/**
 * Created by PhpStorm.
 * User: Carmine
 * Date: 20/12/2016
 * Time: 11:48
 */
use AppBundle\Utility\DB;

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
        $sql = "INSERT INTO contenuto(squadra,titolo,descrizione,URL,tipo)
        VALUES ('".$contenuto->getSquadra()."','"
            .$contenuto->getTitolo()."','"
            .$contenuto->getDescrizione()."','"
            .$contenuto->getURL()."','"
            .$contenuto->getTipo()."');";

        $ris = $this->conn->query($sql);
        if(!$ris) throw new \Exception(("errore inserimento dati nel db"));
    }
}