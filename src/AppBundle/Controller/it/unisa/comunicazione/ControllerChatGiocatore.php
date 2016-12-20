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
     * @Route("/comunicazione/giocatore/inviaMessaggioVoce")
     * @Method("POST")
     */
    public function inviaMessaggioVoce(Request $richiesta){
        $g=new GestoreComunicazione();
        try{
            $ora=$richiesta->request->get("ora");
            $luogo=$richiesta->request->get("luogo");
            $data=$richiesta->request->get("data_appuntamento");
            $g->inviaMessaggio(new Messaggio("ora:".$ora." luogo:".$luogo." data:".$data,
                                $richiesta->request->get("allenatore"),
                                $richiesta->request->get("calciatore"),"calciatore",time(),"voce"));/*lo invia sempre il calciatore da questa classe*/
            return new Response("messaggio inviato correttamente");
        }catch (\Exception $e){
            return new Response($e->getMessage(), 404);
        }
    }
    /**
     * @Route("/comunicazione/giocatore/inviaMessaggioChat")
     * @Method("POST")
     */
    public function inviaMessaggioChat(Request $richiesta){
        $g=new GestoreComunicazione();
        try{
            $testo=$richiesta->request->get("testo");
            $g->inviaMessaggio(new Messaggio($testo,
                $richiesta->request->get("allenatore"),
                $richiesta->request->get("calciatore"),"calciatore",time(),"chat"));/*lo invia sempre il calciatore da questa classe*/
            return new Response("messaggio inviato correttamente");
        }catch (\Exception $e){
            return new Response($e->getMessage(), 404);
        }
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
/*CHIARAMENTE I MESSAGGI VANNO ORDINATI IN BASE ALLA DATA(DA FARE)*/
    /**
     * @Route("/comunicazione/giocatore/ottieniMessaggioChatView/{contratto_giocatore}")
     * @Method("GET")
     */
    public function ottieniMessaggioChatView($contratto_giocatore){

        $g=new GestoreComunicazione();
        try{
            $messaggi=$g->ottieniMessaggiCalciatore($contratto_giocatore,"chat");
            $str="";
            foreach ($messaggi as $m)
                $str=$str.$m;
            return new Response($str);


        }catch (\Exception $e){
            return new Response($e->getMessage(), 404);
        }
    }

    /**
     * @Route("/comunicazione/giocatore/ottieniMessaggioVoceView/{contratto_giocatore}")
     * @Method("GET")
     */
    public function ottieniMessaggioVoceView($contratto_giocatore){

        $g=new GestoreComunicazione();
        try{
            $messaggi=$g->ottieniMessaggiCalciatore($contratto_giocatore,"voce");
            $str="";
            foreach ($messaggi as $m)
                $str=$str.$m;
            return new Response($str);


        }catch (\Exception $e){
            return new Response($e->getMessage(), 404);
        }
    }


}