<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 21/12/2016
 * Time: 13:01
 */

namespace AppBundle\Controller\it\unisa\statistiche;


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
     * @Route("/statistiche/staff/calciatore/insert/form/{calciatore}/{nome_partita}/{data_partita}")
     * @Method("GET")
     * @param $calciatore L'username del calciatore.
     * @param $nome_partita Il nome della partita.
     * @param $data_partita La data e l'ora della partita.
     */
    public function getInserisciStatisticheForm(Request $request, $calciatore, $nome_partita, $data_partita)
    {
        $request->getSession()->set("calciatore", $calciatore);
        $request->getSession()->set("nome_partita", $nome_partita);
        $request->getSession()->set("data_partita", $data_partita);

        /*TO-DO
         * Controllare che il calciatore e la partita esistano.
         */

        if (!isset($_SESSION) || $_SESSION["tipo"] != "staff") {
            throw new AccessDeniedException("Access Denied!!!");
        } else {
            return $this->render("staff/FormInserisciStatisticheCalciatore.html.twig");
        }
    }

    /**
     * Inserisce le statistiche di un calciatore relativamente ad una partita nel DataBase.
     * @Route("/statistiche/staff/calciatore/insert/submit", name="InserisciStatisticheCalciatore");
     * @Method("POST")
     * @param $request La richiesta contenente la sessione con gli attributi "calciatore", "nome_partita", "data_partita".
     * @return Response
     */
    public function inserisciStatistiche(Request $request)
    {
        /*
         * Le informazioni riguardanti il calciatore è la partita vengono settate al momento della richiesta del form per l'inserimento delle statistiche.
         */
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
        $gestoreStatisticheCalciatore = new GestoreStatisticheCalciatore();
        $executed = $gestoreStatisticheCalciatore->inserisciStatistiche($statisticheCalciatore, $nomePartita, $dataPartita, $_SESSION["squadra"]);

        return new JsonResponse(array("executed" => $executed));
    }

    /**
     * Restituisce il form per modificare le statistiche di un calciatore relativamente ad una partita.
     * @param $calciatore L'ID del calciatore.
     * @Route("/statistiche/staff/calciatore/edit/form/{calciatore}/{nome_partita}/{data_partita}")
     * @Method("GET")
     */
    public function getModificaStatisticheForm(Request $request, $calciatore, $nome_partita, $data_partita)
    {
        if (!isset($_SESSION) || $_SESSION["tipo"] != "staff") {
            throw new AccessDeniedException("Access Denied!!!");
        } else {//E' un account STAFF
            $request->getSession()->set("calciatore", $calciatore);
            $request->getSession()->set("nome_partita", $nome_partita);
            $request->getSession()->set("data_partita", $data_partita);
            $squadra = $_SESSION["squadra"];

            $gestoreStatisticheCalciatore = new GestoreStatisticheCalciatore();
            $statisticheCalciatore = $gestoreStatisticheCalciatore->getStatisticheCalciatore($calciatore, $nome_partita, $data_partita, $squadra);
            return $this->render(":staff:FormModificaStatisticheCalciatore.html.twig", array("statistiche_calciatore" => $statisticheCalciatore));
        }
    }

    /**
     * @param Request $request
     * @Route("/statistiche/staff/calciatore/edit/submit", name="ModificheStatisticheCalciatore")
     * @Method("POST")
     */
    public function modificaStatistiche(Request $request)
    {
        /*
         * Le informazioni riguardanti il calciatore è la partita vengono settate al momento della richiesta del form per l'inserimento delle statistiche.
         */
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
        $gestoreStatisticheCalciatore = new GestoreStatisticheCalciatore();
        $executed = $gestoreStatisticheCalciatore->modificaStatistiche($statisticheCalciatore, $nomePartita, $dataPartita, $squadra);

        //return new Response(($executed ? "Modifiche effettuate" : "Modifiche non effettuate") . "Modifica statistiche calciatore: " . $calciatore . " partita: " . $nomePartita . " " . $dataPartita);
        return new JsonResponse(array("executed" => $executed, "statistiche" => $statisticheCalciatore));
    }

    /**
     * Restituisce la view con la lista delle statistiche dei calciatori della squadra dell'utente.
     * @Route("/statistiche/user/calciatore/all", name = "lista_statistiche_calciatori")
     * @Method("GET")
     */
    public function getStatisticheCalciatoriView()
    {
        $squadra = $_SESSION["squadra"];

        $gestore = new GestoreStatisticheCalciatore();
        $calciatori = $gestore->getCalciatori($squadra);

        //XDebug
        //var_dump($calciatori);

        //return new Response("Statistiche calciatori: ");

        return $this->render("staff/ViewListaStatisticheCalciatori.html.twig", array("calciatori" => $calciatori));
    }

    /**
     * @Route("/statistiche/staff/calciatore/insert/view/{nome}/{data}", name="ViewInserisciStatisticheCalciatori")
     * @deprecated
     */
    /*public function getInserisciStatisticheCalciatoriView($nome, $data)
    {
        $squadra = $_SESSION["squadra"];

        $gestorePartite = new GestorePartite();
        $partita = $gestorePartite->getPartita($nome, $data, $squadra);
        $calciatori = $gestorePartite->getCalciatoriConvocati($partita);

        return $this->render("staff/ViewInserisciStatisticheCalciatori.html.twig", array("partita" => $partita, "calciatori" => $calciatori));
    }*/

    /**
     * Restituisce la view per la modifica delle statistiche dei calciatori convocati.
     * @Route("/statistiche/staff/calciatore/edit/view/{nome}/{data}", name = "ViewModificaStatisticheCalciatori")
     * @deprecated
     */
    /*public function getModificaStatisticheCalciatoriView($nome, $data)
    {
        $squadra = $_SESSION["squadra"];

        $gestorePartite = new GestorePartite();
        $partita = $gestorePartite->getPartita($nome, $data, $squadra);
        $calciatori = $gestorePartite->getCalciatoriConvocati($partita);

        //return render template modifica
        return $this->render("staff/ViewModificaStatisticheCalciatori.html.twig", array("partita" => $partita, "calciatori" => $calciatori));
    }*/

    /**
     * @Route("/statistiche/staff/calciatore/{nome}/{data}", name = "lista_statistiche_calciatori_partita")
     */
    public function getListaStatisticheCalciatoriPartitaView($nome, $data)
    {
        $squadra = $_SESSION["squadra"];

        $gestorePartite = new GestorePartite();
        $partita = $gestorePartite->getPartita($nome, $data, $squadra);
        $calciatori = $gestorePartite->getCalciatoriConvocati($partita);

        return $this->render(":staff:ViewListaStatisticheCalciatoriPartita.html.twig", array("partita" => $partita, "calciatori" => $calciatori));
    }
}