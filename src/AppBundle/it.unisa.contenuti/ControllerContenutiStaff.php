<?php

/**
 * Created by PhpStorm.
 * User: Carmine
 * Date: 14/12/2016
 * Time: 15:37
 */

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        $nome = $richiesta->request->get("nome");
        $descrizione = $richiesta->request->get("descrizione");
        echo nome." ".descrizione;
        return new Response();
    }
}