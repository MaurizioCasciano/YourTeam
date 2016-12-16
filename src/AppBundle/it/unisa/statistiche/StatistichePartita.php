<?php

/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 14/12/2016
 * Time: 18:52
 */
class StatistichePartita
{
    /**
     * @var $golFatti Il numero di gol fatti.
     */
    private $golFatti;
    /**
     * @var $golSubiti Il numero di gol subiti.
     */
    private $golSubiti;
    private $possessoPalla;
    private $marcatori;
    private $assistMen;
    private $ammonizioni;
    private $espulsioni;
    /**
     * @var $nome Il nome della partita.
     */
    private $nome;
    /**
     * @var $data La data della partita.
     */
    private $data;

    /**
     * @var $squadra La squdra a cui si riferiscono le statistiche della partita.
     */
    private $squadra;

    /**
     * Restituisce il numero di gol fatti dalla squdra.
     * @return Il numero di gol fatti dalla squadra.
     */
    public function getGolFatti()
    {
        return $this->golFatti;
    }

    /**
     * @param $golFatti Il numero di gol fatti dalla squadra.
     */
    public function setGolFatti($golFatti)
    {
        $this->golFatti = $golFatti;
    }

    /**
     * @return Il numero di gol subiti dalla squadra.
     */
    public function getGolSubiti()
    {
        return $this->golSubiti;
    }

    /**
     * @param $golSubiti Il numero di gol subiti dalla squadra.
     */
    public function setGolSubiti($golSubiti)
    {
        $this->golSubiti = $golSubiti;
    }

    /**
     * @return Il possesso palla della squadra nell'arco della partita.
     */
    public function getPossessoPalla()
    {
        return $this->possessoPalla;
    }

    /**
     * @param mixed $possessoPalla
     */
    public function setPossessoPalla($possessoPalla)
    {
        $this->possessoPalla = $possessoPalla;
    }

    /**
     * @return mixed
     */
    public function getMarcatori()
    {
        return $this->marcatori;
    }

    /**
     * @param mixed $marcatori
     */
    public function setMarcatori($marcatori)
    {
        $this->marcatori = $marcatori;
    }

    /**
     * @return mixed
     */
    public function getAssistMen()
    {
        return $this->assistMen;
    }

    /**
     * @param mixed $assistMen
     */
    public function setAssistMen($assistMen)
    {
        $this->assistMen = $assistMen;
    }

    /**
     * @return mixed
     */
    public function getAmmonizioni()
    {
        return $this->ammonizioni;
    }

    /**
     * @param mixed $ammonizioni
     */
    public function setAmmonizioni($ammonizioni)
    {
        $this->ammonizioni = $ammonizioni;
    }

    /**
     * @return mixed
     */
    public function getEspulsioni()
    {
        return $this->espulsioni;
    }

    /**
     * @param mixed $espulsioni
     */
    public function setEspulsioni($espulsioni)
    {
        $this->espulsioni = $espulsioni;
    }

    /**
     * @return Il
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param Il $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return La
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param La $data
     */
    public function setData($data)
    {
        $this->data = $data;
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
}