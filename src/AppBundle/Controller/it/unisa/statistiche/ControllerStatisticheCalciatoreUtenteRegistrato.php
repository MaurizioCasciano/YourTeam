<?php
namespace AppBundle\Controller\it\unisa\statistiche;

use AppBundle\it\unisa\autenticazione\GestoreAutenticazione;
use AppBundle\it\unisa\statistiche\FiltroStatisticheCalciatore;
use AppBundle\it\unisa\statistiche\GestoreStatisticheCalciatore;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 15/12/2016
 * Time: 11:37
 */
class ControllerStatisticheCalciatoreUtenteRegistrato extends Controller
{
    /**
     * Restituisce il form per filtrare i calciatori in base alle loro statistiche.
     * @Route("/statistiche/user/calciatore/filter/form", name = "form_filtra_calciatori")
     * @Method("GET")
     */
    public function getFiltraCalciatoriForm(Request $request)
    {
        //var_dump($request->get("_route"));
        if (isset($_SESSION) && isset($_SESSION["squadra"]) && isset($_SESSION["tipo"])) {

            $autenticazione = GestoreAutenticazione::getInstance();
            if ($autenticazione->check($request->get("_route"))) {

                switch ($_SESSION["tipo"]) {
                    case "allenatore" :
                        return $this->render(":allenatore:FormFiltraCalciatori.html.twig");
                    case "calciatore" :
                        return $this->render(":giocatore:FormFiltraCalciatori.html.twig");
                    case "tifoso" :
                        return $this->render(":tifoso:FormFiltraCalciatori.html.twig");
                    case "staff":
                        return $this->render(":staff:FormFiltraCalciatori.html.twig");
                    default :
                        return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "Tipo sconosciuto."));
                }
            } else {
                return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "Azione non consentita."));
            }
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "Effettuare il login."));
        }
    }

    /**
     * @Route("/statistiche/user/calciatore/filter/submit", name = "filtra_calciatori")
     * @Method("POST")
     * @param Request $request
     * @return Response
     */
    public function filtraCalciatori(Request $request)
    {
        if (isset($_SESSION) && isset($_SESSION["squadra"]) && isset($_SESSION["tipo"])) {
            $autenticazione = GestoreAutenticazione::getInstance();
            if ($autenticazione->check($request->get("_route"))) {
                $squadra = $_SESSION["squadra"];

                //MIN
                $minTiriTotali = empty($request->get("min_tiri_totali")) ? 0 : $request->get("min_tiri_totali");
                $minTiriPorta = empty($request->get("min_tiri_porta")) ? 0 : $request->get("min_tiri_porta");
                $minFalliFatti = empty($request->get("min_falli_fatti")) ? 0 : $request->get("min_falli_fatti");
                $minFalliSubiti = empty($request->get("min_falli_subiti")) ? 0 : $request->get("min_falli_subiti");
                $minPercentualePassaggiRiusciti = empty($request->get("min_percentuale_passaggi_riusciti")) ? 0 : $request->get("min_percentuale_passaggi_riusciti");
                $minGolFatti = empty($request->get("min_gol_fatti")) ? 0 : $request->get("min_gol_fatti");
                $minGolSubiti = empty($request->get("min_gol_subiti")) ? 0 : $request->get("min_gol_subiti");
                $minAssist = empty($request->get("min_assist")) ? 0 : $request->get("min_assist");
                $minAmmonizioni = empty($request->get("min_ammonizioni")) ? 0 : $request->get("min_ammonizioni");
                $minEspulsioni = empty($request->get("min_espulsioni")) ? 0 : $request->get("min_espulsioni");

                //MAX
                $maxTiriTotali = empty($request->get("max_tiri_totali")) ? PHP_INT_MAX : $request->get("max_tiri_totali");
                $maxTiriPorta = empty($request->get("max_tiri_porta")) ? PHP_INT_MAX : $request->get("max_tiri_porta");
                $maxFalliFatti = empty($request->get("max_falli_fatti")) ? PHP_INT_MAX : $request->get("max_falli_fatti");
                $maxFalliSubiti = empty($request->get("max_falli_subiti")) ? PHP_INT_MAX : $request->get("max_falli_subiti");
                $maxPercentualePassaggiRiusciti = empty($request->get("max_percentuale_passaggi_riusciti")) ? 100 : $request->get("max_percentuale_passaggi_riusciti");
                $maxGolFatti = empty($request->get("max_gol_fatti")) ? PHP_INT_MAX : $request->get("max_gol_fatti");
                $maxGolSubiti = empty($request->get("max_gol_subiti")) ? PHP_INT_MAX : $request->get("max_gol_subiti");
                $maxAssist = empty($request->get("max_assist")) ? PHP_INT_MAX : $request->get("max_assist");
                $maxAmmonizioni = empty($request->get("max_ammonizioni")) ? PHP_INT_MAX : $request->get("max_ammonizioni");
                $maxEspulsioni = empty($request->get("max_espulsioni")) ? PHP_INT_MAX : $request->get("max_espulsioni");

                $gestoreStatisticheCalciatore = GestoreStatisticheCalciatore::getInstance();
                $calciatori = $gestoreStatisticheCalciatore->filtraCalciatori($squadra, $minTiriTotali, $minTiriPorta, $minGolFatti, $minGolSubiti, $minAssist,
                    $minFalliFatti, $minFalliSubiti, $minPercentualePassaggiRiusciti,
                    $minAmmonizioni, $minEspulsioni, $maxTiriTotali, $maxTiriPorta,
                    $maxGolFatti, $maxGolSubiti, $maxAssist, $maxFalliFatti, $maxFalliSubiti,
                    $maxPercentualePassaggiRiusciti, $maxAmmonizioni, $maxEspulsioni);

                switch ($_SESSION["tipo"]) {
                    case "allenatore" :
                        return $this->render(":allenatore:ViewListaStatisticheCalciatori.html.twig", array("calciatori" => $calciatori));
                    case "calciatore" :
                        return $this->render(":calciatore:ViewListaStatisticheCalciatori.html.twig", array("calciatori" => $calciatori));
                    case "tifoso" :
                        return $this->render(":tifoso:ViewListaStatisticheCalciatori.html.twig", array("calciatori" => $calciatori));
                    case "staff":
                        return $this->render(":staff:ViewListaStatisticheCalciatori.html.twig", array("calciatori" => $calciatori));
                    default :
                        return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "Tipo sconosciuto."));
                }
            } else {
                return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "Azione non consentita."));
            }
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "Effettuare il login."));
        }
    }

    /**
     * Restituisce la view con la lista delle statistiche dei calciatori della squadra dell'utente.
     * @Route("/statistiche/user/calciatore/all", name = "lista_statistiche_calciatori")
     * @Method("GET")
     */
    public function getStatisticheCalciatoriView(Request $request)
    {
        if (isset($_SESSION) && isset($_SESSION["squadra"]) && isset($_SESSION["tipo"])) {

            $autenticazione = GestoreAutenticazione::getInstance();
            if ($autenticazione->check($request->get("_route"))) {
                $gestore = GestoreStatisticheCalciatore::getInstance();
                $calciatori = $gestore->getCalciatori($_SESSION["squadra"]);

                switch ($_SESSION["tipo"]) {
                    case "allenatore" :
                        return $this->render("allenatore/ViewListaStatisticheCalciatori.html.twig", array("calciatori" => $calciatori));
                    case "calciatore" :
                        return $this->render("giocatore/ViewListaStatisticheCalciatori.html.twig", array("calciatori" => $calciatori));
                    case "tifoso" :
                        return $this->render("tifoso/ViewListaStatisticheCalciatori.html.twig", array("calciatori" => $calciatori));
                    case "staff":
                        return $this->render("staff/ViewListaStatisticheCalciatori.html.twig", array("calciatori" => $calciatori));
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