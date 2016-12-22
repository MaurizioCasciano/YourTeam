<?php
namespace AppBundle\it\unisa\contenuti;

/**
 * Created by PhpStorm.
 * User: Carmine
 * Date: 20/12/2016
 * Time: 11:48
 */
use AppBundle\Utility\DB;

class GestioneContenuti
{

    private $conn;
    private $db;

    public function __construct()
    {
        $this->db=new DB();
        $this->conn=$this->db->connect();
    }

    public function inserisciContenuto(Contenuto $contenuto){
        $sql = "INSERT INTO contenuto(squadra,titolo,descrizione,URL,tipo)
        VALUES ('".$contenuto->getSquadra()."','"
            .$contenuto->getTitolo()."','"
            .$contenuto->getDescrizione()."','"
            .$contenuto->getURL()."','"
            .$contenuto->getTipo()."');";

        $res = $this->conn->query($sql);
        if(!$res) throw new \Exception(("errore inserimento dati nel db"));
    }

    public function cancellaContenuto($id){
        try{
            $this->visualizzaContenuto($id);
            $sql = "DELETE FROM contenuto WHERE id='$id'";
            $this->conn->query($sql);
        }catch (\Exception $e) {
            throw new \Exception("il contenuto da eliminare non esiste");
        }
    }

    public function modificaContenuto($id,Contenuto $contenuto){
        try{
            $this->visualizzaContenuto($id);
            $sql = "UPDATE contenuto 
                    SET titolo='".$contenuto->getTitolo()
               ."', descrizione='".$contenuto->getDescrizione()
               ."', url='".$contenuto->getURL()
               ."', tipo='".$contenuto->getTipo()
               ."' WHERE id='$id'";
            $this->conn->query($sql);

        }catch (\Exception $e) {
            throw new \Exception("il contenuto da modificare non esiste");
        }
    }

    public function visualizzaElencoContenuti(){
        $sql="SELECT * FROM contenuto";
        $elenco = array();
        $res = $this->conn->query($sql);
        $i=0;
        if($res->num_rows <= 0) throw new \Exception("Elenco contenuti vuoto");
            while($row = $res->fetch_assoc()){
                $contenuto = new Contenuto($row["titolo"],$row["descrizione"], $row["url"],$row["tipo"],$row["squadra"]);
                $elenco[$i]=$contenuto;
                $i++;
            }
        for ($i=0;$i<count($elenco);$i++){
            echo $elenco[$i]."<br/>";
        }
    }

    public function visualizzaElencoContenutiSquadra($squadra){
        $sql="SELECT * FROM contenuto WHERE squadra='$squadra'";
        $elenco = array();
        $res = $this->conn->query($sql);
        $i=0;
        if($res->num_rows <= 0) throw new \Exception("Elenco contenuti vuoto per la squadra selezionata");
        while($row = $res->fetch_assoc()){
            $contenuto = new Contenuto($row["titolo"],$row["descrizione"], $row["url"],$row["tipo"],$row["squadra"]);
            $elenco[$i]=$contenuto;
            $i++;
        }
        for ($i=0;$i<count($elenco);$i++){
            echo $elenco[$i]."<br/>";
        }
    }

    public function visualizzaContenuto($id){
        $sql = "SELECT * FROM contenuto WHERE id='$id'";
        $res = $this->conn->query($sql);
        if($res->num_rows <= 0) throw new \Exception("contenuto non disponibile");
        $row = $res->fetch_assoc();

        $contenuto = new Contenuto($row["titolo"],$row["descrizione"], $row["url"],$row["tipo"],$row["squadra"]);
        $contenuto->setId($row["id"]);
        echo $contenuto;
        return $contenuto;
    }
}