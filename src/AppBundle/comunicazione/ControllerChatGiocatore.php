<?php

namespace AppBundle\comunicazione;

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