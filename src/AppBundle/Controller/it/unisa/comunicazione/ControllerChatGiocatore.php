<?php

namespace AppBundle\Controller\it\unisa\comunicazione;

use AppBundle\it\unisa\account\GestoreAccount;
use AppBundle\it\unisa\autenticazione\GestoreAutenticazione;
use AppBundle\it\unisa\comunicazione\GestoreComunicazione;
use AppBundle\it\unisa\comunicazione\Messaggio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $g = GestoreComunicazione::getInstance();
        $autenticazione = GestoreAutenticazione::getInstance();
        if ($autenticazione->check($richiesta->get("_route"))) {
            $messaggio = null;

            try {
                $testo = $richiesta->request->get("testo");
                $gestoreAccount = GestoreAccount::getInstance();
                $usernameCalciatore = $_SESSION["username"];
                $accountCalciatore = $gestoreAccount->ricercaAccount_G($usernameCalciatore);
                $usernameAllenatore = $richiesta->get("destinatario");
                $accountAllenatore = $gestoreAccount->ricercaAccount_A_T_S($usernameAllenatore);

                $now = new \DateTime();

                $messaggio = new Messaggio($testo, $usernameAllenatore, $usernameCalciatore, "calciatore", $now, "chat");
                $messaggio->setNomeMittente($accountCalciatore->getNome());
                $messaggio->setCognomeMittente($accountCalciatore->getCognome());
                $messaggio->setNomeDestinatario($accountAllenatore->getNome());
                $messaggio->setCognomeDestinatario($accountAllenatore->getCognome());

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
     * @Route("/comunicazione/giocatore/inviaMessaggioVoce", name="inviamessaggiovoce")
     * @Method("POST")
     */
    public function inviaMessaggioVoce(Request $richiesta)
    {
        $g = GestoreComunicazione::getInstance();
        $autenticazione = GestoreAutenticazione::getInstance();
        if ($autenticazione->check($richiesta->get("_route"))) {
            try {
                $allenatore = $richiesta->get("d");
                $calciatore = $_SESSION["username"];
                $mittente = "calciatore";
                $ora = $richiesta->request->get("ora");
                $luogo = $richiesta->request->get("luogo");
                $data = $richiesta->request->get("data");
                $dateTime = new \DateTime($data . " " . $ora);
                $testo = $ora . " " . $luogo . " " . $data;
                $tipo = "voce";

                $messaggio = new Messaggio($testo, $allenatore, $calciatore, $mittente, $dateTime, $tipo);
                $g->inviaMessaggio($messaggio);

                return $this->render(":giocatore:MessaggioSuccesso.html.twig");
            } catch (\Exception $e) {
                return new Response($e->getMessage(), 404);
            }
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "ACCOUNT NON ABILITATO A QUESTA AZIONE"));
        }
    }

    /**
     * @Route("/comunicazione/giocatore/ottieniMessaggioChatView", name="ottieniMessaggioChatView")
     * @Method("GET")
     */
    public function ottieniMessaggioChatView(Request $request)
    {
        $autenticazione = GestoreAutenticazione::getInstance();
        if ($autenticazione->check($request->get("_route"))) {
            if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "calciatore") {
                throw new \Exception("Calciatore non loggato");
            }

            $gestoreComunicazione = GestoreComunicazione::getInstance();

            $g = GestoreAccount::getInstance();
            // = $g->ricercaAccount_G($_SESSION["username"]);
            $calciatoreMittente = $_SESSION["username"];
            $squadra = $_SESSION["squadra"];
            $allenatoreDestinatario = $gestoreComunicazione->getAllenatorePerSquadra($squadra);

            //XDebug
            //var_dump($allenatoreDestinatario); //OK

            $g = GestoreComunicazione::getInstance();
            try {
                $messaggi = $g->ottieniMessaggiCalciatore($calciatoreMittente,
                    "chat");

                //var_dump($messaggi);

                return $this->render("giocatore/FormChatCalciatore.html.twig",
                    array("messaggi" => $messaggi,
                        "destinatario" => $allenatoreDestinatario->getUsernameCodiceContratto()));
                // "calciatore" => $calciatoreMittente));
            } catch (\Exception $e) {
                return new Response($e->getMessage());
            }
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "ACCOUNT NON ABILITATO A QUESTA AZIONE"));
        }
    }

    /**
     * @Route("/comunicazione/giocatore/ottieniMessaggioVoceView", name="ottieniMessaggioVoceView")
     * @Method("GET")
     */
    public function ottieniMessaggioVoceView(Request $request)
    {
        $autenticazione = GestoreAutenticazione::getInstance();
        if ($autenticazione->check($request->get("_route"))) {
            if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "calciatore") {
                throw new \Exception("Calciatore non loggato");
            }
            $g = GestoreComunicazione::getInstance();

            $calciatoreMittente = $_SESSION["username"];
            $squadra = $_SESSION["squadra"];
            $allenatoreDestinatario = $g->getAllenatorePerSquadra($squadra);
            try {
                $messaggi = $g->getCalciatoriPerSquadra($squadra);

                return $this->render("giocatore/FormVoceCalciatore.html.twig",
                    array("messaggi" => $messaggi, "d" => $allenatoreDestinatario->getUsernameCodiceContratto()));
            } catch (\Exception $e) {
                return new Response($e->getMessage(), 404);
            }
            /*$g = new GestoreComunicazione();
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
            }*/
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "ACCOUNT NON ABILITATO A QUESTA AZIONE"));
        }
    }

    /**
     * @Route("/comunicazione/giocatore/ottieniVistaRichiamoMulta", name="ottieniMulta")
     * @Method("GET")
     */
    public function ottieniVistaRichiamoMulta(Request $request)
    {
        $autenticazione = GestoreAutenticazione::getInstance();
        if ($autenticazione->check($request->get("_route"))) {
            if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "calciatore") {
                throw new \Exception("Calciatore non loggato");
            }
            $gestoreComunicazione = GestoreComunicazione::getInstance();

            $calciatoreMittente = $_SESSION["username"];
            $squadra = $_SESSION["squadra"];
            $allenatoreDestinatario = $gestoreComunicazione->getAllenatorePerSquadra($squadra);
            try {
                $messaggi = $gestoreComunicazione->ottieniMessaggiMulta($allenatoreDestinatario);
                if (!$messaggi) {
                    return $this->render("giocatore/NonCiSonoMessaggi.html.twig");
                }
                return $this->render("giocatore/VistaRichiamoMulta.html.twig", array("messaggi" => $messaggi));
            } catch (\Exception $e) {
                return new Response($e->getMessage(), 404);
            }
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "ACCOUNT NON ABILITATO A QUESTA AZIONE"));
        }
    }

    /**
     * @Route("/comunicazione/giocatore/ottieniVistaRichiamoAvvertimento", name="ottieniAvvertimento")
     * @Method("GET")
     */
    public function ottieniVistaRichiamoAvvertimento(Request $request)
    {
        $autenticazione = GestoreAutenticazione::getInstance();
        if ($autenticazione->check($request->get("_route"))) {
            if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "calciatore") {
                throw new \Exception("Calciatore non loggato");
            }
            $gestoreComunicazione = GestoreComunicazione::getInstance();

            $calciatoreMittente = $_SESSION["username"];
            $squadra = $_SESSION["squadra"];
            $allenatoreDestinatario = $gestoreComunicazione->getAllenatorePerSquadra($squadra);
            try {
                $messaggi = $gestoreComunicazione->ottieniMessaggioAvvertimento($allenatoreDestinatario);
                if (!$messaggi) {
                    return $this->render("giocatore/NonCiSonoMessaggi.html.twig");
                }
                return $this->render("giocatore/VistaRichiamoAvvertimento.html.twig", array("messaggi" => $messaggi));
            } catch (\Exception $e) {
                return new Response($e->getMessage(), 404);
            }
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "ACCOUNT NON ABILITATO A QUESTA AZIONE"));
        }
    }

    /**
     * @Route("/comunicazione/giocatore/ottieniVistaRichiamoDieta", name="ottieniDieta")
     * @Method("GET")
     */
    public function ottieniVistaRichiamoDieta(Request $request)
    {
        $autenticazione = GestoreAutenticazione::getInstance();
        if ($autenticazione->check($request->get("_route"))) {
            if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "calciatore") {
                throw new \Exception("Calciatore non loggato");
            }
            $gestoreComunicazione = GestoreComunicazione::getInstance();

            $calciatoreMittente = $_SESSION["username"];
            $squadra = $_SESSION["squadra"];
            $allenatoreDestinatario = $gestoreComunicazione->getAllenatorePerSquadra($squadra);
            try {
                $messaggi = $gestoreComunicazione->ottieniMessaggioDieta($allenatoreDestinatario);
                if (!$messaggi) {
                    return $this->render("giocatore/NonCiSonoMessaggi.html.twig");
                }
                return $this->render("giocatore/VistaRichiamoDieta.html.twig", array("messaggi" => $messaggi));
            } catch (\Exception $e) {
                return new Response($e->getMessage(), 404);
            }
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "ACCOUNT NON ABILITATO A QUESTA AZIONE"));
        }
    }

    /**
     * @Route("/comunicazione/giocatore/ottieniVistaRichiamoAllenamento", name="ottieniAllenamento")
     * @Method("GET")
     */
    public function ottieniVistaRichiamoAllenamento(Request $request)
    {
        $autenticazione = GestoreAutenticazione::getInstance();
        if ($autenticazione->check($request->get("_route"))) {
            if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] != "calciatore") {
                throw new \Exception("Calciatore non loggato");
            }
            $gestoreComunicazione = GestoreComunicazione::getInstance();

            $calciatoreMittente = $_SESSION["username"];
            $squadra = $_SESSION["squadra"];
            $allenatoreDestinatario = $gestoreComunicazione->getAllenatorePerSquadra($squadra);
            try {
                $messaggi = $gestoreComunicazione->ottieniMessaggioAllenamento($allenatoreDestinatario);
                if (!$messaggi) {
                    return $this->render("giocatore/NonCiSonoMessaggi.html.twig");
                }
                return $this->render("giocatore/VistaRichiamoAllenamento.html.twig", array("messaggi" => $messaggi));
            } catch (\Exception $e) {
                return new Response($e->getMessage(), 404);
            }
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "ACCOUNT NON ABILITATO A QUESTA AZIONE"));
        }
    }

    /**
     * @Route("comunicazione/giocatore/chat/new", name = "nuoviMessaggiCalciatore")
     * @Method("POST")
     */
    public function getNuoviMessaggiChat(Request $request)
    {
        $calciatore = $_SESSION["username"];
        $allenatore = $request->get("destinatario");
        $data = $request->get("data");

        $g = GestoreComunicazione::getInstance();
        $messaggi = $g->getNuoviMessaggi($allenatore, $calciatore, "chat", $data);
        return new JsonResponse(array("messaggi" => $messaggi));
    }
}