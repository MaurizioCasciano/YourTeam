<?php

/**
 * Created by PhpStorm.
 * User: luigidurso
 * Date: 28/01/17
 * Time: 10:29
 */

use \AppBundle\it\unisa\formazione\Partita;

class PartitaTest extends PHPUnit_Framework_TestCase
{
    protected  $partita;
    private $nome;
    private $data;
    private $squadra;
    private $stadio;
    private $modulo;

    protected function setUp()
    {
        $this->partita= new Partita($this->nome,$this->data,$this->squadra,$this->stadio,$this->modulo);
    }

    public function testGetNome()
    {
        $this->assertEquals($this->nome, $this->partita->getNome());
    }


    public function testGetData()
    {
        $this->assertEquals($this->data,$this->partita->getData());
    }

    public function testGetSquadra()
    {
        $this->assertEquals($this->squadra,$this->partita->getSquadra());
    }

    public function testGetStadio()
    {
        $this->assertEquals($this->stadio,$this->partita->getStadio());
    }

    public function testSetNome()
    {
        $nuovoNome="nuovoNome";
        $this->partita->setNome($nuovoNome);

        $this->assertEquals($nuovoNome, $this->partita->getNome());
    }

    public function testSetSquadra()
    {
        $nuovaSquadra="nuovaSquadra";
        $this->partita->setSquadra($nuovaSquadra);

        $this->assertEquals($nuovaSquadra, $this->partita->getSquadra());
    }
}
