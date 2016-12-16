<?php
namespace AppBundle\it\unisa\account;
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 15/12/2016
 * Time: 10:35
 */
class Calciatore extends Account
{
    /*Dati peculiari al calciatore*/
    private $nazionalita;
    private $numeroMaglia;
    private $valore;
    private $stipendio;
    private $piedePreferito;
    private $capitano;
    private $ruoli;

    /*Dati statistiche*/
    private $statisticheCalciatore;

    /**
     * @return mixed
     */
    public function getNazionalita()
    {
        return $this->nazionalita;
    }

    /**
     * @param mixed $nazionalita
     */
    public function setNazionalita($nazionalita)
    {
        $this->nazionalita = $nazionalita;
    }

    /**
     * @return mixed
     */
    public function getNumeroMaglia()
    {
        return $this->numeroMaglia;
    }

    /**
     * @param mixed $numeroMaglia
     */
    public function setNumeroMaglia($numeroMaglia)
    {
        $this->numeroMaglia = $numeroMaglia;
    }

    /**
     * @return mixed
     */
    public function getValore()
    {
        return $this->valore;
    }

    /**
     * @param mixed $valore
     */
    public function setValore($valore)
    {
        $this->valore = $valore;
    }

    /**
     * @return mixed
     */
    public function getStipendio()
    {
        return $this->stipendio;
    }

    /**
     * @param mixed $stipendio
     */
    public function setStipendio($stipendio)
    {
        $this->stipendio = $stipendio;
    }

    /**
     * @return mixed
     */
    public function getPiedePreferito()
    {
        return $this->piedePreferito;
    }

    /**
     * @param mixed $piedePreferito
     */
    public function setPiedePreferito($piedePreferito)
    {
        $this->piedePreferito = $piedePreferito;
    }

    /**
     * @return mixed
     */
    public function getCapitano()
    {
        return $this->capitano;
    }

    /**
     * @param mixed $capitano
     */
    public function setCapitano($capitano)
    {
        $this->capitano = $capitano;
    }

    /**
     * @return mixed
     */
    public function getRuoli()
    {
        return $this->ruoli;
    }

    /**
     * @param mixed $ruoli
     */
    public function setRuoli($ruoli)
    {
        $this->ruoli = $ruoli;
    }

    /**
     * @return mixed
     */
    public function getStatisticheCalciatore()
    {
        return $this->statisticheCalciatore;
    }

    /**
     * @param mixed $statisticheCalciatore
     */
    public function setStatisticheCalciatore($statisticheCalciatore)
    {
        $this->statisticheCalciatore = $statisticheCalciatore;
    }
}