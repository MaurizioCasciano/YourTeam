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
     * @Route("/comunicazione/giocatore/inviaMessaggioChat")
     * @Method("POST")
     */
    public function inviaMessaggioChat(Request $richiesta)
    {
        $g = new GestoreComunicazione();
        try {
            $testo = $richiesta->request->get("testo");
            $g->inviaMessaggio(new Messaggio($testo, $richiesta->get("d"), $_SESSION["username"],

                "calciatore", time(), "chat"));
            return new Response("messaggio inviato correttamente");
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
            $data = $richiesta->request->get("data_appuntamento");
            $g->inviaMessaggio(new Messaggio("ora:" . $ora . " luogo:" . $luogo . " data:" . $data,
                $richiesta->request->get("allenatore"),
                $richiesta->request->get("calciatore"), "calciatore", time(), "voce"));/*lo invia sempre il calciatore da questa classe*/
            return new Response("messaggio inviato correttamente");
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
    }

    /**
     * @Route("/comunicazione/giocatore/ottieniinviaMessaggioForm")
     * @Method("GET")
     */
    public function ottieniMessaggioForm()
    {

    }

    /**
     * @Route("/comunicazione/giocatore/ottieniMessaggioVoceForm")
     * @Method("GET")
     */
    public function ottieniMessaggioVoceForm()
    {

    }



    /*CHIARAMENTE I MESSAGGI VANNO ORDINATI IN BASE ALLA DATA(DA FARE)*/
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

            // return new Response(var_dump($messaggi));
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
     * @Route("/comunicazione/giocatore/ottieniMessaggioVoceView/{contratto_giocatore}")
     * @Method("GET")
     */
    public function ottieniMessaggioVoceView($contratto_giocatore)
    {
        $g = new GestoreComunicazione();
        try {
            $messaggi = $g->ottieniMessaggiCalciatore($contratto_giocatore, "voce");
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