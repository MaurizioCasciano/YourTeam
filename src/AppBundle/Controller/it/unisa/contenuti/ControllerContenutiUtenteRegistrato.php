<?php
/**
 * Created by PhpStorm.
 * User: Carmine
 * Date: 22/12/2016
 * Time: 11:36
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
class ControllerContenutiUtenteRegistrato extends Controller
{
    /**
     * @Route("/contenuti/utenteRegistrato/visualizzaElencoContenuti")
     * @Method("GET")
     */
    public function visualizzaElencoContenuti(){
        $squadra=$_SESSION["squadra"];
        $gestore = GestioneContenuti::getInstance();
        try {
            $contenuti=$gestore->visualizzaElencoContenutiSquadra($squadra);
            return $this->render("tifoso/visualizzaElencoContenuti.html.twig",array("elenco"=>$contenuti));
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }

    }

    /**
     * @Route("/contenuti/utenteRegistrato/visualizzaContenutoView/{id}")
     * @Method("GET")
     */
    public function visualizzaContenutoView($id){
        $gestore = GestioneContenuti::getInstance();

        try {
            $contenuto=$gestore->visualizzaContenuto($id);
            if ($contenuto->getTipo()=="immagine") {
                return $this->render("tifoso/visualizzaContenuto.html.twig",
                    array('contenuto' => $contenuto));
            }else{
                if ($contenuto->getTipo()=="video") {
                    return $this->render("tifoso/visualizzaVideo.html.twig",
                        array('contenuto' => $contenuto));
                }
            }
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
    }

    /**
     * @Route("/contenuti/utenteRegistrato/visualizzaElencoContenutiPerTipo/{tipo}")
     * @Method("GET")
     */
    public function visualizzaElencoContenutiPerTipo($tipo){
        $gestore = GestioneContenuti::getInstance();
        try {
            $elenco=$gestore->visualizzaElencoContenutiPerTipo($tipo);
            if($tipo=="immagine") {
                return $this->render("tifoso/visualizzaElencoContenutiPerTipo.html.twig",
                    array('elenco' => $elenco));
            }else{
                if ($tipo=="video"){
                    return $this->render("tifoso/visualizzaElencoVideo.html.twig",
                        array('video' => $elenco));
                }
            }
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
    }
}