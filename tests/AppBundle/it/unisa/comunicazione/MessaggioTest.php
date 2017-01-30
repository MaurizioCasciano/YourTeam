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

    protected $messaggio;
    private $mittente = "allenatore";
    private $calciatore = "Bonucci";
    private $allenatore = "Allegri";
    private $testo = "CI vediamo il giorno x alle xx:xx il yy/yy/yyyy";
    private $data;
    private $tipo = "voce";
    private $id = "01";

    //nome cognome
    private $nomeMittente = "Massimiliano";
    private $cognomeMittente = "Allegri";
    private $nomeDestinatario = "Leonardo";
    private $cognomeDestinatario = "Bonucci";

    protected function setUp()
    {
        $this->data = new \DateTime();
        $this->messaggio = new Messaggio($this->testo, $this->allenatore, $this->calciatore, $this->mittente, $this->data, $this->tipo);
        $this->markTestSkipped("TEST SKIPPED");
    }

    public function testGetDataString()
    {
        /*$testo = "Ciaone";
        $usernameAllenatore = "allentore";
        $usernameCalciatore = "123456";
        $mittente = "allenatore";
        $data = new \DateTime();
        $tipo = "chat";*/

        $this->messaggio = new Messaggio($this->testo, $this->allenatore, $this->calciatore, $this->mittente, $this->data, $this->tipo);

        //ecnho $messaggio->getDataString();
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
        $this->assertEquals($this->nomeMittente, $this->messaggio->getNomeMittente());
    }

    /**
     * @param mixed $nomeMittente
     */
    public function testSetNomeMittente($nomeMittente)
    {

    }

    /**
     * @return mixed
     */
    public function testGetCognomeMittente()
    {
        $this->assertEquals($this->cognomeMittente, $this->messaggio->getCognomeMittente());
    }

    /**
     * @param mixed $cognomeMittente
     */
    public function testSetCognomeMittente()
    {

    }

    /**
     * @return mixed
     */
    public function testGetNomeDestinatario()
    {
        $this->assertEquals($this->nomeDestinatario, $this->messaggio->getNomeDestinatario());
    }

    /**
     * @param mixed $nomeDestinatario
     */
    public function testSetNomeDestinatario()
    {

    }

    /**
     * @return mixed
     */
    public function testGetCognomeDestinatario()
    {
        $this->assertEquals($this->cognomeDestinatario, $this->messaggio->getCognomeDestinatario());
    }

    /**
     * @param mixed $cognomeDestinatario
     */
    public function testSetCognomeDestinatario()
    {

    }

    /**
     * @return mixed
     */
    public function testGetMittente()
    {
        $this->assertEquals($this->mittente, $this->messaggio->getMittente());
    }

    /**
     * Restituisce il tipo dell'account mittente: allenatore o calciatore.
     * @param mixed $mittente
     */
    public function testSetMittente()
    {

    }

    /**
     * @return mixed
     */
    public function testGetCalciatore()
    {
        $this->assertEquals($this->calciatore, $this->messaggio->getCakciatore());
    }

    /**
     * @param mixed $calciatore
     */
    public function testSetCalciatore()
    {

    }

    /**
     * @return mixed
     */
    public function testGetAllenatore()
    {
        $this->assertEquals($this->allenatore, $this->messaggio->getAllenatore());
    }

    /**
     * @param mixed $allenatore
     */
    public function testSetAllenatore()
    {

    }

    /**
     * @return mixed
     */
    public function testGetTesto()
    {
        $this->assertEquals($this->testo, $this->messaggio->getTesto());
    }

    /**
     * @param mixed $testo
     */
    public function testSetTesto()
    {

    }
}
