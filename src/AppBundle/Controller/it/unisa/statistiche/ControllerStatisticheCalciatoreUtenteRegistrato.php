<?php
namespace AppBundle\Controller\it\unisa\statistiche;

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
     * Restituisce la view con le statistiche complessive di un calciatore.
     * @param $calciatore L'ID del calciatore di cui si vogliono visualizzare le statistiche complessive.
     * @Route("/statistiche/user/calciatore/view/{calciatore}")
     * @Method("GET")
     */
    public function getStatisticheView($calciatore)
    {
        $gestoreStatisticheCalciatore = GestoreStatisticheCalciatore::getInstance();
        $statistiche = $gestoreStatisticheCalciatore->getStatisticheComplessiveCalciatore($calciatore);

        return $this->render(":staff:ViewStatisticheCalciatore.html.twig", array("statistiche_calciatore" => $statistiche));
    }

    /**
     * Restituisce il form per filtrare i calciatori in base alle loro statistiche.
     * @Route("/statistiche/user/calciatore/filter/form", name = "form_filtra_calciatori")
     * @Method("GET")
     */
    public function getFiltraCalciatoriForm()
    {
        if (isset($_SESSION)) {
            if ($_SESSION["tipo"] == "allenatore") {
                return $this->render(":allenatore:FormFiltraCalciatori.html.twig");
            } else if ($_SESSION["tipo"] == "calciatore") {
                return $this->render(":giocatore:FormFiltraCalciatori.html.twig");
            } else if ($_SESSION["tipo"] == "tifoso") {
                return $this->render(":tifoso:FormFiltraCalciatori.html.twig");
            } else if ($_SESSION["tipo"] == "staff") {
                return $this->render(":staff:FormFiltraCalciatori.html.twig");
            }
        } else {
            throw new AccessDeniedException("Access Denied!!!");
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
        //var_dump($request);
        if (!isset($_SESSION)) {
            throw new \Exception("SESSION NOT SER");
        }

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

        //var_dump($calciatori);

        if (isset($_SESSION) && isset($_SESSION["tipo"])) {
            if ($_SESSION["tipo"] == "allenatore") {
                return $this->render(":allenatore:ViewListaStatisticheCalciatori.html.twig", array("calciatori" => $calciatori));
            } else if ($_SESSION["tipo"] == "calciatore") {
                return $this->render(":calciatore:ViewListaStatisticheCalciatori.html.twig", array("calciatori" => $calciatori));
            } else if ($_SESSION["tipo"] == "tifoso") {
                return $this->render(":tifoso:ViewListaStatisticheCalciatori.html.twig", array("calciatori" => $calciatori));
            } else if ($_SESSION["tipo"] == "staff") {
                return $this->render(":staff:ViewListaStatisticheCalciatori.html.twig", array("calciatori" => $calciatori));
            }
        } else {
            throw new AccessDeniedException("Access Denied!!!");
        }
    }
}