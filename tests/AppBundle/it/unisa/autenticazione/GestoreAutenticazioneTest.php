<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 16/01/2017
 * Time: 17:32
 */

namespace Tests\AppBundle\it\unisa\autenticazione;

use AppBundle\it\unisa\account\Account;
use AppBundle\it\unisa\account\GestoreAccount;
use AppBundle\it\unisa\autenticazione\GestoreAutenticazione;
use AppBundle\Utility\DB;

class GestoreAutenticazioneTest extends \PHPUnit_Framework_TestCase
{
    private $db;
    private $connection;
    private $gestoreAutenticazione;
    private $gestoreAccount;
    private $account;
    private $username;
    private $password;
    private $squadra;

    protected function setUp()
    {
        $this->db = DB::getInstance();
        $this->connection = $this->db->connect();
        $this->connection->begin_transaction();

        $this->gestoreAutenticazione = GestoreAutenticazione::getInstance();
        $this->gestoreAccount = GestoreAccount::getInstance();

        try {
            $this->squadra = $this->gestoreAccount->ottieniTutteLeSquadre()[0]->getNome();

            $this->username = "qwertyuiopqwertyuiop";
            $this->password = "P@ssw0rd";
            $email = "user@gmail.com";
            $nome = "Nome";
            $cognome = "Cognome";
            $dataDiNascita = date_format(new \DateTime(), "YYYY-mm-dd H:i:s");
            $domicilio = "Salerno";
            $indirizzo = "Via da qui";

            $provincia = "SA";
            $telefono = "3333333333";
            $immagine = "immagine.jpg";
            $tipo = "allenatore";

            $this->account = new Account($this->username, $this->password, $this->squadra, $email,
                $nome, $cognome, $dataDiNascita, $domicilio, $indirizzo, $provincia, $telefono, $immagine, $tipo);

        } catch (\Exception $ex) {
            $this->markTestSkipped("Questo test è stato saltato perchè non vi sono suadre presenti nel DB.");
        }
    }

    /**
     * The following annotation is required to prevent the error: "session_start(): Cannot send session cookie - headers already sent by..."
     * @runInSeparateProcess
     */
    public function testLogin()
    {
        $this->assertTrue($this->gestoreAccount->aggiungiAccount_A_T_S($this->account));
        $this->assertTrue($this->gestoreAccount->ricercaAccount_A_T_S($this->username) instanceof Account);

        $this->assertTrue($this->gestoreAutenticazione->login($this->username, $this->password));
        $this->assertFalse($this->gestoreAutenticazione->login($this->username, "WRONG_PASSWORD"));

        $this->expectException(\Exception::class);
        $this->gestoreAutenticazione->login(null, null);
    }

    /**
     * @runInSeparateProcess
     */
    public function testLogout()
    {
        $this->assertTrue($this->gestoreAccount->aggiungiAccount_A_T_S($this->account));
        $this->assertTrue($this->gestoreAccount->ricercaAccount_A_T_S($this->username) instanceof Account);

        $this->assertTrue($this->gestoreAutenticazione->login($this->username, $this->password));
        $this->assertTrue($this->gestoreAutenticazione->logout());
    }

    protected function tearDown()
    {
        $this->gestoreAutenticazione->logout();
        $this->connection->rollback();
    }
}
