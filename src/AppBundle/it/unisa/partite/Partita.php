<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 26/12/2016
 * Time: 15:23
 */

namespace AppBundle\it\unisa\partite;


use AppBundle\it\unisa\statistiche\StatistichePartita;

class Partita implements PartitaInterface, \JsonSerializable
{
    private $casa;
    private $trasferta;
    private $data;
    private $squadra;
    private $stadio;
    private $statistiche;
    private $convocati;

    /**
     * Partita constructor.
     * @param string $casa Il nome della squadra che gioca in casa.
     * @param string $trasferta Il nome della squadra che gioca in trasferta.
     * @param \DateTime $data La data e l'ora in cui si disputa l'incontro.
     * @param string $squadra La squadra a cui si riferiscono le informazioni dell'incontro.
     * @param string $stadio Lo stadio in cui si disputa l'incontro.
     */
    public function __construct($casa, $trasferta, $data, $squadra, $stadio)
    {
        $this->casa = $casa;
        $this->trasferta = $trasferta;
        $this->data = $data;
        $this->squadra = $squadra;
        $this->stadio = $stadio;
        $this->statistiche = null;
        $this->convocati = null;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->getCasa() . "-" . $this->getTrasferta();
    }

    /**
     * @return mixed
     */
    public function getCasa()
    {
        return $this->casa;
    }

    /**
     * @param mixed $casa
     */
    public function setCasa($casa)
    {
        $this->casa = $casa;
    }

    /**
     * @return mixed
     */
    public function getTrasferta()
    {
        return $this->trasferta;
    }

    /**
     * @param mixed $trasferta
     */
    public function setTrasferta($trasferta)
    {
        $this->trasferta = $trasferta;
    }

    /**Restituisce la data completa in cui si disputa l'incontro.
     * Es. 2016-12-12 20:45:00
     * @return mixed
     */
    public function getData()
    {
        return $this->data->format("Y-m-d H:i:s");
    }

    /**
     * Restituisce la data completa in cui si disputa l'incontro, come stringa.
     * @return string La data della partita come stringa.
     */
    public function getDataString()
    {
        return $this->data->format("Y-m-d H:i:s");
    }

    /**
     * Restituisce la data, a meno dell'ora,  in cui si disputa l'incontro.
     * @return string La data, a meno dell'ora.
     */
    public function getDataSenzaOra()
    {
        $dataSenzaOra = $this->data->format('Y-m-d');
        return $dataSenzaOra;
    }

    /**
     * Restituisce l'ora in cui si disputa l'incontro.
     * @return string L'ora in cui si disputa l'incontro.
     */
    public function getOra()
    {
        $time = $this->data->format("H:i:s");
        return $time;
    }

    /**
     * @param \DateTime $data
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

    /**
     * @return bool
     */
    public function hasStatistiche()
    {
        return $this->statistiche != null;
    }

    /**
     * @return mixed
     */
    public function getStatistiche()
    {
        if ($this->hasStatistiche()) {
            return $this->statistiche;
        } else {
            throw new \Exception("Non ci sono ancora statistiche per questa partita.");
        }
    }

    /**
     * @param mixed $statistiche
     */
    public function setStatistiche($statistiche)
    {
        $this->statistiche = $statistiche;
    }

    public function hasConvocati()
    {
        return $this->convocati != null && count($this->convocati) > 0;
    }

    /**
     * @return null
     */
    public function getConvocati()
    {
        if ($this->hasConvocati()) {
            return $this->convocati;
        } else {
            throw new \Exception("Non ci sono ancora convocati per questa partita.");
        }

    }

    /**
     * @param null $convocati
     */
    public function setConvocati($convocati)
    {
        if (count($convocati) > 0) {
            $this->convocati = $convocati;
        }
    }

    function __toString()
    {
        return "Partita[nome: " . $this->getNome() . ", data: " . $this->data . ", squadra: " . $this->getSquadra() . ", stadio: " . $this->getStadio() . "]";
    }


    function jsonSerialize()
    {
        return [
            "casa" => $this->getCasa(),
            "trasferta" => $this->getTrasferta(),
            "nome" => $this->getNome(),
            "data" => $this->getDataString(),
            "data_senza_ora" => $this->getDataSenzaOra(),
            "ora" => $this->getOra(),
            "squadra" => $this->getSquadra(),
            "stadio" => $this->getStadio()
        ];
    }
}