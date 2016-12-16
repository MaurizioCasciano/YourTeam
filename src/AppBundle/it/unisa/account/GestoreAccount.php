<?php
/**
 * Created by PhpStorm.
 * User: Raffaele
 * Date: 16/12/2016
 * Time: 08:46
 */

namespace AppBundle\it\unisa\account;



use AppBundle\Utility\DB;


class GestoreAccount
{

    private $conn;
    private $db;

    public function __construct()
    {
        $this->db=new DB();
        $this->conn=$this->db->connect();
    }

    public function aggiungiAccount(Account $a){

        /*controlliamo che l'account non sia null(controllo piuttosto inutile)*/
        if($a==null)throw new \Exception("valore nullo");
        $sql = "INSERT INTO utente (username, squadra, email, password, nome, cognome, 
                  datadinascita, domicilio, indirizzo, provincia, telefono, immagine) 
                VALUES ('" . $a->getUsername() . "','"
                            . $a->getSquadra() . "','"
                            . $a->getEmail() . "','"
                            . $a->getPassword() . "','"
                            . $a->getNome() . "','"
                            . $a->getCognome() . "','"
                            . $a->getDataDiNascita() . "','"
                            . $a->getDomicilio() . "','"
                            . $a->getIndirizzo(). "','"
                            . $a->getProvincia() . "','"
                            . $a->getTelefono(). "','"
                            . $a->getImmagine(). "');";
        $ris = $this->conn->query($sql);
        /*il metodo query ritorna il valore false nel caso in cui la query non va a buon fine, casi:
            - query non formattata bene(problema in fase di costruzione
            - viola qualche vincolo(pe esempio il campo squadra dove squadra non esiste)
          in tutti gli altri casi ritorna un oggetto con info che non ci serve
          nota: se il cmpo prevede 10 caratteri, e passiamo una stringa di 12 caratteri, mysql la tronca -> non va in errore*/
        if(!$ris) throw new \Exception(("errore inserimento dati nel db"));

    }

    public function ricercaAccount($u){
        if(!isset($u))throw new \Exception("valore non setttato");

        $sql = "SELECT * FROM utente WHERE username='$u'";
        $res = $this->conn->query($sql);
        /*se la query ha successo allora la proprietà di $res è >0
        chiaramente potremmo controllare anche se la query è ben formattata(controllo solo in fase di sviluppo)
        quindi si può evitare di fare*/
        if($res->num_rows <= 0) throw new \Exception("account con username".$u."non esiste");
        $row = $res->fetch_assoc();
        $user = new Account($row["username"],$row["password"],
                            $row["squadra"],$row["email"],$row["nome"],
                            $row["cognome"],$row["datadinascita"],$row["domicilio"],
                            $row["indirizzo"],$row["provincia"],$row["telefono"],
                            $row["immagine"]);

        return $user;

    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        $this->db->close($this->conn);
    }
}