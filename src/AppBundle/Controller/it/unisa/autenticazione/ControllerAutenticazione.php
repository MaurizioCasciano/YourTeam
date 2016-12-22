<?php

/**
 * Created by PhpStorm.
 * User: Raffaele
 * Date: 16/12/2016
 * Time: 09:09
 */
namespace AppBundle\Controller\it\unisa\autenticazione;


use AppBundle\it\unisa\autenticazione\GestoreAutenticazione;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;





class ControllerAutenticazione extends Controller
{


    /**
     * @Route("/login",name="login")
     * @Method("POST")
     */
    public function login(Request $richiesta)
    {
        $u=$richiesta->request->get("u");
        $p=$richiesta->request->get("p");
        $g=new GestoreAutenticazione();
        $r=$g->login($u,$p);
        if($r)
            return new Response("login effettuato".$_SESSION["squadra"]);
        else
            return new Response("non hai i permessi");

    }

    /**
     * @Route("/",name="home")
     * @Method("GET")
     */
    public function home()
    {

        return $this->render("guest/home.html.twig");

    }

}