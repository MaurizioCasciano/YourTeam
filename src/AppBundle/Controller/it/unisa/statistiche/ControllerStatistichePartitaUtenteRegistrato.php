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
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function getStatisticheView()
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

    /**
     * Restituisce i convocati per la partita.
     * @Route("/statistiche/convocati/{nome}/{data}")
     */
    public function getConvocati($nome, $data)
    {
        try {
            $gestorePartite = new GestorePartite();
            $partita = $gestorePartite->getPartita($nome, $data, $_SESSION["squadra"]);

            $gestioneRosa = new GestioneRosa();
            $calciatori = $gestioneRosa->ottieniConvocati($partita);

        } catch (\Exception $e1) {
            return new Response($e1->getMessage());
        }

        return new JsonResponse(array("calciatori" => $calciatori));
    }
}