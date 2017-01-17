<?php
/**
 * Created by PhpStorm.
 * User: Raffaele
 * Date: 17/12/2016
 * Time: 09:50
 */

namespace AppBundle\it\unisa\autenticazione;


use AppBundle\it\unisa\account\GestoreAccount;
use AppBundle\Utility\DB;

/**
 * Class GestioneAutenticazione
 * @package AppBundle\it\unisa\autenticazione
 */
class GestoreAutenticazione
{

    /**
     * @var \mysqli
     */
    private $conn;
    /**
     * @var DB
     */
    private $db;
    private static $instance = null;

    /**
     * GestioneAutenticazione constructor.
     */
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

    /**
     * @param $username
     * @param $password
     * @return bool : true se esiste:
     *                              crea una sessione con tre info:
     *                                      -useranme
     *                                      -squadra appartenenza
     *                                      - tipo(calciatore,allenatore,staff,tisofo)
     *                false se non esiste l'account
     */
    public function login($username, $password)
    {
        $g = GestoreAccount::getInstance();

        $acc = $g->ricercaAccount_A_T_S($username);
        if ($acc == "valore non esiste") {
            $acc = $g->ricercaAccount_G($username);
            if ($acc == "valore non esiste") return false;

            $check = $this->checkPassword($password, $acc->getPassword());

            if ($check) {
                $this->creaSession($acc->getUsernameCodiceContratto(), "calciatore", $acc->getSquadra());
                return true;
            } else return false;
        }

        $check = $this->checkPassword($password, $acc->getPassword());

        if ($check) {
            $this->creaSession($acc->getUsernameCodiceContratto(), $acc->getTipo(), $acc->getSquadra());
            return true;
        } else return false;

    }

    /**
     * @param $username
     * @param $tipo
     * @param $squadra
     */
    private function creaSession($username, $tipo, $squadra)
    {
        if (isset($_SESSION)) {
            $this->logout();
        }

        // Finally, destroy the session.
        session_start();
        $_SESSION["username"] = $username;
        $_SESSION["tipo"] = $tipo;
        $_SESSION["squadra"] = $squadra;
    }

    /**
     * @param $passwordInserita
     * @param $passwordSalvata
     * @return bool
     */
    private
    function checkPassword($passwordInserita, $passwordSalvata)
    {
        //if(strcmp(md5($passwordInserita),$passwordSalvata) == 0){
        if (strcmp($passwordInserita, $passwordSalvata) == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @param $ogg
     */
    public
    function check($rotta)
    {

        $rotteStabilite = $this->inizializzazioneRotte();
        foreach ($rotteStabilite as $r) {
            if ($r->getRotta() == $rotta) {
                foreach ($r->getAttori() as $a) {
                    if ($a == $_SESSION["tipo"]) {
                        return true;
                    }
                }

            }
        }
        return false;
    }

    private
    function inizializzazioneRotte()
    {
        $rotte = array(new RottaUtente("convalidaAccountForm", array("staff")),
            new RottaUtente("ricercaAccountForm", array("staff")),
            new RottaUtente("verificaConvocazioni", array("allenatore")),
            new RottaUtente("verificaFormazione", array("allenatore")),
            new RottaUtente("infoPartita", array("allenatore", "calciatore", "staff", "tifoso")),
            new RottaUtente("lista_partite", array("allenatore", "calciatore", "staff", "tifoso")),
            new RottaUtente("inserisciPartitaForm", array("staff")),
            new RottaUtente("inserisciPartita", array("staff")),
            new RottaUtente("Form_modifica_partita", array("staff")),
            new RottaUtente("modificaPartita", array("staff")),
            new RottaUtente("StatisticheComplessiveCalciatoreView", array("allenatore", "calciatore", "staff", "tifoso")),
            new RottaUtente("form_filtra_calciatori", array("allenatore", "calciatore", "staff", "tifoso")),
            new RottaUtente("filtra_calciatori", array("allenatore", "calciatore", "staff", "tifoso")),
            new RottaUtente("lista_statistiche_calciatori", array("allenatore", "calciatore", "staff", "tifoso")),
            new RottaUtente("form_modifica_statistiche_calciatore", array("staff")),
            new RottaUtente("form_inserisci_statistiche_calciatore", array("staff")),
            new RottaUtente("InserisciStatisticheCalciatore", array("staff")),
            new RottaUtente("ModificheStatisticheCalciatore", array("staff")),
            new RottaUtente("lista_statistiche_calciatori_partita", array("staff")),
            new RottaUtente("inserisciStatistichePartita", array("staff")),
            new RottaUtente("modificaStatistichePartita", array("staff")),
            new RottaUtente("getConvocatiPartita", array("staff")),
            new RottaUtente("lista_statistiche_partite", array("allenatore", "calciatore", "staff", "tifoso")),
            new RottaUtente("sceglichat", array("allenatore")),
            new RottaUtente("sceglivoce", array("allenatore")),
            new RottaUtente("sceglicomportamento", array("allenatore")),
            new RottaUtente("sceglisalute", array("allenatore")),
            new RottaUtente("allenatore_chat_view",array("allenatore")),
            new RottaUtente("inviaMessaggioVoce",array("allenatore")),
            new RottaUtente("inviaMulta",array("allenatore")),
            new RottaUtente("inviaAvvertimento",array("allenatore")),
            new RottaUtente("inviaDieta",array("allenatore")),
            new RottaUtente("inviaAllenamento",array("allenatore")),
            new RottaUtente("allenatore_chat_view",array("allenatore")),
            new RottaUtente("ottienivoceview",array("allenatore")),
            new RottaUtente("ottienimultaview",array("allenatore")),
            new RottaUtente("ottieniavvertimentoview",array("allenatore")),
            new RottaUtente("ottienidietaview",array("allenatore")),
            new RottaUtente("ottieniallenamentoview",array("allenatore")),
            new RottaUtente("calciatoreInviaMessaggioChat",array("calciatore")),
            new RottaUtente("ottieniMessaggioChatView",array("calciatore")),
            new RottaUtente("ottieniMessaggioVoceView",array("calciatore")),
            new RottaUtente("ottieniMulta",array("calciatore")),
            new RottaUtente("ottieniAvvertimento",array("calciatore")),
            new RottaUtente("ottieniDieta",array("calciatore")),
            new RottaUtente("ottieniAllenamento",array("calciatore")),
            new RottaUtente("calciatoreinviamessaggiovoce",array("calciatore")),
            new RottaUtente("inviamessaggiovoce",array("calciatore")),
            new RottaUtente("inserisciContenutoForm",array("staff")),
            new RottaUtente("inserisciContenuto",array("staff")),
            new RottaUtente("cancellaContenuto",array("staff")),
            new RottaUtente("visualizzaContenuto",array("staff")),
            new RottaUtente("visualizzaElencoContenutiSquadra",array("staff")),
            new RottaUtente("visualizzaContenutoUtenteRegistrato",array("tifoso")),
            new RottaUtente("visualizzaElencoContenutiPerTipo",array("tifoso")),
            new RottaUtente("allenatoreInviaMessaggioChat", array("allenatore"))
        );
        return $rotte;
    }

    /**
     * Verifica che l'account sia validato
     * @param $account
     */
    public
    function verificaValidaAccount($account)
    {
        if ($_SESSION["tipo"] == "staff") {
            return 1;
        }
        if ($_SESSION["tipo"] == "calciatore") {
            $sql = "SELECT * FROM calciatore WHERE attivo ='1' AND contratto ='$account' ";
        }
        if ($_SESSION["tipo"] == "allenatore" || $_SESSION["tipo"] == "tifoso") {
            $sql = "SELECT * FROM utente WHERE attivo ='1' AND username_codiceContratto ='$account' ";

        }

        $res = $this->conn->query($sql);

        if ($res->num_rows > 0) {
            return 1;
        } else {
            $sq = $_SESSION["squadra"];
            $staffQuery = "SELECT * FROM utente WHERE tipo= 'staff' AND squadra='$sq'";
            $riga = $this->conn->query($staffQuery)->fetch_assoc();
            if ($riga["telefono"] == null) {
                return "numero dello staff non presente per la squadra";
            } else {
                return $riga["telefono"];
            }
        }

    }


    /**
     * @return bool
     */
    public
    function logout()
    {
        if (isset($_SESSION)) {
            /*
            setcookie("PHPSESSID","",time()-3600,"/");
            return session_destroy();
            */

            $_SESSION = array();

            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();

                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
            return session_destroy();

        } else
            return FALSE;
    }

    /**
     *
     */
    public
    function __destruct()
    {
        // TODO: Implement __destruct() method.
        $this->db->close($this->conn);
    }

}