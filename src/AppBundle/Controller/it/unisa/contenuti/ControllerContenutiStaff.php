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
     * @Route("/contenuti/staff/inserisciContenuto")
     * @Method("POST")
     */
    public function inserisciContenuto(Request $richiesta){
        $nome = $richiesta->request->get("nome");
        $descrizione = $richiesta->request->get("descrizione");
        echo $nome." ".$descrizione;
        return new Response();
    }
}