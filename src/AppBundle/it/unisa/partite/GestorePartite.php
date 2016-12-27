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
                $casa = trim($squadre[0]);
                $trasferta = trim($squadre[1]);

                $arrayPartite[] = new Partita($casa, $trasferta, $row["data"], $row["squadra"], $row["stadio"]);
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
        $data = $partita->getData();
        $squadra = $partita->getSquadra();
        $stadio = $partita->getStadio();

        $statement->bind_param("ssss", $nome, $data, $squadra, $stadio);

        return $statement->execute();
    }
}