<?php
namespace AppBundle\Controller\it\unisa\partite;

use AppBundle\it\unisa\partite\Partita;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 26/12/2016
 * Time: 12:13
 */
class ControllerPartiteStaff extends Controller
{
    /**
     * @Route("/partite/staff/insert/form")
     * @Method("GET")
     */
    public function getInserisciPartitaForm()
    {
        return $this->render(":staff:FormInserisciPartita.html.twig", array("squadra" => $_SESSION["squadra"]));
    }

    /**
     * @Route("/partite/staff/insert/submit/", name = "inserisciPartita")
     * @Method("POST")
     *
     */
    public function inserisciPartita(Request $request)
    {
        $squadra_casa = $request->get("squadra_casa");
        $squadra_trasferta = $request->get("squdara_trasferta");
        $stadio = $request->get("stadio");
        $data = $request->get("data");
        $ora = $request->get("ora");

        return new Response("casa: " . $squadra_casa . " trasferta: " . $squadra_trasferta . " stadio: " . $stadio . " data: " . $data . " opa: " . $ora);
    }
}