<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 20/12/2016
 * Time: 11:46
 */

namespace AppBundle\it\unisa\statistiche;

use AppBundle\it\unisa\account\AccountCalciatore;
use AppBundle\Utility\DB;

class GestoreStatisticheCalciatore
{
    private $db;
    private $conn;
    private static $tabellaStatisticheCalciatore = "statistiche_calciatore";

    public function __construct()
    {
        $this->db = new DB();
        $this->conn = $this->db->connect();
    }

    /**
     * Inserisce la statistiche nel database.
     * L'effetto dell'esecuzione di questo metodo è l'inserimento nel DB delle statistiche date in input, che andranno a sommarsi a quelle già presenti.
     * @param StatisticheCalciatore $statistiche
     */
    public function inserisciStatistiche(StatisticheCalciatore $statistiche, $nomePartita, $dataPartita)
    {
        $statement = $this->conn->prepare("INSERT INTO " . "statistiche_calciatore" .
            "(`calciatore`,`nome_partita`,`data_partita`,`tiri_totali`,`tiri_porta`,`falli_fatti`,`falli_subiti`,
            `percentuale_passaggi_riusciti`,`gol_fatti`,`gol_subiti`,`assist`,`ammonizioni`,`espulsioni`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $username = $statistiche->getUsernameCalciatore();
        $tiriTotali = $statistiche->getTiriTotali();
        $tiriPorta = $statistiche->getTiriPorta();
        $falliFatti = $statistiche->getFalliFatti();
        $falliSubiti = $statistiche->getFalliSubiti();
        $percentuaòlePassaggiRiusciti = $statistiche->getPercentualePassaggiRiusciti();
        $golFatti = $statistiche->getGolFatti();
        $golSubiti = $statistiche->getGolSubiti();
        $assist = $statistiche->getAssist();
        $ammonizioni = $statistiche->getAmmonizioni();
        $espulsioni = $statistiche->getEspulsioni();

        $statement->bind_param("sssiiiiiiiiii", $username, $nomePartita, $dataPartita, $tiriTotali,
            $tiriPorta, $falliFatti, $falliSubiti, $percentuaòlePassaggiRiusciti, $golFatti,
            $golSubiti, $assist, $ammonizioni, $espulsioni);

        $executed = $statement->execute();
        $statement->close();
        return $executed;
    }

    /**
     * Restituisce le statistiche di un calciatore relativamente ad una partita.
     * @param $usernameCalciatore L'ID del calciatore.
     * @return StatisticheCalciatore Le statistiche del calciatore.
     */
    public function getStatisticheCalciatore($usernameCalciatore, $nome_partita, $data_partita)
    {
        /*EXAMPLE
        // prepare and bind
            $stmt = $conn->prepare("INSERT INTO MyGuests (firstname, lastname, email) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $firstname, $lastname, $email);
        */
        /*
         * The argument may be one of four types:
            i - integer
            d - double
            s - string
            b - BLOB*/


        $statement = $this->conn->prepare("SELECT * FROM statistiche_calciatore WHERE calciatore = ? AND nome_partita = ? AND data_partita = ?");
        $statement->bind_param("sss", $usernameCalciatore, $nome_partita, $data_partita);
        $executed = $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $statisticheCalciatore = new StatisticheCalciatore($usernameCalciatore,
                $row["tiri_totali"], $row["tiri_porta"], $row["falli_fatti"],
                $row["falli_subiti"], $row["percentuale_passaggi_riusciti"],
                $row["gol_fatti"], $row["gol_subiti"], $row["assist"],
                $row["ammonizioni"], $row["espulsioni"], 0);

            return $statisticheCalciatore;
        }

        return new StatisticheCalciatore($usernameCalciatore, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
    }

    /**
     * Restituisce le statistiche complessive di un calciatore.
     */
    public function getStatisticheComplessiveCalciatore($usernameCalciatore)
    {
        if ($usernameCalciatore == null) throw new \Exception("L'username del calciatore è null.");

        $statement = $this->conn->prepare(
            "SELECT calciatore,
                SUM(tiri_totali) AS tiri_totali,
                SUM(tiri_porta) AS tiri_porta,
                SUM(falli_fatti) AS falli_fatti,
                SUM(falli_subiti) AS falli_subiti,
                (SUM(percentuale_passaggi_riusciti) / COUNT('calciatore')) AS percentuale_passaggi_riusciti,
                SUM(gol_fatti) AS gol_fatti,
                SUM(gol_subiti) AS gol_subiti,
                SUM(assist) AS assist,
                SUM(ammonizioni) as ammonizioni,
                SUM(espulsioni) as espulsioni,
                COUNT('calciatore') AS partite_giocate
            FROM
                statistiche_calciatore
            WHERE
                calciatore = ?
            GROUP BY (calciatore);");

        $statement->bind_param("s", $usernameCalciatore);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $statisticheCalciatore = new StatisticheCalciatore($usernameCalciatore, $row["tiri_totali"], $row["tiri_porta"], $row["falli_fatti"], $row["falli_subiti"], $row["percentuale_passaggi_riusciti"], $row["gol_fatti"], $row["gol_subiti"], $row["assist"], $row["ammonizioni"], $row["espulsioni"], $row["partite_giocate"]);
            return $statisticheCalciatore;
        }

        return null;
    }

    /**
     * Restituisce le statistiche dei calciatori che rispettano il filtro.
     * @param $minTiriTotali int
     * @param $minTiriPorta int
     * @param $minGolFatti int
     * @param $minGolSubiti int
     * @param $minAssist int
     * @param $minFalliFatti int
     * @param $minFalliSubiti int
     * @param $minPercentualePassaggiRiusciti int
     * @param $minAmmonizioni int
     * @param $minEspulsioni int
     * @param $maxTiriTotali int
     * @param $maxTiriPorta int
     * @param $maxGolFatti int
     * @param $maxGolSubiti int
     * @param $maxAssist int
     * @param $maxFalliFatti int
     * @param $maxFalliSubiti int
     * @param $maxPercentualePassaggiRiusciti int
     * @param $maxAmmonizioni int
     * @param $maxEspulsioni int
     * @return StatisticheCalciatore|null
     */
    public function filtraCalciatori($minTiriTotali, $minTiriPorta, $minGolFatti, $minGolSubiti, $minAssist,
                                     $minFalliFatti, $minFalliSubiti, $minPercentualePassaggiRiusciti,
                                     $minAmmonizioni, $minEspulsioni, $maxTiriTotali, $maxTiriPorta,
                                     $maxGolFatti, $maxGolSubiti, $maxAssist, $maxFalliFatti, $maxFalliSubiti,
                                     $maxPercentualePassaggiRiusciti, $maxAmmonizioni, $maxEspulsioni)
    {
        $statement = $this->conn->prepare(
            "SELECT calciatore,
                SUM(tiri_totali) AS tiri_totali,
                SUM(tiri_porta) AS tiri_porta,
                SUM(falli_fatti) AS falli_fatti,
                SUM(falli_subiti) AS falli_subiti,
                (SUM(percentuale_passaggi_riusciti) / COUNT(calciatore)) AS percentuale_passaggi_riusciti,
                SUM(gol_fatti) AS gol_fatti,
                SUM(gol_subiti) AS gol_subiti,
                SUM(assist) AS assist,
                SUM(ammonizioni) as ammonizioni,
                SUM(espulsioni) as espulsioni,
                COUNT('calciatore') AS partite_giocate
            FROM
                statistiche_calciatore
            GROUP BY (calciatore)
            HAVING
              tiri_totali >= ? AND tiri_totali <= ? AND
              tiri_porta >= ? AND tiri_porta <= ? AND 
              falli_fatti >= ? AND falli_fatti <= ? AND 
              falli_subiti >= ? AND falli_subiti <= ? AND 
              percentuale_passaggi_riusciti >= ? AND percentuale_passaggi_riusciti <= ? AND 
              gol_fatti >= ? AND gol_fatti <= ? AND 
              gol_subiti >= ? AND gol_subiti <= ? AND 
              assist >= ? AND assist <= ? AND 
              ammonizioni >= ? AND ammonizioni <= ? AND 
              espulsioni >= ? AND espulsioni <= ?;");

        $statement->bind_param("iiiiiiiiiiiiiiiiiiii", $minTiriTotali, $maxTiriTotali, $minTiriPorta, $maxTiriPorta, $minFalliFatti, $maxFalliFatti,
            $minFalliSubiti, $maxFalliSubiti, $minPercentualePassaggiRiusciti, $maxPercentualePassaggiRiusciti, $minGolFatti, $maxGolFatti, $minGolSubiti,
            $maxGolSubiti, $minAssist, $maxAssist, $minAmmonizioni, $maxAmmonizioni, $minEspulsioni, $maxEspulsioni);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            $arrayStatistiche = array();

            for ($i = 0; $row = $result->fetch_assoc(); $i++) {
                $arrayStatistiche[] = new StatisticheCalciatore(row["calciatore"], $row["tiri_totali"], $row["tiri_porta"],
                    $row["falli_fatti"], $row["falli_subiti"], $row["percentuale_passaggi_riusciti"], $row["gol_fatti"],
                    $row["gol_subiti"], $row["assist"], $row["ammonizioni"], $row["espulsioni"], $row["partite_giocate"]);
            }

            return $arrayStatistiche;
        } else {
            return null;
        }

        /*$arrayStatistiche = array();
        for ($i = 0; $i < 10; $i++) {
            $arrayStatistiche[] = "ciao";
        }

        return $arrayStatistiche;*/
    }

    /**
     * Modifica le statistiche del calciatore, sostituendole con quelle passate in input.
     * @param StatisticheCalciatore $statisticheCalciatore
     */
    public function modificaStatisticheCalciatore(StatisticheCalciatore $statistiche, $nomePartita, $dataPartita)
    {
        $statement = $this->conn->prepare("UPDATE statistiche_calciatore SET tiri_totali = ?, tiri_porta = ?, 
falli_fatti = ?, falli_subiti = ?, percentuale_passaggi_riusciti = ?, gol_fatti = ?, gol_subiti = ?, 
assist = ?, ammonizioni = ?, espulsioni = ? WHERE calciatore = ? AND nome_partita = ? AND data_partita = ?");
        $username = $statistiche->getUsernameCalciatore();
        $tiriTotali = $statistiche->getTiriTotali();
        $tiriPorta = $statistiche->getTiriPorta();
        $falliFatti = $statistiche->getFalliFatti();
        $falliSubiti = $statistiche->getFalliSubiti();
        $percentualePassaggiRiusciti = $statistiche->getPercentualePassaggiRiusciti();
        $golFatti = $statistiche->getGolFatti();
        $golSubiti = $statistiche->getGolSubiti();
        $assist = $statistiche->getAssist();
        $ammonizioni = $statistiche->getAmmonizioni();
        $espulsioni = $statistiche->getEspulsioni();

        $statement->bind_param("iiiiiiiiiisss", $tiriTotali, $tiriPorta, $falliFatti, $falliSubiti,
            $percentualePassaggiRiusciti, $golFatti, $golSubiti, $assist, $ammonizioni, $espulsioni, $username, $nomePartita, $dataPartita);

        $executed = $statement->execute();
        return $executed;
    }
}