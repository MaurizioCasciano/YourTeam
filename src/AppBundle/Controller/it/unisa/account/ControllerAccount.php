<?php

/**
 * Created by PhpStorm.
 * User: Raffaele
 * Date: 16/12/2016
 * Time: 09:09
 */
namespace AppBundle\Controller\it\unisa\account;

use AppBundle\it\unisa\account\AccountCalciatore;
use AppBundle\it\unisa\account\Calciatore;
use \AppBundle\it\unisa\account\GestoreAccount;
use \AppBundle\it\unisa\account\Account;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;



/*Aggiungere  i controller per :

    aggiungere le altre viste
    e chiaramente quelli per visualizzare le schermate*/

class ControllerAccount extends Controller
{


    /**
     * @Route("/account/{attore}/formaggiungi",name="formAggiungiAccount")
     * @Method("GET")
     */
    /*attore potrà essere:
       -calciatore
       -staff_allenatore_tifoso
   */
    public function aggiungiAccountForm($attore)
    {
        if($attore=="staff_allenatore_tifoso")
                return $this->render("guest/registrazione.html.twig");/*vista non completa*/
        else
            return new Response("da fare");

    }
    /**
     * @Route("/account/{attore}/aggiungi",name="aggiungiAccount")
     * @Method("POST")
     */
    /*attore potrà essere:
        -calciatore
        -staff_allenatore_tifoso
    */
    public function aggiungiAccount(Request $r,$attore)
    {

        if($attore=="staff_allenatore_tifoso"){
            $g = new GestoreAccount();
            $a = new Account($r->request->get("u"),
                $r->request->get("p"),
                $r->request->get("s"),
                $r->request->get("e"), $r->request->get("n"),
                $r->request->get("c"), $r->request->get("d"),
                $r->request->get("do"), $r->request->get("i"),
                $r->request->get("pr"), $r->request->get("t"),
                $r->request->get("im"), $r->request->get("tipo"));
            $validator=$this->get("validator");
            $e=$validator->validate($a);
            if(count($e)>0)
                return new Response((string)$e,404);
            try {
                $g->aggiungiAccount_A_T_S($a);
                return new Response("inserimento andato a buon fine");
            } catch (\Exception $e) {
                return new Response($e->getMessage(), 404);
            }
        }
        else
            if($attore=="calciatore") {
                $g = new GestoreAccount();
                $a = new Calciatore($r->request->get("u"),
                    $r->request->get("p"),
                    $r->request->get("s"),
                    $r->request->get("e"), $r->request->get("n"),
                    $r->request->get("c"), $r->request->get("d"),
                    $r->request->get("do"), $r->request->get("i"),
                    $r->request->get("pr"), $r->request->get("t"),
                    $r->request->get("im"), $r->request->get("nazionalita"));
                try {
                    $g->aggiungiAccount_C($a);
                    return new Response("inserimento andato a buon fine");
                } catch (\Exception $e) {
                    return new Response($e->getMessage(), 404);
                }
        }
        else return new Response("la rotta non esiste",404);

    }

    /**
     * @Route("/account/all/ricerca",name="ricercaAccountForm")
     * @Method("GET")
     */
    public function ricercaAccountVista($attore)
    {

        /*vista non completa*/
        return $this->render("account/ricercaAccount.html.twig");

    }
    /**
     * @Route("/account/{attore}/{username}",name="ricercaAccount")
     * @Method("GET")
     */
    /*attore potrà essere:
        -calciatore
        -staff_allenatore_tifoso
    */
    public function ricercaAccount($attore,$username)
    {
        $g = new GestoreAccount();
        if($attore=="staff_allenatore_tifoso"){
            try {
                $a = $g->ricercaAccount_A_T_S($username);
                return new Response("ACC:" . $a->getUsernameCodiceContratto() . "appartiene alla squadra" . $a->getSquadra());
            } catch (\Exception $e) {
                return new Response($e->getMessage(), 404);
            }
        }
        else return new Response("da fare",404);


    }

    /**
     * @Route("/account/{attore}/modifica",name="modificaUtente")
     * @Method("POST")
     */
    /*attore potrà essere:
       -calciatore
       -staff_allenatore_tifoso
   */
    public function modificaAccount(Request $r,$attore)
    {
        if($attore=="staff_allenatore_tifoso"){
            /*il tipo e la squadra non possono essere modificati quindi non glieli inviamo proprio non devono */
            $g = new GestoreAccount();
            $a = new Account($r->request->get("u"),
                $r->request->get("p"), "",
                $r->request->get("e"), $r->request->get("n"),
                $r->request->get("c"), $r->request->get("d"),
                $r->request->get("do"), $r->request->get("i"),
                $r->request->get("pr"), $r->request->get("t"),
                $r->request->get("im"), "");

            try {
                $g->modificaAccount_A_T_S($r->request->get("u"), $a);
                return new Response("modifica andata a buon fine");
            } catch (\Exception $e) {
                return new Response($e->getMessage(), 404);
            }
        }
        else return new Response("ancora da fare",404);


    }

    /**
     * @Route("/account/{attore}/elimina/{username}",name="eliminaAccount")
     * @Method("GET")
     */
    /*attore potrà essere:
        -calciatore
        -staff_allenatore_tifoso
    */
    public function eliminaAccount($username,$attore)
    {
        if($attore=="staff_allenatore_tifoso"){
            $g = new GestoreAccount();
            try {
                $a = $g->eliminaAccount_A_T_S($username);
                return new Response("ACC:" . $username . "eliminato");
            } catch (\Exception $e) {
                return new Response($e->getMessage(), 404);
            }
        }
        else return new Response("ancora da fare",404);


    }

    /**
     * @Route("/account/Staff/convalida",name="convalidaAccount")
     * @Method("POST")
     */
    public function convalidaAccount(Request $request)
    {
        $g = new GestoreAccount();
        try {
            $g->convalidaAccount_A_G($request->request->get("u"));
            return new Response("account convalidato");
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }

    }

}