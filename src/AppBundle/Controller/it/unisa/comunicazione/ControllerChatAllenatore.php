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


            //return new Response("Messaggio inviato correttamente");


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
            $data = $richiesta->request->get("data_appuntamento");
            $g->inviaMessaggio(new Messaggio("ora:" . $ora . " luogo:" . $luogo . " data:" . $data,
                $richiesta->request->get("allenatore"),
                $richiesta->request->get("calciatore"), "allenatore", time(), "voce"));
            return new Response("messaggio inviato correttamente");
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
            return new Response("Messaggio inviato correttamente");
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
            return new Response("Messaggio inviato correttamente");
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
            return new Response("Messaggio inviato correttamente");
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
            return new Response("Messaggio inviato correttamente");
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
    }

    /**
     * @Route("/comunicazione/allenatore/ottieniMessaggioForm")
     * @Method("GET")
     */
    public function ottieniMessaggioForm()
    {

    }

    /**
     * @Route("/comunicazione/allenatore/ottieniMessaggioVoceForm")
     * @Method("GET")
     */
    public function ottieniMessaggioVoceForm()
    {

    }

    /**
     * @Route("/comunicazione/allenatore/ottieniRichiamoMultaForm")
     * @Method("GET")
     */
    public function ottieniRichiamoMultaForm()
    {

    }

    /**
     * @Route("/comunicazione/allenatore/ottieniRichiamoAvvertimentoForm")
     * @Method("GET")
     */
    public function ottieniRichiamoAvvertimentoForm()
    {

    }

    /**
     * @Route("/comunicazione/allenatore/ottieniRichiamoDietaForm")
     * @Method("GET")
     */
    public function ottieniRichiamoDietaForm()
    {

    }

    /**
     * @Route("/comunicazione/allenatore/ottieniRichiamoAllenamentoForm")
     * @Method("GET")
     */
    public function ottieniRichiamoAllenamentoForm()
    {

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

        //return new Response(var_dump($calciatori));
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

        $allenatoreMittente = $_SESSION["username"];
        $calciatoreDestinatario = $request->get("calciatore_destinatario");

        $g = new GestoreComunicazione();
        try {
            $messaggi = $g->ottieniMessaggiAllenatore($allenatoreMittente, "chat", $calciatoreDestinatario);

            //return new Response(var_dump($messaggi));
            return $this->render("allenatore/FormChatAllenatore2.html.twig", array("messaggi" => $messaggi, "destinatario" => $calciatoreDestinatario));
        } catch (\Exception $e) {
            return $this->render("allenatore/FormChatAllenatore2.html.twig", array("messaggi" => array(), "destinatario" => $calciatoreDestinatario));


        }
    }

    /**
     * @Route("/comunicazione/allenatore/ottieniMessaggioVoceView/{contratto_allenatore}")
     * @Method("GET")
     */
    public function ottieniMessaggioVoceView($contratto_allenatore)
    {
        $g = new GestoreComunicazione();
        try {
            $messaggi = $g->ottieniMessaggiAllenatore($contratto_allenatore, "voce");
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
            $messaggi = $g->ottieniMessaggioComportamento($allenatoreMittente, "multa", $calciatoreDestinatario, $testomulta);
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
            $messaggi = $g->ottieniMessaggioComportamento($allenatoreMittente, "avvertimento", $calciatoreDestinatario, $testomulta);
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
            $messaggi = $g->ottieniMessaggioComportamento($allenatoreMittente, "dieta", $calciatoreDestinatario, $testorichiamo);
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
            $messaggi = $g->ottieniMessaggioComportamento($allenatoreMittente, "allenamento", $calciatoreDestinatario, $testorichiamo);
            $str = "";

            return $this->render("allenatore/FormRichiamoSalute.html.twig", array("messaggi" => $messaggi, "d" => $calciatoreDestinatario));
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
    }


}