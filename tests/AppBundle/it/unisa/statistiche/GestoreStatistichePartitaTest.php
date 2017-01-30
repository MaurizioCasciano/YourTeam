<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 28/01/2017
 * Time: 23:22
 */

namespace Tests\AppBundle\it\unisa\statistiche;


use AppBundle\it\unisa\account\GestoreAccount;
use AppBundle\it\unisa\partite\GestorePartite;
use AppBundle\it\unisa\partite\Partita;
use AppBundle\it\unisa\statistiche\GestoreStatistichePartita;
use AppBundle\it\unisa\statistiche\StatistichePartita;
use AppBundle\Utility\DB;


class GestoreStatistichePartitaTest extends \PHPUnit_Framework_TestCase
{
    private $statistichePartita;
    private $gestoreStatistichePartita;
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
        $this->gestoreStatistichePartita = GestoreStatistichePartita::getInstance();

        $this->casa = "SquadraA";
        $this->trasferta = "SquadraB";
        $this->data = new \DateTime();

        try {
            $this->squadra = $this->gestoreAccount->ottieniTutteLeSquadre()[0];
            $this->stadio = $this->squadra->getStadio();
            $this->squadra = $this->squadra->getNome();
            $this->partita = new Partita($this->casa, $this->trasferta, $this->data, $this->squadra, $this->stadio);
        } catch (\Exception $ex) {
            $this->markTestSkipped("Questo test è stato saltato perchè non vi sono suadre presenti nel DB.");
        }
    }

    public function testInserisciStatistiche()
    {
        $this->assertTrue($this->gestorePartite->inserisciPartita($this->partita));

        $statistiche = new StatistichePartita(null, 3, -1, array(), array(), array(), array());
        $this->partita->setStatistiche($statistiche);

        $this->expectException(\InvalidArgumentException::class);
        $this->gestoreStatistichePartita->inserisciStatistiche($this->partita);
    }

    public function testModificaStatistiche()
    {
        $this->assertTrue($this->gestorePartite->inserisciPartita($this->partita));

        $statistiche = new StatistichePartita(0, 3, 77, array(), array(), array(), array());
        $this->partita->setStatistiche($statistiche);

        $this->assertTrue($this->gestoreStatistichePartita->inserisciStatistiche($this->partita));

        $statistiche = new StatistichePartita(2, 3, 30, array(), array(), array(), array());
        $this->partita->setStatistiche($statistiche);
        $this->assertTrue($this->gestoreStatistichePartita->modificaStatistiche($this->partita));
    }

    public function testModificaStatistiche2()
    {
        $this->assertTrue($this->gestorePartite->inserisciPartita($this->partita));

        $statistiche = new StatistichePartita(0, 3, 77, array(), array(), array(), array());
        $this->partita->setStatistiche($statistiche);

        $this->assertTrue($this->gestoreStatistichePartita->inserisciStatistiche($this->partita));

        $statistiche = new StatistichePartita(null, null, 101, array(), array(), array(), array());
        $this->partita->setStatistiche($statistiche);

        $this->expectException(\InvalidArgumentException::class);
        $this->gestoreStatistichePartita->modificaStatistiche($this->partita);
    }

    protected function tearDown()
    {
        $this->connection->rollback();
    }
}
