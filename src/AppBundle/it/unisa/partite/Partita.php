<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 26/12/2016
 * Time: 15:23
 */

namespace AppBundle\it\unisa\partite;


class Partita implements PartitaInterface
{
    private $casa;
    private $trasferta;
    private $data;
    private $squadra;
    private $stadio;

    /**
     * Partita constructor.
     * @param $nome string Il nome della partita. Es. : Casa - Trasferta
     * @param $data \DateTime La data e l'ora della partita. Es. : 2016-12-20 20:45
     * @param $squadra string La squadra a cui si riferiscono le informazioni della partita.
     * @param $stadio string Lo stadio in cui si disputa l'incontro.
     */
    public function __construct($casa, $trasferta, $data, $squadra, $stadio)
    {
        $this->casa = $casa;
        $this->trasferta = $trasferta;
        $this->data = $data;
        $this->squadra = $squadra;
        $this->stadio = $stadio;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->casa . " - " . $this->trasferta;
    }

    /**
     * @return mixed
     */
    public function getCasa()
    {
        return $this->casa;
    }

    /**
     * @return mixed
     */
    public function getTrasferta()
    {
        return $this->trasferta;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
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

    /**
     * @return mixed
     */
    public function getStadio()
    {
        return $this->stadio;
    }

    /**
     * @param mixed $stadio
     */
    public function setStadio($stadio)
    {
        $this->stadio = $stadio;
    }

    function __toString()
    {
        return "Partita[nome: " . $this->nome . ", data: " . $this->data . ", squadra: " . $this->getSquadra() . ", stadio: " . $this->getStadio() . "]";
    }


}