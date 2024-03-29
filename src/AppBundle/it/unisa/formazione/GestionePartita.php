<?php
/**
 * Created by PhpStorm.
 * User: luigidurso
 * Date: 20/12/16
 * Time: 12:17
 */

namespace AppBundle\it\unisa\formazione;

use \AppBundle\Utility\DB;
use Symfony\Component\Config\Definition\Exception\Exception;

class GestionePartita
{
    private $db;
    private $connessione;
    private static $instance = null;

    private function __construct()
    {
        $this->db=DB::getInstance();
        $this->connessione=$this->db->connect();
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

    /**
     * Controlla la presenza di una partita tra massimo 2 giorni
     * @param $squadra
     * @return Partita|null
     */
    private function disponibilitaPartita($squadra)
    {
        //creazione data odierna e +2 giorni
        $dateStart=date("Y-m-d");
        $dateEnd=date("Y-m-d",strtotime($dateStart."+ 2 days"));
        //prendo partita tra 2 giorni
        $query="SELECT * FROM partita WHERE squadra='$squadra' AND data>='$dateStart' AND data<='$dateEnd'";

        $risultato=$this->connessione->query($query);

        if($risultato->num_rows<0) throw new Exception("errore query partite per la squadra: ".$squadra);
        //se esiste, ritorna la partita
        if($risultato->num_rows==1)
        {
            $partita=$risultato->fetch_assoc();
            $modelPartita=new Partita($partita["nome"],$partita["data"],$partita["squadra"],$partita["stadio"],$partita["modulo"]);
            return $modelPartita;
        }

        if($risultato->num_rows>1) throw new Exception("Errore database, piu partite in 2 giorni per : ".$squadra);

        return null;


    }

    /**
     * prende , se presenta , una partita entro 2 giorni e ne controlla la disp. alla formazione
     * @param $squadra
     */
    public function disponibilitaFormazione($squadra)
    {
        try
        {
            $partita=$this->disponibilitaPartita($squadra);
        }
        catch (Exception $erDatabase)
        {
            throw new PartitaNonDispException("".$erDatabase->getMessage());
        }

        if(!is_null($partita))
        {
            $data=$partita->getData();
            $nomePartita=$partita->getNome();

            $query="SELECT * FROM giocare WHERE partita='$nomePartita' AND data='$data' AND squadra='$squadra'";
            $risultato=$this->connessione->query($query);

            if($risultato->num_rows<=0)
            {
                throw new FormazioneNonDispException("Convocazioni non ancora diramate per la prossima partita.");
            }
            if($partita->getModulo()!= null)
            {
                throw new FormazioneNonDispException("Formazione già schierata per la prossima partita.");
            }
            return $partita;
        }
        else
        {
            throw new PartitaNonDispException("Non esiste nessuna partita entro 48 ore disponibile alla formazione!");
        }

    }

    /**
     * prende , se presenta , una partita entro 2 giorni e ne controlla la disp. alle convocazioni
     * @param $squadra
     */
    public function disponibilitaConvocazione($squadra)
    {
        try
        {
            $partita=$this->disponibilitaPartita($squadra);
        }
        catch (Exception $erDatabase)
        {
            throw new PartitaNonDispException("".$erDatabase->getMessage());
        }

        if(!is_null($partita))
        {
            $data=$partita->getData();
            $nomePartita=$partita->getNome();

            $query="SELECT * FROM giocare WHERE partita='$nomePartita' AND data='$data' AND squadra='$squadra'";
            $risultato=$this->connessione->query($query);

            if($risultato->num_rows!=0)
            {
                throw new ConvocNonDispException("Convocazioni già diramate per la prossima partita!");
            }
            else
            {
                return $partita;
            }
        }
        else
        {
            throw new PartitaNonDispException("Non esiste nessuna partita entro 48 ore disponibile alla convocazione!");
        }
    }

    /**
     * Metodo che prende in input i calciatori e la partita e scrive nel db le convocazioni
     * @param $calciatori
     * @param $partita
     */
    public function diramaConvocazioni($calciatori,$partita)
    {
        $data=$partita->getData();
        $nomePartita=$partita->getNome();
        $squadra=$partita->getSquadra();

        foreach ($calciatori as $calciatore)
        {
            $query="INSERT INTO giocare(calciatore,partita,data,squadra) VALUES ('$calciatore', '$nomePartita','$data','$squadra')";
            $this->connessione->query($query);
        }


    }

    /**
     * Metodo che prende in input una partita ed un modulo ed aggiorna la tabella partita nel db.
     * @param $partita
     * @param $modulo
     */
    public function scritturaModulo($partita,$modulo)
    {
        $data=$partita->getData();
        $nomePartita=$partita->getNome();
        $squadra=$partita->getSquadra();

        $query="UPDATE partita SET modulo='$modulo' WHERE data='$data' AND nome='$nomePartita' AND squadra='$squadra'";

        $this->connessione->query($query);
    }


    function __destruct()
    {
        // TODO: Implement __destruct() method.
        $this->db->close($this->connessione);
    }


}