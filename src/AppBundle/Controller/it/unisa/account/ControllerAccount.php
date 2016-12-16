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


class ControllerAccount //extends Controller
{

/* @Route("/account/utenteguest/aggiungi",name="aggiungiUtente")
* @Method("POST")
*/
    public function aggiungiAccount()
    {

        //$g=new GestoreAccount();
       //($username, $password, $squadra, $email, $nome, $cognome, $dataDiNascita, $domicilio, $indirizzo, $provincia, $telefono, $immagine)

        //$a=new Account($request->r);



    }
        /*if(!isset($_SESSION)){
            $manager = new ManagerUser();
            $utente = new User();
            $utente->setEmail($request->request->get("email"));
            $utente->setPassword($request->request->get("password"));
            $ris = $manager->registrazione($utente,$request->request->get("nomeSquadra"));
            if($ris != FALSE){
                return new Response("Registrazione avvenuta con successo");
            } else {
                return new Response("Problemi con la registrazione",404);
            }
        } else {
            return new Response("Non puoi registrare più di una squadra",404);
        }
    }
*/
}