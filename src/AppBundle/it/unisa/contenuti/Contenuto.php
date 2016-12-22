<?php
namespace AppBundle\it\unisa\contenuti;

/**
 * Created by PhpStorm.
 * User: Carmine
 * Date: 20/12/2016
 * Time: 11:35
 */
class Contenuto
{
    private $id;
    private $titolo;
    private $descrizione;
    private $URL;
    private $tipo;
    private $squadra;

    /**
     * Contenuto constructor.
     * @param $titolo
     * @param $descrizione
     * @param $URL
     * @param $tipo
     * @param $squadra
     */
    public function __construct($titolo, $descrizione, $URL, $tipo,$squadra)
    {
        $this->titolo = $titolo;
        $this->descrizione = $descrizione;
        $this->URL = $URL;
        $this->tipo = $tipo;
        $this->squadra=$squadra;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * @return mixed
     */
    public function getSquadra()
    {
        return $this->squadra;
    }

    /**
     * @param mixed $squadra
     */
    public function setSquadra($squadra)
    {
        $this->squadra = $squadra;
    }



    /**
     * @return mixed
     */
    public function getTitolo()
    {
        return $this->titolo;
    }

    /**
     * @param mixed $titolo
     */
    public function setTitolo($titolo)
    {
        $this->titolo = $titolo;
    }

    /**
     * @return mixed
     */
    public function getDescrizione()
    {
        return $this->descrizione;
    }

    /**
     * @param mixed $desrizione
     */
    public function setDescrizione($descrizione)
    {
        $this->descrizione = $descrizione;
    }

    /**
     * @return mixed
     */
    public function getURL()
    {
        return $this->URL;
    }

    /**
     * @param mixed $URL
     */
    public function setURL($URL)
    {
        $this->URL = $URL;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function __toString()
    {
        return "Titolo: ".$this->titolo."<br/> Descrizione: ".$this->descrizione."<br/> URL: ".$this->URL." <br/> Tipo: ".$this->tipo." <br/> Squadra: ".$this->squadra;
    }
}