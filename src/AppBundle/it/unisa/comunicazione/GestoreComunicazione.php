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


            $sql = "INSERT INTO messaggio (testo,allenatore,calciatore,mittente,data,tipo) 
                VALUES ('" . $msg->getTesto() . "','"
                . $msg->getAllenatore() . "','"
                . $msg->getCalciatore() . "','"
                . $msg->getMittente() . "','"
                . $msg->getData() . "','"
                . $msg->getTipo(). "');";
        $ris = $this->conn->query($sql);
        if(!$ris) throw new \Exception(("errore inserimento dati nel db"));
    }


    public function ottieniMessaggiCalciatore($calciatore,$tipo){
        if($calciatore==null)throw new \Exception("Messaggio non trovato");
        $messaggi=array();
        $sql="SELECT * from messaggio WHERE calciatore='$calciatore' and tipo='$tipo'";
        $result = $this->conn->query($sql);
        $res="";
        $i=0;
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                /*$t, $u, $c, $mitt,$data,$tipo*/
                $m=new Messaggio($row["testo"],$row["allenatore"],$row["calciatore"],$row["mittente"],$row["data"],$row["tipo"]);
                $m->setId($row["id"]);
                $messaggi[$i]=$m;
                $i++;
            }
            return $messaggi;
        } else
            throw new \Exception("non esistono messaggi");



    }

    public function __destruct()
    {
        $this->db->close($this->conn);
    }

}