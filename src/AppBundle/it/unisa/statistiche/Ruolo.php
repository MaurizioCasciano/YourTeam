<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 20/12/2016
 * Time: 11:34
 */

namespace AppBundle\it\unisa\statistiche;


class Ruolo
{
    private $id;
    private $descrizione;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDescrizione()
    {
        return $this->descrizione;
    }
}