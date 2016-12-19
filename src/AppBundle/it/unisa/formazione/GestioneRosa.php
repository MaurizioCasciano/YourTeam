<?php

/**
 * Created by PhpStorm.
 * User: luigidurso
 * Date: 19/12/16
 * Time: 10:02
 */

namespace AppBundle\it\unisa\formazione;

use AppBundle\it\unisa\account\Calciatore;
use \AppBundle\Utility\DB;
use Symfony\Component\Config\Definition\Exception\Exception;

class GestioneRosa
{
    private $db;
    private $connessione;

    //inizio connessione al database alla costruzione del gestore
    public function __construct()
    {
        $this->db=new DB();
        $this->connessione=$this->db->connect();
    }

    /**
     * Metodo che prende tutti i calciatori della squadra dal db e li restituisce
     * @return array
     */
    public function visualizzaRosa()
    {
        if (isset($_SESSION))
        {
            $squadra=$_SESSION["squadra"];
            $query="SELECT * FROM Calciatore WHERE squadra='$squadra'";
            $risultato=$this->connessione->query($query);

            if($risultato->num_rows<=0) throw new Exception("nessun calciatore trovato per la squadra".$squadra);

            while ($calciatore=$risultato->fetch_assoc())
            {
                $obj=new Calciatore($calciatore["contratto"],$calciatore["password"],$calciatore["squadra"],$calciatore["email"],$calciatore["nome"],$calciatore["cognome"],$calciatore["datadinascita"],$calciatore["domicilio"],$calciatore["indirizzo"],$calciatore["provincia"],$calciatore["telefono"],$calciatore["immagine"],$calciatore["nazionalita"]);

                $calciatori[]=$obj;
            }
            return $calciatori;
        }
        else
        {
            throw new Exception("eseguire prima l'accesso");
        }
    }

    /**
     * Ritorna tutte le tattiche predefinite inserite nel db
     */
    public function visualizzaTattica()
    {

    }

    /**
     * Metodo che prende in input un ruolo e ne restituisce tutti i calciatori che lo conoscono.
     * @param $ruolo
     */
    public function scegliCalciatore($ruolo)
    {

    }

    /**
     * Metodo che prende in input una partita ed un modulo ed aggiorna la tabella partita nel db.
     * @param $partita
     * @param $modulo
     */
    public function scritturaModulo($partita,$modulo)
    {

    }

    function __destruct()
    {
        // TODO: Implement __destruct() method.
        $this->db->close($this->connessione);
    }


}