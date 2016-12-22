<?php
/**
 * Created by PhpStorm.
 * User: luigidurso
 * Date: 22/12/16
 * Time: 12:42
 */

namespace AppBundle\it\unisa\account;


class DettagliCalciatore extends AccountCalciatore implements \JsonSerializable
{
    //dettagli calciatore
    private $numeroMaglia;
    private $valore;
    private $stipendio;
    private $piedePreferito;
    private $capitano;
    private $ruoli;

    /**
     * DettagliCalciatore constructor.
     * @param $numeroMaglia
     * @param $valore
     * @param $stipendio
     * @param $piedePreferito
     * @param $capitano
     * @param $ruoli
     */
    public function __construct($username_codiceContratto, $password, $squadra, $email, $nome, $cognome, $dataDiNascita, $domicilio, $indirizzo, $provincia, $telefono, $immagine,$nazionalita,$numeroMaglia, $valore, $stipendio, $piedePreferito, $capitano, $ruoli)
    {
        parent::__construct($username_codiceContratto, $password, $squadra, $email, $nome, $cognome, $dataDiNascita, $domicilio, $indirizzo, $provincia, $telefono, $immagine,$nazionalita);
        $this->numeroMaglia = $numeroMaglia;
        $this->valore = $valore;
        $this->stipendio = $stipendio;
        $this->piedePreferito = $piedePreferito;
        $this->capitano = $capitano;
        $this->ruoli = $ruoli;
    }

    public function aggiungiRuolo($ruolo)
    {
        $this->ruoli[]=$ruolo;
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

    function jsonSerialize()
    {
        return [
            'contratto' => $this->getUsernameCodiceContratto(),
            'nomeCognome' => $this->getNome()." ".$this->getCognome(),
            'ruoli' => $this->ruoli
        ];
    }


}