<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 15/01/2017
 * Time: 16:22
 */

namespace Tests\AppBundle\it\unisa\comunicazione;

use AppBundle\it\unisa\account\Account;
use AppBundle\it\unisa\account\AccountCalciatore;
use AppBundle\it\unisa\account\GestoreAccount;
use AppBundle\it\unisa\account\Squadra;
use AppBundle\it\unisa\comunicazione\GestoreComunicazione;
use AppBundle\it\unisa\comunicazione\Messaggio;
use AppBundle\Utility\DB;

class GestoreComunicazioneTest extends \PHPUnit_Framework_TestCase
{
    private $gestoreComunicazione;
    private $db;
    private $connection;
    private $gestoreAccount;
    private $squadra;
    private $allenatore;
    private $calciatore;
    private $messaggio;

    protected function setUp()
    {
        /*==============DB TRANSACTION===================*/
        $this->db = DB::getInstance();
        $this->connection = $this->db->connect();
        $this->connection->begin_transaction();
        /*==============DB TRANSACTION===================*/

        /*===============GESTORI========================*/
        $this->gestoreAccount = GestoreAccount::getInstance();
        $this->gestoreComunicazione = GestoreComunicazione::getInstance();
        /*===============GESTORI========================*/

        /*==============SQUADRA==========================*/
        $nome = "SquadraRandom123";
        $sede = "Salerno";
        $stadio = "Stadio123";
        $golfatti = 0;
        $golsubiti = 0;
        $possessopalla = 0;
        $vittorie = 0;
        $sconfitte = 0;
        $pareggi = 0;
        $emblema = "Emblema";
        $immagine = "Immagine.jpg";
        $scudetti = 0;

        $this->squadra = new Squadra($nome, $sede, $stadio,
            $golfatti, $golsubiti, $possessopalla, $vittorie,
            $sconfitte, $pareggi, $emblema, $immagine, $scudetti);
        /*==============SQUADRA==========================*/

        /*==================ALLENATORE===================*/
        $username_a = "Allenatore1234234";
        $password = "P@ssw0rd";
        $squadra = $this->squadra->getNome();
        $email = "lamiaemail@live.it";
        $nome_a = "Allenatore";
        $cognome_a = "Cognome";
        $dataDiNascita = "1995-12-29";
        $domicilio = "Salerno";
        $indirizzo = "Via da qui";
        $provincia = "SA";
        $telefono = "3333333333";
        $tipo = "allenatore";

        $this->allenatore = new Account($username_a,
            $password, $squadra, $email, $nome_a, $cognome_a, $dataDiNascita, $domicilio, $indirizzo, $provincia, $telefono, $immagine, $tipo);
        /*==================ALLENATORE===================*/


        /*=================CALCIATORE====================*/
        $username_c = "Calciatore231423";
        $nome_c = "Calciatore";
        $cognome_c = "Cognome";
        $nazionalita = "Italiana";

        $this->calciatore = new AccountCalciatore($username_c, $password,
            $squadra, $email, $nome_c, $cognome_c, $dataDiNascita, $domicilio, $indirizzo, $provincia, $telefono, $immagine, $nazionalita);
        /*=================CALCIATORE====================*/

        /*=================MESSAGGIO=====================*/
        $testo = "Ciao, ci vediamo domani";
        $allenatore = $this->allenatore->getUsernameCodiceContratto();
        $calciatore = $this->calciatore->getUsernameCodiceContratto();
        $mittente = "allenatore";
        $data = new \DateTime();
        $tipo2 = "chat";

        $this->messaggio = new Messaggio($testo, $allenatore, $calciatore, $mittente, $data, $tipo2);
        $this->messaggio->setNomeMittente($this->allenatore->getNome());
        $this->messaggio->setCognomeMittente($this->allenatore->getCognome());
        $this->messaggio->setNomeDestinatario($this->calciatore->getNome());
        $this->messaggio->setCognomeDestinatario($this->calciatore->getCognome());
        /*=================MESSAGGIO=====================*/

        $this->gestoreComunicazione = GestoreComunicazione::getInstance();
    }

    public function testInviaMessaggio()
    {
        $this->assertTrue($this->gestoreAccount->aggiungiSquadra($this->squadra));
        $this->assertTrue($this->gestoreAccount->aggiungiAccount_A_T_S($this->allenatore));
        $this->assertTrue($this->gestoreAccount->aggiungiAccount_C($this->calciatore));

        $this->assertTrue($this->gestoreComunicazione->inviaMessaggio($this->messaggio));
    }

    public function testGetNuoviMessaggi()
    {
        $this->assertTrue($this->gestoreAccount->aggiungiSquadra($this->squadra));
        $this->assertTrue($this->gestoreAccount->aggiungiAccount_A_T_S($this->allenatore));
        $this->assertTrue($this->gestoreAccount->aggiungiAccount_C($this->calciatore));
        $this->assertTrue($this->gestoreComunicazione->inviaMessaggio($this->messaggio));

        $allenatore = $this->allenatore->getUsernameCodiceContratto();
        $calciatore = $this->calciatore->getUsernameCodiceContratto();
        $tipo = "chat";
        $data = "2015-15-01 15:52:37";

        $messaggi = $this->gestoreComunicazione->getNuoviMessaggi($allenatore, $calciatore, $tipo, $data);

        $this->assertGreaterThan(0, count($messaggi));
    }

    protected function tearDown()
    {
        $this->connection->rollback();
    }
}
