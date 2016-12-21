<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 21/12/2016
 * Time: 13:01
 */

namespace AppBundle\Controller\it\unisa\statistiche;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ControllerStatisticheCalciatoreStaff extends ControllerStatisticheCalciatoreUtenteRegistrato
{
    /**
     * @Route("/statistiche/staff/{calciatore}/insert/form")
     * @Method("GET")
     */
    public function getInserisciStatisticheForm($calciatore)
    {
        return new Response(var_dump($calciatore));
    }

    /**
     * @Route("/statistiche/staff/{calciatore}/insert/submit");
     * @Method("POST")
     */
    public function inserisciStatistiche(Request $request, $calciatore)
    {


        return new Response("Statistiche inserite per il calciatore: " . $calciatore);
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