<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 26/12/2016
 * Time: 14:46
 */

namespace AppBundle\it\unisa\partite;


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

        if ($result->num_rows > 0) {
            $arrayPartite = array();

            while ($row = $result->fetch_assoc()) {
                $squadre = explode('-', $row["nome"]);
                $casa = $squadre[0];
                $trasferta = $squadre[1];
                $dateTime = new \DateTime($row["data"]);

                $arrayPartite[] = new Partita($casa, $trasferta, $dateTime, $row["squadra"], $row["stadio"]);
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
        $statement = $this->conn->prepare(
            "UPDATE partita
                SET
                nome = ?,
                data = ?,
                stadio = ?
                WHERE nome = ? AND data = ? AND squadra = ?");

        $newNome = $new->getNome();
        $newData = $new->getDataString();
        $newStadio = $new->getStadio();

        $oldNome = $old->getNome();
        $oldData = $old->getDataString();
        $oldSquadra = $old->getSquadra();

        $statement->bind_param("ssssss", $newNome, $newData, $newStadio, $oldNome, $oldData, $oldSquadra);

        $success = $statement->execute();
        return $success;
    }
}