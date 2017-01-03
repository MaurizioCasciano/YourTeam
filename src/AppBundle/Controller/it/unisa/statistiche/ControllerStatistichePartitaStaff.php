<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 30/12/2016
 * Time: 23:02
 */

namespace AppBundle\Controller\it\unisa\statistiche;


use AppBundle\it\unisa\partite\GestorePartite;
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
        $values = $request->get("values");

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
        $possessoPalla = $array["possessopalla"];

        $gestorePartite = new GestorePartite();
        $partita = $gestorePartite->getPartita($nomePartita, $dataPartita, $squadra);

        //__construct($golFatti, $golSubiti, $possessoPalla,
        // array $marcatori, array $assistMen, array $ammonizioni, array $espulsioni)
        $statistiche = new StatistichePartita($golFatti, $golSubiti, $possessoPalla, $marcatori, $assistmen, $ammonizioni, $espulsioni);
        $partita->setStatistiche($statistiche);

        $gestoreStatistichePartita = new GestoreStatistichePartita();
        $executed = $gestoreStatistichePartita->inserisciStatistiche($partita);

        return new Response("OK Response\nExecuted: " . $executed);
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
        $gestoreStatistichePartita = new GestoreStatistichePartita();
        $marcatori = $gestoreStatistichePartita->getMarcatori($nome, $data, $squadra);

        return new JsonResponse($marcatori);
    }


    /**
     * @Route("/test/hello/{nome}")
     * @Method("GET")
     */
    public function hello($nome)
    {
        return new Response("Hello dear " . $nome);
    }

    /**
     * @Route("/test/echo/{a}/{b}/{c}")
     * @Method("GET")
     * @param $a
     * @param $b
     * @param $c
     */
    public function echo ($a, $b, $c)
    {
        return new Response($a . "\n" . $b . "\n" . $c);
    }
}