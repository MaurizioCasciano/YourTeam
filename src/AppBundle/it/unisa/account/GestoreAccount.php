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

        if($a==null)throw new \Exception("valore nullo");
        $sql = "INSERT INTO utente ('username', 'squadra', 'email', 'password', 'nome', 'cognome', 
                  'datadinascita', 'domicilio', 'indirizzo', 'provincia', 'telefono', 'immagine') 
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
                            . $a->getImmagine(). "')";
        $ris = $this->conn->query($sql);
        if(!$ris) throw new \Exception(("errore inserimento dati nel db"));

    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        $this->db->close($this->conn);
    }
}