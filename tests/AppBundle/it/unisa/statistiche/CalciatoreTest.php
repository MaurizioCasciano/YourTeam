<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 14/01/2017
 * Time: 01:29
 */
namespace Tests\AppBundle\it\unids\statistiche;

use AppBundle\it\unisa\statistiche\Calciatore;

class CalciatoreTest extends \PHPUnit_Framework_TestCase
{
    protected $calciatore;
    private $contratto = "123456789";
    private $password = "abcdefghil";
    private $squadra = "Napoli";
    private $email = "calciatore@gmail.com";
    private $nome = "Nome";
    private $cognome = "Cognome";
    private $dataDiNascita = "2016-01-14 20:45";
    private $numeroMaglia = 17;
    private $domicilio = "Napoli";
    private $indirizzo = "Via 1";
    private $provincia = "Napoli";
    private $telefono = "123456789";
    private $immagine = "/img/user.jpg";

    protected function setUp()
    {
        $this->calciatore = new Calciatore($this->contratto, $this->password,
            $this->squadra, $this->email, $this->nome, $this->cognome, $this->dataDiNascita,
            $this->numeroMaglia, $this->domicilio, $this->indirizzo, $this->provincia, $this->telefono, $this->immagine);
    }

    public function testGetContratto()
    {
        $this->assertEquals($this->contratto, $this->calciatore->getContratto());
    }

    public function testSetContratto()
    {
        $newContratto = "qwertyuiop";
        $this->calciatore->setContratto($newContratto);

        $this->assertEquals($newContratto, $this->calciatore->getContratto());
    }

    public function testGetPassword()
    {
        $this->assertEquals($this->password, $this->calciatore->getPassword());
    }

    public function testSetPassword()
    {
        $newPassword = "qwertyuiop";
        $this->calciatore->setPassword($newPassword);

        $this->assertEquals($newPassword, $this->calciatore->getPassword());
    }

    public function testGetSquadra()
    {
        $this->assertEquals($this->squadra, $this->calciatore->getSquadra());
    }

    public function testSetSquadra()
    {
        $newSquadra = "qwertyuiop";
        $this->calciatore->setSquadra($newSquadra);

        $this->assertEquals($newSquadra, $this->calciatore->getSquadra());
    }

    public function testGetEmail()
    {
        $this->assertEquals($this->email, $this->calciatore->getEmail());
    }

    public function testSetEmail()
    {
        $newEmail = "qwertyuiop@gmail.com";
        $this->calciatore->setEmail($newEmail);

        $this->assertEquals($newEmail, $this->calciatore->getEmail());
    }

    public function testGetNome()
    {
        $this->assertEquals($this->nome, $this->calciatore->getNome());
    }

    public function testSetNome()
    {
        $newNome = "Paolo";
        $this->calciatore->setNome($newNome);

        $this->assertEquals($newNome, $this->calciatore->getNome());
    }

    public function testGetCognome()
    {
        $this->assertEquals($this->cognome, $this->calciatore->getCognome());
    }

    public function testSetCognome()
    {
        $newCognome = "Paolo";
        $this->calciatore->setCognome($newCognome);

        $this->assertEquals($newCognome, $this->calciatore->getCognome());
    }

    public function testGetDataDiNascita()
    {
        $this->assertEquals($this->dataDiNascita, $this->calciatore->getDataDiNascita());
    }

    public function testSetDataDiNascita()
    {
        $newDataDiNascita = "1995-12-31";
        $this->calciatore->setDataDiNascita($newDataDiNascita);

        $this->assertEquals($newDataDiNascita, $this->calciatore->getDataDiNascita());
    }

    public function getNumeroMaglia()
    {
        $this->assertEquals($this->numeroMaglia, $this->calciatore->getNumeroMaglia());
    }

    public function setNumeroMaglia()
    {
        $newNumeroMaglia = "19";
        $this->calciatore->setNumeroMaglia($newNumeroMaglia);

        $this->assertEquals($newNumeroMaglia, $this->calciatore->getNumeroMaglia());
    }

    public function testGetDomicilio()
    {
        $this->assertEquals($this->domicilio, $this->calciatore->getDomicilio());
    }

    public function testSetDomicilio()
    {
        $newDomicilio = "New York";
        $this->calciatore->setDomicilio($newDomicilio);

        $this->assertEquals($newDomicilio, $this->calciatore->getDomicilio());
    }

    public function getIndirizzo()
    {
        $this->assertEquals($this->indirizzo, $this->calciatore->getIndirizzo());
    }

    public function setIndirizzo()
    {
        $newIndirizzo = "Via nuova";
        $this->calciatore->setIndirizzo($newIndirizzo);

        $this->assertEquals($newIndirizzo, $this->calciatore->getIndirizzo());
    }

    public function testGetProvincia()
    {
        $this->assertEquals($this->provincia, $this->calciatore->getProvincia());
    }

    public function testSetProvincia()
    {
        $newProvincia = "Milano";
        $this->calciatore->setProvincia($newProvincia);

        $this->assertEquals($newProvincia, $this->calciatore->getProvincia());
    }

    public function testGetTelefono()
    {
        $this->assertEquals($this->telefono, $this->calciatore->getTelefono());
    }

    public function testSetTelefono()
    {
        $newTelefono = "3334445556";
        $this->calciatore->setTelefono($newTelefono);

        $this->assertEquals($newTelefono, $this->calciatore->getTelefono());
    }

    public function testGetImmagine()
    {
        $this->assertEquals($this->immagine, $this->calciatore->getImmagine());
    }

    public function testSetImmagine()
    {
        $newImmagine = "compleanno.png";
        $this->calciatore->setImmagine($newImmagine);

        $this->assertEquals($newImmagine, $this->calciatore->getImmagine());
    }

    public function testHasStatistiche()
    {
        $this->assertEquals(false, $this->calciatore->hasStatistiche());
    }

    public function testGetStatistiche()
    {
        $this->expectException(\Exception::class);
        $this->calciatore->getStatistiche();
    }
}