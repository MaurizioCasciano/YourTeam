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
class ControllerContenutiUtenteRegistrato
{
    /**
     * @Route("/contenuti/staff/visualizzaElencoContenuti/utenteRegistrato/{squadra}")
     * @Method("GET")
     */
    public function visualizzaElencoContenuti($squadra)
    {
        /* quando verrà implementata la sessione, la squadra sarà ottenuta dalla sessione
        $squadra= $_SESSION["squadra"];*/

        $gestore = new GestioneContenuti();
        try {
            $gestore->visualizzaElencoContenutiSquadra($squadra);
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
        return new Response();
    }

    /**
     * @Route("/contenuti/staff/visualizzaContenutoView/utenteRegistrato/{id}")
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
}