<?php
/**
 * Created by PhpStorm.
 * User: Carmine
 * Date: 22/12/2016
 * Time: 14:10
 */

namespace AppBundle\Controller\it\unisa\contenuti;

use AppBundle\Utility\DB;
use AppBundle\it\unisa\contenuti\Contenuto;
use AppBundle\it\unisa\contenuti\GestioneContenuti;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
class ControllerContenutiUtenteGuest extends Controller
{
    /**
     * @Route("/contenuti/utenteGuest/visualizzaContenuto")
     * @Method("GET")
     */
    public function visualizzaElencoContenuti()
    {
        $gestore = new GestioneContenuti();
        try {
            $elenco= $gestore->visualizzaElencoContenuti();
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
        return $this->render("guest/visualizzaElencoContenuti.html.twig",
            array('elenco' => $elenco));
    }

    /**
     * @Route("/contenuti/utenteGuest/visualizzaContenutoView/{id}")
     * @Method("GET")
     */
    public function visualizzaContenutoView($id){
        $gestore = new GestioneContenuti();

        try {
            $contenuto = $gestore->visualizzaContenuto($id);
            return $this->render("guest/visualizzaContenuto.html.twig",
                array('contenuto' => $contenuto));
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
        return new Response();
    }

    /**
     * @Route("/")
     * @Method("GET")
     */
    public function visualizzaElencoContenutiPerTipo(){
        $gestore = new GestioneContenuti();
        try {
            $elenco= $gestore->visualizzaElencoContenutiPerTipo("immagine");
            return $this->render("guest/visualizzaElencoContenuti.html.twig",
                array('elenco' => $elenco));
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
        return new Response();
    }
}