<?php
/**
 * Created by PhpStorm.
 * User: luigidurso
 * Date: 21/12/16
 * Time: 16:07
 */

namespace AppBundle\it\unisa\formazione;


use Symfony\Component\Config\Definition\Exception\Exception;

class ConvocNonDispException extends Exception
{
    public function messaggioDiErrore()
    {
        return $this->message;
    }

}