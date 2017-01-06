<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 30/12/2016
 * Time: 23:04
 */

namespace AppBundle\Controller\it\unisa\statistiche;


use AppBundle\it\unisa\formazione\GestioneRosa;
use AppBundle\it\unisa\partite\GestorePartite;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ControllerStatistichePartitaUtenteRegistrato extends Controller
{
    /**
     * @Route("/statistiche/staff/partita/all", name = "lista_statistiche_partite")
     * @Method("GET")
     */
    public function getListaStatisticheView()
    {
        if (isset($_SESSION) && isset($_SESSION["squadra"]) && isset($_SESSION["tipo"])) {
            $gestorePartite = new GestorePartite();
            $partite = $gestorePartite->getPartite($_SESSION["squadra"]);

            switch ($_SESSION["tipo"]) {
                case "allenatore" :
                    return $this->render(":staff:ViewListaStatistichePartite.html.twig", array("partite" => $partite));
                case "calciatore" :
                    return $this->render(":staff:ViewListaStatistichePartite.html.twig", array("partite" => $partite));
                case "tifoso" :
                    return $this->render(":staff:ViewListaStatistichePartite.html.twig", array("partite" => $partite));
                case "staff":
                    return $this->render(":staff:ViewListaStatistichePartite.html.twig", array("partite" => $partite));
                default :
                    throw new \Exception("Tipo account sconosciuto.");
            }
        } else {
            throw new \Exception("SESSION not set");
        }
    }
}