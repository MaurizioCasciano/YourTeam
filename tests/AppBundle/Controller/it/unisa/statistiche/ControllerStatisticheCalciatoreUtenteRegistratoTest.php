<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 14/01/2017
 * Time: 13:05
 */
namespace Tests\AppBundle\Controller\it\unisa\statistiche;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ControllerStatisticheCalciatoreUtenteRegistratoTest extends WebTestCase
{
    protected function setUp()
    {
        $_SESSION["squadra"] = "Napoli";
        $_SESSION["tipo"] = "tifoso";
    }


    /*public function testGetFiltraCalciatoriForm()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', "/statistiche/user/calciatore/filter/form");
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertEquals(1, $crawler->filter('form')->count());
    }*/

    public function testFiltraCalciatori()
    {
        $client = static::createClient();
        $crawler = $client->request('POST', "/statistiche/user/calciatore/filter/submit");
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertEquals(1, $crawler->filter('#accordion')->count());
    }

    public function testGetStatisticheCalciatoriView()
    {
        $client = static::createClient();
        $crawler = $client->request('POST', "/statistiche/user/calciatore/filter/submit");
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertEquals(1, $crawler->filter('#accordion')->count());
    }

    protected function tearDown()
    {
        $_SESSION = array();
    }
}