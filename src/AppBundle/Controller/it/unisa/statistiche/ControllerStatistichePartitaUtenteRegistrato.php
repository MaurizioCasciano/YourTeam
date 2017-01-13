<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 30/12/2016
 * Time: 23:04
 */

namespace AppBundle\Controller\it\unisa\statistiche;


use AppBundle\it\unisa\autenticazione\GestoreAutenticazione;
use AppBundle\it\unisa\partite\GestorePartite;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ControllerStatistichePartitaUtenteRegistrato extends Controller
{
    /**
     * @Route("/statistiche/user/partita/all", name = "lista_statistiche_partite")
     * @Method("GET")
     */
    public function getListaStatisticheView(Request $request)
    {
        if (isset($_SESSION) && isset($_SESSION["squadra"]) && isset($_SESSION["tipo"])) {

            $autenticazione = GestoreAutenticazione::getInstance();
            if ($autenticazione->check($request->get("_route"))) {
                $gestorePartite = GestorePartite::getInstance();
                $partite = $gestorePartite->getPartite($_SESSION["squadra"]);

                switch ($_SESSION["tipo"]) {
                    case "allenatore" :
                        return $this->render(":allenatore:ViewListaStatistichePartite.html.twig", array("partite" => $partite));
                    case "calciatore" :
                        return $this->render(":giocatore:ViewListaStatistichePartite.html.twig", array("partite" => $partite));
                    case "tifoso" :
                        return $this->render(":tifoso:ViewListaStatistichePartite.html.twig", array("partite" => $partite));
                    case "staff":
                        return $this->render(":staff:ViewListaStatistichePartite.html.twig", array("partite" => $partite));
                    default :
                        throw new \Exception("Tipo account sconosciuto.");
                }
            } else {
                return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "Azione non consentita."));
            }
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "Effettuare il login."));
        }
    }
}