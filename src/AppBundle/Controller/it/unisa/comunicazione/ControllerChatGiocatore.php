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
        $g = new GestoreComunicazione();
        try {
            $testo = $richiesta->request->get("testo");
            $messaggio = new Messaggio($testo, $_SESSION["username"],
                $richiesta->get("destinatario"),
                "calciatore", time(), "chat");

            $g->inviaMessaggio($messaggio);
            return new Response(json_encode(array("testo" => $messaggio->getTesto(),
                "nomeMittente" => $messaggio->getNomeMittente(),
                "cognomeMittente" => $messaggio->getCognomeMittente(),
                "mittente" => $messaggio->getMittente(),
                "data" => $messaggio->getData()), JSON_PRETTY_PRINT));
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
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

        $calciatoreMittente = $_SESSION["username"];
        $squadra = $_SESSION["squadra"];
        $allenatoreDestinatario = $gestoreComunicazione->getAllenatorePerSquadra($squadra);

        $g = new GestoreComunicazione();
        try {
            $messaggi = $g->ottieniMessaggiCalciatore($calciatoreMittente,
                "chat");

            return $this->render("giocatore/FormChatCalciatore.html.twig",
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


}