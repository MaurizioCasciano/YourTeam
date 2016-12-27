<?php
/**
 * Created by PhpStorm.
 * User: luigidurso
 * Date: 22/12/16
 * Time: 10:06
 */

namespace AppBundle\it\unisa\formazione;


use Symfony\Component\Config\Definition\Exception\Exception;

class FormazioneNonDispException extends Exception
{
    public function messaggioDiErrore()
    {
       return $this->message;
    }

}