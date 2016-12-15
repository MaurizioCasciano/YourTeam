<?php
/**
 * Created by PhpStorm.
 * User: Donato
 * Date: 14/12/2016
 * Time: 16:37
 */

namespace AppBundle\comunicazione;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ControllerChatAllenatore extends Controller
{

    /**
     * @Route("/inviaMessaggio")
     * @Method("POST")
     */
    public function inviaMessaggio(Request $richiesta){

    }

    /**
     * @Route("/inviaMessaggioVoce)
     * @Method("POST")
     */
    public function inviaMessaggioVoce(Request $richiesta){

    }

    /**
     * @Route("/inviaRichiamoMulta")
     * @Method("POST")
     */
    public function inviaRichiamoMulta(Request $richiesta){

    }

    /**
     * @Route("/inviaRichiamoAvvertimento")
     * @Method("POST")
     */
    public function inviaRichiamoAvvertimento(Request $richiesta){

    }

    /**
     * @Route("/inviaRichiamoDieta")
     * @Method("POST")
     */
    public function inviaRichiamoDieta(Request $richiesta){

    }

    /**
     * @Route("/inviaRichiamoAllenamento")
     * @Method("POST")
     */
    public function inviaRichiamoAllenamento(Request $richiesta){

    }

    /**
     * @Route("/ottieniMessaggioForm")
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
     * @Route("/ottieniRichiamoMultaForm")
     * @Method("GET")
     */
    public function ottieniRichiamoMultaForm(){

    }

    /**
     * @Route("/ottieniRichiamoAvvertimentoForm")
     * @Method("GET")
     */
    public function ottieniRichiamoAvvertimentoForm(){

    }

    /**
     * @Route("/ottieniRichiamoDietaForm")
     * @Method("GET")
     */
    public function ottieniRichiamoDietaForm(){

    }

    /**
     * @Route("/ottieniRichiamoAllenamentoForm")
     * @Method("GET")
     */
    public function ottieniRichiamoAllenamentoForm(){

    }

    /**
     * @Route("/ottieniMessaggioView")
     * @Method("GET")
     */
    public function ottieniMessaggioView(){

    }

    /**
     * @Route("/ottieniRichiamoVoceView")
     * @Method("GET")
     */
    public function ottieniMessaggioVoceView(){

    }

    /**
     * @Route("/ottieniRichiamoMultaView")
     * @Method("GET")
     */
    public function ottieniRichiamoMultaView(){

    }

    /**
     * @Route("/ottieniRichiamoAvvertimentoView")
     * @Method("GET")
     */
    public function ottieniRichiamoAvvertimentoView(){

    }

    /**
     * @Route("/ottieniRichiamoDietaView")
     * @Method("GET")
     */
    public function ottieniRichiamoDietaView(){

    }

    /**
     * @Route("/ottieniRichiamoAllenamentoView")
     * @Method("GET")
     */
    public function ottieniRichiamoAllenamentoView(){

    }


}