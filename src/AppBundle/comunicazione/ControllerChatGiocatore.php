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
     * @Route("/inviaMessaggio")
     * @Method("POST")
     */
    public function inviaMessaggio(Request $richiesta){


    }

    /**
     * @Route("/inviaMessaggioVoce")
     * @Method("POST")
     */
    public function inviaMessaggioVoce(Request $richiesta){

    }

    /**
     * @Route("/ottieniinviaMessaggioForm")
     * @Method("GET")
     */
    public function ottieniMessaggioForm(){

    }


    /**
     * @Route("/ottieniMessaggioVoceForm")
     * @Method("GET")
     */
    public function ottieniMessaggioVoceForm(){

    }

    /**
     * @Route("/ottieniMessaggioView")
     * @Method("GET")
     */
    public function ottieniMessaggioView(){

    }

    /**
     * @Route("/ottieniMessaggioVoceView")
     * @Method("GET")
     */
    public function ottieniMessaggioVoceView(){

    }


}