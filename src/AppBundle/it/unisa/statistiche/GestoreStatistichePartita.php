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

    /**
     * GestoreStatistichePartita constructor.
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


    public function inserisciStatistiche(PartitaInterface $partita)
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

        var_dump($calciatori);
        $statisticheCalciatori = array();
        $gestoreStatisticheCalciatore = new GestoreStatisticheCalciatore();

        $executed = true;

        foreach ($calciatori as $calciatore) {
            var_dump($calciatore);
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

            $statisticheCalciatore = new StatisticheCalciatore($calciatore, $tiriTotali, $tiriPorta,
                $falliCommessi, $falliSubiti, $percentualePassaggiRiusciti, $golFattiCalciatore, $golSubitiCalciatore,
                $assistCalciatore, $ammonizioniCalciatore, $espulsioniCalciatore, $partiteGiocate);

            var_dump($statisticheCalciatore);
            $statisticheCalciatori[] = $statisticheCalciatore;
            $executed = $executed && $gestoreStatisticheCalciatore->inserisciStatistiche($statisticheCalciatore, $nome, $data, $squadra);
            var_dump($executed);
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


        foreach ($marcatori as $marcatore) {
            //var_dump("Marcatore: " . $marcatore);
        }

        foreach ($assistmen as $assitMan) {
            //var_dump("AssistMan: " . $assitMan);
        }

        foreach ($ammonizioni as $ammonizione) {
            //var_dump("Ammonizione: " . $ammonizione);
        }

        foreach ($espulsioni as $espulsione) {
            //var_dump("Espulsione: " . $espulsione);
        }

        return $executed && $executed1;
    }

    public function getStatistiche()
    {

    }

    public function modificaStatistiche()
    {

    }


    public function getMarcatori($nome, $data, $squadra)
    {
        if ($statement = $this->conn->prepare("
            SELECT *
            FROM statistiche_calciatore
            WHERE
              nome_partita = ?
              AND data_partita = ?
              AND squadra = ?;
        ")
        ) {
            $statement->bind_param("sss", $nome, $data, $squadra);
            $statement->execute();
            $result = $statement->get_result();

            $marcatori = array();

            while ($row = $result->fetch_assoc()) {
                $calciatore = $row["calciatore"];
                $golFatti = $row["gol_fatti"];

                for ($i = 0; $i < $golFatti; $i++) {
                    $marcatori[] = $calciatore;
                }
            }

            return $marcatori;
        } else {
            throw  new \Exception("Prepare failed: (" . $this->conn->errno . ") " . $this->conn->error);
        }
    }
}