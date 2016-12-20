<?php

namespace AppBundle\Controller\it\unisa\comunicazione;
use AppBundle\it\unisa\comunicazione\GestoreComunicazione;
use AppBundle\it\unisa\comunicazione\Messaggio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ControllerChatGiocatore extends Controller
{


    /**
     * @Route("/comunicazione/giocatore/inviaMessaggio")
     * @Method("POST")
     * @param $richiesta
     */
    public function inviaMessaggio(Request $richiesta){

        $g = new GestoreComunicazione();
        $m = new Messaggio($richiesta->request->get("testo"),
            $richiesta->request->get("username"),$richiesta->request->get("calciatore"),
            $richiesta->request->get("mittente"));
        try{
            $g->inviaMessaggio($m);
            return new Response("Messaggio inviato");
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }


    }

    /**
     * @Route("/comunicazione/giocatore/inviaMessaggioVoce")
     * @Method("POST")
     * @param $richiesta
     */
    public function inviaMessaggioVoce(Request $richiesta){

    }

    /**
     * @Route("/comunicazione/giocatore/ottieniinviaMessaggioForm")
     * @Method("GET")
     */
    public function ottieniMessaggioForm(){

    }


    /**
     * @Route("/comunicazione/giocatore/ottieniMessaggioVoceForm")
     * @Method("GET")
     */
    public function ottieniMessaggioVoceForm(){

    }

    /**
     * @Route("/comunicazione/giocatore/ottieniMessaggioView")
     * @Method("GET")
     */
    public function ottieniMessaggioView(){

    }

    /**
     * @Route("/comunicazione/giocatore/ottieniMessaggioVoceView")
     * @Method("GET")
     */
    public function ottieniMessaggioVoceView(){

    }


}