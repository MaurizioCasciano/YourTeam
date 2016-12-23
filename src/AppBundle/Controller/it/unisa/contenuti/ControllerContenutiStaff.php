<?php
namespace AppBundle\Controller\it\unisa\contenuti;

/**
 * Created by PhpStorm.
 * User: Carmine
 * Date: 14/12/2016
 * Time: 15:37
 */

use AppBundle\Utility\DB;
use AppBundle\it\unisa\contenuti\Contenuto;
use AppBundle\it\unisa\contenuti\GestioneContenuti;
use AppBundle\Utility\Utility;
use Monolog\Handler\Curl\Util;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
class ControllerContenutiStaff extends Controller

{
    /**
     * @Route("/contenuti/staff/inserisciContenutoForm")
     * @Method("GET")
     */
    public function inserisciContenutoForm(){

        return $this->render("staff/inserisciContenutoForm.html.twig");
    }

    /**
     * @Route("/contenuti/staff/inserisciContenuto")
     * @Method("POST")
     */
    public function inserisciContenuto(Request $richiesta){
        $titolo = $richiesta->request->get("t");
        $descrizione = $richiesta->request->get("d");
        //$URL = $richiesta->request->get("u");
        $tipo = $richiesta->request->get("ti");

        /* per un test di prova iniziale la variabile squadra sarà inviata tramite form*/
        //$squadra = $richiesta->request->get("squadra");

         /*quando verrà implementata la sessione, la squadra sarà ottenuta dalla sessione*/
        $squadra= $_SESSION["squadra"];


        $path=Utility::loadFile("file","contenuti");
        if($path!=null){

            $contenuto = new Contenuto($titolo,$descrizione,$path,$tipo,$squadra);
            $gestore = new GestioneContenuti();
            try {
                $gestore->inserisciContenuto($contenuto);
                return $this->render("staff/alertInserisciContenuto.html.twig");
            } catch (\Exception $e) {
                return new Response($e->getMessage(), 404);
            }

        }
        return new Response("problema a caricare l'immagine");

    }

    /**
     * @Route("/contenuti/staff/modificaContenutoForm {id}")
     * @Method("GET")
     */
    public function modificaContenutoForm(){

    }

    /**
     * @Route("/contenuti/staff/modificaContenuto/{id}")
     * @Method("POST")
     */
    public function modificaContenuto($id,Request $richiesta){
        echo "controller modifica contenuto".$id;
        $titolo = $richiesta->request->get("titolo");
        $descrizione = $richiesta->request->get("descrizione");
        $URL = $richiesta->request->get("URL");
        $tipo = $richiesta->request->get("tipo");

        /* per un test di prova iniziale la variabile squadra sarà inviata tramite form*/
        $squadra = $richiesta->request->get("squadra");

        /* quando verrà implementata la sessione, la squadra sarà ottenuta dalla sessione
        $squadra= $_SESSION["squadra"];*/

        $contenuto = new Contenuto($titolo,$descrizione,$URL,$tipo,$squadra);
        $gestore = new GestioneContenuti();
        try {
            $gestore->modificaContenuto($id,$contenuto);
            return new Response("<br/> modifica andata a buon fine <br/>");
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
    }

    /**
     * @Route("/contenuti/staff/cancellaContenuto/{id}")
     * @Method("GET")
     */
    public function cancellaContenutoView($id){

        $gestore = new GestioneContenuti();

        try {
            $contenuto = $gestore->cancellaContenuto($id);
            unlink("../web/ImmaginiApp/contenuti/".$contenuto->getURL());
            return $this->render("staff/alertCancellaContenuto.html.twig");
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
    }

    /**
     * @Route("/contenuti/staff/visualizzaElencoContenuti")
     * @Method("GET")
     */
    public function visualizzaElencoContenuti(){
        $gestore = new GestioneContenuti();
        try {
            $gestore->visualizzaElencoContenuti();
        }catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
        return new Response();
    }

    /**
     * @Route("/contenuti/staff/visualizzaContenutoView/{id}")
     * @Method("GET")
     */
    public function visualizzaContenutoView($id){
        $gestore = new GestioneContenuti();
        try {
            $contenuto=$gestore->visualizzaContenuto($id);
            return $this->render("staff/visualizzaContenutoStaff.html.twig",
            array("contenuto"=>$contenuto));
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
    }

    /**
     * @Route("/contenuti/staff/visualizzaElencoContenutiSquadra")
     * @Method("GET")
     */
    public function visualizzaElencoContenutiSquadra(){
        $squadra=$_SESSION["squadra"];
        $gestore = new GestioneContenuti();
        try {
            $contenuti=$gestore->visualizzaElencoContenutiSquadra($squadra);
            return $this->render("staff/visualizzaElencoContenuti.html.twig",array("elenco"=>$contenuti));
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }

    }

    /**
     * @Route("/contenuti/staff/visualizzaElencoContenutiPerTipo/{tipo}")
     * @Method("GET")
     */
    public function visualizzaElencoContenutiPerTipo($tipo){
        $gestore = new GestioneContenuti();
        try {
            $gestore->visualizzaElencoContenutiPerTipo($tipo);
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
        return new Response();
    }
}