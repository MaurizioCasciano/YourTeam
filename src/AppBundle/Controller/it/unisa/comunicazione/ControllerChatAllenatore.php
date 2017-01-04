<?php
/**
 * Created by PhpStorm.
 * User: Donato
 * Date: 14/12/2016
 * Time: 16:37
 */

namespace AppBundle\Controller\it\unisa\comunicazione;

use AppBundle\it\unisa\comunicazione\GestoreComunicazione;
use AppBundle\it\unisa\comunicazione\Messaggio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ControllerChatAllenatore extends Controller
{

    /**
     * @Route("/comunicazione/allenatore/inviaMessaggioChat", name="allenatoreInviaMessaggioChat")
     *
     * @param $richiesta
     */

    public function inviaMessaggioChat(Request $richiesta)
    {
        $g = new GestoreComunicazione();
        try {
            $testo = $richiesta->request->get("testo");
            $messaggio = new Messaggio($testo, $_SESSION["username"],
                $richiesta->get("destinatario"),
                "allenatore", time(), "chat");

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
     * @Route("/comunicazione/allenatore/inviaMessaggioVoce")
     * @Method("POST")
     * @param $richiesta
     */
    public function inviaMessaggioVoce(Request $richiesta)
    {
        $g = new GestoreComunicazione();
        try {
            $ora = $richiesta->request->get("ora");
            $luogo = $richiesta->request->get("luogo");
            $data = $richiesta->request->get("data");
            $messaggio = new Messaggio("ora:" . $ora . " luogo:" . $luogo . " data:" . $data,
                $_SESSION["username"],
                $richiesta->get("d"), "allenatore", time(), "voce");

            $g -> inviaMessaggio($messaggio);
            return $this->scegliCalciatoreVoce($richiesta);
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
    }

    /**
     * @Route("/comunicazione/allenatore/inviaRichiamoMulta")
     * @Method("POST")
     * @param $richiesta
     */
    public function inviaRichiamoMulta(Request $richiesta)
    {
        $g = new GestoreComunicazione();
        try {
            $testo = $richiesta->request->get("multa");
            $g->inviaMessaggio(new Messaggio($testo, $_SESSION["username"],
                $richiesta->get("d"),
                "allenatore", time(), "multa"));
            return $this->scegliCalciatoreComportamento($richiesta);
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
    }

    /**
     * @Route("/comunicazione/allenatore/inviaRichiamoAvvertimento")
     * @Method("POST")
     * @param $richiesta
     */
    public function inviaRichiamoAvvertimento(Request $richiesta)
    {
        $g = new GestoreComunicazione();
        try {
            $testo = $richiesta->request->get("avvertimento");
            $g->inviaMessaggio(new Messaggio($testo, $_SESSION["username"],
                $richiesta->get("d"),
                "allenatore", time(), "avvertimento"));
            return $this->scegliCalciatoreComportamento($richiesta);
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
    }

    /**
     * @Route("/comunicazione/allenatore/inviaRichiamoDieta")
     * @Method("POST")
     * @param $richiesta
     */
    public function inviaRichiamoDieta(Request $richiesta)
    {
        $g = new GestoreComunicazione();
        try {
            $testo = $richiesta->request->get("dieta");
            $g->inviaMessaggio(new Messaggio($testo, $_SESSION["username"],
                $richiesta->get("d"),
                "allenatore", time(), "dieta"));
            return $this->scegliCalciatoreSalute($richiesta);
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
    }

    /**
     * @Route("/comunicazione/allenatore/inviaRichiamoAllenamento")
     * @Method("POST")
     * @param $richiesta
     */
    public function inviaRichiamoAllenamento(Request $richiesta)
    {
        $g = new GestoreComunicazione();
        try {
            $testo = $richiesta->request->get("allenamento");
            $g->inviaMessaggio(new Messaggio($testo, $_SESSION["username"],
                $richiesta->get("d"),
                "allenatore", time(), "allenamento"));
            return $this->scegliCalciatoreSalute($richiesta);
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
    }

    /**
     * @Route("/comunicazione/allenatore/sceglicalciatore")
     * @Method("GET")
     */
    public function scegliCalciatore(Request $request)
    {
        $g = new GestoreComunicazione();
        if (!isset($_SESSION["squadra"])) {
            throw new \RuntimeException("Squadra is null");
        }
        $calciatori = $g->getCalciatoriPerSquadra($_SESSION["squadra"]);


        return $this->render(":allenatore:FormScegliCalciatore.html.twig", array("calciatori" => $calciatori));
    }

    /**
     * @Route("/comunicazione/allenatore/sceglicalciatorevoce")
     * @Method("GET")
     */
    public function scegliCalciatoreVoce(Request $request)
    {
        $g = new GestoreComunicazione();
        if (!isset($_SESSION["squadra"])) {
            throw new \RuntimeException("Squadra is null");
        }
        $calciatori = $g->getCalciatoriPerSquadra($_SESSION["squadra"]);

        return $this->render(":allenatore:FormScegliCalciatoreVoce.html.twig", array("calciatori" => $calciatori));
    }

    /**
    * @Route("/comunicazione/allenatore/sceglicalciatorecomportamento")
    * @Method("GET")
    */
    public function scegliCalciatoreComportamento(Request $request)
    {
        $g = new GestoreComunicazione();
        if (!isset($_SESSION["squadra"])) {
            throw new \RuntimeException("Squadra is null");
        }
        $calciatori = $g->getCalciatoriPerSquadra($_SESSION["squadra"]);
        $messaggi = $g->ottieniMessaggiRichiamoMulta($calciatori);
        $messaggi2 = $g->ottieniMessaggioRichiamoAvvertimento($calciatori);

        return $this->render(":allenatore:FormScegliCalciatoreComportamento.html.twig", array("calciatori" => $calciatori, "messaggi" => $messaggi, "messaggi2" => $messaggi2));
}

    /**
     * @Route("/comunicazione/allenatore/sceglicalciatoresalute")
     * @Method("GET")
     */
    public function scegliCalciatoreSalute(Request $request)
    {
        $g = new GestoreComunicazione();
        if (!isset($_SESSION["squadra"])) {
            throw new \RuntimeException("Squadra is null");
        }
        $calciatori = $g->getCalciatoriPerSquadra($_SESSION["squadra"]);
        $messaggi = $g->ottieniMessaggioRichiamoDieta($calciatori);
        $messaggi2 = $g->ottieniMessaggioRichiamoAllenamento($calciatori);

        return $this->render(":allenatore:FormScegliCalciatoreSalute.html.twig", array("calciatori" => $calciatori, "messaggi" => $messaggi, "messaggi2" => $messaggi2));
    }

    /**
     * @Route("/comunicazione/allenatore/ottieniMessaggioChatView", name="allenatore_chat_view")
     * @Method("POST")
     */
    public function ottieniMessaggioChatView(Request $request)
    {
        if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "allenatore") {
            throw new \Exception("Allenatore non loggato");
        }

        $g = new GestoreAccount();
        $allenatoreMittente = $g->ricercaAccount_A_T_S($_SESSION["username"]);
        $calciatoreDestinatario = $request->get("calciatore_destinatario");

        $g = new GestoreComunicazione();
        try {
            $messaggi = $g->ottieniMessaggi($allenatoreMittente, "chat", $calciatoreDestinatario);

            return $this->render("allenatore/FormChatAllenatore2.html.twig", array("messaggi" => $messaggi, "destinatario" => $calciatoreDestinatario, "allenatore" => $allenatoreMittente));
        } catch (\Exception $e) {
            return $this->render("allenatore/FormChatAllenatore2.html.twig", array("messaggi" => array(), "destinatario" => $calciatoreDestinatario, "allenatore" => $allenatoreMittente));
        }
    }

    /**
     * @Route("/comunicazione/allenatore/ottieniMessaggioVoceView")
     * @Method("POST")
     */
    public function ottieniMessaggioVoceView(Request $request)
    {
        if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "allenatore") {
            throw new \Exception("Allenatore non loggato");
        }
        $allenatoreMittente = $_SESSION["username"];
        $calciatoreDestinatario = $request->get("calciatore_destinatario");
        $g = new GestoreComunicazione();
        try {
            $messaggi = $g->ottieniMessaggi($allenatoreMittente, "chat", $calciatoreDestinatario);

            return $this->render("allenatore/FormVoceAllenatore.html.twig", array("messaggi" => $messaggi, "d" => $calciatoreDestinatario));
        } catch (\Exception $e) {
            return $this->render("allenatore/FormVoceAllenatore.html.twig", array("messaggi" => array(), "d" => $calciatoreDestinatario));
        }
    }

    /**
     * @Route("/comunicazione/allenatore/ottieniRichiamoMultaView")
     * @Method("POST")
     */
    public function ottieniRichiamoMultaView(Request $request)
    {
        if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "allenatore") {
            throw new \Exception("Allenatore non loggato");
        }

        $allenatoreMittente = $_SESSION["username"];
        $calciatoreDestinatario = $request->get("calciatore_destinatario");
        $testomulta = $request->get("multa");
        $g = new GestoreComunicazione();

        try {
            $messaggi = $g->ottieniMessaggioComportamento($allenatoreMittente, $calciatoreDestinatario, $testomulta);
            $str = "";

            return $this->render("allenatore/FormRichiamoComportamento.html.twig", array("messaggi" => $messaggi, "d" => $calciatoreDestinatario));
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
    }

    /**
     * @Route("/comunicazione/allenatore/ottieniRichiamoAvvertimentoView")
     * @Method("POST")
     */
    public function ottieniRichiamoAvvertimentoView(Request $request)
    {
        if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "allenatore") {
            throw new \Exception("Allenatore non loggato");
        }
        $allenatoreMittente = $_SESSION["username"];
        $calciatoreDestinatario = $request->get("calciatore_destinatario");
        $testomulta = $request->get("avvertimento");
        $g = new GestoreComunicazione();
        try {
            $messaggi = $g->ottieniMessaggioComportamento($allenatoreMittente, $calciatoreDestinatario, $testomulta);
            $str = "";

            return $this->render("allenatore/FormRichiamoComportamento.html.twig", array("messaggi" => $messaggi, "d" => $calciatoreDestinatario));
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
    }

    /**
     * @Route("/comunicazione/allenatore/ottieniRichiamoDietaView")
     * @Method("POST")
     */
    public function ottieniRichiamoDieta(Request $request)
    {
        if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "allenatore") {
            throw new \Exception("Allenatore non loggato");
        }
        $allenatoreMittente = $_SESSION["username"];
        $calciatoreDestinatario = $request->get("calciatore_destinatario");
        $testorichiamo = $request->get("avvertimento");
        $g = new GestoreComunicazione();
        try {
            $messaggi = $g->ottieniMessaggioSalute($allenatoreMittente, $calciatoreDestinatario, $testorichiamo);
            $str = "";

            return $this->render("allenatore/FormRichiamoSalute.html.twig", array("messaggi" => $messaggi, "d" => $calciatoreDestinatario));
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
    }

    /**
     * @Route("/comunicazione/allenatore/ottieniRichiamoAllenamentoView")
     * @Method("POST")
     */
    public function ottieniRichiamoAllenamentoView(Request $request){
        if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "allenatore") {
            throw new \Exception("Allenatore non loggato");
        }
        $allenatoreMittente = $_SESSION["username"];
        $calciatoreDestinatario = $request->get("calciatore_destinatario");
        $testorichiamo = $request->get("avvertimento");
        $g = new GestoreComunicazione();
        try {
            $messaggi = $g->ottieniMessaggioSalute($allenatoreMittente, $calciatoreDestinatario, $testorichiamo);
            $str = "";

            return $this->render("allenatore/FormRichiamoSalute.html.twig", array("messaggi" => $messaggi, "d" => $calciatoreDestinatario));
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
    }


}