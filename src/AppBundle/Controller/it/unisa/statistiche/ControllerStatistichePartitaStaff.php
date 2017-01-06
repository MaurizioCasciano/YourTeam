<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 30/12/2016
 * Time: 23:02
 */

namespace AppBundle\Controller\it\unisa\statistiche;


use AppBundle\it\unisa\formazione\GestioneRosa;
use AppBundle\it\unisa\partite\GestorePartite;
use AppBundle\it\unisa\statistiche\GestoreStatisticheCalciatore;
use AppBundle\it\unisa\statistiche\GestoreStatistichePartita;
use AppBundle\it\unisa\statistiche\StatistichePartita;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ControllerStatistichePartitaStaff extends Controller
{
    /**
     *
     */
    public function getInserisciStatisticheForm()
    {

    }

    /**
     * @Route("/statistiche/staff/partita/insert/submit", name = "inserisciStatistichePartita")
     * @Method("POST")
     */
    public function inserisciStatistiche(Request $request)
    {
        $squadra = $_SESSION["squadra"];
        /*$values = $request->get("values");

        $array = json_decode($values, true);
        //var_dump($array);

        $marcatori = $array["marcatori"];
        $assistmen = $array["assistmen"];
        $ammonizioni = $array["ammonizioni"];
        $espulsioni = $array["espulsioni"];

        //var_dump($marcatori);
        //var_dump($assistmen);
        //var_dump($ammonizioni);
        //var_dump($espulsioni);

        //var_dump(count($espulsioni));

        $nomePartita = $array["nome"];
        $dataPartita = $array["data"];
        $golFatti = $array["golfatti"];
        $golSubiti = $array["golsubiti"];
        $possessoPalla = $array["possessopalla"];*/

        $nomePartita = $request->get("nome");
        $dataPartita = $request->get("data");
        $golFatti = $request->get("golfatti");
        $golSubiti = $request->get("golsubiti");
        $possessoPalla = $request->get("possessopalla");

        $marcatori = $request->get("marcatori");
        $assistmen = $request->get("assistmen");
        $ammonizioni = $request->get("ammonizioni");
        $espulsioni = $request->get("espulsioni");

        $gestorePartite = new GestorePartite();
        $partita = $gestorePartite->getPartita($nomePartita, $dataPartita, $squadra);

        //__construct($golFatti, $golSubiti, $possessoPalla,
        // array $marcatori, array $assistMen, array $ammonizioni, array $espulsioni)
        $statistiche = new StatistichePartita($golFatti, $golSubiti, $possessoPalla, $marcatori, $assistmen, $ammonizioni, $espulsioni);
        $partita->setStatistiche($statistiche);

        $gestoreStatistichePartita = new GestoreStatistichePartita();
        $executed = $gestoreStatistichePartita->inserisciStatistiche($partita);

        if ($executed) {
            return $this->redirectToRoute("ViewInserisciStatisticheCalciatori", array("nome" => $nomePartita, "data" => $dataPartita));

        } else {
            return new Response("CONTROLLER_STATISTICHE_PARTITA_STAFF: Errore nell'inserimento delle statistiche della partita.");
        }
    }

    /**
     *
     */
    public function getModificaStatisticheForm()
    {

    }

    /**
     *
     */
    public function modificaStatistiche()
    {

    }

    /**
     * @Route("/test/marcatori/{nome}/{data}/{squadra}")
     * @Method("GET")
     */
    public function getMarcatori($nome, $data, $squadra)
    {
        $gestorePartite = new GestorePartite();
        $partita = $gestorePartite->getPartita($nome, $data, $squadra);

        $gestoreStatistichePartita = new GestoreStatistichePartita();
        $marcatori = $gestoreStatistichePartita->getMarcatori($partita);

        return new JsonResponse($marcatori);
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