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
    private $data = "data";
    private $tipo = "voce";
    private $id = "01";

    //nome cognome
    private $nomeMittente = "Massimiliano";
    private $cognomeMittente = "Allegri";
    private $nomeDestinatario = "Leonardo";
    private $cognomeDestinatario = "Bonucci";

    protected function setUp()
    {
        $this->messaggio = new Messaggio($this->testo, $this->allenatore, $this->calciatore, $this->mittente, $this->data, $this->tipo);
    }

    public function testGetDataString()
    {
        /*$testo = "Ciaone";
        $usernameAllenatore = "allentore";
        $usernameCalciatore = "123456";
        $mittente = "allenatore";
        $data = new \DateTime();
        $tipo = "chat";*/

        $messaggio = new Messaggio($this->testo, $this->allenatore, $this->calciatore, $this->mittente, $this->data, $this->tipo);

        //ecnho $messaggio->getDataString();
        $this->assertStringEndsNotWith(".000000", $messaggio->getDataString());
    }
        /**
         * @return mixed
         */
        public function testGetId()
        {
            $this->assertEquals($this->id, $this->messaggio->getId());
        }

        /**
         * @param mixed $id
         */
        public function testSetId($id)
        {

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
        public function testSetData($data)
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
        public function testSetTipo($tipo)
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
        public function testSetCognomeMittente($cognomeMittente)
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
        public function testSetNomeDestinatario($nomeDestinatario)
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
        public function testSetCognomeDestinatario($cognomeDestinatario)
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
        public function testSetMittente($mittente)
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
        public function testSetCalciatore($calciatore)
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
        public function testSetAllenatore($allenatore)
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
        public function testSetTesto($testo)
        {

        }

        /*
         ;
         private $testo;
         private $data;
         private $tipo;
         */
        public function __toString()
        {
            return "id:" . $this->getId() . " mittente:" . $this->getMittente() .
            " calciatore:" . $this->getCalciatore() . " allenatore:" . $this->getAllenatore() .
            " testo:" . $this->getTesto() . " data:" . $this->getData() . " tipo:" . $this->getTipo();
        }

        function jsonSerialize()
        {
            return [
                "mittente" => $this->getMittente(),
                "calciatore" => $this->getCalciatore(),
                "allenatore" => $this->getAllenatore(),
                "testo" => $this->getTesto(),
                "data" => $this->getDataString(),
                "tipo" => $this->getTipo(),
                "id" => $this->getId(),
                "nomeMittente" => $this->getNomeMittente(),
                "cognomeMittente" => $this->getCognomeMittente(),
                "nomeDestinatario" => $this->getNomeDestinatario(),
                "cognomeDestinatario" => $this->getCognomeDestinatario()
            ];
        }
}
