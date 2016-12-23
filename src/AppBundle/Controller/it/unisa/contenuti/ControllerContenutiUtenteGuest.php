<?php
/**
 * Created by PhpStorm.
 * User: Carmine
 * Date: 22/12/2016
 * Time: 14:10
 */

namespace AppBundle\Controller\it\unisa\contenuti;

<<<<<<< HEAD
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Config\Definition\Exception\Exception;


=======
use AppBundle\Utility\DB;
use AppBundle\it\unisa\contenuti\Contenuto;
use AppBundle\it\unisa\contenuti\GestioneContenuti;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
>>>>>>> comunicazione
class ControllerContenutiUtenteGuest
{
    /**
     * @Route("/contenuti/utenteGuest/visualizzaElencoContenuti/")
     * @Method("GET")
     */
    public function visualizzaElencoContenuti()
    {
        $gestore = new GestioneContenuti();
        try {
            $gestore->visualizzaElencoContenuti();
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
        return new Response();
    }

    /**
     * @Route("/contenuti/utenteGuest/visualizzaContenutoView")
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