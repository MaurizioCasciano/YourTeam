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
    private $allenatore;
    private $testo;
    private $data;
    private $tipo;
    private $id;

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


    public function __construct($t, $u, $c, $mitt,$data,$tipo)
    {
        $this->testo = $t;
        $this->allenatore = $u;
        $this->calciatore = $c;
        $this->mittente = $mitt;
        $this->data=$data;
        $this->tipo=$tipo;
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
       return "id:".$this->getId()." mittente:".$this->getMittente().
       " calciatore:".$this->getCalciatore()." allenatore:".$this->getAllenatore().
       " testo:".$this->getTesto()." data:".$this->getData()." tipo:".$this->getTipo();
    }

}