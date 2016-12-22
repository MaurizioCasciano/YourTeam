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
            $gestore->inserisciContenuto($contenuto);
            return new Response("<br/> inserimento andato a buon fine <br/>");
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }

        return new Response();
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
            $gestore->cancellaContenuto($id);
            return new Response("<br/> cancellazione andata a buon fine <br/>");
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
            $gestore->visualizzaContenuto($id);
            return new Response("<br/> visualizzazione andata a buon fine <br/>");
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
        return new Response();
    }

    /**
     * @Route("/contenuti/staff/visualizzaElencoContenutiSquadra/{squadra}")
     * @Method("GET")
     */
    public function visualizzaElencoContenutiSquadra($squadra){
        $gestore = new GestioneContenuti();
        try {
            $gestore->visualizzaElencoContenutiSquadra($squadra);
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
        return new Response();
    }
}