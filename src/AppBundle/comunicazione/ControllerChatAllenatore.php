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
     * @Route("/comunicazione/allenatore/inviaMessaggio")
     * @Method("POST")
     * @param $richiesta
     */
    public function inviaMessaggio(Request $richiesta){

    }

    /**
     * @Route("/comunicazione/allenatore/inviaMessaggioVoce)
     * @Method("POST")
     * @param $richiesta
     */
    public function inviaMessaggioVoce(Request $richiesta){

    }

    /**
     * @Route("/comunicazione/allenatore/inviaRichiamoMulta")
     * @Method("POST")
     * @param $richiesta
     */
    public function inviaRichiamoMulta(Request $richiesta){

    }

    /**
     * @Route("/comunicazione/allenatore/inviaRichiamoAvvertimento")
     * @Method("POST")
     * @param $richiesta
     */
    public function inviaRichiamoAvvertimento(Request $richiesta){

    }

    /**
     * @Route("/comunicazione/allenatore/inviaRichiamoDieta")
     * @Method("POST")
     * @param $richiesta
     */
    public function inviaRichiamoDieta(Request $richiesta){

    }

    /**
     * @Route("/comunicazione/allenatore/inviaRichiamoAllenamento")
     * @Method("POST")
     * @param $richiesta
     */
    public function inviaRichiamoAllenamento(Request $richiesta){

    }

    /**
     * @Route("/comunicazione/allenatore/ottieniMessaggioForm")
     * @Method("GET")
     */
    public function ottieniMessaggioForm(){

    }

    /**
     * @Route("/comunicazione/allenatore/ottieniMessaggioVoceForm")
     * @Method("GET")
     */
    public function ottieniMessaggioVoceForm(){

    }

    /**
     * @Route("/comunicazione/allenatore/ottieniRichiamoMultaForm")
     * @Method("GET")
     */
    public function ottieniRichiamoMultaForm(){

    }

    /**
     * @Route("/comunicazione/allenatore/ottieniRichiamoAvvertimentoForm")
     * @Method("GET")
     */
    public function ottieniRichiamoAvvertimentoForm(){

    }

    /**
     * @Route("/comunicazione/allenatore/ottieniRichiamoDietaForm")
     * @Method("GET")
     */
    public function ottieniRichiamoDietaForm(){

    }

    /**
     * @Route("/comunicazione/allenatore/ottieniRichiamoAllenamentoForm")
     * @Method("GET")
     */
    public function ottieniRichiamoAllenamentoForm(){

    }

    /**
     * @Route("/comunicazione/allenatore/ottieniMessaggioView")
     * @Method("GET")
     */
    public function ottieniMessaggioView(){

    }

    /**
     * @Route("/comunicazione/allenatore/ottieniRichiamoVoceView")
     * @Method("GET")
     */
    public function ottieniMessaggioVoceView(){

    }

    /**
     * @Route("/comunicazione/allenatore/ottieniRichiamoMultaView")
     * @Method("GET")
     */
    public function ottieniRichiamoMultaView(){

    }

    /**
     * @Route("/comunicazione/allenatore/ottieniRichiamoAvvertimentoView")
     * @Method("GET")
     */
    public function ottieniRichiamoAvvertimentoView(){

    }

    /**
     * @Route("/comunicazione/allenatore/ottieniRichiamoDietaView")
     * @Method("GET")
     */
    public function ottieniRichiamoDietaView(){

    }

    /**
     * @Route("/comunicazione/allenatore/ottieniRichiamoAllenamentoView")
     * @Method("GET")
     */
    public function ottieniRichiamoAllenamentoView(){

    }


}