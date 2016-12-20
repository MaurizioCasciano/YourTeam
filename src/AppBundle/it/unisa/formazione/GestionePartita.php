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

    public function __construct()
    {
        $this->db=new DB();
        $this->connessione=$this->db->connect();
    }

    /**
     * Controlla la presenza di una partita tra massimo 2 giorni
     */
    public function disponibilitaPartita($squadra)
    {
        $dateStart=date("Y-m-d");
        $dateEnd=date("Y-m-d",strtotime($dateStart."+ 2 days"));

        $query="SELECT * FROM partita WHERE squadra='$squadra' AND data>='$dateStart' AND data<='$dateEnd'";

        $risultato=$this->connessione->query($query);

        if($risultato->num_rows<=0) throw new Exception("errore query partite per la squadra: ".$squadra);

        if($risultato->num_rows==1)
        {
            $partita=$risultato->fetch_assoc();
            return $partita["nome"]; //in attesa del model
        }

        return null;


    }

    function __destruct()
    {
        // TODO: Implement __destruct() method.
        $this->db->close($this->connessione);
    }


}