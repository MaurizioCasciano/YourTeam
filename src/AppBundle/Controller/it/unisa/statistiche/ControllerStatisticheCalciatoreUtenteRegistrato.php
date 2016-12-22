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
     */
    public function getFiltraCalciatoriForm()
    {
        if (isset($_SESSION)) {
            if ($_SESSION["tipo"] == "allenatore") {
                return $this->render("staff/FormFiltraCalciatori.html.twig");
            } else if ($_SESSION["tipo"] == "calciatore") {
                return $this->render("formFil");
            } else if ($_SESSION["tipo"] == "tifoso") {

            } else if ($_SESSION["tipo"] == "staff") {

            }
        } else {
            throw new AccessDeniedException("Access Denied!!!");
        }
    }

    /**
     * @Route("/statistiche/user/calciatore/filter/submit")
     * @param Request $request
     * @return Response
     */
    public function filtraCalciatori(Request $request)
    {
        $filtroStatisticheCalciatore = new FiltroStatisticheCalciatore($request->request->get("minTiriTotali"), $request->request->get("minTiriPorta"), $request->request->get("minGolFatti"), $request->request->get("minAssist"), $request->request->get("minFalliFatti"), $request->request->get("minFalliSubiti"), $request->request->get("minPercentualePassaggiRiusciti"), $request->request->get("minAmmonizioni"), $request->request->get("minEspulsioni"), $request->request->get("maxTiriTotali"), $request->request->get("maxTiriPorta"), $request->request->get("maxGolFatti"), $request->request->get("maxAssist"), $request->request->get("maxFalliFatti"), $request->request->get("maxFalliSubiti"), $request->request->get("maxPercentualePassaggiRiusciti"), $request->request->get("maxAmmonizioni"), $request->request->get("maxEspulsioni"));

        $gestoreStatisticheCalciatore = new GestoreStatisticheCalciatore();
        $calciatori[] = $gestoreStatisticheCalciatore->filtraCalciatori($filtroStatisticheCalciatore);
        $response = new Response(var_dump($calciatori));
        return $response;
    }
}