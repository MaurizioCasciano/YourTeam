<?php
namespace AppBundle\it\unisa\account;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 14/12/2016
 * Time: 16:09
 */
class Account
{
    /*Dati di accesso*/
    /**
     * @Assert\NotBlank();
     */
    private $username_codiceContratto;
    /**
     * @Assert\NotBlank();
     */
    private $password;
    /**
     * @Assert\NotBlank();
     */
    private $squadra;
    /**
     * @Assert\NotBlank();
     * @Assert\Email()
     */
    private $email;

    /*Dati personali*/
    /**
     * @Assert\NotBlank();
     */
    private $nome;
    /**
     * @Assert\NotBlank();
     */
    private $cognome;
    /**
     * @Assert\NotBlank();
     */
    private $dataDiNascita;
    /**
     * @Assert\NotBlank();
     */
    private $domicilio;
    /**
     * @Assert\NotBlank();
     */
    private $indirizzo;
    /**
     * @Assert\NotBlank();
     */
    private $provincia;
    /**
     * @Assert\NotBlank();
     */
    private $telefono;
    /**
     * @Assert\NotBlank();
     */
    private $immagine;
    /**
     * @Assert\NotBlank();
     */
    private $tipo;

    /**
     * Account constructor.
     * @param $username_codiceContratto
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
     * @param $tipo
     */
    public function __construct()
    {

    }


    /**
     * @return mixed
     */
    public function getUsernameCodiceContratto()
    {
        return $this->username_codiceContratto;
    }

    /**
     * @param mixed $username_codiceContratto
     * @return Account
     */
    public function setUsernameCodiceContratto(String $username_codiceContratto)
    {
        $this->username_codiceContratto = $username_codiceContratto;
        return $this;
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
     * @return Account
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
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
     * @return Account
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
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
     * @return Account
     */
    public function setCognome($cognome)
    {
        $this->cognome = $cognome;
        return $this;
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
     * @return Account
     */
    public function setDataDiNascita($dataDiNascita)
    {
        $this->dataDiNascita = $dataDiNascita;
        return $this;
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
     * @return Account
     */
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResidenza()
    {
        return $this->residenza;
    }

    /**
     * @param mixed $residenza
     * @return Account
     */
    public function setResidenza($residenza)
    {
        $this->residenza = $residenza;
        return $this;
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
     * @return Account
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
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
     * @return Account
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
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

}