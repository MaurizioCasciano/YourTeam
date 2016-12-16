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


class ControllerAccount extends Controller
{
    /**
     * @Route("/account/utenteguest/aggiungi",name="aggiungiUtente")
     * @Method("POST")
     */
    public function aggiungiAccount(Request $r)
    {

        $g=new GestoreAccount();
        $a=new Account($r->request->get("u"),
                       $r->request->get("p"),$r->request->get("s"),
                       $r->request->get("e"),$r->request->get("n"),
                       $r->request->get("c"),$r->request->get("d"),
                       $r->request->get("do"),$r->request->get("i"),
                       $r->request->get("pr"), $r->request->get("t"),
                       $r->request->get("im"));
        try{
            $g->aggiungiAccount($a);
            return new Response("inserimento andato a buon fine");
        }catch (\Exception $e){
            return new Response($e->getMessage(),404);
        }

    }
    /**
     * @Route("/account/utenteregistrato/{username}",name="ricercaAccount")
     * @Method("GET")
     */
    public function ricercaAccount($username){
         $g = new GestoreAccount();
        try{
            $a = $g->ricercaAccount($username);
            return new Response("ACC:".$a->getUsername()."appartiene alla squadra".$a->getSquadra());
        }catch (\Exception $e){
            return new Response($e->getMessage(),404);
        }

     }
}