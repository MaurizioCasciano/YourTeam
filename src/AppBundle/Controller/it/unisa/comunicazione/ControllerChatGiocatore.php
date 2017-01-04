<?php

namespace AppBundle\Controller\it\unisa\comunicazione;

use AppBundle\it\unisa\account\GestoreAccount;
use AppBundle\it\unisa\comunicazione\GestoreComunicazione;
use AppBundle\it\unisa\comunicazione\Messaggio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ControllerChatGiocatore extends Controller
{

    /**
     * @Route("/comunicazione/giocatore/inviaMessaggioChat", name="calciatoreInviaMessaggioChat")
     * @Method("POST")
     */
    public function inviaMessaggioChat(Request $richiesta)
    {
        var_dump("InviaMessaggioCHAT");

        $g = new GestoreComunicazione();
        try {
            $testo = $richiesta->request->get("testo");
            $allenatore = $richiesta->get("destinatario");
            $calciatore = $_SESSION["username"];
            $mittente = "calciatore";
            $data = time();
            $tipo = "chat";


            //__construct($testo, $allenatore, $calciatore, $mittente, $data, $tipo)
            $messaggio = new Messaggio($testo, $allenatore, $calciatore, $mittente, $data, $tipo);
            var_dump($messaggio);


            $g->inviaMessaggio($messaggio);
            return new Response(json_encode(array("testo" => $messaggio->getTesto(),
                "nomeMittente" => $messaggio->getNomeMittente(),
                "cognomeMittente" => $messaggio->getCognomeMittente(),
                "mittente" => $messaggio->getMittente(),
                "data" => $messaggio->getData()), JSON_PRETTY_PRINT));
        } catch (\Exception $e) {
            return new Response($e->getMessage());
        }
    }

    /**
     * @Route("/comunicazione/giocatore/inviaMessaggioVoce")
     * @Method("POST")
     */
    public function inviaMessaggioVoce(Request $richiesta)
    {
        $g = new GestoreComunicazione();
        try {
            $ora = $richiesta->request->get("ora");
            $luogo = $richiesta->request->get("luogo");
            $data = $richiesta->request->get("data");
            $g->inviaMessaggio(new Messaggio("ora:" . $ora . " luogo:" . $luogo . " data:" . $data,
                $_SESSION["username"],
                $richiesta->get("d"), "calciatore", time(), "voce"));
            return new Response("Messaggio inviato correttamente");
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
    }

    /**
     * @Route("/comunicazione/giocatore/ottieniMessaggioChatView")
     * @Method("GET")
     */
    public function ottieniMessaggioChatView(Request $request)
    {
        if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "calciatore") {
            throw new \Exception("Calciatore non loggato");
        }
        $gestoreComunicazione = new GestoreComunicazione();

        $g = new GestoreAccount();
        // = $g->ricercaAccount_G($_SESSION["username"]);
        $calciatoreMittente = $_SESSION["username"];
        $squadra = $_SESSION["squadra"];
        $allenatoreDestinatario = $gestoreComunicazione->getAllenatorePerSquadra($squadra);

        //XDebug
        var_dump($allenatoreDestinatario); //OK


        $g = new GestoreComunicazione();
        try {
            $messaggi = $g->ottieniMessaggiCalciatore($calciatoreMittente,
                "chat");

            var_dump($messaggi);

            return $this->render("giocatore/FormChatCalciatore.html.twig",
                array("messaggi" => $messaggi,
                       "destinatario" => $allenatoreDestinatario->getUsernameCodiceContratto()));
                     // "calciatore" => $calciatoreMittente));
        } catch (\Exception $e) {
            return new Response($e->getMessage());
        }
    }

    /**
     * @Route("/comunicazione/giocatore/ottieniMessaggioVoceView")
     * @Method("GET")
     */
    public function ottieniMessaggioVoceView(Request $request)
    {
        if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "calciatore") {
            throw new \Exception("Calciatore non loggato");
        }
        $gestoreComunicazione = new GestoreComunicazione();

        $calciatoreMittente = $_SESSION["username"];
        $squadra = $_SESSION["squadra"];
        $allenatoreDestinatario = $gestoreComunicazione->getAllenatorePerSquadra($squadra);

        $g = new GestoreComunicazione();
        try {
            $messaggi = $g->ottieniMessaggiCalciatore($calciatoreMittente,
                "chat");

            return $this->render("giocatore/FormVoceCalciatore.html.twig",
                array("messaggi" => $messaggi, "d" => $allenatoreDestinatario->getUsernameCodiceContratto()));
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
        $g = new GestoreComunicazione();
        try {
            $messaggi = $g->ottieniMessaggiCalciatore($contratto_giocatore, "chat");
            $str = "";
            foreach ($messaggi as $m) {
                $str = $str . $m;
                $str = $str . "</br >";
            }
            return new Response($str);
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
    }

    /**
     * @Route("/comunicazione/giocatore/ottieniVistaRichiamoMulta")
     * @Method("GET")
     */
    public function ottieniVistaRichiamoMulta(Request $request){
        if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "calciatore") {
            throw new \Exception("Calciatore non loggato");
        }
        $gestoreComunicazione = new GestoreComunicazione();

        $calciatoreMittente = $_SESSION["username"];
        $squadra = $_SESSION["squadra"];
        //$allenatoreDestinatario = $gestoreComunicazione->getAllenatorePerSquadra($squadra);
        try{
            $messaggi = $gestoreComunicazione->ottieniMessaggiRichiamoMulta($calciatoreMittente);

            return $this->render("giocatore/VistaRichiamoMulta.html.twig", array("messaggi" => $messaggi));
        }catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
    }

    /**
     * @Route("/comunicazione/giocatore/ottieniVistaRichiamoAvvertimento")
     * @Method("GET")
     */
    public function ottieniVistaRichiamoAvvertimento(Request $request){
        if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "calciatore") {
            throw new \Exception("Calciatore non loggato");
        }
        $gestoreComunicazione = new GestoreComunicazione();

        $calciatoreMittente = $_SESSION["username"];
        $squadra = $_SESSION["squadra"];
        //$allenatoreDestinatario = $gestoreComunicazione->getAllenatorePerSquadra($squadra);
        try{
            $messaggi = $gestoreComunicazione->ottieniMessaggioRichiamoAvvertimento($calciatoreMittente);

            return $this->render("giocatore/VistaRichiamoAvvertimento.html.twig", array("messaggi" => $messaggi));
        }catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
    }

    /**
     * @Route("/comunicazione/giocatore/ottieniVistaRichiamoDieta")
     * @Method("GET")
     */
    public function ottieniVistaRichiamoDieta(Request $request){
        if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "calciatore") {
            throw new \Exception("Calciatore non loggato");
        }
        $gestoreComunicazione = new GestoreComunicazione();

        $calciatoreMittente = $_SESSION["username"];
        $squadra = $_SESSION["squadra"];
        //$allenatoreDestinatario = $gestoreComunicazione->getAllenatorePerSquadra($squadra);
        try{
            $messaggi = $gestoreComunicazione->ottieniMessaggioRichiamoDieta($calciatoreMittente);

            return $this->render("giocatore/VistaRichiamoDieta.html.twig", array("messaggi" => $messaggi));
        }catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
    }

    /**
     * @Route("/comunicazione/giocatore/ottieniVistaRichiamoAllenamento")
     * @Method("GET")
     */
    public function ottieniVistaRichiamoAllenamento(Request $request){
        if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "calciatore") {
            throw new \Exception("Calciatore non loggato");
        }
        $gestoreComunicazione = new GestoreComunicazione();

        $calciatoreMittente = $_SESSION["username"];
        $squadra = $_SESSION["squadra"];
        //$allenatoreDestinatario = $gestoreComunicazione->getAllenatorePerSquadra($squadra);
        try{
            $messaggi = $gestoreComunicazione->ottieniMessaggioRichiamoAllenamento($calciatoreMittente);

            return $this->render("giocatore/VistaRichiamoAllenamento.html.twig", array("messaggi" => $messaggi));
        }catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
    }


}