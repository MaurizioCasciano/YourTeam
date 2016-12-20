<?php

/**
 * Created by PhpStorm.
 * User: Carmine
 * Date: 20/12/2016
 * Time: 11:35
 */
class Contenuto
{
    private $titolo;
    private $desrizione;
    private $URL;
    private $tipo;
    private $squadra;

    /**
     * Contenuto constructor.
     * @param $titolo
     * @param $desrizione
     * @param $URL
     * @param $tipo
     * @param $squadra
     */
    public function __construct($titolo, $desrizione, $URL, $tipo,$squadra)
    {
        $this->titolo = $titolo;
        $this->desrizione = $desrizione;
        $this->URL = $URL;
        $this->tipo = $tipo;
        $this->squadra=$squadra;
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
    public function getDesrizione()
    {
        return $this->desrizione;
    }

    /**
     * @param mixed $desrizione
     */
    public function setDesrizione($desrizione)
    {
        $this->desrizione = $desrizione;
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


}