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
    private static $instance = null;

    /**
     * GestionePartite constructor.
     * @param $conn
     */
    protected function __construct()
    {
        $this->db = new DB();
        $this->conn = $this->db->connect();
    }

    private function __clone()
    {
        //Prevent any object or instance of this class to be cloned
    }

    /**
     * @return null
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            selef::$instance = new static();
        }

        return self::$instance;
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
                $arrayPartite[] = new Partita($row["nome"], $row["data"], $row["squadra"], $row["stadio"]);
            }

            return $arrayPartite;
        } else {
            return array();
        }
    }

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
        $executed = $statement->execute();

        if (!$executed) {
            throw  new \Exception("Error: " . $this->conn->error);
        }
    }
}