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

    public function inviaMessaggio(Messaggio $messaggio)
    {
        if ($messaggio == null) {
            throw new \Exception("Il messaggio non può essere NULL");
        }

        if ($statement = $this->conn->prepare("
            INSERT INTO messaggio (testo, allenatore, calciatore, mittente, data, tipo)
            VALUES (?, ?, ?, ?, ?, ?)")
        ) {
            $testo = $messaggio->getTesto();
            $allenatore = $messaggio->getAllenatore();
            $calciatore = $messaggio->getCalciatore();
            $mittente = $messaggio->getMittente();
            $data = $messaggio->getDataString();
            $tipo = $messaggio->getTipo();

            if ($statement->bind_param("ssssss", $testo, $allenatore, $calciatore, $mittente, $data, $tipo)) {
                if ($statement->execute()) {
                    return true;
                } else {
                    throw new \Exception("Messaggio non inserito nel database.");
                }
            } else {
                throw new \Exception("Statement binding non eseguito.");
            }
        } else {
            throw new \Exception("Statement non preparato.");
        }
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
                $data = new \DateTime($row["data"]);
                $messaggio = new Messaggio($row["testo"], $row["allenatore"], $row["calciatore"], $row["mittente"], $data, $row["tipo"]);
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
        }
    }

    /**
     * Restituisce l'array di oggetti Messaggio scambiati tra l'allenatore ed il calciatore, ordinati per data.
     * @param $allenatore username dell'allenatore.
     * @param $tipo
     * @param $calciatoreDestinatario username del calciatore.
     * @return array
     * @throws \Exception
     */
    public function ottieniMessaggi($allenatore, $tipo, $calciatoreDestinatario)
    {
        if ($allenatore == null) {
            throw new \Exception("Messaggio non trovato");
        }

        if ($statement = $this->conn->prepare("
            SELECT * FROM messaggio
            WHERE allenatore = ?
            AND calciatore = ?
            AND tipo = ?
            ORDER BY data")
        ) {
            if ($statement->bind_param("sss", $allenatore, $calciatoreDestinatario, $tipo)) {
                if ($statement->execute()) {
                    if ($result = $statement->get_result()) {
                        $i = 0;
                        if ($result->num_rows > 0) { //se la query ha dato risulatato
                            // output data of each row
                            $messaggi = array();

                            while ($row = $result->fetch_assoc()) {
                                /*$t, $u, $c, $mitt,$data,$tipo*/
                                $data = new \DateTime($row["data"]);
                                $m = new Messaggio($row["testo"], $row["allenatore"], $row["calciatore"], $row["mittente"], $data, $row["tipo"]);
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
                        } else {
                            return array();
                        }
                    } else {
                        throw new \Exception("Statement get result fail");
                    }
                } else {
                    throw new \Exception("Statement execution fail");
                }
            } else {
                throw new \Exception("Statement binding fail");
            }
        } else {
            throw new \Exception("Statement not prepared.");
        }
    }

    public function ottieniMessaggioComportamento($allenatore, $calciatoreDestinatario, $testo_comportamento)
    {
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

    public function ottieniMessaggiRichiamoMulta($calciatore)
    {
        if ($calciatore == null) throw new \Exception("Messaggio non trovato");
        $messaggi = array();
        $sql = "SELECT * from messaggio WHERE tipo = 'multa' AND calciatore =" . '$calciatore' . " ORDER BY data;";

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
        }
    }

    public function ottieniMessaggioRichiamoAvvertimento($calciatore)
    {
        if ($calciatore == null) throw new \Exception("Messaggio non trovato");
        $messaggi = array();
        $sql = "SELECT * from messaggio WHERE messaggio.tipo = 'avvertimento' AND messaggio.calciatore = '$calciatore' ORDER BY data;";

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
        }
    }

    public function ottieniMessaggioRichiamoDieta($calciatore)
    {
        if ($calciatore == null) throw new \Exception("Messaggio non trovato");
        $messaggi = array();
        $sql = "SELECT * from messaggio WHERE messaggio.tipo = 'dieta' AND messaggio.calciatore = '$calciatore'  ORDER BY data;";

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
        }
    }

    public function ottieniMessaggioRichiamoAllenamento($calciatore)
    {
        if ($calciatore == null) throw new \Exception("Messaggio non trovato");
        $messaggi = array();
        $sql = "SELECT * from messaggio WHERE messaggio.tipo = 'allenamento' AND messaggio.calciatore = '$calciatore'  ORDER BY data;";

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
        }
    }

    /**
     * Restituisce l'array di messaggi scambiati tra l'allenatore ed il calciatore, successivi alla data indicata.
     * @param $allenatore l'username dell'allenatore
     * @param $calciatore l'username del calciatore
     * @param $tipo il tipo dei messaggi richiesti
     * @param $data la data successiva alla quale sono richiesti i messaggi.
     * @return array I nuovi messaggi scambiati tra il calciatore e l'allenatore, del tipo indicato.
     */
    public function getNuoviMessaggi($allenatore, $calciatore, $tipo, $data)
    {
        if ($statement = $this->conn->prepare("
            SELECT * FROM messaggio
            WHERE allenatore = ?
            AND calciatore = ?
            AND tipo = ?
            AND data > ?
            ORDER BY data")
        ) {
            if ($statement->bind_param("ssss", $allenatore, $calciatore, $tipo, $data)) {
                if ($statement->execute()) {
                    if ($result = $statement->get_result()) {
                        $i = 0;
                        if ($result->num_rows > 0) { //se la query ha dato risulatato
                            // output data of each row
                            $messaggi = array();

                            while ($row = $result->fetch_assoc()) {
                                /*$t, $u, $c, $mitt,$data,$tipo*/
                                $data = new \DateTime($row["data"]);
                                $m = new Messaggio($row["testo"], $row["allenatore"], $row["calciatore"], $row["mittente"], $data, $row["tipo"]);
                                $m->setId($row["id"]);
                                $messaggi[$i] = $m;
                                $i++;

                                $g = GestoreAccount::getInstance();
                                $accountAllenatore = $g->ricercaAccount_A_T_S($allenatore);

                                $accountCalciatore = $g->ricercaAccount_G($calciatore);

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
                        } else {
                            return array();
                        }
                    } else {
                        throw new \Exception("Statement get result fail");
                    }
                } else {
                    throw new \Exception("Statement execution fail");
                }
            } else {
                throw new \Exception("Statement binding fail");
            }
        } else {
            throw new \Exception("Statement not prepared.");
        }
    }
}