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
    private $nome;
    private $data;
    private $squadra;
    private $stadio;

    /**
     * Partita constructor.
     * @param $nome
     * @param $data
     * @param $squadra
     * @param $stadio
     */
    public function __construct($nome, $data, $squadra, $stadio)
    {
        $this->nome = $nome;
        $this->data = $data;
        $this->squadra = $squadra;
        $this->stadio = $stadio;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
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
}