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

    private $messaggio;
    private $allenatore;
    private $nomeAll;
    private $cognomeAll;
    private $calciatore;
    private $nomeCalc;
    private $cognomeCalc;
    private $mittente;
    private $testo;
    private $data;
    private $tipo;
    private $id;

    protected function setUp()
    {
        /*=================MESSAGGIO=====================*/
        $this->allenatore = "Allenatore";
        $this->nomeAll = "NomeAllenatore";
        $this->cognomeAll = "ConomeAllenatore";

        $this->calciatore = "Calciatore";
        $this->nomeCalc = "NomeCalciatore";
        $this->cognomeCalc = "CognomeCalciatore";

        $this->mittente = "allenatore";
        $this->testo = "Ciao, ci vediamo domani";
        $this->data = new \DateTime();
        $this->tipo = "chat";
        $this->id = "123";

        $this->messaggio = new Messaggio($this->testo, $this->allenatore, $this->calciatore, $this->mittente, $this->data, $this->tipo);
        $this->messaggio->setNomeMittente($this->nomeAll);
        $this->messaggio->setCognomeMittente($this->cognomeAll);
        $this->messaggio->setNomeDestinatario($this->nomeCalc);
        $this->messaggio->setCognomeDestinatario($this->cognomeCalc);
        /*=================MESSAGGIO=====================*/
    }

    public function testGetDataString()
    {
        $this->assertStringEndsNotWith(".000000", $this->messaggio->getDataString());
    }

    /**
     * @return mixed
     */
    public function testGetId()
    {
        $this->messaggio->setId($this->id);
        $this->assertEquals($this->id, $this->messaggio->getId());
    }

    /**
     * @return \DateTime
     */
    public function testGetData()
    {
        $this->assertEquals($this->data, $this->messaggio->getData());
    }

    /**
     * @param \DateTime $data
     */
    public function testSetData()
    {

    }

    /**
     * @return mixed
     */
    public function testGetTipo()
    {
        $this->assertEquals($this->tipo, $this->messaggio->getTipo());
    }

    /**
     * @param mixed $tipo
     */
    public function testSetTipo()
    {

    }

    /**
     * @return mixed
     */
    public function testGetNomeMittente()
    {
        $this->assertEquals($this->nomeAll, $this->messaggio->getNomeMittente());
    }

    /**
     * @return mixed
     */
    public function testGetCognomeMittente()
    {
        $this->assertEquals($this->cognomeAll, $this->messaggio->getCognomeMittente());
    }

    /**
     * @return mixed
     */
    public function testGetNomeDestinatario()
    {
        $this->assertEquals($this->nomeCalc, $this->messaggio->getNomeDestinatario());
    }

    /**
     * @return mixed
     */
    public function testGetCognomeDestinatario()
    {
        $this->assertEquals($this->cognomeCalc, $this->messaggio->getCognomeDestinatario());
    }

    /**
     * @return mixed
     */
    public function testGetMittente()
    {
        $this->assertEquals($this->mittente, $this->messaggio->getMittente());
    }

    /**
     * @return mixed
     */
    public function testGetCalciatore()
    {
        $this->assertEquals($this->calciatore, $this->messaggio->getCalciatore());
    }

    /**
     * @return mixed
     */
    public function testGetAllenatore()
    {
        $this->assertEquals($this->allenatore, $this->messaggio->getAllenatore());
    }

    /**
     * @return mixed
     */
    public function testGetTesto()
    {
        $this->assertEquals($this->testo, $this->messaggio->getTesto());
    }
}
