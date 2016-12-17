<?php
namespace AppBundle\it\unisa\account;
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 14/12/2016
 * Time: 16:09
 */
class AccountCalciatore extends Account
{

    private $nazionalita;

    /**
     * AccountCalciatore constructor.
     * @param $nazionalita
     */
    public function __construct($username_codiceContratto, $password, $squadra, $email, $nome, $cognome, $dataDiNascita, $domicilio, $indirizzo, $provincia, $telefono, $immagine,$nazionalita)
    {
        $this->setUsernameCodiceContratto($username_codiceContratto);
        $this->setPassword($password);
        $this->setSquadra($squadra);
        $this->setEmail($email);
        $this->setNome($nome);
        $this->setCognome($cognome);
        $this->setDataDiNascita($dataDiNascita);
        $this->setDomicilio($domicilio);
        $this->setIndirizzo($indirizzo);
        $this->setProvincia($provincia);
        $this->setTelefono($telefono);
        $this->setImmagine($immagine);
        $this->nazionalita=$nazionalita;
    }

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

}