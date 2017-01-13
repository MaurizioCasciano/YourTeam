<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 20/12/2016
 * Time: 12:37
 */

namespace AppBundle\it\unisa\statistiche;


use AppBundle\it\unisa\partite\PartitaInterface;
use AppBundle\Utility\DB;

class GestoreStatistichePartita
{
    private $conn;
    private $db;
    private static $instance = null;

    /**
     * GestoreStatistichePartita constructor.
     */
    private function __construct()
    {
        $this->db = new DB();
        $this->conn = $this->db->connect();
    }

    function __destruct()
    {
        $this->db->close($this->conn);
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

    public function inserisciStatistiche($partita)
    {
        if (!$partita->hasStatistiche()) {
            throw new \RuntimeException("Partita senza statistiche.");
        }

        $nome = $partita->getNome();
        $data = $partita->getDataString();
        $squadra = $partita->getSquadra();
        $statistiche = $partita->getStatistiche();
        $golFatti = $statistiche->getGolFatti();
        $golSubiti = $statistiche->getGolSubiti();
        $possessoPalla = $statistiche->getPossessoPalla();

        /**
         * Array contenente i marcatori come elementi, un elemento è ripetuto tante volte quanti sono i suoi gol.
         */
        $marcatori = $statistiche->getMarcatori();
        /**
         * Array contenente gli assistmen come elementi, un elemento è ripetuto tante volte quanti sono i suoi assist.
         */
        $assistmen = $statistiche->getAssistMen();
        /**
         * Array contenente gli ammoniti come elementi, un elemento è ripetuto tante volte quanti sono le sua ammonizioni.
         */
        $ammonizioni = $statistiche->getAmmonizioni();
        /**
         * Array contenente gli espulsi come elementi, ogni elemento dovrebbe essere presente massimo 1 volta.
         */
        $espulsioni = $statistiche->getEspulsioni();

        /*===============================================================================================================*/

        /**
         * Array associativo contenente le coppie ("contratto" => numero gol).
         */
        $goals = array_count_values($marcatori);
        /**
         * Array associativo contenente le coppie ("contratto" => numero assist).
         */
        $assists = array_count_values($assistmen);
        /**
         * Array associativo contenente le coppie ("contratto" => numero ammonizioni).
         */
        $yellowCards = array_count_values($ammonizioni);
        /**
         * Array associativo contenente le coppie ("contratto" => numero espulsioni).
         */
        $redCards = array_count_values($espulsioni);

        /**
         * Array contenente il "contratto" dei calciatori che hanno segnato, fatto un assist, preso un'ammonizione o un'espulsione.
         */
        $calciatori = array_keys($goals + $assists + $yellowCards + $redCards);

        //var_dump($calciatori);
        $statisticheCalciatori = array();
        $gestoreStatisticheCalciatore = GestoreStatisticheCalciatore::getInstance();

        $executed = true;

        foreach ($calciatori as $calciatore) {
            //var_dump($calciatore);
            $username = $calciatore;
            $tiriTotali = 0;
            $tiriPorta = 0;
            $falliCommessi = 0;
            $falliSubiti = 0;
            $percentualePassaggiRiusciti = 0;
            $golFattiCalciatore = array_key_exists($calciatore, $goals) ? $goals[$calciatore] : 0;
            $golSubitiCalciatore = 0;
            $assistCalciatore = array_key_exists($calciatore, $assists) ? $assists[$calciatore] : 0;
            $ammonizioniCalciatore = array_key_exists($calciatore, $yellowCards) ? $yellowCards[$calciatore] : 0;
            $espulsioniCalciatore = array_key_exists($calciatore, $redCards) ? $redCards[$calciatore] : 0;
            $partiteGiocate = 0;


            //__construct($usernameCalciatore, $tiriTotali, $tiriPorta,
            // $falliCommessi, $falliSubiti, $percentualPassaggiRiusciti,
            // $golFatti, $golSubiti, $assist, $ammonizioni, $espulsioni, $partiteGiocate)

            $statisticheCalciatore = new StatisticheCalciatore($username, $tiriTotali, $tiriPorta,
                $falliCommessi, $falliSubiti, $percentualePassaggiRiusciti, $golFattiCalciatore, $golSubitiCalciatore,
                $assistCalciatore, $ammonizioniCalciatore, $espulsioniCalciatore, $partiteGiocate);

            //var_dump($statisticheCalciatore);
            $statisticheCalciatori[] = $statisticheCalciatore;
            $executed = $executed && $gestoreStatisticheCalciatore->inserisciStatistiche($statisticheCalciatore, $nome, $data, $squadra);
            //var_dump($executed);
        }


        $statement1 = $this->conn->prepare(
            "UPDATE partita
                SET
                golfatti = ?,
                golsubiti = ?,
                possessopalla = ?
                WHERE nome = ? AND data = ? AND squadra = ?");

        $statement1->bind_param("iiisss", $golFatti, $golSubiti, $possessoPalla, $nome, $data, $squadra);
        $executed1 = $statement1->execute();

        return $executed && $executed1;
    }

    /**
     * Modifica le statistiche della partita passata in input.
     * @param PartitaInterface $partita
     */
    public function modificaStatistiche($partita)
    {
        if (!$partita->hasStatistiche()) {
            throw new \RuntimeException("Partita senza statistiche.");
        }

        $gestoreStatisticheCalciatore = GestoreStatisticheCalciatore::getInstance();
        $gestoreStatisticheCalciatore->rimuoviMarcatori($partita);
        $gestoreStatisticheCalciatore->rimuoviAssistMen($partita);
        $gestoreStatisticheCalciatore->rimuoviAmmonizioni($partita);
        $gestoreStatisticheCalciatore->rimuoviEspulsioni($partita);

        $nome = $partita->getNome();
        $data = $partita->getDataString();
        $squadra = $partita->getSquadra();
        $statistiche = $partita->getStatistiche();
        $golFatti = $statistiche->getGolFatti();
        $golSubiti = $statistiche->getGolSubiti();
        $possessoPalla = $statistiche->getPossessoPalla();

        /**
         * Array contenente i marcatori come elementi, un elemento è ripetuto tante volte quanti sono i suoi gol.
         */
        $marcatori = $statistiche->getMarcatori();
        /**
         * Array contenente gli assistmen come elementi, un elemento è ripetuto tante volte quanti sono i suoi assist.
         */
        $assistmen = $statistiche->getAssistMen();
        /**
         * Array contenente gli ammoniti come elementi, un elemento è ripetuto tante volte quanti sono le sua ammonizioni.
         */
        $ammonizioni = $statistiche->getAmmonizioni();
        /**
         * Array contenente gli espulsi come elementi, ogni elemento dovrebbe essere presente massimo 1 volta.
         */
        $espulsioni = $statistiche->getEspulsioni();

        /*===============================================================================================================*/

        /**
         * Array associativo contenente le coppie ("contratto" => numero gol).
         */
        $goals = array_count_values($marcatori);
        /**
         * Array associativo contenente le coppie ("contratto" => numero assist).
         */
        $assists = array_count_values($assistmen);
        /**
         * Array associativo contenente le coppie ("contratto" => numero ammonizioni).
         */
        $yellowCards = array_count_values($ammonizioni);
        /**
         * Array associativo contenente le coppie ("contratto" => numero espulsioni).
         */
        $redCards = array_count_values($espulsioni);

        /**
         * Array contenente il "contratto" dei calciatori che hanno segnato, fatto un assist, preso un'ammonizione o un'espulsione.
         */
        $calciatori = array_keys($goals + $assists + $yellowCards + $redCards);

        //var_dump($calciatori);
        $statisticheCalciatori = array();
        $gestoreStatisticheCalciatore = GestoreStatisticheCalciatore::getInstance();

        $executed = true;

        foreach ($calciatori as $calciatore) {
            //var_dump($calciatore);
            $username = $calciatore;
            $tiriTotali = 0;
            $tiriPorta = 0;
            $falliCommessi = 0;
            $falliSubiti = 0;
            $percentualePassaggiRiusciti = 0;
            $golFattiCalciatore = array_key_exists($calciatore, $goals) ? $goals[$calciatore] : 0;
            $golSubitiCalciatore = 0;
            $assistCalciatore = array_key_exists($calciatore, $assists) ? $assists[$calciatore] : 0;
            $ammonizioniCalciatore = array_key_exists($calciatore, $yellowCards) ? $yellowCards[$calciatore] : 0;
            $espulsioniCalciatore = array_key_exists($calciatore, $redCards) ? $redCards[$calciatore] : 0;
            $partiteGiocate = 0;

            try {
                $oldStatisticheCalciatore = $gestoreStatisticheCalciatore->getStatisticheCalciatore();
                $oldStatisticheCalciatore->setGolFatti($golFattiCalciatore);
                $oldStatisticheCalciatore->setAssist($assistCalciatore);
                $oldStatisticheCalciatore->setAmmonizioni($ammonizioniCalciatore);
                $oldStatisticheCalciatore->setEspulsioni($espulsioniCalciatore);
                $executed = $executed && $gestoreStatisticheCalciatore->modificaStatistiche($oldStatisticheCalciatore, $nome, $data, $squadra);
            } catch (\Exception $ex) {
                //__construct($usernameCalciatore, $tiriTotali, $tiriPorta,
                // $falliCommessi, $falliSubiti, $percentualPassaggiRiusciti,
                // $golFatti, $golSubiti, $assist, $ammonizioni, $espulsioni, $partiteGiocate)

                $statisticheCalciatore = new StatisticheCalciatore($username, $tiriTotali, $tiriPorta,
                    $falliCommessi, $falliSubiti, $percentualePassaggiRiusciti, $golFattiCalciatore, $golSubitiCalciatore,
                    $assistCalciatore, $ammonizioniCalciatore, $espulsioniCalciatore, $partiteGiocate);

                $executed = $executed && $gestoreStatisticheCalciatore->inserisciStatistiche($statisticheCalciatore, $nome, $data, $squadra);
            }

            var_dump($executed);
        }

        if ($statement = $this->conn->prepare(
            "UPDATE partita
                SET
                golfatti = ?,
                golsubiti = ?,
                possessopalla = ?
                WHERE nome = ? AND data = ? AND squadra = ?")
        ) {
            if ($statement->bind_param("iiisss", $golFatti, $golSubiti, $possessoPalla, $nome, $data, $squadra)) {
                if ($statement->execute()) {
                    return true && $executed;
                } else {
                    throw new \Exception("Statement non eseguito.");
                }
            } else {
                throw new \Exception("Statement binding non eseguito.");
            }
        } else {
            throw new \Exception("Statement non preparato.");
        }
    }

    /**
     * Restituisce le statistiche della partita, se presenti.
     * @param PartitaInterface $partita
     * @return StatistichePartita|null
     */
    public function getStatistiche($partita)
    {
        if ($statement = $this->conn->prepare("
        SELECT * FROM partita
        WHERE nome = ? AND data = ? AND squadra = ?")
        ) {
            $nome = $partita->getNome();
            $data = $partita->getDataString();
            $squadra = $partita->getSquadra();

            if ($statement->bind_param("sss", $nome, $data, $squadra)) {
                if ($statement->execute()) {
                    if ($result = $statement->get_result()) {
                        if ($row = $result->fetch_assoc()) {
                            $golFatti = $row["golfatti"];
                            $golSubiti = $row["golsubiti"];
                            $possessoPalla = $row["possessopalla"];

                            if ((empty($golFatti) || is_null($golFatti))
                                && (empty($golSubiti) || is_null($golSubiti))
                                && (empty($possessoPalla) || is_null($possessoPalla))
                            ) {
                                return null;
                            } else {
                                $marcatori = $this->getMarcatori($partita);
                                $assistMen = $this->getAssistMen($partita);
                                $ammonizioni = $this->getAmmonizioni($partita);
                                $espulsioni = $this->getEspulsioni($partita);

                                $stats = new StatistichePartita($golFatti, $golSubiti, $possessoPalla, $marcatori, $assistMen, $ammonizioni, $espulsioni);
                                return $stats;
                            }
                        }
                    }
                }
            }
        }
    }

    public function getMarcatori($partita)
    {
        if ($statement = $this->conn->prepare("
            SELECT *
            FROM statistiche_calciatore
            WHERE
            nome_partita = ?
              AND data_partita = ?
              AND squadra = ?;")
        ) {
            $nome = $partita->getNome();
            $data = $partita->getData();
            $squadra = $partita->getSquadra();

            if ($statement->bind_param("sss", $nome, $data, $squadra)) {
                if ($statement->execute()) {
                    if ($result = $statement->get_result()) {

                        $marcatori = array();

                        while ($row = $result->fetch_assoc()) {
                            $calciatore = $row["calciatore"];
                            $gol_fatti = $row["gol_fatti"];

                            for ($i = 0; $i < $gol_fatti; $i++) {
                                $marcatori[] = $calciatore;
                            }
                        }

                        return $marcatori;
                    }
                }
            }
        }
    }

    public function getAssistMen($partita)
    {
        if ($statement = $this->conn->prepare("
            SELECT *
            FROM statistiche_calciatore
            WHERE
            nome_partita = ?
              AND data_partita = ?
              AND squadra = ?;")
        ) {
            $nome = $partita->getNome();
            $data = $partita->getData();
            $squadra = $partita->getSquadra();

            if ($statement->bind_param("sss", $nome, $data, $squadra)) {
                if ($statement->execute()) {
                    if ($result = $statement->get_result()) {

                        $assistmen = array();

                        while ($row = $result->fetch_assoc()) {
                            $calciatore = $row["calciatore"];
                            $assist = $row["assist"];

                            for ($i = 0; $i < $assist; $i++) {
                                $assistmen[] = $calciatore;
                            }
                        }

                        return $assistmen;
                    }
                }
            }
        }
    }

    public function getAmmonizioni($partita)
    {
        if ($statement = $this->conn->prepare("
            SELECT *
            FROM statistiche_calciatore
            WHERE
            nome_partita = ?
              AND data_partita = ?
              AND squadra = ?;")
        ) {
            $nome = $partita->getNome();
            $data = $partita->getData();
            $squadra = $partita->getSquadra();

            if ($statement->bind_param("sss", $nome, $data, $squadra)) {
                if ($statement->execute()) {
                    if ($result = $statement->get_result()) {

                        $ammonizioni = array();

                        while ($row = $result->fetch_assoc()) {
                            $calciatore = $row["calciatore"];
                            $yellows = $row["ammonizioni"];

                            for ($i = 0; $i < $yellows; $i++) {
                                $ammonizioni[] = $calciatore;
                            }
                        }

                        return $ammonizioni;
                    }
                }
            }
        }
    }

    public function getEspulsioni($partita)
    {
        if ($statement = $this->conn->prepare("
            SELECT *
            FROM statistiche_calciatore
            WHERE
            nome_partita = ?
              AND data_partita = ?
              AND squadra = ?;")
        ) {
            $nome = $partita->getNome();
            $data = $partita->getData();
            $squadra = $partita->getSquadra();

            if ($statement->bind_param("sss", $nome, $data, $squadra)) {
                if ($statement->execute()) {
                    if ($result = $statement->get_result()) {

                        $espulsioni = array();

                        while ($row = $result->fetch_assoc()) {
                            $calciatore = $row["calciatore"];
                            $reds = $row["espulsioni"];

                            for ($i = 0; $i < $reds; $i++) {
                                $espulsioni[] = $calciatore;
                            }
                        }

                        return $espulsioni;
                    }
                }
            }
        }
    }
}