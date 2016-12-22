<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 21/12/2016
 * Time: 13:01
 */

namespace AppBundle\Controller\it\unisa\statistiche;


use AppBundle\it\unisa\statistiche\StatisticheCalciatore;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ControllerStatisticheCalciatoreStaff extends ControllerStatisticheCalciatoreUtenteRegistrato
{
    /**
     * @Route("/statistiche/staff/calciatore/insert/form/{calciatore}/{nome_partita}/{data_partita}")
     * @Method("GET")
     */
    public function getInserisciStatisticheForm(Request $request, $calciatore, $nome_partita, $data_partita)
    {
        $request->getSession()->set("calciatore", $calciatore);
        $request->getSession()->set("nome_partita", $nome_partita);
        $request->getSession()->set("data_partita", $data_partita);

        return $this->render(":statistiche:fomrinseriscistatistichecalciatore.html.twig", array());
    }

    /**
     * @Route("/statistiche/staff/calciatore/insert/submit");
     * @Method("POST")
     */
    public function inserisciStatistiche(Request $request)
    {
        /*
         * Le informazioni riguardanti il calciatore è la partita vengono settate al momento della richiesta del form per l'inserimento delle statistiche.
         */
        //inizio chiave statistiche_calciatore
        $calciatore = $request->getSession()->get("calciatore");
        $nomePartita = $request->getSession()->get("nome_partita");
        $dataPartita = $request->getSession()->get("data_partita");
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


        /*
         * TO-DO
         * inserire i dati nel database e gestire possibili eccezioni
         */

        return new Response("Statistiche inserite per il calciatore: " . $calciatore . " - " . $nomePartita . " - " . $dataPartita);
    }

    /**
     * @param $calciatore L'ID del calciatore.
     * @Route("/statistiche/staff/{calciatore}/edit/form")
     * @Method("GET")
     */
    public function getModificaStatisticheForm($calciatore)
    {

        return new Response("FORM MODIFICA STATISTICHE calciatore: " . $calciatore);
    }

    /**
     * @param Request $request
     * @Route("/statistiche/staff/{calciatore}/edit/submit")
     * @Method("POST")
     */
    public function modificaStatistiche(Request $request, $calciatore)
    {

    }
}