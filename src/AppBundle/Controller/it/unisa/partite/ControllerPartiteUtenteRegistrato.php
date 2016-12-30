<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 26/12/2016
 * Time: 12:21
 */

namespace AppBundle\Controller\it\unisa\partite;


use AppBundle\it\unisa\partite\GestorePartite;
use AppBundle\it\unisa\partite\PartitaInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class ControllerPartiteUtenteRegistrato extends Controller
{
    /**
     * Restituisce la view con le info riguardanti la partita cercata.
     * @Route("/partite/user/info", name ="infoPartita")
     * @Method("POST")
     */
    public function getInfoPartitaView(Request $request)
    {
        $nome = $request->get("nome");
        $data = $request->get("data");
        $squadra = $_SESSION["squadra"];
        $gestorePartite = new GestorePartite();

        try {
            $partita = $gestorePartite->getPartita($nome, $data, $squadra);
            return $this->render("staff/ViewInfoPartita.html.twig", array("partita" => $partita));
        } catch (\Exception $ex) {
            return new Response($ex->getMessage(), 404);
        }
    }

    /**
     * @Route("/partite/user", name = "lista_partite")
     * @Method("GET")
     */
    public function getListaPartiteView()
    {
        if (isset($_SESSION) && isset($_SESSION["squadra"]) && isset($_SESSION["tipo"])) {
            $gestorePartite = new GestorePartite();
            $partite = $gestorePartite->getPartite($_SESSION["squadra"]);

            switch ($_SESSION["tipo"]) {
                case "allenatore" :
                    return $this->render("allenatore/ViewListaPartite.html.twig", array("partite" => $partite));
                case "calciatore" :
                    return $this->render("giocatore/ViewListaPartite.html.twig", array("partite" => $partite));
                case "tifoso" :
                    return $this->render("tifoso/ViewListaPartite.html.twig", array("partite" => $partite));
                case "staff":
                    return $this->render("staff/ViewListaPartite.html.twig", array("partite" => $partite));
                default :
                    throw new \Exception("Tipo account sconosciuto.");
            }
        } else {
            throw new \Exception("SESSION not set");
        }
    }
}