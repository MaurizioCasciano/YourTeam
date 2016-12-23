<?php

namespace AppBundle\it\unisa\comunicazione;

use AppBundle\it\unisa\account\GestoreAccount;
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
        $this->db = new DB();
        $this->conn = $this->db->connect();
    }

    public function inviaMessaggio(Messaggio $msg)
    {
        /*controlliamo che l'account non sia null(controllo piuttosto inutile)*/
        if ($msg == null) throw new \Exception("valore nullo");

        $sql = "INSERT INTO messaggio (testo,allenatore,calciatore,mittente,data,tipo) 
                VALUES ('" . $msg->getTesto() . "','"
            . $msg->getAllenatore() . "','"
            . $msg->getCalciatore() . "','"
            . $msg->getMittente() . "','"
            . $msg->getData() . "','"
            . $msg->getTipo() . "');";
        $ris = $this->conn->query($sql);
        if (!$ris) throw new \Exception(("errore inserimento dati nel db"));
    }


    public function ottieniMessaggiCalciatore($calciatore, $tipo)
    {
        if ($calciatore == null) throw new \Exception("Messaggio non trovato");
        $messaggi = array();
        $sql = "SELECT * from messaggio WHERE calciatore='$calciatore' and tipo='$tipo'";
        $result = $this->conn->query($sql);
        $i = 0;
        if ($result->num_rows > 0) { //se la query ha dato risultato
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                /*$t, $u, $c, $mitt,$data,$tipo*/
                $m = new Messaggio($row["testo"], $row["allenatore"], $row["calciatore"], $row["mittente"], $row["data"], $row["tipo"]);
                $m->setId($row["id"]);
                $messaggi[$i] = $m;
                $i++;
            }
            return $messaggi;
        } else
            throw new \Exception("non esistono messaggi");


    }

    /**
     * Restituisce l'array di oggetti Messaggio inviati dall'allenatore al calciatore, ordinati per data.
     * @param $allenatore
     * @param $tipo
     * @param $calciatoreDestinatario
     * @return array
     * @throws \Exception
     */
    public function ottieniMessaggiAllenatore($allenatore, $tipo, $calciatoreDestinatario)
    {
        if ($allenatore == null) throw new \Exception("Messaggio non trovato");
        $messaggi = array();
        $sql = "SELECT * from messaggio WHERE allenatore='$allenatore' and tipo='$tipo' AND calciatore = $calciatoreDestinatario ORDER BY data;";

        $result = $this->conn->query($sql);
        $i = 0;
        if ($result->num_rows > 0) { //se la query ha dato risulatato
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                /*$t, $u, $c, $mitt,$data,$tipo*/
                $m = new Messaggio($row["testo"], $row["allenatore"], $row["calciatore"], $row["mittente"], $row["data"], $row["tipo"]);
                $m->setId($row["id"]);
                $messaggi[$i] = $m;
                $i++;

                $g = new GestoreAccount();
                $accountAllenatore = $g->ricercaAccount_A_T_S($allenatore);

                $accountCalciatore = $g->ricercaAccount_G($calciatoreDestinatario);

                $m->setNomeMittente($accountAllenatore->getNome());
                $m->setCognomeMittente($accountAllenatore->getCognome());

                $m->setNomeDestinatario($accountCalciatore->getNome());
                $m->setCognomeDestinatario($accountCalciatore->getCognome());
            }
            return $messaggi;
        } else
            throw new \Exception("non esistono messaggi");
    }

    public function ottieniMessaggioComportamento($allenatore, $tipo, $calciatoreDestinatario, $testo_comportamento){
        if ($allenatore == null) throw new \Exception("Messaggio non trovato");
        $messaggi = array();
        $sql = "SELECT * from messaggio WHERE allenatore='$allenatore' and tipo='$tipo' AND calciatore = $calciatoreDestinatario ORDER BY data;";

        $result = $this->conn->query($sql);
        $i = 0;
        if ($result->num_rows > 0) { //se la query ha dato risulatato
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                /*$t, $u, $c, $mitt,$data,$tipo*/
                $m = new Messaggio($row["testo"], $row["allenatore"], $row["calciatore"], $row["mittente"], $row["data"], $row["tipo"]);
                $m->setId($row["id"]);
                $messaggi[$i] = $m;
                $i++;

                $g = new GestoreAccount();
                $accountAllenatore = $g->ricercaAccount_A_T_S($allenatore);

                $accountCalciatore = $g->ricercaAccount_G($calciatoreDestinatario);

                $m->setTesto($testo_comportamento);

                $m->setNomeMittente($accountAllenatore->getNome());
                $m->setCognomeMittente($accountAllenatore->getCognome());

                $m->setNomeDestinatario($accountCalciatore->getNome());
                $m->setCognomeDestinatario($accountCalciatore->getCognome());
            }
            return $messaggi;
        } else
            throw new \Exception("non esistono messaggi");


    }

    /**
     * @param $squadra
     * @return array
     */
    public function getCalciatoriPerSquadra($squadra)
    {
        $statement = $this->conn->prepare("SELECT * FROM calciatore WHERE squadra = ?;");

        $statement->bind_param("s", $squadra);
        $statement->execute();
        $result = $statement->get_result();

        $calciatori = array();
        while ($row = $result->fetch_assoc()) {
            $calciatori[] = $row["contratto"];
        }

        return $calciatori;
    }

    public function __destruct()
    {
        $this->db->close($this->conn);
    }

}