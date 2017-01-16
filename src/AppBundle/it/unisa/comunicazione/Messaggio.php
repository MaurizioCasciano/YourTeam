<?php

namespace AppBundle\it\unisa\comunicazione;

use AppBundle\it\unisa\account\GestoreAccount;


/**
 * Created by PhpStorm.
 * User: Donato
 * Date: 20/12/2016
 * Time: 11:58
 */
class Messaggio implements \JsonSerializable
{
    private $mittente;
    private $calciatore;
    private $allenatore;
    private $testo;
    private $data;
    private $tipo;
    private $id;

    //nome cognome
    private $nomeMittente;
    private $cognomeMittente;
    private $nomeDestinatario;
    private $cognomeDestinatario;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    public function getDataString()
    {
        return $this->data->format("Y-m-d H:i:s");
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
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }


    public function __construct($testo, $allenatore, $calciatore, $mittente, $data, $tipo)
    {
        $this->testo = $testo;
        $this->allenatore = $allenatore;
        $this->calciatore = $calciatore;
        $this->mittente = $mittente;
        $this->data = $data;
        $this->tipo = $tipo;
    }


    /**
     * @return mixed
     */
    public function getNomeMittente()
    {
        if (!isset($this->nomeMittente)) {
            $gestoreAccount = GestoreAccount::getInstance();

            if ($this->mittente == "allenatore") {
                $accountAllenatore = $gestoreAccount->ricercaAccount_A_T_S($this->allenatore);
                $this->nomeMittente = $accountAllenatore->getNome();
                $this->cognomeMittente = $accountAllenatore->getCognome();
            } else if ($this->mittente == "calciatore") {
                $accountCalciatore = $gestoreAccount->ricercaAccount_G($this->calciatore);
                $this->nomeMittente = $accountCalciatore->getNome();
                $this->cognomeMittente = $accountCalciatore->getCognome();
            }
        }
        return $this->nomeMittente;
    }

    /**
     * @param mixed $nomeMittente
     */
    public function setNomeMittente($nomeMittente)
    {
        $this->nomeMittente = $nomeMittente;
    }

    /**
     * @return mixed
     */
    public function getCognomeMittente()
    {
        if (!isset($this->cognomeMittente)) {
            $gestoreAccount = GestoreAccount::getInstance();

            if ($this->mittente == "allenatore") {
                $accountAllenatore = $gestoreAccount->ricercaAccount_A_T_S($this->allenatore);
                $this->nomeMittente = $accountAllenatore->getNome();
                $this->cognomeMittente = $accountAllenatore->getCognome();
            } else if ($this->mittente == "calciatore") {
                $accountCalciatore = $gestoreAccount->ricercaAccount_G($this->calciatore);
                $this->nomeMittente = $accountCalciatore->getNome();
                $this->cognomeMittente = $accountCalciatore->getCognome();
            }
        }

        return $this->cognomeMittente;
    }

    /**
     * @param mixed $cognomeMittente
     */
    public function setCognomeMittente($cognomeMittente)
    {
        $this->cognomeMittente = $cognomeMittente;
    }

    /**
     * @return mixed
     */
    public function getNomeDestinatario()
    {
        if (!isset($this->nomeDestinatario)) {
            $gestoreAccount = GestoreAccount::getInstance();

            if ($this->mittente == "allenatore") {
                $accountCalciatore = $gestoreAccount->ricercaAccount_G($this->calciatore);
                $this->nomeDestinatario = $accountCalciatore->getNome();
                $this->cognomeDestinatario = $accountCalciatore->getCognome();
            } else if ($this->mittente == "calciatore") {
                $accountAllenatore = $gestoreAccount->ricercaAccount_A_T_S($this->allenatore);
                $this->nomeDestinatario = $accountAllenatore->getNome();
                $this->cognomeDestinatario = $accountAllenatore->getCognome();
            }
        }

        return $this->nomeDestinatario;
    }

    /**
     * @param mixed $nomeDestinatario
     */
    public function setNomeDestinatario($nomeDestinatario)
    {
        $this->nomeDestinatario = $nomeDestinatario;
    }

    /**
     * @return mixed
     */
    public function getCognomeDestinatario()
    {
        if (!isset($this->cognomeDestinatario)) {
            $gestoreAccount = GestoreAccount::getInstance();

            if ($this->mittente == "allenatore") {
                $accountCalciatore = $gestoreAccount->ricercaAccount_G($this->calciatore);
                $this->nomeDestinatario = $accountCalciatore->getNome();
                $this->cognomeDestinatario = $accountCalciatore->getCognome();
            } else if ($this->mittente == "calciatore") {
                $accountAllenatore = $gestoreAccount->ricercaAccount_A_T_S($this->allenatore);
                $this->nomeDestinatario = $accountAllenatore->getNome();
                $this->cognomeDestinatario = $accountAllenatore->getCognome();
            }
        }

        return $this->cognomeDestinatario;
    }

    /**
     * @param mixed $cognomeDestinatario
     */
    public function setCognomeDestinatario($cognomeDestinatario)
    {
        $this->cognomeDestinatario = $cognomeDestinatario;
    }

    /**
     * @return mixed
     */
    public function getMittente()
    {
        return $this->mittente;
    }

    /**
     * Restituisce il tipo dell'account mittente: allenatore o calciatore.
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
    public function getAllenatore()
    {
        return $this->allenatore;
    }

    /**
     * @param mixed $allenatore
     */
    public function setAllenatore($allenatore)
    {
        $this->allenatore = $allenatore;
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

    /*
     ;
     private $testo;
     private $data;
     private $tipo;
     */
    public function __toString()
    {
        return "id:" . $this->getId() . " mittente:" . $this->getMittente() .
            " calciatore:" . $this->getCalciatore() . " allenatore:" . $this->getAllenatore() .
            " testo:" . $this->getTesto() . " data:" . $this->getData() . " tipo:" . $this->getTipo();
    }

    function jsonSerialize()
    {
        return [
            "mittente" => $this->getMittente(),
            "calciatore" => $this->getCalciatore(),
            "allenatore" => $this->getAllenatore(),
            "testo" => $this->getTesto(),
            "data" => $this->getDataString(),
            "tipo" => $this->getTipo(),
            "id" => $this->getId(),
            "nomeMittente" => $this->getNomeMittente(),
            "cognomeMittente" => $this->getCognomeMittente(),
            "nomeDestinatario" => $this->getNomeDestinatario(),
            "cognomeDestinatario" => $this->getCognomeDestinatario()
        ];
    }
}