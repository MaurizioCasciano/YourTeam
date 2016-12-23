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
     * @Route("/comunicazione/allenatore/inviaMessaggioChat")
     * @Method("POST")
     * @param $richiesta
     */

    public function inviaMessaggioChat(Request $richiesta)
    {
        $g = new GestoreComunicazione();
        try {
            $testo = $richiesta->request->get("testo");
            $g->inviaMessaggio(new Messaggio($testo, $_SESSION["username"],
                $richiesta->get("d"),
                "allenatore", time(), "chat"));
            return new Response("Messaggio inviato correttamente");
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
            $testo = "Sei stato multato per comportamenti scorretti. Per chiarimenti mi trovi nel mio ufficio.";
            $g->inviaMessaggio(new Messaggio($testo,
                $richiesta->request->get("allenatore"),
                $richiesta->request->get("calciatore"), "allenatore", time(), "multa"));
            return new Response("messaggio inviato correttamente");
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
            $testo = "Volevo avvisarti che il tuo comportamento, se non modificato, potrà avere delle conseguenze";
            $g->inviaMessaggio(new Messaggio($testo,
                $richiesta->request->get("allenatore"),
                $richiesta->request->get("calciatore"), "allenatore", time(), "avvertimento"));
            return new Response("messaggio inviato correttamente");
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
            $testo = "Ti consiglio di migliorare e fare attenzione alla tua dieta.";
            $g->inviaMessaggio(new Messaggio($testo,
                $richiesta->request->get("allenatore"),
                $richiesta->request->get("calciatore"), "allenatore", time(), "dieta"));
            return new Response("messaggio inviato correttamente");
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
            $testo = "Ti consiglio di migliorare il tuo regime di allenamento.";
            $g->inviaMessaggio(new Messaggio($testo,
                $richiesta->request->get("allenatore"),
                $richiesta->request->get("calciatore"), "allenatore", time(), "allenamento"));
            return new Response("messaggio inviato correttamente");
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
     * @Route("/comunicazione/allenatore/ottieniMessaggioChatView")
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

            /*$str = "";
            foreach ($messaggi as $m) {
                $str = $str . $m;
                $str = $str . "</br >";
            }*/


            // return new Response(var_dump($messaggi));
            return $this->render("allenatore/FormChatAllenatore.html.twig", array("messaggi" => $messaggi, "d" => $calciatoreDestinatario));
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
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
     * @Route("/comunicazione/allenatore/ottieniRichiamoMultaView/{contratto_allenatore}")
     * @Method("GET")
     */
    public function ottieniRichiamoMultaView($contratto_allenatore)
    {
        $g = new GestoreComunicazione();
        try {
            $messaggi = $g->ottieniMessaggiAllenatore($contratto_allenatore, "multa");
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
     * @Route("/comunicazione/allenatore/ottieniRichiamoAvvertimentoView/{contratto_allenatore}")
     * @Method("GET")
     */
    public function ottieniRichiamoAvvertimentoView($contratto_allenatore)
    {
        $g = new GestoreComunicazione();
        try {
            $messaggi = $g->ottieniMessaggiAllenatore($contratto_allenatore, "avvertimento");
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
     * @Route("/comunicazione/allenatore/ottieniRichiamoDietaView/{contratto_allenatore}")
     * @Method("GET")
     */
    public function ottieniRichiamoDietaView($contratto_allenatore)
    {
        $g = new GestoreComunicazione();
        try {
            $messaggi = $g->ottieniMessaggiAllenatore($contratto_allenatore, "dieta");
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
     * @Route("/comunicazione/allenatore/ottieniRichiamoAllenamentoView/{contratto_allenatore}")
     * @Method("GET")
     */
    public function ottieniRichiamoAllenamentoView($contratto_allenatore)
    {
        $g = new GestoreComunicazione();
        try {
            $messaggi = $g->ottieniMessaggiAllenatore($contratto_allenatore, "allenamento");
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