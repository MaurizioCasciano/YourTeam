<?php
/**
 * Created by PhpStorm.
 * User: Raffaele
 * Date: 16/12/2016
 * Time: 08:46
 */

namespace AppBundle\it\unisa\account;


use AppBundle\Utility\DB;
use Symfony\Component\Config\Definition\Exception\Exception;


class GestoreAccount
{

    private $conn;
    private $db;
    private static $instance = null;

    /*Aggiungere   :

        eliminaAccount_G
        ricercaAcount_G
        modificaAccount_G


    Modificare convalida account come:
    Aggiungere il controllo che il giocatore esiste veramente nella clausola, quindi sfruttare ricerca_G*/


    private function __construct()
    {
        $this->db = DB::getInstance();
        $this->conn = $this->db->connect();
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /*
        public function getAccount_G($u){
            if($u==null)throw new \Exception("valore nullo");

            $sql="SELECT * FROM calciatore WHERE contratto=='$u'";
            $res = $this->conn->query($sql);

            if($res->num_rows <= 0) throw new \Exception("account con username".$u."non esiste");
            $row = $res->fetch_assoc();
            $user = new AccountCalciatore($row["contratto"],$row["password"],
                $row["squadra"],$row["email"],$row["nome"],
                $row["cognome"],$row["datadinascita"],$row["domicilio"],
                $row["indirizzo"],$row["provincia"],$row["telefono"],
                $row["immagine"],$row["nazionalita"]);
            // se è un calciatore query cercare tutti i suoi ruoli->cra un ruolo
            return $user;
        }

        public function getAccount_A_T_S($u){
            if($u==null)throw new \Exception("valore nullo");

        if($res->num_rows <= 0) throw new \Exception("account con username".$u."non esiste");
        $row = $res->fetch_assoc();
        $user = new Account($row["username_codiceContratto"],$row["password"],
            $row["squadra"],$row["email"],$row["nome"],
            $row["cognome"],$row["datadinascita"],$row["domicilio"],
            $row["indirizzo"],$row["provincia"],$row["telefono"],
            $row["immagine"],$row["tipo"]);
        // se è un calciatore query cercare tutti i suoi ruoli->cra un ruolo
        return $user;
    }
*/

    public function aggiungiSquadra(Squadra $s)
    {

        $sql = "INSERT INTO squadra (nome,sede,stadio,golfatti,golsubiti,possessopalla,vittorie,sconfitte,pareggi,emblema,scudetti,immagine) 
        VALUES ('" . $s->getNome() . "','"
            . $s->getSede() . "','"
            . $s->getStadio() . "','"
            . $s->getGolfatti() . "','"
            . $s->getGolsubiti() . "','"
            . $s->getPossessopalla() . "','"
            . $s->getVittorie() . "','"
            . $s->getSconfitte() . "','"
            . $s->getPareggi() . "','"
            . $s->getEmblema() . "','"
            . $s->getScudetti() . "','"
            . $s->getImmagine() . "');";

        $this->conn->query($sql);

    }

    public function aggiungiAccount_A_T_S(Account $a)
    {


        /*controlliamo che l'account non sia null(controllo piuttosto inutile)*/
        if ($a == null) throw new \Exception("valore nullo");

        if ($a->getTipo() == "allenatore" || $a->getTipo() == "tifoso" || $a->getTipo() == "staff") {
            $sql = "INSERT INTO utente (username_codiceContratto, squadra, email, password, nome, cognome, 
                  datadinascita, domicilio, indirizzo, provincia, telefono,tipo, immagine) 
                VALUES ('" . $a->getUsernameCodiceContratto() . "','"
                . $a->getSquadra() . "','"
                . $a->getEmail() . "','"
                . $a->getPassword() . "','"
                . $a->getNome() . "','"
                . $a->getCognome() . "','"
                . $a->getDataDiNascita() . "','"
                . $a->getDomicilio() . "','"
                . $a->getIndirizzo() . "','"
                . $a->getProvincia() . "','"
                . $a->getTelefono() . "','"
                . $a->getTipo() . "','"
                . $a->getImmagine() . "');";


        } else throw new \Exception("la tipologia account scelta non va bene");

        $ris = $this->conn->query($sql);
        /*il metodo query ritorna il valore false nel caso in cui la query non va a buon fine, casi:
            - query non formattata bene(problema in fase di costruzione
            - viola qualche vincolo(pe esempio il campo squadra dove squadra non esiste)
          in tutti gli altri casi ritorna un oggetto con info che non ci serve
          nota: se il cmpo prevede 10 caratteri, e passiamo una stringa di 12 caratteri, mysql la tronca -> non va in errore*/
        if (!$ris) throw new \Exception(("errore inserimento dati nel db"));

    }


    /*spostare altrove*/
    public function ottieniTutteLeSquadre()
    {


        $squadre = array();
        $sql = "SELECT * from squadra";
        $result = $this->conn->query($sql);
        $res = "";
        $i = 0;
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                //$nome, $sede, $stadio, $golfatti, $golsubiti, $possessopalla, $vittorie, $sconfitte, $pareggi, $emblema, $scudetti
                $s = new Squadra($row["nome"], $row["sede"], $row["stadio"],
                    $row["golfatti"], $row["golsubiti"], $row["possessopalla"],
                    $row["vittorie"], $row["sconfitte"], $row["pareggi"], $row["emblema"], $row["scudetti"], $row["immagine"]);
                $squadre[$i] = $s;
                $i++;
            }
            return $squadre;
        }
        throw new \Exception("nessuna squadra");
    }

    public function modificaAccount_A_T_S($username_codiceContratto, Account $newAccount)
    {

        /*controlliamo che l'account e il primo paramentro  non siano null(controllo piuttosto inutile)*/
        /*controlliamo che l'account non sia null(controllo piuttosto inutile)*/
        if ($username_codiceContratto == null || $newAccount == null) throw new \Exception("valore nullo");
        try {
            /*forziamo il metodo e lo utilizziamo come controllo, perchè se l'account non esiste viene lanciata
            l'eccezione*/
            $this->ricercaAccount_A_T_S($username_codiceContratto);
            $sql = "UPDATE utente SET email='" . $newAccount->getEmail()
                . "', password='" . $newAccount->getPassword()
                . "', nome='" . $newAccount->getNome()
                . "', cognome='" . $newAccount->getCognome()
                . "', datadinascita='" . $newAccount->getDataDiNascita()
                . "', domicilio='" . $newAccount->getDomicilio()
                . "', indirizzo='" . $newAccount->getIndirizzo()
                . "', provincia='" . $newAccount->getProvincia()
                . "', telefono='" . $newAccount->getTelefono()
                . "', immagine='" . $newAccount->getImmagine()
                . "' WHERE username_codiceContratto='$username_codiceContratto'";
            //questo controllo non funziona se passiamo un username che non esiste perciò abbiamo
            //fatto il controllo di ricercaAccount sopra
            //if (!$this->conn->query($sql))  throw new \Exception(("errore MODIFICA dati nel db"));
            $this->conn->query($sql);

        } catch (\Exception $e) {
            throw new \Exception(("errore MODIFICA dati nel db" . $e->getMessage()));
        }


    }

    public function modificaAccount_G($username_codiceContratto, AccountCalciatore $newAccount)
    {

        /*controlliamo che l'account e il primo paramentro  non siano null(controllo piuttosto inutile)*/
        /*controlliamo che l'account non sia null(controllo piuttosto inutile)*/
        if ($username_codiceContratto == null || $newAccount == null) throw new \Exception("valore nullo");
        try {
            /*forziamo il metodo e lo utilizziamo come controllo, perchè se l'account non esiste viene lanciata
            l'eccezione*/
            $this->ricercaAccount_G($username_codiceContratto);
            $sql = "UPDATE calciatore SET email='" . $newAccount->getEmail()
                . "', password='" . $newAccount->getPassword()
                . "', nome='" . $newAccount->getNome()
                . "', cognome='" . $newAccount->getCognome()
                . "', datadinascita='" . $newAccount->getDataDiNascita()
                . "', domicilio='" . $newAccount->getDomicilio()
                . "', indirizzo='" . $newAccount->getIndirizzo()
                . "', provincia='" . $newAccount->getProvincia()
                . "', telefono='" . $newAccount->getTelefono()
                . "', immagine='" . $newAccount->getImmagine()
                . "', nazionalita='" . $newAccount->getNazionalita()
                . "' WHERE contratto='$username_codiceContratto'";
            //questo controllo non funziona se passiamo un username che non esiste perciò abbiamo
            //fatto il controllo di ricercaAccount sopra
            //if (!$this->conn->query($sql))  throw new \Exception(("errore MODIFICA dati nel db"));
            $this->conn->query($sql);

        } catch (\Exception $e) {
            throw new \Exception(("errore MODIFICA dati nel db" . $e->getMessage()));
        }


    }

    public function ricercaAccount_A_T_S($u)
    {
          //return una stringa di fallimento

        $sql = "SELECT * FROM utente WHERE username_codiceContratto='$u'";
        $res = $this->conn->query($sql);
        /*se la query ha successo allora la proprietà di $res è >0
        chiaramente potremmo controllare anche se la query è ben formattata(controllo solo in fase di sviluppo)
        quindi si può evitare di fare*/
        if ($res->num_rows <= 0) return "valore non esiste";
        $row = $res->fetch_assoc();
        $user = new Account($row["username_codiceContratto"], $row["password"],
            $row["squadra"], $row["email"], $row["nome"],
            $row["cognome"], $row["datadinascita"], $row["domicilio"],
            $row["indirizzo"], $row["provincia"], $row["telefono"],
            $row["immagine"], $row["tipo"]);
        // se è un calciatore query cercare tutti i suoi ruoli->cra un ruolo

        return $user;

    }

    public function ricercaAccount_G($u)
    {
        if ($u == null) throw new \Exception("valore non settato");

        $sql = "SELECT * FROM calciatore WHERE contratto='$u'";
        $res = $this->conn->query($sql);
        /*se la query ha successo allora la proprietà di $res è >0
        chiaramente potremmo controllare anche se la query è ben formattata(controllo solo in fase di sviluppo)
        quindi si può evitare di fare*/
        if ($res->num_rows <= 0) return "valore non esiste";
        $row = $res->fetch_assoc();
        $user = new AccountCalciatore($row["contratto"], $row["password"],
            $row["squadra"], $row["email"], $row["nome"],
            $row["cognome"], $row["datadinascita"], $row["domicilio"],
            $row["indirizzo"], $row["provincia"], $row["telefono"],
            $row["immagine"], $row["nazionalita"]);
        // se è un calciatore query cercare tutti i suoi ruoli->cra un ruolo
        return $user;

    }

    public function eliminaAccount_A_T_S($u)
    {

        try {
            /*forziamo il metodo e lo utilizziamo come controllo, perchè se l'account non esiste viene lanciata
            l'eccezione*/
            $this->ricercaAccount_A_T_S($u);
            $query = "DELETE FROM utente WHERE  username_codiceContratto='$u'";
            //questo controllo non funziona se passiamo un username che non esiste perciò abbiamo
            //fatto il controllo di ricercaAccount sopra
            //if (!$this->conn->query($sql))  throw new \Exception(("errore MODIFICA dati nel db"));
            $this->conn->query($query);
        } catch (\Exception $e) {
            throw new \Exception("l'utente da eliminare non esiste");
        }
        return "Andato a buon fine";
    }

    public function eliminaAccount_G($u)
    {

        try {
            /*forziamo il metodo e lo utilizziamo come controllo, perchè se l'account non esiste viene lanciata
            l'eccezione*/
            $this->ricercaAccount_G($u);
            $query = "DELETE FROM calciatore WHERE  contratto='$u'";
            //questo controllo non funziona se passiamo un username che non esiste perciò abbiamo
            //fatto il controllo di ricercaAccount sopra
            //if (!$this->conn->query($sql))  throw new \Exception(("errore MODIFICA dati nel db"));
            $this->conn->query($query);
        } catch (\Exception $e) {
            throw new \Exception("l'utente da eliminare non esiste");
        }
        return "Andato a buon fine";
    }

    public function aggiungiAccount_C(AccountCalciatore $c)
    {


        /*controlliamo che l'account non sia null(controllo piuttosto inutile)*/
        if ($c == null) throw new \Exception("valore nullo");
        $sql = "INSERT INTO calciatore (contratto, squadra, email, password, nome, cognome, 
                  datadinascita, domicilio, indirizzo, provincia, telefono,nazionalita, immagine) 
                VALUES ('" . $c->getUsernameCodiceContratto() . "','"
            . $c->getSquadra() . "','"
            . $c->getEmail() . "','"
            . $c->getPassword() . "','"
            . $c->getNome() . "','"
            . $c->getCognome() . "','"
            . $c->getDataDiNascita() . "','"
            . $c->getDomicilio() . "','"
            . $c->getIndirizzo() . "','"
            . $c->getProvincia() . "','"
            . $c->getTelefono() . "','"
            . $c->getNazionalita() . "','"
            . $c->getImmagine() . "');";
        $ris = $this->conn->query($sql);
        /*il metodo query ritorna il valore false nel caso in cui la query non va c buon fine, casi:
            - query non formattata bene(problema in fase di costruzione
            - viola qualche vincolo(pe esempio il campo squadra dove squadra non esiste)
          in tutti gli altri casi ritorna un oggetto con info che non ci serve
          nota: se il cmpo prevede 10 caratteri, e passiamo una stringa di 12 caratteri, mysql la tronca -> non va in errore*/
        if (!$ris) throw new \Exception(("errore inserimento dati nel db"));

    }

    public function convalidaAccount_A_G($u)
    {  $sql = "UPDATE calciatore SET attivo='1' WHERE contratto='$u'";
        $sql2 = "UPDATE utente SET attivo='1' WHERE username_codiceContratto='$u'";
        try {
          //  $this->ricercaAccount_A_T_S($u);

            //questo controllo non funziona se passiamo un username che non esiste perciò abbiamo
            //fatto il controllo di ricercaAccount sopra
            //if (!$this->conn->query($sql))  throw new \Exception(("errore MODIFICA dati nel db"));
            $this->conn->query($sql);
            $this->conn->query($sql2);

        } catch (\Exception $e) {
            //significa che in utente non c'è allora vado a vedere se è un giocatore


        }
    }

    public function dammiAccountDaConvalidare()
    {
        $squadra =$_SESSION["squadra"];
        $utenti = null;

        $sql = "SELECT * FROM utente WHERE attivo ='0' AND tipo !='staff' AND squadra='$squadra'";
        $sql2 = "SELECT * FROM calciatore WHERE attivo ='0' AND squadra='$squadra'";
        try {
            $ris = $this->conn->query($sql);
            $ris2 = $this->conn->query($sql2);

            if ($ris->num_rows >= 0) //throw new Exception("Nessun utente trovato");
            {
            while ($row = $ris->fetch_assoc()) {
                $user = new Account($row["username_codiceContratto"], $row["password"],
                    $row["squadra"], $row["email"], $row["nome"],
                    $row["cognome"], $row["datadinascita"], $row["domicilio"],
                    $row["indirizzo"], $row["provincia"], $row["telefono"],
                    $row["immagine"], $row["tipo"]);

                $utenti[] = $user;
            }}
            if ($ris2->num_rows >= 0) //throw new Exception("Nessun utente trovato");
            {
            while ($row = $ris2->fetch_assoc()) {
                $user = new Account($row["contratto"], $row["password"],
                    $row["squadra"], $row["email"], $row["nome"],
                    $row["cognome"], $row["datadinascita"], $row["domicilio"],
                    $row["indirizzo"], $row["provincia"], $row["telefono"],
                    $row["immagine"], "");

                $utenti[] = $user;
            }}

        } catch (\Exception $e) {


        }
        if($utenti==null)return "vuoto";
        return $utenti;
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        $this->db->close($this->conn);
    }
}