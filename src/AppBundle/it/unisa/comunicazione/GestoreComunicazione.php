<?php

namespace AppBundle\it\unisa\comunicazione;

use AppBundle\Utility\DB;

/**
 * Created by PhpStorm.
 * User: Donato
 * Date: 20/12/2016
 * Time: 11:46
 */
class GestoreComunicazione
{
    private $conn;
    private $db;

    public function __construct()
    {
        $this->db=new DB();
        $this->conn=$this->db->connect();
    }

    public function inviaMessaggio(Messaggio $msg){


        /*controlliamo che l'account non sia null(controllo piuttosto inutile)*/
        if($msg==null)throw new \Exception("valore nullo");


            $sql = "INSERT INTO messaggio (testo,username,calciatore,mittente) 
                VALUES ('" . $msg->getTesto() . "','"
                . $msg->getUsername() . "','"
                . $msg->getCalciatore() . "','"
                . $msg->getMittente(). "');";
        $ris = $this->conn->query($sql);
        if(!$ris) throw new \Exception(("errore inserimento dati nel db"));
    }



    public function ottieniMessaggio(Messaggio $msg){
        if($msg==null)throw new \Exception("Messaggio non trovato");

        $sql = "SELECT * FROM messaggio";
        $res = $this->conn->query($sql);

        if($res->num_rows <= 0) throw new \Exception("Messaggio non esiste");
        $row = $res->fetch_assoc();
        $messaggio = new Messaggio($row["mittente"],$row["destinatario"], $row["testo"]);

        return $messaggio;
    }

    public function __destruct()
    {
        $this->db->close($this->conn);
    }

}