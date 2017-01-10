<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 26/12/2016
 * Time: 14:46
 */

namespace AppBundle\it\unisa\partite;


use AppBundle\it\unisa\statistiche\Calciatore;
use AppBundle\it\unisa\statistiche\GestoreStatisticheCalciatore;
use AppBundle\it\unisa\statistiche\GestoreStatistichePartita;
use AppBundle\Utility\DB;

class GestorePartite
{
    private $conn;
    private $db;

    /**
     * GestionePartite constructor.
     * @param $conn
     */
    public function __construct()
    {
        $this->db = new DB();
        $this->conn = $this->db->connect();
    }

    function __destruct()
    {
        $this->db->close($this->conn);
    }


    /**
     * Restituisce le partite
     * @param $squadra
     */
    public function getPartite($squadra)
    {
        $statement = $this->conn->prepare("SELECT * FROM partita WHERE squadra = ?;");
        $statement->bind_param("s", $squadra);
        $executed = $statement->execute();
        $result = $statement->get_result();
        $g = new GestoreStatistichePartita();

        if ($result->num_rows > 0) {
            $arrayPartite = array();

            while ($row = $result->fetch_assoc()) {
                $squadre = explode('-', $row["nome"]);

                //var_dump($squadre);
                //var_dump($row["nome"]);

                $casa = $squadre[0];
                $trasferta = $squadre[1];
                $dateTime = new \DateTime($row["data"]);
                $squadra = $row["squadra"];
                $stadio = $row["stadio"];

                $partita = new Partita($casa, $trasferta, $dateTime, $squadra, $stadio);

                $golFatti = $row["golfatti"];
                $golSubiti = $row["golsubiti"];

                if (($stats = $g->getStatistiche($partita)) != null) {
                    $partita->setStatistiche($stats);
                }

                if (count($convocati = $this->getCalciatoriConvocati($partita)) > 0) {
                    $partita->setConvocati($convocati);
                }

                $arrayPartite[] = $partita;
            }

            return $arrayPartite;
        } else {
            return array();
        }
    }

    /**
     * Inserisce la partita in input nel DataBase.
     * @param PartitaInterface $partita La partita de inserire nel DataBase.
     * @return bool true on success or false on failure.
     */
    public function inserisciPartita(PartitaInterface $partita)
    {
        $statement = $this->conn->prepare("INSERT INTO partita
            (`nome`,
            `data`,
            `squadra`,
            `stadio`)
            VALUES
            (?, ?, ?, ?);");

        $nome = $partita->getNome();
        $data = $partita->getDataString();
        $squadra = $partita->getSquadra();
        $stadio = $partita->getStadio();

        $statement->bind_param("ssss", $nome, $data, $squadra, $stadio);

        return $statement->execute();
    }


    /**
     * Restituisce la partita corrispondente ai parametri passati in input.
     * @param $nome Il nome della partita. Es. Milan-Inter
     * @param $data La data e l'ora in cui si disputa l'incontro. Es. 2016-12-12 20:45:00
     * @param $squadra La squadra a cui si riferiscono le informazioni della partita.
     */
    public function getPartita($nome, $data, $squadra)
    {
        $statement = $this->conn->prepare("SELECT * FROM partita WHERE nome = ? AND data = ? AND squadra = ?;");
        $statement->bind_param("sss", $nome, $data, $squadra);

        $executed = $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $squadre = explode('-', $row["nome"]);
                $casa = $squadre[0];
                $trasferta = $squadre[1];
                $dateTime = new \DateTime($row["data"]);

                $partita = new Partita($casa, $trasferta, $dateTime, $row["squadra"], $row["stadio"]);
                $g = new GestoreStatistichePartita();

                if (($stats = $g->getStatistiche($partita)) != null) {
                    $partita->setStatistiche($stats);
                }

                if (count($convocati = $this->getCalciatoriConvocati($partita)) > 0) {
                    $partita->setConvocati($convocati);
                }
            }

            return $partita;
        } else {
            throw new \Exception("La partita cercata non esiste.");
        }
    }

    /**
     * Modifica i dati della vecchia partita con quelli della nuova.
     * @param PartitaInterface $old La vecchia partita.
     * @param PartitaInterface $new La nuova partita.
     */
    public function modificaPartita(PartitaInterface $old, PartitaInterface $new)
    {
        //ogni squadra può modificare solo le proprie partite.
        if ($statement = $this->conn->prepare(
            "UPDATE partita
                SET
                nome = ?,
                data = ?,
                stadio = ?
                WHERE nome = ? AND data = ? AND squadra = ?")
        ) {
            $newNome = $new->getNome();
            $newData = $new->getDataString();
            $newStadio = $new->getStadio();

            $oldNome = $old->getNome();
            $oldData = $old->getDataString();
            $oldSquadra = $old->getSquadra();

            if ($statement->bind_param("ssssss", $newNome, $newData, $newStadio, $oldNome, $oldData, $oldSquadra)) {
                if ($statement->execute()) {
                    return true;
                } else {
                    throw new \Exception("Statement non eseguito.");
                }
            } else {
                throw new \Exception("Binding non eseguito.");
            }
        } else {
            throw new \Exception("Statement not prepared.");
        }
    }

    public function getCalciatoriConvocati(PartitaInterface $partita)
    {
        if ($statement = $this->conn->prepare("
            SELECT * FROM calciatore JOIN giocare ON calciatore.contratto = giocare.calciatore
            WHERE data = ? AND partita = ? AND giocare.squadra = ?")
        ) {
            $data = $partita->getDataString();
            $nome_partita = $partita->getNome();
            $squadra = $partita->getSquadra();

            if ($statement->bind_param("sss", $data, $nome_partita, $squadra)) {
                if ($statement->execute()) {
                    if ($result = $statement->get_result()) {
                        $calciatori = array();

                        while ($row = $result->fetch_assoc()) {
                            $contratto = $row["contratto"];
                            $password = $row["password"];
                            $squadra = $row["squadra"];
                            $email = $row["email"];
                            $nome = $row["nome"];
                            $cognome = $row["cognome"];
                            $dataDiNascita = $row["datadinascita"];
                            $numeroMaglia = $row["numeromaglia"];
                            $domicilio = $row["domicilio"];
                            $indirizzo = $row["indirizzo"];
                            $provincia = $row["provincia"];
                            $telefono = $row["telefono"];
                            $immagine = $row["immagine"];

                            $calciatore = new Calciatore($contratto, $password, $squadra, $email, $nome, $cognome, $dataDiNascita, $numeroMaglia, $domicilio, $indirizzo, $provincia, $telefono, $immagine);

                            try {
                                $g = new GestoreStatisticheCalciatore();
                                $stats = $g->getStatisticheCalciatore($contratto, $nome_partita, $data, $squadra);
                                //var_dump($stats);
                                $calciatore->setStatistiche($stats);
                            } catch (\Exception $exception) {
                                //var_dump($exception);
                            }

                            $calciatori[] = $calciatore;
                        }

                        return $calciatori;
                    } else {
                        throw new \Exception("Result is false.");
                    }
                } else {
                    throw new \Exception("Statement not executed.");
                }
            } else {
                throw new \Exception("Parameters binding failed.");
            }
        } else {
            throw new \Exception("Statement preparation failed.");
        }
    }
}