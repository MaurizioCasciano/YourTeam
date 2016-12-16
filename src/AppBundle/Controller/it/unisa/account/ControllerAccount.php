<?php

/**
 * Created by PhpStorm.
 * User: Raffaele
 * Date: 16/12/2016
 * Time: 09:09
 */
namespace AppBundle\Controller\it\unisa\account;

use \AppBundle\it\unisa\account\GestoreAccount;
use \AppBundle\it\unisa\account\Account;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/*Aggiungere  i controller per :
    aggiungiAccount_G
    eliminaAccount_G
    ricercaAcount_G
    modificaAccount_G
    getAccount_A_T_S
    getAccount_G
    e chiaramente quelli per visualizzare le schermate*/

class ControllerAccount extends Controller
{
    /**
     * @Route("/account/Allenatore_Tifoso_Staff/aggiungi",name="aggiungiUtente")
     * @Method("POST")
     */
    public function aggiungiAccount_A_T_S(Request $r)
    {

        $g = new GestoreAccount();
        $a = new Account($r->request->get("u"),
            $r->request->get("p"),
            $r->request->get("s"),
            $r->request->get("e"), $r->request->get("n"),
            $r->request->get("c"), $r->request->get("d"),
            $r->request->get("do"), $r->request->get("i"),
            $r->request->get("pr"), $r->request->get("t"),
            $r->request->get("im"), $r->request->get("tipo"));
        try {
            $g->aggiungiAccount_A_T_S($a);
            return new Response("inserimento andato a buon fine");
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }

    }

    /**
     * @Route("/account/Allenatore_Tifoso_Staff/{username}",name="ricercaAccount")
     * @Method("GET")
     */
    public function ricercaAccount_A_T_S($username)
    {
        $g = new GestoreAccount();
        try {
            $a = $g->ricercaAccount_A_T_S($username);
            return new Response("ACC:" . $a->getUsernameCodiceContratto() . "appartiene alla squadra" . $a->getSquadra());
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }

    }

    /**
     * @Route("/account/Allenatore_Tifoso_Staff/modifica",name="modificaUtente")
     * @Method("POST")
     */
    public function modificaAccount_A_T_S(Request $r)
    {
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

    /**
     * @Route("/account/Allenatore_Tifoso_Staff/elimina/{username}",name="eliminaAccount")
     * @Method("GET")
     */
    public function eliminaAccount_A_T_S($username)
    {
        $g = new GestoreAccount();
        try {
            $a = $g->eliminaAccount_A_T_S($username);
            return new Response("ACC:" . $username . "eliminato");
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }

    }

    /**
     * @Route("/account/Staff/convalida",name="convalidaAccount")
     * @Method("POST")
     */
    public function convalidaAccount_A_T_S(Request $request)
    {
        $g = new GestoreAccount();
        try {
            $a = $g->convalidaAccount_A_G($request->request->get("u"));
            return new Response("account convalidato");
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }

    }

}