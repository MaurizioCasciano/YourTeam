<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 21/12/2016
 * Time: 13:01
 */

namespace AppBundle\Controller\it\unisa\statistiche;


use AppBundle\it\unisa\autenticazione\GestoreAutenticazione;
use AppBundle\it\unisa\partite\GestorePartite;
use AppBundle\it\unisa\statistiche\GestoreStatisticheCalciatore;
use AppBundle\it\unisa\statistiche\StatisticheCalciatore;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ControllerStatisticheCalciatoreStaff extends ControllerStatisticheCalciatoreUtenteRegistrato
{
    /**
     * Restituisce il form per inserire le statistiche di un calciatore relativamente ad una partita.
     * @Route("/statistiche/staff/calciatore/insert/form/{calciatore}/{nome_partita}/{data_partita}", name = "form_inserisci_statistiche_calciatore")
     * @Method("GET")
     * @param $calciatore L'username del calciatore.
     * @param $nome_partita Il nome della partita.
     * @param $data_partita La data e l'ora della partita.
     */
    public function getInserisciStatisticheForm(Request $request, $calciatore, $nome_partita, $data_partita)
    {
        //var_dump($request->get("_route"));
        if (isset($_SESSION) && isset($_SESSION["squadra"]) && isset($_SESSION["tipo"])) {
            $autenticazione = GestoreAutenticazione::getInstance();
            if ($autenticazione->check($request->get("_route"))) {
                $request->getSession()->set("calciatore", $calciatore);
                $request->getSession()->set("nome_partita", $nome_partita);
                $request->getSession()->set("data_partita", $data_partita);

                return $this->render("staff/FormInserisciStatisticheCalciatore.html.twig");

            } else {
                return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "Azione non consentita."));
            }
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "Effettuare il login."));
        }
    }

    /**
     * Inserisce le statistiche di un calciatore relativamente ad una partita nel DataBase.
     * @Route("/statistiche/staff/calciatore/insert/submit", name="InserisciStatisticheCalciatore");
     * @Method("POST")
     * @param $request La richiesta contenente la sessione con gli attributi "calciatore", "nome_partita", "data_partita".
     * @return Response
     */
    public
    function inserisciStatistiche(Request $request)
    {
        //var_dump($request->get("_route"));
        if (isset($_SESSION) && isset($_SESSION["squadra"]) && isset($_SESSION["tipo"])) {
            $autenticazione = GestoreAutenticazione::getInstance();
            if ($autenticazione->check($request->get("_route"))) {
                //inizio chiave statistiche_calciatore
                $calciatore = $request->get("calciatore");
                $nomePartita = $request->get("nome");
                $dataPartita = $request->get("data");
                //fine chiave statistiche calciatore

                //statistiche
                $tiriTotali = $request->get("tiri_totali");
                $tiriPorta = $request->get("tiri_porta");
                $falliFatti = $request->get("falli_fatti");
                $falliSubiti = $request->get("falli_subiti");
                $percentualePassaggiriusciti = $request->get("percentuale_passagii_riusciti");
                $golFatti = $request->get("gol_fatti");
                $golSubiti = $request->get("gol_subiti");
                $assist = $request->get("assist");
                $ammonizioni = $request->get("ammonizioni");
                $espulsioni = $request->get("espulsioni");

                //inserisco i dati nel DataBase
                $statisticheCalciatore = new StatisticheCalciatore($calciatore, $tiriTotali, $tiriPorta, $falliFatti, $falliSubiti, $percentualePassaggiriusciti, $golFatti, $golSubiti, $assist, $ammonizioni, $espulsioni, 0);
                $gestoreStatisticheCalciatore = GestoreStatisticheCalciatore::getInstance();
                $executed = $gestoreStatisticheCalciatore->inserisciStatistiche($statisticheCalciatore, $nomePartita, $dataPartita, $_SESSION["squadra"]);

                return new JsonResponse(array("executed" => $executed));
            } else {
                return new JsonResponse(array("executed" => false));
            }
        } else {
            return new JsonResponse(array("executed" => false));
        }
    }

    /**
     * Restituisce il form per modificare le statistiche di un calciatore relativamente ad una partita.
     * @param $calciatore L'ID del calciatore.
     * @Route("/statistiche/staff/calciatore/edit/form/{calciatore}/{nome_partita}/{data_partita}", name = "form_modifica_statistiche_calciatore")
     * @Method("GET")
     */
    public
    function getModificaStatisticheForm(Request $request, $calciatore, $nome_partita, $data_partita)
    {
        //var_dump($request->get("_route"));
        if (isset($_SESSION) && isset($_SESSION["squadra"]) && isset($_SESSION["tipo"])) {
            $autenticazione = GestoreAutenticazione::getInstance();
            if ($autenticazione->check($request->get("_route"))) {
                $request->getSession()->set("calciatore", $calciatore);
                $request->getSession()->set("nome_partita", $nome_partita);
                $request->getSession()->set("data_partita", $data_partita);
                $squadra = $_SESSION["squadra"];

                $gestoreStatisticheCalciatore = GestoreStatisticheCalciatore::getInstance();
                $statisticheCalciatore = $gestoreStatisticheCalciatore->getStatisticheCalciatore($calciatore, $nome_partita, $data_partita, $squadra);
                return $this->render(":staff:FormModificaStatisticheCalciatore.html.twig", array("statistiche_calciatore" => $statisticheCalciatore));
            } else {
                return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "Azione non consentita."));
            }
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "Effettuare il login."));
        }
    }

    /**
     * @param Request $request
     * @Route("/statistiche/staff/calciatore/edit/submit", name="ModificheStatisticheCalciatore", name = "modificaStatisticheCalciatore")
     * @Method("POST")
     */
    public
    function modificaStatistiche(Request $request)
    {
        if (isset($_SESSION) && isset($_SESSION["squadra"]) && isset($_SESSION["tipo"])) {
            $autenticazione = GestoreAutenticazione::getInstance();
            if ($autenticazione->check($request->get("_route"))) {
                //inizio chiave statistiche_calciatore
                $calciatore = $request->get("calciatore");
                $nomePartita = $request->get("nome_partita");
                $dataPartita = $request->get("data_partita");
                $squadra = $_SESSION["squadra"];
                //fine chiave statistiche calciatore

                //statistiche
                $tiriTotali = $request->get("tiri_totali");
                $tiriPorta = $request->get("tiri_porta");
                $falliFatti = $request->get("falli_fatti");
                $falliSubiti = $request->get("falli_subiti");
                $percentualePassaggiriusciti = $request->get("percentuale_passagii_riusciti");
                $golFatti = $request->get("gol_fatti");
                $golSubiti = $request->get("gol_subiti");
                $assist = $request->get("assist");
                $ammonizioni = $request->get("ammonizioni");
                $espulsioni = $request->get("espulsioni");


                //inserisco i dati nel DataBase
                $statisticheCalciatore = new StatisticheCalciatore($calciatore, $tiriTotali, $tiriPorta, $falliFatti, $falliSubiti, $percentualePassaggiriusciti, $golFatti, $golSubiti, $assist, $ammonizioni, $espulsioni, 0);
                $gestoreStatisticheCalciatore = GestoreStatisticheCalciatore::getInstance();
                $executed = $gestoreStatisticheCalciatore->modificaStatistiche($statisticheCalciatore, $nomePartita, $dataPartita, $squadra);

                //return new Response(($executed ? "Modifiche effettuate" : "Modifiche non effettuate") . "Modifica statistiche calciatore: " . $calciatore . " partita: " . $nomePartita . " " . $dataPartita);
                return new JsonResponse(array("executed" => $executed, "statistiche" => $statisticheCalciatore));
            } else {
                return new JsonResponse(array("executed" => false, "statistiche" => null));
            }
        } else {
            return new JsonResponse(array("executed" => false, "statistiche" => null));
        }
    }

    /**
     * @Route("/statistiche/staff/calciatore/{nome}/{data}", name = "lista_statistiche_calciatori_partita")
     */
    public
    function getListaStatisticheCalciatoriPartitaView(Request $request, $nome, $data)
    {
        if (isset($_SESSION) && isset($_SESSION["squadra"]) && isset($_SESSION["tipo"])) {
            $autenticazione = GestoreAutenticazione::getInstance();
            if ($autenticazione->check($request->get("_route"))) {
                $squadra = $_SESSION["squadra"];

                $gestorePartite = GestorePartite::getInstance();
                $partita = $gestorePartite->getPartita($nome, $data, $squadra);
                $calciatori = $gestorePartite->getCalciatoriConvocati($partita);

                return $this->render(":staff:ViewListaStatisticheCalciatoriPartita.html.twig", array("partita" => $partita, "calciatori" => $calciatori));
            } else {
                return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "Azione non consentita."));
            }
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "Effettuare il login."));
        }
    }
}