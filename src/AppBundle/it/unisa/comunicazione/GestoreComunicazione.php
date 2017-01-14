<?php

namespace AppBundle\it\unisa\comunicazione;

use AppBundle\it\unisa\account\Account;
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
    private static $instance = null;

    private function __construct()
    {
        $this->db = DB::getInstance();
        $this->conn = $this->db->connect();
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

    public function inviaMessaggio(Messaggio $msg)
    {
        if ($msg == null) throw new \Exception("valore nullo");

        $sql = "INSERT INTO messaggio (testo,allenatore,calciatore,mittente,data,tipo) 
                VALUES ('" . $msg->getTesto() . "','"
            . $msg->getAllenatore() . "','"
            . $msg->getCalciatore() . "','"
            . $msg->getMittente() . "','"
            . $msg->getData() . "','"
            . $msg->getTipo() . "');";
        $ris = $this->conn->query($sql);
        if (!$ris) throw new \Exception(("errore inserimento dati nel db " . $this->conn->error));
    }




    public function ottieniMessaggiCalciatore($calciatore, $tipo)
    {
        if ($calciatore == null) throw new \Exception("Messaggio non trovato");
        $messaggi = array();
        $sql = "SELECT * from messaggio WHERE calciatore='$calciatore' and tipo='$tipo' ORDER BY data;";

        $result = $this->conn->query($sql);
        $i = 0;
        if ($result->num_rows > 0) { //se la query ha dato risulatato
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                /*$t, $u, $c, $mitt,$data,$tipo*/
                $messaggio = new Messaggio($row["testo"], $row["allenatore"], $row["calciatore"], $row["mittente"], $row["data"], $row["tipo"]);
                $messaggio->setId($row["id"]);
                $messaggi[$i] = $messaggio;
                $i++;

                $gestoreAccount = GestoreAccount::getInstance();
                $accountAllenatore = $gestoreAccount->ricercaAccount_A_T_S($row["allenatore"]);
                $accountCalciatore = $gestoreAccount->ricercaAccount_G($row["calciatore"]);

                if ($messaggio->getMittente() == "allenatore") {
                    $messaggio->setNomeMittente($accountAllenatore->getNome());
                    $messaggio->setCognomeMittente($accountAllenatore->getCognome());

                    $messaggio->setNomeDestinatario($accountCalciatore->getNome());
                    $messaggio->setCognomeDestinatario($accountCalciatore->getCognome());
                } else if ($messaggio->getMittente() == "calciatore") {
                    $messaggio->setNomeMittente($accountCalciatore->getNome());
                    $messaggio->setCognomeMittente($accountCalciatore->getCognome());

                    $messaggio->setNomeDestinatario($accountAllenatore->getNome());
                    $messaggio->setCognomeDestinatario($accountAllenatore->getCognome());
                }
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
        $sql = "SELECT * from messaggio WHERE allenatore='$allenatore' and tipo='$tipo' ORDER BY data;";

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

                $g = GestoreAccount::getInstance();
                $accountAllenatore = $g->ricercaAccount_A_T_S($allenatore);

                $accountCalciatore = $g->ricercaAccount_G($calciatoreDestinatario);

                if ($m->getMittente() == "allenatore") {
                    $m->setNomeMittente($accountAllenatore->getNome());
                    $m->setCognomeMittente($accountAllenatore->getCognome());

                    $m->setNomeDestinatario($accountCalciatore->getNome());
                    $m->setCognomeDestinatario($accountCalciatore->getCognome());
                } else if ($m->getMittente() == "calciatore") {
                    $m->setNomeMittente($accountCalciatore->getNome());
                    $m->setCognomeMittente($accountCalciatore->getCognome());

                    $m->setNomeDestinatario($accountAllenatore->getNome());
                    $m->setCognomeDestinatario($accountAllenatore->getCognome());
                }

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
    public function ottieniMessaggi($allenatore, $tipo, $calciatoreDestinatario)
    {
        if ($allenatore == null) throw new \Exception("Messaggio non trovato");
        $messaggi = array();
        $sql = "SELECT * from calciatore WHERE allenatore.squadra=calciatore.squadra;";

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

                $g = GestoreAccount::getInstance();
                $accountAllenatore = $g->ricercaAccount_A_T_S($allenatore);

                $accountCalciatore = $g->ricercaAccount_G($calciatoreDestinatario);

                if ($m->getMittente() == "allenatore") {
                    $m->setNomeMittente($accountAllenatore->getNome());
                    $m->setCognomeMittente($accountAllenatore->getCognome());

                    $m->setNomeDestinatario($accountCalciatore->getNome());
                    $m->setCognomeDestinatario($accountCalciatore->getCognome());
                } else if ($m->getMittente() == "calciatore") {
                    $m->setNomeMittente($accountCalciatore->getNome());
                    $m->setCognomeMittente($accountCalciatore->getCognome());

                    $m->setNomeDestinatario($accountAllenatore->getNome());
                    $m->setCognomeDestinatario($accountAllenatore->getCognome());
                }

            }
            return $messaggi;
        } else
            throw new \Exception("non esistono messaggi");
    }

    public function ottieniMessaggioComportamento($allenatore, $calciatoreDestinatario, $testo_comportamento){
        if ($allenatore == null) throw new \Exception("Messaggio non trovato");
        $messaggi = array();
        $sql = "SELECT * from calciatore WHERE allenatore.squadra=calciatore.squadra;";

        $result = $this->conn->query($sql);
        $i = 0;
           //if ($result->num_rows > 0) {
           //    while ($row = $result->fetch_assoc()) {
           //    /*$t, $u, $c, $mitt,$data,$tipo*/
           //        $m = new Messaggio($row["testo"], $row["allenatore"], $row["calciatore"], $row["mittente"], $row["data"], $row["tipo"]);
          //       $m->setId($row["id"]);
          //       $messaggi[$i] = $m;
          //        $i++;

        //       $g = new GestoreAccount();
        //       $accountAllenatore = $g->ricercaAccount_A_T_S($allenatore);

        //         $accountCalciatore = $g->ricercaAccount_G($calciatoreDestinatario);

        //      $m->setTesto($testo_comportamento);

        //       $m->setNomeMittente($accountAllenatore->getNome());
        //     $m->setCognomeMittente($accountAllenatore->getCognome());

        //     $m->setNomeDestinatario($accountCalciatore->getNome());
        //       $m->setCognomeDestinatario($accountCalciatore->getCognome());
        //    }
        //    return $messaggi;
        // } else
        //     throw new \Exception("non esistono messaggi");
    }

    public function ottieniMessaggioSalute($allenatore, $calciatoreDestinatario, $testo_comportamento)
    {
        if ($allenatore == null) throw new \Exception("Messaggio non trovato");
        $messaggi = array();
        $sql = "SELECT * from calciatore WHERE allenatore.squadra=calciatore.squadra;";

        $result = $this->conn->query($sql);
        $i = 0;
        //if ($result->num_rows > 0) {
        //    while ($row = $result->fetch_assoc()) {
        //        /*$t, $u, $c, $mitt,$data,$tipo*/
        //        $m = new Messaggio($row["testo"], $row["allenatore"], $row["calciatore"], $row["mittente"], $row["data"], $row["tipo"]);
         //       $m->setId($row["id"]);
         //       $messaggi[$i] = $m;
        //        $i++;

         //       $g = new GestoreAccount();
         //       $accountAllenatore = $g->ricercaAccount_A_T_S($allenatore);

       //         $accountCalciatore = $g->ricercaAccount_G($calciatoreDestinatario);

          //      $m->setTesto($testo_comportamento);

         //       $m->setNomeMittente($accountAllenatore->getNome());
           //     $m->setCognomeMittente($accountAllenatore->getCognome());

           //     $m->setNomeDestinatario($accountCalciatore->getNome());
         //       $m->setCognomeDestinatario($accountCalciatore->getCognome());
        //    }
        //    return $messaggi;
       // } else
       //     throw new \Exception("non esistono messaggi");
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

    public function getAllenatorePerSquadra($squadra)
    {
        $statement = $this->conn->prepare("SELECT * FROM utente WHERE squadra = ?;");

        $squadra = $_SESSION["squadra"];
        $statement->bind_param("s", $squadra);
        if ($statement->execute()) {
            $result = $statement->get_result();

            if ($result->num_rows <= 0) {
                throw new \Exception("account allenatore squadra " . $squadra . "non esiste");
            }

            $row = $result->fetch_assoc();
            $user = new Account($row["username_codiceContratto"], $row["password"],
                $row["squadra"], $row["email"], $row["nome"],
                $row["cognome"], $row["datadinascita"], $row["domicilio"],
                $row["indirizzo"], $row["provincia"], $row["telefono"],
                $row["immagine"], $row["tipo"]);
            // se è un calciatore query cercare tutti i suoi ruoli->cra un ruolo
            return $user;
        }
    }

    public function __destruct()
    {
        $this->db->close($this->conn);
    }

    public function ottieniMessaggiRichiamoMulta($calciatore){
        if ($calciatore == null) throw new \Exception("Messaggio non trovato");
        $messaggi = array();
        $sql = "SELECT * from messaggio WHERE messaggio.tipo = 'multa' ORDER BY data;";

        $result = $this->conn->query($sql);
        $i = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $m = new Messaggio($row["testo"], $row["allenatore"], $row["calciatore"], $row["mittente"], $row["data"], $row["tipo"]);
                $m->setId($row["id"]);
                $messaggi[$i] = $m;
                $i++;

                $g = GestoreAccount::getInstance();
                //$accountAllenatore = $g->ricercaAccount_A_T_S($allenatore);

                //$accountCalciatore = $g->ricercaAccount_G($calciatoreDestinatario);

                /*if ($m->getMittente() == "allenatore") {
                    $m->setNomeMittente($accountAllenatore->getNome());
                    $m->setCognomeMittente($accountAllenatore->getCognome());

                    $m->setNomeDestinatario($accountCalciatore->getNome());
                    $m->setCognomeDestinatario($accountCalciatore->getCognome());
                } else if ($m->getMittente() == "calciatore") {
                    $m->setNomeMittente($accountCalciatore->getNome());
                    $m->setCognomeMittente($accountCalciatore->getCognome());

                    $m->setNomeDestinatario($accountAllenatore->getNome());
                    $m->setCognomeDestinatario($accountAllenatore->getCognome());
                }*/

            }
            return $messaggi;
        } else
            throw new \Exception("non esistono messaggi");
    }

    public function ottieniMessaggioRichiamoAvvertimento($calciatore){
        if ($calciatore == null) throw new \Exception("Messaggio non trovato");
        $messaggi = array();
        $sql = "SELECT * from messaggio WHERE messaggio.tipo = 'avvertimento' ORDER BY data;";

        $result = $this->conn->query($sql);
        $i = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                /*$t, $u, $c, $mitt,$data,$tipo*/
                $m = new Messaggio($row["testo"], $row["allenatore"], $row["calciatore"], $row["mittente"], $row["data"], $row["tipo"]);
                $m->setId($row["id"]);
                $messaggi[$i] = $m;
                $i++;

                $g = GestoreAccount::getInstance();
                //$accountAllenatore = $g->ricercaAccount_A_T_S($allenatore);

                //$accountCalciatore = $g->ricercaAccount_G($calciatoreDestinatario);

                /*if ($m->getMittente() == "allenatore") {
                    $m->setNomeMittente($accountAllenatore->getNome());
                    $m->setCognomeMittente($accountAllenatore->getCognome());

                    $m->setNomeDestinatario($accountCalciatore->getNome());
                    $m->setCognomeDestinatario($accountCalciatore->getCognome());
                } else if ($m->getMittente() == "calciatore") {
                    $m->setNomeMittente($accountCalciatore->getNome());
                    $m->setCognomeMittente($accountCalciatore->getCognome());

                    $m->setNomeDestinatario($accountAllenatore->getNome());
                    $m->setCognomeDestinatario($accountAllenatore->getCognome());
                }*/

            }
            return $messaggi;
        } else
            throw new \Exception("non esistono messaggi");
    }

    public function ottieniMessaggioRichiamoDieta($calciatore){
        if ($calciatore == null) throw new \Exception("Messaggio non trovato");
        $messaggi = array();
        $sql = "SELECT * from messaggio WHERE messaggio.tipo = 'dieta'  ORDER BY data;";

        $result = $this->conn->query($sql);
        $i = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                /*$t, $u, $c, $mitt,$data,$tipo*/
                $m = new Messaggio($row["testo"], $row["allenatore"], $row["calciatore"], $row["mittente"], $row["data"], $row["tipo"]);
                $m->setId($row["id"]);
                $messaggi[$i] = $m;
                $i++;

                $g = GestoreAccount::getInstance();
                //$accountAllenatore = $g->ricercaAccount_A_T_S($allenatore);

                //$accountCalciatore = $g->ricercaAccount_G($calciatoreDestinatario);

                /*if ($m->getMittente() == "allenatore") {
                    $m->setNomeMittente($accountAllenatore->getNome());
                    $m->setCognomeMittente($accountAllenatore->getCognome());

                    $m->setNomeDestinatario($accountCalciatore->getNome());
                    $m->setCognomeDestinatario($accountCalciatore->getCognome());
                } else if ($m->getMittente() == "calciatore") {
                    $m->setNomeMittente($accountCalciatore->getNome());
                    $m->setCognomeMittente($accountCalciatore->getCognome());

                    $m->setNomeDestinatario($accountAllenatore->getNome());
                    $m->setCognomeDestinatario($accountAllenatore->getCognome());
                }*/

            }
            return $messaggi;
        } else
            throw new \Exception("non esistono messaggi");
    }

    public function ottieniMessaggioRichiamoAllenamento($calciatore){
        if ($calciatore == null) throw new \Exception("Messaggio non trovato");
        $messaggi = array();
        $sql = "SELECT * from messaggio WHERE messaggio.tipo = 'allenamento'  ORDER BY data;";

        $result = $this->conn->query($sql);
        $i = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                /*$t, $u, $c, $mitt,$data,$tipo*/
                $m = new Messaggio($row["testo"], $row["allenatore"], $row["calciatore"], $row["mittente"], $row["data"], $row["tipo"]);
                $m->setId($row["id"]);
                $messaggi[$i] = $m;
                $i++;

                $g = GestoreAccount::getInstance();
                //$accountAllenatore = $g->ricercaAccount_A_T_S($allenatore);

                //$accountCalciatore = $g->ricercaAccount_G($calciatoreDestinatario);

                /*if ($m->getMittente() == "allenatore") {
                    $m->setNomeMittente($accountAllenatore->getNome());
                    $m->setCognomeMittente($accountAllenatore->getCognome());

                    $m->setNomeDestinatario($accountCalciatore->getNome());
                    $m->setCognomeDestinatario($accountCalciatore->getCognome());
                } else if ($m->getMittente() == "calciatore") {
                    $m->setNomeMittente($accountCalciatore->getNome());
                    $m->setCognomeMittente($accountCalciatore->getCognome());

                    $m->setNomeDestinatario($accountAllenatore->getNome());
                    $m->setCognomeDestinatario($accountAllenatore->getCognome());
                }*/

            }
            return $messaggi;
        } else
            throw new \Exception("non esistono messaggi");
    }
}