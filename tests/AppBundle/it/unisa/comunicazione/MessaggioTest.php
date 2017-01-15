<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 15/01/2017
 * Time: 01:07
 */
namespace Tests\AppBundle\it\unisa\comunicazione;

use AppBundle\it\unisa\comunicazione\Messaggio;


class MessaggioTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDataString()
    {
        $testo = "Ciaone";
        $usernameAllenatore = "allentore";
        $usernameCalciatore = "123456";
        $mittente = "allenatore";
        $data = new \DateTime();
        $tipo = "chat";

        $messaggio = new Messaggio($testo, $usernameAllenatore, $usernameCalciatore, $mittente, $data, $tipo);

        echo $messaggio->getDataString();
        $this->assertStringEndsNotWith(".000000", $messaggio->getDataString());
    }
}
