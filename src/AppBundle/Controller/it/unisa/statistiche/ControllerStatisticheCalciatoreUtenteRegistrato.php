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
        $gestore = new GestoreStatisticheCalciatore();
        $statistiche = $gestore->getStatisticheComplessiveCalciatore($calciatore);

        return $this->render(":staff:ViewStatisticheCalciatore.html.twig", array("statistiche_calciatore" => $statistiche));
    }

    /**
     * Restituisce il form per filtrare i calciatori in base alle loro statistiche.
     * @Route("/statistiche/user/calciatore/filter/form")
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
     * @Route("/statistiche/user/calciatore/filter/submit")
     * @Method("POST")
     * @param Request $request
     * @return Response
     */
    public function filtraCalciatori(Request $request)
    {
        //MIN
        $minTiriTotali = $request->get("min_tiri_totali");
        $minTiriPorta = $request->get("min_tiri_porta");
        $minFalliFatti = $request->get("min_falli_fatti");
        $minFalliSubiti = $request->get("min_falli_subiti");
        $minPercentualePassaggiRiusciti = $request->get("min_percentuale_passaggi_riusciti");
        $minGolFatti = $request->get("min_gol_fatti");
        $minGolSubiti = $request->get("min_gol_subiti");
        $minAssist = $request->get("min_assist");
        $minAmmonizioni = $request->get("min_ammonizioni");
        $minEspulsioni = $request->get("min_espulsioni");

        //MAX
        $maxTiriTotali = $request->get("max_tiri_totali");
        $maxTiriPorta = $request->get("max_tiri_porta");
        $maxFalliFatti = $request->get("max_falli_fatti");
        $maxFalliSubiti = $request->get("max_falli_subiti");
        $maxPercentualePassaggiRiusciti = $request->get("max_percentuale_passaggi_riusciti");
        $maxGolFatti = $request->get("max_gol_fatti");
        $maxGolSubiti = $request->get("max_gol_subiti");
        $maxAssist = $request->get("max_assist");
        $maxAmmonizioni = $request->get("max_ammonizioni");
        $maxEspulsioni = $request->get("max_espulsioni");

        $gestoreStatisticheCalciatore = new GestoreStatisticheCalciatore();
        $arrayStatistiche = $gestoreStatisticheCalciatore->filtraCalciatori($minTiriTotali, $minTiriPorta, $minGolFatti, $minGolSubiti, $minAssist,
            $minFalliFatti, $minFalliSubiti, $minPercentualePassaggiRiusciti,
            $minAmmonizioni, $minEspulsioni, $maxTiriTotali, $maxTiriPorta,
            $maxGolFatti, $maxGolSubiti, $maxAssist, $maxFalliFatti, $maxFalliSubiti,
            $maxPercentualePassaggiRiusciti, $maxAmmonizioni, $maxEspulsioni);


        return $this->render(":staff:ViewCalciatoriFiltrati.html.twig", array("array_statistiche" => $arrayStatistiche));
    }
}