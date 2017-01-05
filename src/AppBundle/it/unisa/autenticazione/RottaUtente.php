<?php
/**
 * Created by PhpStorm.
 * User: raffaele
 * Date: 04/01/17
 * Time: 15.24
 */

namespace AppBundle\it\unisa\autenticazione;


use Symfony\Component\Config\Definition\Exception\Exception;

class RottaUtente
{

    private $rotta;
    private $attori;

    /**
     * RottaUtente constructor.
     * @param $rotta
     * @param $attori
     */
    public function __construct($rotta, $attori)
    {
        if(gettype($rotta)=="string" and gettype($attori)=="array"){
            $this->rotta = $rotta;
            $this->attori = $attori;
        }
        else throw new Exception("attenzione al tipo di paramentri passati, 1^ parametro: stringa, 2^ paramentro array ");

    }

    /**
     * @return mixed
     */
    public function getRotta()
    {
        return $this->rotta;
    }

    /**
     * @param mixed $rotta
     */
    public function setRotta($rotta)
    {
        $this->rotta = $rotta;
    }

    /**
     * @return array
     */
    public function getAttori()
    {
        return $this->attori;
    }

    /**
     * @param array $attori
     */
    public function setAttori($attori)
    {
        $this->attori = $attori;

    }



}