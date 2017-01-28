<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 28/01/2017
 * Time: 23:28
 */

namespace Tests\AppBundle\it\unisa\partite;

use AppBundle\it\unisa\account\GestoreAccount;
use AppBundle\it\unisa\partite\GestorePartite;
use AppBundle\it\unisa\partite\Partita;
use AppBundle\Utility\DB;


class GestorePartiteTest extends \PHPUnit_Framework_TestCase
{
    private $partita;
    private $casa;
    private $trasferta;
    private $data;
    private $squadra;
    private $stadio;
    private $gestorePartite;
    private $gestoreAccount;
    private $db;
    private $connection;

    protected function setUp()
    {
        $this->db = DB::getInstance();
        $this->connection = $this->db->connect();
        $this->connection->begin_transaction();
        $this->gestoreAccount = GestoreAccount::getInstance();
        $this->gestorePartite = GestorePartite::getInstance();

        $this->casa = "SquadraA";
        $this->trasferta = "SquadraB";
        $this->data = new \DateTime();

        try {
            $this->squadra = $this->gestoreAccount->ottieniTutteLeSquadre()[0];
            $this->stadio = $this->squadra->getStadio();
            $this->squadra = $this->squadra->getNome();
            var_dump("Squadra: " . $this->squadra);

            $this->partita = new Partita($this->casa, $this->trasferta, $this->data, $this->squadra, $this->stadio);
        } catch (\Exception $ex) {
            $this->markTestSkipped("Questo test è stato saltato perchè non vi sono suadre presenti nel DB.");
        }
    }

    public function testInserisciGetModificaPartita()
    {
        $this->assertTrue($this->gestorePartite->inserisciPartita($this->partita));

        $nome = $this->partita->getNome();
        $data = $this->partita->getDataString();
        $squadra = $this->partita->getSquadra();

        $partitaOttenuta = $this->gestorePartite->getPartita($nome, $data, $squadra);

        $this->assertEquals(var_dump($this->partita), var_dump($partitaOttenuta));

        $newPartita = new Partita("Casa", "Trasferta", new \DateTime(), $this->squadra, $this->stadio);
        $this->assertTrue($this->gestorePartite->modificaPartita($this->partita, $newPartita));
    }

    protected function tearDown()
    {
        $this->connection->rollback();
    }
}
