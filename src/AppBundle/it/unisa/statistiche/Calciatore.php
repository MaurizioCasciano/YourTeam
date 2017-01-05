<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 03/01/2017
 * Time: 14:58
 */

namespace AppBundle\it\unisa\statistiche;


use AppBundle\it\unisa\account\Account;

class Calciatore implements \JsonSerializable
{
    private $contratto;
    private $password;
    private $squadra;
    private $email;
    private $nome;
    private $cognome;
    private $dataDiNascita;
    private $numeroMaglia;
    private $domicilio;
    private $indirizzo;
    private $provincia;
    private $telefono;
    private $immagine;
    private $statistiche;

    /**
     * Calciatore constructor.
     * @param $contratto
     * @param $password
     * @param $squadra
     * @param $email
     * @param $nome
     * @param $cognome
     * @param $dataDiNascita
     * @param $domicilio
     * @param $indirizzo
     * @param $provincia
     * @param $telefono
     * @param $immagine
     */
    public function __construct($contratto, $password, $squadra, $email, $nome, $cognome, $dataDiNascita, $numeroMaglia, $domicilio, $indirizzo, $provincia, $telefono, $immagine)
    {
        $this->contratto = $contratto;
        $this->password = $password;
        $this->squadra = $squadra;
        $this->email = $email;
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->dataDiNascita = $dataDiNascita;
        $this->numeroMaglia = $numeroMaglia;
        $this->domicilio = $domicilio;
        $this->indirizzo = $indirizzo;
        $this->provincia = $provincia;
        $this->telefono = $telefono;
        $this->immagine = $immagine;
        $this->statistiche = null;
    }

    /**
     * @return mixed
     */
    public function getContratto()
    {
        return $this->contratto;
    }

    /**
     * @param mixed $contratto
     */
    public function setContratto($contratto)
    {
        $this->contratto = $contratto;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
    public function getCognome()
    {
        return $this->cognome;
    }

    /**
     * @param mixed $cognome
     */
    public function setCognome($cognome)
    {
        $this->cognome = $cognome;
    }

    /**
     * @return mixed
     */
    public function getDataDiNascita()
    {
        return $this->dataDiNascita;
    }

    /**
     * @param mixed $dataDiNascita
     */
    public function setDataDiNascita($dataDiNascita)
    {
        $this->dataDiNascita = $dataDiNascita;
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
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * @param mixed $domicilio
     */
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;
    }

    /**
     * @return mixed
     */
    public function getIndirizzo()
    {
        return $this->indirizzo;
    }

    /**
     * @param mixed $indirizzo
     */
    public function setIndirizzo($indirizzo)
    {
        $this->indirizzo = $indirizzo;
    }

    /**
     * @return mixed
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * @param mixed $provincia
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;
    }

    /**
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param mixed $telefono
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    /**
     * @return mixed
     */
    public function getImmagine()
    {
        return $this->immagine;
    }

    /**
     * @param mixed $immagine
     */
    public function setImmagine($immagine)
    {
        $this->immagine = $immagine;
    }

    public function hasStatistiche()
    {
        return $this->statistiche != null;
    }

    /**
     * @return
     */
    public function getStatistiche()
    {
        if (!$this->hasStatistiche()) {
            throw  new \Exception("Questo calciatore non ha statistiche.");
        }

        return $this->statistiche;
    }

    /**
     * @param $statistiche
     */
    public function setStatistiche($statistiche)
    {
        $this->statistiche = $statistiche;
    }

    function jsonSerialize()
    {
        return [
            "contratto" => $this->getContratto(),
            "squadra" => $this->getSquadra(),
            "email" => $this->getEmail(),
            "nome" => $this->getNome(),
            "cognome" => $this->getCognome(),
            "datadinascita" => $this->getDataDiNascita(),
        ];
    }
}