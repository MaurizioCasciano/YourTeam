<?php
namespace AppBundle\Controller\it\unisa\contenuti;

/**
 * Created by PhpStorm.
 * User: Carmine
 * Date: 14/12/2016
 * Time: 15:37
 */

use AppBundle\Utility\DB;
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
        $gestore = new \GestioneContenuti();
        $gestore.$this->inserisciContenuto($contenuto);

        return new Response();
    }

    /**
     * @Route("/contenuti/staff/modificaContenutoForm {id}")
     * @Method("GET")
     */
    public function modificaContenutoForm(){

    }

    /**
     * @Route("/contenuti/staff/modificaContenuto")
     * @Method("POST")
     */
    public function modificaContenuto(Request $richiesta){
        $nome = $richiesta->request->get("nome");
        $descrizione = $richiesta->request->get("descrizione");
        echo $nome." ".$descrizione;
        return new Response();
    }

    /**
     * @Route("/contenuti/staff/modificaContenutoForm {id}")
     * @Method("GET")
     */
    public function cancellaContenutoView(){

    }

    /**
     * @Route("/contenuti/staff/visualizzaElencoContenuto")
     * @Method("GET")
     */
    public function visualizzaElencoContenuti(){
        return new Response();
    }

    /**
     * @Route("/contenuti/staff/visualizzaContenutoView {id}")
     * @Method("GET")
     */
    public function visualizzaContenutoView($id){
        return new Response();
    }
}