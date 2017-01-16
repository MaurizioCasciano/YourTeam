<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 16/01/2017
 * Time: 17:32
 */

namespace Tests\AppBundle\it\unisa\autenticazione;

use AppBundle\it\unisa\autenticazione\GestoreAutenticazione;


class GestoreAutenticazioneTest extends \PHPUnit_Framework_TestCase
{
    private $gestoreAutenticazione;

    protected function setUp()
    {
        $this->gestoreAutenticazione = GestoreAutenticazione::getInstance();
    }

    
}
