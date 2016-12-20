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

    public function __construct()
    {
        $this->db = new DB();
        $this->conn = $this->db->connect();
    }

    public function inserisciStatistiche(StatisticheCalciatore $statisticheCalciatore)
    {

    }

    public function getStatisticheCalciatore($usernameCalciatore)
    {

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

    public
    function modificaStatisticheCalciatore(StatisticheCalciatore $statisticheCalciatore)
    {

    }
}