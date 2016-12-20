<?php
/**
 * Created by PhpStorm.
 * User: luigidurso
 * Date: 15/12/16
 * Time: 10:01
 */

namespace AppBundle\it\unisa\formazione;


class Modulo
{
    private $id;
    private $descrizione;

    /**
     * Modulo constructor.
     * @param $id
     * @param $descrizione
     */
    public function __construct($id, $descrizione)
    {
        $this->id = $id;
        $this->descrizione = $descrizione;
    }

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
    public function getDescrizione()
    {
        return $this->descrizione;
    }

    /**
     * @param mixed $descrizione
     */
    public function setDescrizione($descrizione)
    {
        $this->descrizione = $descrizione;
    }



}