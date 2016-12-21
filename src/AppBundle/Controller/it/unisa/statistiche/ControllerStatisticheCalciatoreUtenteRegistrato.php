<?php
namespace AppBundle\Controller\it\unisa\statistiche;

use AppBundle\it\unisa\statistiche\FiltroStatisticheCalciatore;
use AppBundle\it\unisa\statistiche\GestoreStatisticheCalciatore;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 15/12/2016
 * Time: 11:37
 */
class ControllerStatisticheCalciatoreUtenteRegistrato extends Controller
{
    /**
     * @Route("/statistiche/hello")
     */
    public function hello()
    {
        $response = new Response("Hello Statistiche");
        return $response;
    }

    /**
     * @param $calciatore L'ID del calciatore.
     * @Route("/statistiche/user/{calciatore}/view")
     * @Method("GET")
     */
    public function getStatisticheView($calciatore)
    {
        $gestore = new GestoreStatisticheCalciatore();
        $statistiche = $gestore->getStatisticheCalciatore($calciatore);

        return new Response("Vierw con statistiche del callciatore " . var_dump($calciatore) . var_dump($statistiche));
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