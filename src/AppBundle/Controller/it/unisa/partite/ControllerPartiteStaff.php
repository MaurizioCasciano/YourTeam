<?php
namespace AppBundle\Controller\it\unisa\partite;

use AppBundle\it\unisa\partite\GestorePartite;
use AppBundle\it\unisa\partite\Partita;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

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
        return $this->render(":staff:FormInserisciPartita.html.twig", array());
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

        //return new Response("casa: " . $squadra_casa . " trasferta: " . $squadra_trasferta . " stadio: " . $stadio . " data: " . $data . " opa: " . $ora);

        $nome = $squadra_casa . "-" . $squadra_trasferta;
        $dateTime = $data . " " . $ora;
        //($nome, $data, $squadra, $stadio)
        $partita = new Partita($squadra_casa, $squadra_trasferta, $dateTime, $_SESSION["squadra"], $stadio);

        $gestorePartite = new GestorePartite();

        $success = $gestorePartite->inserisciPartita($partita);

        return new Response("Partita inserita: " . $success);
    }

    /**
     * @Route("/partite/staff", name = "lista_partite")
     */
    public function getListaPartiteView()
    {
        if (isset($_SESSION["squadra"])) {
            $gestorePartite = new GestorePartite();

            $partite = $gestorePartite->getPartite($_SESSION["squadra"]);
            return $this->render("staff/ViewListaPartite.html.twig", array("partite" => $partite));
        } else {
            throw new \Exception("$_SESSION[squadra] not set");
        }
    }

    /**
     * @Route("/test123")
     */
    public function test123()
    {
        $partita = new Partita("Milan-Napoli", "2016-12-26 20:45:00", "Napoli", "San Siro");
        $gestorePartite = new GestorePartite();

        return new Response("Error: " . $gestorePartite->inserisciPartita($partita));
    }
}