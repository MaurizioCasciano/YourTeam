<?php
/**
 * Created by PhpStorm.
 * User: Donato
 * Date: 14/12/2016
 * Time: 16:37
 */

namespace AppBundle\Controller\it\unisa\comunicazione;

use AppBundle\it\unisa\account\GestoreAccount;
use AppBundle\it\unisa\autenticazione\GestoreAutenticazione;
use AppBundle\it\unisa\comunicazione\GestoreComunicazione;
use AppBundle\it\unisa\comunicazione\Messaggio;
use AppBundle\Utility\DB;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;

class ControllerChatAllenatore extends Controller
{

    /**
     * @Route("/comunicazione/allenatore/inviaMessaggioChat", name="allenatoreInviaMessaggioChat")
     * @Method("POST")
     * @param $richiesta
     * @return JsonResponse
     */
    public function inviaMessaggioChat(Request $richiesta)
    {
        $g = GestoreComunicazione::getInstance();
        $autenticazione = GestoreAutenticazione::getInstance();
        if ($autenticazione->check($richiesta->get("_route"))) {
            $messaggio = null;

            try {
                $testo = $richiesta->request->get("testo");
                $gestoreAccount = GestoreAccount::getInstance();
                $usernameAllenatore = $_SESSION["username"];
                $accountAllenatore = $gestoreAccount->ricercaAccount_A_T_S($usernameAllenatore);
                $usernameCalciatore = $richiesta->get("destinatario");
                $accountCalciatore = $gestoreAccount->ricercaAccount_G($usernameCalciatore);

                $now = new \DateTime();

                $messaggio = new Messaggio($testo, $usernameAllenatore, $usernameCalciatore, "allenatore", $now, "chat");
                $messaggio->setNomeMittente($accountAllenatore->getNome());
                $messaggio->setCognomeMittente($accountAllenatore->getCognome());
                $messaggio->setNomeDestinatario($accountCalciatore->getNome());
                $messaggio->setCognomeDestinatario($accountCalciatore->getCognome());

                $g->inviaMessaggio($messaggio);
                return new JsonResponse(array("messaggio" => $messaggio, "ok" => true));
            } catch (\Exception $e) {
                return new JsonResponse(array("messaggio" => $messaggio, "error" => $e->getMessage(), "ok" => false));
            }
        } else {
            return new JsonResponse(array("error" => "ACCOUNT NON ABILITATO A QUESTA AZIONE", "ok" => false));
        }
    }

    /**
     * @Route("/comunicazione/allenatore/inviaMessaggioVoce", name="inviaMessaggioVoce")
     * @Method("POST")
     * @param $richiesta
     */
    public function inviaMessaggioVoce(Request $richiesta)
    {
        $g = GestoreComunicazione::getInstance();
        $autenticazione = GestoreAutenticazione::getInstance();
        if ($autenticazione->check($richiesta->get("_route"))) {
            try {
                $ora = $richiesta->request->get("ora");
                $luogo = $richiesta->request->get("luogo");
                $data = $richiesta->request->get("data");
                $messaggio = new Messaggio("ora:" . $ora . " luogo:" . $luogo . " data:" . $data,
                    $_SESSION["username"],
                    $richiesta->get("d"), "allenatore", new \DateTime(), "voce");

                $g->inviaMessaggio($messaggio);
                return $this->render(":allenatore:MessaggioSuccesso.html.twig");
            } catch (\Exception $e) {
                return new Response($e->getMessage(), 404);
            }
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "ACCOUNT NON ABILITATO A QUESTA AZIONE"));
        }
    }

    /**
     * @Route("/comunicazione/allenatore/inviaRichiamoMulta", name="inviaMulta")
     * @Method("POST")
     * @param $richiesta
     */
    public function inviaRichiamoMulta(Request $richiesta)
    {
        $g = GestoreComunicazione::getInstance();
        $autenticazione = GestoreAutenticazione::getInstance();
        if ($autenticazione->check($richiesta->get("_route"))) {
            try {
                $testo = $richiesta->request->get("multa");
                $g->inviaMessaggio(new Messaggio($testo, $_SESSION["username"],
                    $richiesta->get("d"),
                    "allenatore", new \DateTime(), "multa"));
                return $this->render(":allenatore:MessaggioSuccesso.html.twig");
            } catch (\Exception $e) {
                return new Response($e->getMessage(), 404);
            }
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "ACCOUNT NON ABILITATO A QUESTA AZIONE"));
        }
    }

    /**
     * @Route("/comunicazione/allenatore/inviaRichiamoAvvertimento", name="inviaAvvertimento")
     * @Method("POST")
     * @param $richiesta
     */
    public function inviaRichiamoAvvertimento(Request $richiesta)
    {
        $g = GestoreComunicazione::getInstance();
        $autenticazione = GestoreAutenticazione::getInstance();
        if ($autenticazione->check($richiesta->get("_route"))) {
            try {
                $testo = $richiesta->request->get("avvertimento");
                $g->inviaMessaggio(new Messaggio($testo, $_SESSION["username"],
                    $richiesta->get("d"),
                    "allenatore", new \DateTime(), "avvertimento"));
                return $this->render(":allenatore:MessaggioSuccesso.html.twig");
            } catch (\Exception $e) {
                return new Response($e->getMessage(), 404);
            }
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "ACCOUNT NON ABILITATO A QUESTA AZIONE"));
        }
    }

    /**
     * @Route("/comunicazione/allenatore/inviaRichiamoDieta", name="inviaDieta")
     * @Method("POST")
     * @param $richiesta
     */
    public function inviaRichiamoDieta(Request $richiesta)
    {
        $g = GestoreComunicazione::getInstance();
        $autenticazione = GestoreAutenticazione::getInstance();
        if ($autenticazione->check($richiesta->get("_route"))) {
            try {
                $testo = $richiesta->request->get("dieta");
                $g->inviaMessaggio(new Messaggio($testo, $_SESSION["username"],
                    $richiesta->get("d"),
                    "allenatore", new \DateTime(), "dieta"));
                return $this->render(":allenatore:MessaggioSuccesso.html.twig");
            } catch (\Exception $e) {
                return new Response($e->getMessage(), 404);
            }
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "ACCOUNT NON ABILITATO A QUESTA AZIONE"));
        }
    }

    /**
     * @Route("/comunicazione/allenatore/inviaRichiamoAllenamento", name="inviaAllenamento")
     * @Method("POST")
     * @param $richiesta
     */
    public function inviaRichiamoAllenamento(Request $richiesta)
    {
        $g = GestoreComunicazione::getInstance();
        $autenticazione = GestoreAutenticazione::getInstance();
        if ($autenticazione->check($richiesta->get("_route"))) {
            try {
                $testo = $richiesta->request->get("allenamento");
                $g->inviaMessaggio(new Messaggio($testo, $_SESSION["username"],
                    $richiesta->get("d"),
                    "allenatore", new \DateTime(), "allenamento"));
                return $this->render(":allenatore:MessaggioSuccesso.html.twig");
            } catch (\Exception $e) {
                return new Response($e->getMessage(), 404);
            }
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "ACCOUNT NON ABILITATO A QUESTA AZIONE"));
        }
    }

    /**
     * @Route("/comunicazione/allenatore/sceglicalciatore", name="sceglichat")
     * @Method("GET")
     */
    public function scegliCalciatore(Request $request)
    {
        $g = GestoreComunicazione::getInstance();
        $autenticazione = GestoreAutenticazione::getInstance();
        if ($autenticazione->check($request->get("_route"))) {
            if (!isset($_SESSION["squadra"])) {
                throw new \RuntimeException("Squadra is null");
            }
            $calciatori = $g->getCalciatoriPerSquadra($_SESSION["squadra"]);

            return $this->render(":allenatore:FormScegliCalciatore.html.twig", array("calciatori" => $calciatori));
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "ACCOUNT NON ABILITATO A QUESTA AZIONE"));
        }

    }

    /**
     * @Route("/comunicazione/allenatore/sceglicalciatorevoce", name="sceglivoce")
     * @Method("GET")
     */
    public function scegliCalciatoreVoce(Request $request)
    {
        $g = GestoreComunicazione::getInstance();
        $autenticazione = GestoreAutenticazione::getInstance();
        if ($autenticazione->check($request->get("_route"))) {
            if (!isset($_SESSION["squadra"])) {
                throw new \RuntimeException("Squadra is null");
            }
            $calciatori = $g->getCalciatoriPerSquadra($_SESSION["squadra"]);

            return $this->render(":allenatore:FormScegliCalciatoreVoce.html.twig", array("calciatori" => $calciatori));
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "ACCOUNT NON ABILITATO A QUESTA AZIONE"));
        }
    }

    /**
     * @Route("/comunicazione/allenatore/sceglicalciatorecomportamento", name="sceglicomportamento")
     * @Method("GET")
     */
    public function scegliCalciatoreComportamento(Request $request)
    {
        $g = GestoreComunicazione::getInstance();
        $autenticazione = GestoreAutenticazione::getInstance();
        if ($autenticazione->check($request->get("_route"))) {
            if (!isset($_SESSION["squadra"])) {
                throw new \RuntimeException("Squadra is null");
            }
            $calciatori = $g->getCalciatoriPerSquadra($_SESSION["squadra"]);
            $messaggi = $g->ottieniMessaggiRichiamoMulta($calciatori);
            $messaggi2 = $g->ottieniMessaggioRichiamoAvvertimento($calciatori);

            return $this->render(":allenatore:FormScegliCalciatoreComportamento.html.twig", array("calciatori" => $calciatori, "messaggi" => $messaggi, "messaggi2" => $messaggi2));
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "ACCOUNT NON ABILITATO A QUESTA AZIONE"));
        }
    }

    /**
     * @Route("/comunicazione/allenatore/sceglicalciatoresalute", name="sceglisalute")
     * @Method("GET")
     */
    public function scegliCalciatoreSalute(Request $request)
    {
        $g = GestoreComunicazione::getInstance();
        $autenticazione = GestoreAutenticazione::getInstance();
        if ($autenticazione->check($request->get("_route"))) {
            if (!isset($_SESSION["squadra"])) {
                throw new \RuntimeException("Squadra is null");
            }
            $calciatori = $g->getCalciatoriPerSquadra($_SESSION["squadra"]);
            $messaggi = $g->ottieniMessaggioRichiamoDieta($calciatori);
            $messaggi2 = $g->ottieniMessaggioRichiamoAllenamento($calciatori);

            return $this->render(":allenatore:FormScegliCalciatoreSalute.html.twig", array("calciatori" => $calciatori, "messaggi" => $messaggi, "messaggi2" => $messaggi2));
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "ACCOUNT NON ABILITATO A QUESTA AZIONE"));
        }
    }

    /**
     * @Route("/comunicazione/allenatore/ottieniMessaggioChatView", name="allenatore_chat_view")
     * @Method("POST")
     */
    public function ottieniMessaggioChatView(Request $request)
    {
        $autenticazione = GestoreAutenticazione::getInstance();
        if ($autenticazione->check($request->get("_route"))) {
            if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "allenatore") {
                throw new \Exception("Allenatore non loggato");
            }

            $g = GestoreAccount::getInstance();
            $allenatoreMittente = $g->ricercaAccount_A_T_S($_SESSION["username"]);
            //var_dump($allenatoreMittente);

            $calciatoreDestinatario = $request->get("calciatore_destinatario");
            //var_dump($calciatoreDestinatario);

            $g = GestoreComunicazione::getInstance();
            try {
                $messaggi = $g->ottieniMessaggiAllenatore($allenatoreMittente->getUsernameCodiceContratto(),
                    "chat", $calciatoreDestinatario);

                return $this->render("allenatore/FormChatAllenatore.html.twig", array("messaggi" => $messaggi, "destinatario" => $calciatoreDestinatario, "allenatore" => $allenatoreMittente));
            } catch (\Exception $e) {
                //var_dump($e);
                return $this->render("allenatore/FormChatAllenatore.html.twig", array("messaggi" => array(), "destinatario" => $calciatoreDestinatario, "allenatore" => $allenatoreMittente));
            }
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "ACCOUNT NON ABILITATO A QUESTA AZIONE"));
        }
    }

    /**
     * @Route("/comunicazione/allenatore/ottieniMessaggioVoceView", name="ottienivoceview")
     * @Method("POST")
     */
    public function ottieniMessaggioVoceView(Request $request)
    {
        $autenticazione = GestoreAutenticazione::getInstance();
        if ($autenticazione->check($request->get("_route"))) {
            if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "allenatore") {
                throw new \Exception("Allenatore non loggato");
            }
            $allenatoreMittente = $_SESSION["username"];
            $calciatoreDestinatario = $request->get("calciatore_destinatario");
            $g = GestoreComunicazione::getInstance();
            try {
                $messaggi = $g->ottieniMessaggi($allenatoreMittente, "chat", $calciatoreDestinatario);

                return $this->render("allenatore/FormVoceAllenatore.html.twig", array("messaggi" => $messaggi, "d" => $calciatoreDestinatario));
            } catch (\Exception $e) {
                return $this->render("allenatore/FormVoceAllenatore.html.twig", array("messaggi" => array(), "d" => $calciatoreDestinatario));
            }
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "ACCOUNT NON ABILITATO A QUESTA AZIONE"));
        }
    }

    /**
     * @Route("/comunicazione/allenatore/ottieniRichiamoMultaView", name="ottienimultaview")
     * @Method("POST")
     */
    public function ottieniRichiamoMultaView(Request $request)
    {
        $autenticazione = GestoreAutenticazione::getInstance();
        if ($autenticazione->check($request->get("_route"))) {
            if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "allenatore") {
                throw new \Exception("Allenatore non loggato");
            }

            $allenatoreMittente = $_SESSION["username"];
            $calciatoreDestinatario = $request->get("calciatore_destinatario");
            $testomulta = $request->get("multa");
            $testomulta2 = $request->get("avvertimento");
            $g = GestoreComunicazione::getInstance();

            try {
                $messaggi = $g->ottieniMessaggioComportamento($allenatoreMittente, $calciatoreDestinatario, $testomulta);
                $messaggi2 = $g->ottieniMessaggioComportamento($allenatoreMittente, $calciatoreDestinatario, $testomulta2);
                $str = "";

                return $this->render("allenatore/FormRichiamoComportamento.html.twig", array("messaggi" => $messaggi, "messaggi2" => $messaggi2, "d" => $calciatoreDestinatario));
            } catch (\Exception $e) {
                return new Response($e->getMessage(), 404);
            }
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "ACCOUNT NON ABILITATO A QUESTA AZIONE"));
        }
    }

    /**
     * @Route("/comunicazione/allenatore/ottieniRichiamoAvvertimentoView", name="ottieniavvertimentoview")
     * @Method("POST")
     */
    public function ottieniRichiamoAvvertimentoView(Request $request)
    {
        $autenticazione = GestoreAutenticazione::getInstance();
        if ($autenticazione->check($request->get("_route"))) {
            if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "allenatore") {
                throw new \Exception("Allenatore non loggato");
            }
            $allenatoreMittente = $_SESSION["username"];
            $calciatoreDestinatario = $request->get("calciatore_destinatario");
            $testomulta = $request->get("avvertimento");
            $g = GestoreComunicazione::getInstance();
            try {
                $messaggi = $g->ottieniMessaggioComportamento($allenatoreMittente, $calciatoreDestinatario, $testomulta);
                $str = "";

                return $this->render("allenatore/FormRichiamoComportamento.html.twig", array("messaggi" => $messaggi, "d" => $calciatoreDestinatario));
            } catch (\Exception $e) {
                return new Response($e->getMessage(), 404);
            }
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "ACCOUNT NON ABILITATO A QUESTA AZIONE"));
        }
    }

    /**
     * @Route("/comunicazione/allenatore/ottieniRichiamoDietaView", name="ottienidietaview")
     * @Method("POST")
     */
    public function ottieniRichiamoDieta(Request $request)
    {
        $autenticazione = GestoreAutenticazione::getInstance();
        if ($autenticazione->check($request->get("_route"))) {
            if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "allenatore") {
                throw new \Exception("Allenatore non loggato");
            }
            $allenatoreMittente = $_SESSION["username"];
            $calciatoreDestinatario = $request->get("calciatore_destinatario");
            $testorichiamo = $request->get("dieta");
            $testorichiamo2 = $request->get("allenamento");
            $g = GestoreComunicazione::getInstance();
            try {
                $messaggi = $g->ottieniMessaggioSalute($allenatoreMittente, $calciatoreDestinatario, $testorichiamo);
                $messaggi2 = $g->ottieniMessaggioSalute($allenatoreMittente, $calciatoreDestinatario, $testorichiamo2);
                $str = "";

                return $this->render("allenatore/FormRichiamoSalute.html.twig", array("messaggi" => $messaggi, "messaggi2" => $messaggi2, "d" => $calciatoreDestinatario));
            } catch (\Exception $e) {
                return new Response($e->getMessage(), 404);
            }
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "ACCOUNT NON ABILITATO A QUESTA AZIONE"));
        }
    }

    /**
     * @Route("/comunicazione/allenatore/ottieniRichiamoAllenamentoView", name="ottieniallenamentoview")
     * @Method("POST")
     */
    public function ottieniRichiamoAllenamentoView(Request $request)
    {
        $autenticazione = GestoreAutenticazione::getInstance();
        if ($autenticazione->check($request->get("_route"))) {
            if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "allenatore") {
                throw new \Exception("Allenatore non loggato");
            }
            $allenatoreMittente = $_SESSION["username"];
            $calciatoreDestinatario = $request->get("calciatore_destinatario");
            $testorichiamo = $request->get("allenamento");
            $g = GestoreComunicazione::getInstance();
            try {
                $messaggi = $g->ottieniMessaggioSalute($allenatoreMittente, $calciatoreDestinatario, $testorichiamo);
                $str = "";

                return $this->render("allenatore/FormRichiamoSalute.html.twig", array("messaggi" => $messaggi, "d" => $calciatoreDestinatario));
            } catch (\Exception $e) {
                return new Response($e->getMessage(), 404);
            }
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "ACCOUNT NON ABILITATO A QUESTA AZIONE"));
        }
    }

    /**
     * @Route("comunicazione/allenatore/chat/new", name = "nuoviMessaggiAllenatore")
     * @Method("POST")
     */
    public function getNuoviMessaggiChat(Request $request)
    {
        $allenatore = $_SESSION["username"];
        $calciatore = $request->get("destinatario");
        $data = $request->get("data");

        $g = GestoreComunicazione::getInstance();
        $messaggi = $g->getNuoviMessaggi($allenatore, $calciatore, "chat", $data);
        return new JsonResponse(array("messaggi" => $messaggi));
    }
}