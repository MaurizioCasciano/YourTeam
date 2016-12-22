<?php

/**
 * Created by PhpStorm.
 * User: luigidurso
 * Date: 19/12/16
 * Time: 10:02
 */

namespace AppBundle\it\unisa\formazione;

use AppBundle\it\unisa\account\AccountCalciatore;
use AppBundle\it\unisa\account\DettagliCalciatore;
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
    public function visualizzaRosa($squadra)
    {

        $query="SELECT * FROM Calciatore WHERE squadra='$squadra'";
        $risultato=$this->connessione->query($query);

        if($risultato->num_rows<=0) throw new Exception("nessun calciatore trovato per la squadra".$squadra);

        while ($calciatore=$risultato->fetch_assoc())
        {
            $obj=new AccountCalciatore($calciatore["contratto"],$calciatore["password"],$calciatore["squadra"],$calciatore["email"],$calciatore["nome"],$calciatore["cognome"],$calciatore["datadinascita"],$calciatore["domicilio"],$calciatore["indirizzo"],$calciatore["provincia"],$calciatore["telefono"],$calciatore["immagine"],$calciatore["nazionalita"]);

            $calciatori[]=$obj;
        }
        return $calciatori;

    }

    /**
     * Ritorna tutte le tattiche predefinite inserite nel db
     */
    public function visualizzaTattica()
    {
        $query="SELECT * FROM modulo";

        $risultato=$this->connessione->query($query);

        if($risultato->num_rows<=0) throw new Exception("errore accesso alle tattiche nel db!");

        while($tattica=$risultato->fetch_assoc())
        {
            $tattiche[]=$tattica["id"];
        }

        return $tattiche;


    }

    /**
     * metodo che prende in input i contratti dei calciatori schierati in campo
     * e li notifica con una email informativa
     * @param $calciatori
     */
    public function inviaEmailSchieramentoFormazione($calciatori)
    {
        foreach ($calciatori as $contratto)
        {
            $query="SELECT * FROM calciatore WHERE contratto='$contratto'";

            $risultato=$this->connessione->query($query);
            if($risultato->num_rows<=0) throw new Exception("nessun calciatore trovato!");

            if($risultato->num_rows==1)
            {
                $riga=$risultato->fetch_assoc();
                $emailCalciatore=$riga["email"];

                //invio email da implementare in attesa di account email per il sistema
            }
        }

    }

    /**
     * Metodo che ritorna i calciatori convocati per una partita
     * specificata in input
     * @param $partita
     */
    public function ottieniConvocati($partita)
    {
        $nomePartita=$partita->getNome();
        $dataPartita=$partita->getData();
        //seleziono tutti i calciatori convocati per questa partita
        $query="SELECT * FROM calciatore JOIN giocare ON calciatore.contratto=giocare.calciatore WHERE data='$dataPartita' AND partita='$nomePartita'";

        $risultato=$this->connessione->query($query);

        if($risultato->num_rows<=0) throw new Exception("nessun convocato trovato!");

        while ($dettaglioCalciatore=$risultato->fetch_assoc())
        {
            $convocato=new DettagliCalciatore($dettaglioCalciatore["contratto"],null,null,null,$dettaglioCalciatore["nome"],$dettaglioCalciatore["cognome"],null,null,null,null,null,null,null,null,null,null,null,null,null);
            //per ogni calciatore setto l'array di ruoli
            $contratto=$dettaglioCalciatore["contratto"];
            $queryRuoli="SELECT * FROM conosce WHERE calciatore='$contratto'";

            $risultatoRuoli=$this->connessione->query($queryRuoli);

            if($risultatoRuoli->num_rows<=0) throw new Exception("nessun ruolo trovato!");

            while ($ruolo=$risultatoRuoli->fetch_assoc())
            {
                $convocato->aggiungiRuolo($ruolo["ruolo"]);
            }
            $convocati[]=$convocato;
        }
        return $convocati;
    }


    function __destruct()
    {
        // TODO: Implement __destruct() method.
        $this->db->close($this->connessione);
    }


}