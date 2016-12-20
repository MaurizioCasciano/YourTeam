<?php

namespace AppBundle\it\unisa\comunicazione;


/**
 * Created by PhpStorm.
 * User: Donato
 * Date: 20/12/2016
 * Time: 11:58
 */
class Messaggio
{

    private $mittente;
    private $calciatore;
    private $username;
    private $testo;


    public function __construct($t, $u, $c, $mitt)
    {
        $this->testo = $t;
        $this->username = $u;
        $this->calciatore = $c;
        $this->mittente = $mitt;
    }

    /**
     * @return mixed
     */
    public function getMittente()
    {
        return $this->mittente;
    }

    /**
     * @param mixed $mittente
     */
    public function setMittente($mittente)
    {
        $this->mittente = $mittente;
    }

    /**
     * @return mixed
     */
    public function getCalciatore()
    {
        return $this->calciatore;
    }

    /**
     * @param mixed $calciatore
     */
    public function setCalciatore($calciatore)
    {
        $this->calciatore = $calciatore;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $allenatore
     */
    public function setusername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getTesto()
    {
        return $this->testo;
    }

    /**
     * @param mixed $testo
     */
    public function setTesto($testo)
    {
        $this->testo = $testo;
    }



}