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

    public function inviaRichiamoMulta(Request $richiesta){

    }

    public function inviaRichiamoAvvertimento(Request $richiesta){

    }

    public function inviaRichiamoDieta(Request $richiesta){

    }

    public function inviaRichiamoAllenamento(Request $richiesta){

    }

    public function ottieniMessaggioForm(){

    }

    public function ottieniMessaggioVoceForm(){

    }

    public function ottieniRichiamoMultaForm(){

    }

    public function ottieniRichiamoAvvertimentoForm(){

    }

    public function ottieniRichiamoDietaForm(){

    }

    public function ottieniRichiamoAllenamentoForm(){

    }

    public function ottieniMessaggioView(){

    }

    public function ottieniMessaggioVoceView(){

    }

    public function ottieniRichiamoMultaView(){

    }

    public function ottieniRichiamoAvvertimentoView(){

    }

    public function ottieniRichiamoDietaView(){

    }

    public function ottieniRichiamoAllenamentoView(){

    }


}