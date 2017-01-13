<?php
namespace AppBundle\Controller\it\unisa\partite;

use AppBundle\it\unisa\partite\GestorePartite;
use AppBundle\it\unisa\partite\Partita;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 26/12/2016
 * Time: 12:13
 */
class ControllerPartiteStaff extends Controller
{
    /**
     * @Route("/partite/staff/insert/form", name = "inserisciPartitaForm")
     * @Method("GET")
     */
    public function getInserisciPartitaForm()
    {
        return $this->render(":staff:FormInserisciPartita.html.twig", array());
    }

    /**
     * @Route("/partite/staff/insert/submit", name = "inserisciPartita")
     * @Method("POST")
     *
     */
    public function inserisciPartita(Request $request)
    {
        $casa = $request->get("casa");
        $trasferta = $request->get("trasferta");
        $stadio = $request->get("stadio");
        $data = $request->get("data");
        $ora = $request->get("ora");
        $squadra = $_SESSION["squadra"];

        $nome = $casa . "-" . $trasferta;
        $dateTime = new \DateTime($data . " " . $ora);
        //($nome, $data, $squadra, $stadio)
        $partita = new Partita($casa, $trasferta, $dateTime, $squadra, $stadio);

        $gestorePartite = GestorePartite::getInstance();

        $success = $gestorePartite->inserisciPartita($partita);

        return new JsonResponse(array("partita" => $partita, "success" => $success));
    }

    /**
     * @Route("/partite/staff/edit/form", name ="Form_modifica_partita")
     * @Method("POST")
     */
    public function getModificaPartitaForm(Request $request)
    {
        $nome = $request->get("nome");
        $data = $request->get("data");
        $squadra = $_SESSION["squadra"];
        $gestorePartite = GestorePartite::getInstance();

        try {
            $partita = $gestorePartite->getPartita($nome, $data, $squadra);
            return $this->render("staff/FormModificaPartita.html.twig", array("partita" => $partita));
        } catch (\Exception $ex) {
            return new Response($ex->getMessage(), 404);
        }
    }

    /**
     * Permette di modificare le informazioni base di una partita.
     * @Route("/partite/staff/edit/submit", name = "modificaPartita");
     * @Method("POST");
     */
    public function modificaPartita(Request $request)
    {
        $squadra = $_SESSION["squadra"];
        $JSON_values = $request->get("values");
        //var_dump($JSON_values);

        // Convert JSON string to AssocArray
        $values = json_decode($JSON_values, true);

        //var_dump($values);

        $oldCasa = $values["casa"]["old"];
        $oldTrasferta = $values["trasferta"]["old"];
        $oldData = $values["data"]["old"];
        $oldOra = $values["ora"]["old"];
        $oldDateTime = new \DateTime($oldData . " " . $oldOra);
        $oldStadio = $values["stadio"]["old"];

        //XDEBUG
        //var_dump($oldCasa);
        //var_dump($oldTrasferta);
        //var_dump($oldDateTime);
        //var_dump($oldStadio);
        //var_dump($_SESSION["squadra"]);

        //__construct($casa, $trasferta, $data, $squadra, $stadio)
        $old = new Partita($oldCasa, $oldTrasferta, $oldDateTime, $_SESSION["squadra"], $oldStadio);

        $newCasa = $values["casa"]["new"];
        $newTrasferta = $values["trasferta"]["new"];
        $newData = $values["data"]["new"];
        $newOra = $values["ora"]["new"];
        $newDateTime = new \DateTime($newData . " " . $newOra);
        $newStadio = $values["stadio"]["new"];
        $new = new Partita($newCasa, $newTrasferta, $newDateTime, $_SESSION["squadra"], $newStadio);

        $gestorePartite = GestorePartite::getInstance();

        try {
            $success = $gestorePartite->modificaPartita($old, $new);
            return new JsonResponse(array("old" => $old, "new" => $new, "success" => $success));
        } catch (\Exception $ex) {
            return new JsonResponse(array("old" => $old, "new" => $new, "success" => false));
        }
    }
}