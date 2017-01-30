<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 30/01/2017
 * Time: 11:21
 */

namespace Tests\AppBundle\it\unisa\account;

use AppBundle\it\unisa\account\Account;
use AppBundle\it\unisa\account\GestoreAccount;
use AppBundle\Utility\DB;


class GestoreAccountTest extends \PHPUnit_Framework_TestCase
{
    private $db;
    private $connection;
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

    public function testAggiungiAccount_A_T_S()
    {
        $this->assertTrue($this->gestoreAccount->aggiungiAccount_A_T_S($this->account));
    }

    public function testModificaAccount_A_T_S()
    {
        $this->assertTrue($this->gestoreAccount->aggiungiAccount_A_T_S($this->account));

        $this->username = "qwertyuiopqwertyuiop";
        $this->password = "P@ssw0rd24234234234";
        $email = "user1234@gmail.com";
        $nome = "Nome2";
        $cognome = "Cognome2";
        $dataDiNascita = date_format(new \DateTime(), "YYYY-mm-dd H:i:s");
        $domicilio = "Salerno 2";
        $indirizzo = "Via da qui ora";

        $provincia = "SA";
        $telefono = "3332333333";
        $immagine = "immagine2.jpg";
        $tipo = "staff";

        $newAccount = new Account($this->username, $this->password, $this->squadra, $email,
            $nome, $cognome, $dataDiNascita, $domicilio, $indirizzo, $provincia, $telefono, $immagine, $tipo);

        $this->assertTrue($this->gestoreAccount->modificaAccount_A_T_S($this->username, $this->account));
    }

    protected function tearDown()
    {
        $this->connection->rollback();
    }
}
