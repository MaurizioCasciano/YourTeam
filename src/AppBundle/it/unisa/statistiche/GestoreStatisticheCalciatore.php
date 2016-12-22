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
     * Restituisce le statistiche di un calciatore.
     * @param $usernameCalciatore L'ID del calciatore.
     * @return StatisticheCalciatore Le statistiche del calciatore.
     * @deprecated
     */
    public function getStatisticheCalciatore($usernameCalciatore)
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

        $statement = $this->conn->prepare("SELECT * FROM calciatore WHERE calciatore.contratto = ?");
        $statement->bind_param("s", $usernameCalciatore);
        $executed = $statement->execute();
        $result = $statement->get_result();

        $row = $result->fetch_assoc();

        $statisticheCalciatore = new StatisticheCalciatore($row["contratto"], $row["tiritotali"], $row["tiriporta"], $row["fallifatti"], $row["fallisubiti"], $row["percentualepassaggiriusciti"], $row["golfatti"], $row["golsubiti"], $row["assist"], $row["ammonizioni"], $row["espulsioni"]/*, $row["partitegiocate"]*/);
        return $statisticheCalciatore;
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
                yourteam.statistiche_calciatore
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
     * Restituisce i calciatori che rispettano il filtro.
     * @param Filtro $filtro
     * @return Account
     * @throws \Exception
     */
    public function filtraCalciatori(FiltroStatisticheCalciatore $filtroStatisticheCalciatore)
    {
        $sql = "SELECT * FROM calciatore";
        $result = $this->conn->query($sql);

        /*se la query ha successo allora la proprietà di $res è >0
        chiaramente potremmo controllare anche se la query è ben
        formattata(controllo solo in fase di sviluppo)
        quindi si può evitare di fare*/
        if ($result->num_rows <= 0) throw new \Exception("Nessun calciatore presente nel database.");

        $calciatori[] = array();
        //get data of each row
        while ($row = $result->fetch_assoc()) {
            //statistiche
            $usernameCalciatore = $row["contratto"];
            $tiriTotali = $row["tiritotali"];
            $tiriPorta = $row["tiriporta"];
            $falliFatti = $row["fallifatti"];
            $falliSubiti = $row["fallisubiti"];
            $percentualePassaggiRiusciti = $row["percentualepassaggiriusciti"];
            $golFatti = $row["golfatti"];
            $golSubiti = $row["golsubiti"];
            $assist = $row["assist"];
            $ammonizioni = $row["ammonizioni"];
            $espulsioni = $row["espulsioni"];
            $partiteGiocate = $row["partitegiocate"];

            //dettagli
            $numeroMaglia = $row["numeromaglia"];
            $valore = $row["valore"];
            $stipendio = $row["stipendio"];
            $piedePreferito = $row["piedepreferito"];
            $capitano = $row["capitano"];
            $ruoli = null;


            //accountCalciatore
            /*usernameCalciatore*/
            $password = $row["password"];
            $squadra = $row["squadra"];
            $email = $row["email"];
            $nome = $row["nome"];
            $cognome = $row["cognome"];
            $dataDiNascita = $row["datadinascita"];
            $domicilio = $row["domicilio"];
            $indirizzo = $row["indirizzo"];
            $provincia = $row["provincia"];
            $telefono = $row["telefono"];
            $immagine = $row["immagine"];
            $nazionalita = $row["nazionalita"];

            $accountCalciatore = new AccountCalciatore($usernameCalciatore, $password, $squadra, $email, $nome, $cognome, $dataDiNascita, $domicilio, $indirizzo, $provincia, $telefono, $immagine, $nazionalita);
            $dettagliCalciatore = new DettagliCalciatore($usernameCalciatore, $tiriTotali, $tiriPorta, $falliFatti, $falliSubiti, $percentualePassaggiRiusciti, $golFatti, $golSubiti, $assist, $ammonizioni, $espulsioni, $partiteGiocate, $numeroMaglia, $valore, $stipendio, $piedePreferito, $capitano, $ruoli);

            if ($filtroStatisticheCalciatore->accept($dettagliCalciatore)) {
                $calciatori[] = array(
                    "calciatore" => $accountCalciatore
                );
            }
        }

        return $calciatori;
    }

    /**
     * Modifica le statistiche del calciatore, sostituendole con quelle passate in input.
     * @param StatisticheCalciatore $statisticheCalciatore
     */
    public function modificaStatisticheCalciatore(StatisticheCalciatore $statisticheCalciatore)
    {

    }
}