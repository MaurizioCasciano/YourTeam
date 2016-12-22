<?php

/**
 * Created by PhpStorm.
 * User: luigidurso
 * Date: 15/12/16
 * Time: 09:37
 */



namespace AppBundle\Controller\it\unisa\formazione;

use AppBundle\it\unisa\formazione\ConvocNonDispException;
use AppBundle\it\unisa\formazione\FormazioneNonDispException;
use AppBundle\it\unisa\formazione\GestioneRosa;
use AppBundle\it\unisa\formazione\GestionePartita;
use AppBundle\it\unisa\formazione\PartitaNonDispException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Config\Definition\Exception\Exception;

class ControllerFormazione extends Controller
{
    /**
     * Verifica esistenza partita abilitata alle convocazioni e
     * comunicazione di lista calciatori o
     * messaggio di errore in base alla disponibilità della partita.
     *
     * @Route("/formazione/allenatore/verificaConvocazioni")
     * @Method("GET")
     */
    public function verificaConvocazioniVista()
    {
        if(isset($_SESSION))
        {
            $gestionePartita=new GestionePartita();
            $gestoreRosa=new GestioneRosa();

            try
            {
                $squadra=$_SESSION["squadra"];

                $partita=$gestionePartita->disponibilitaConvocazione($squadra);
                $calciatori=$gestoreRosa->visualizzaRosa($squadra);

                $_SESSION["partita"]=$partita;

                return new Response(var_dump($calciatori)." convocati per la partita: ".var_dump($partita)); //in attesa della view della lista calciatori

            }
            catch (PartitaNonDispException $e1)
            {
                return new Response($e1->messaggioDiErrore());
            }
            catch (ConvocNonDispException $e2)
            {
                return new Response($e2->messaggioDiErrore());
            }
        }
        else
        {
            return new Response("devi effettuare prima l accesso!");
        }
    }

    /**
     * Verifica esistenza partita abilitata alla formazione  e
     * comunicazione della schermata di selezione tattica o
     * messaggio di errore in base alla disponibilità della partita.
     *
     * @Route("/formazione/allenatore/verificaFormazione")
     * @Method("GET")
     */
    public function verificaFormazioneVista()
    {
        if(isset($_SESSION))
        {
            $gestionePartita=new GestionePartita();

            try
            {
                $squadra=$_SESSION["squadra"];

                $partita=$gestionePartita->disponibilitaFormazione($squadra);

                $_SESSION["partita"]=$partita;

                return new Response(var_dump($partita)." per questa partita selezioneremo tattica e formazione"); //in attesa della view della selezione tattica

            }
            catch (PartitaNonDispException $e1)
            {
                return new Response($e1->messaggioDiErrore());
            }
            catch (FormazioneNonDispException $e2)
            {
                return new Response($e2->messaggioDiErrore());
            }
        }
        else
        {
            return new Response("devi effettuare prima l accesso!");
        }



    }

    /**
     * Acquisizione in input delle convocazioni scelte e
     * scrittura su database delle scelte effettuate.
     *
     * @Route("/formazione/allenatore/controlConvocazioni")
     * @Method("POST")
     * @param Request $r
     */
    public function controlConvocazioniVista(Request $r)
    {
        $convocazioni=$r->get("calciatori"); //elenco id calciatori convocati

        if(!is_null($convocazioni))
        {
            $partita=$_SESSION["partita"];
            if(!is_null($partita))
            {
                $gestionePartita=new GestionePartita();

                $gestionePartita->diramaConvocazioni($convocazioni,$partita);

                return new Response("convocazioni diramate!");
            }

        }

        return new Response("nessun calciatore trovato!");

    }

    /**
     * Acquisizione in input della formazione scelta e
     * notifica ai calciatori via email.
     *
     * @Route("/formazione/allenatore/schieraFormazione")
     * @Method("POST")
     * @param Request $r
     */
    public function schieraFormazioneVista(Request  $r)
    {

        $calciatori=$r->get("calciatori");
        $tattica=$r->get("modulo");

        $gestionePartita=new GestionePartita();

        $gestionePartita->scritturaModulo($_SESSION["partita"],$tattica);

        $calciatori=json_decode($calciatori);

        $gestoreRosa=new GestioneRosa();

        $gestoreRosa->inviaEmailSchieramentoFormazione($calciatori);

        return new JsonResponse(array("risposta" => "ok"));
    }

    /**
     * Questo controller rimanda in risposta l'elenco delle tattiche presenti nel database
     *
     * @Route("/formazione/allenatore/ottieniTattiche")
     * @Method("GET")
     */
    public function ottieniTattiche()
    {
        $gestioneRosa=new GestioneRosa();

        $tattiche=$gestioneRosa->visualizzaTattica();

        $tattiche=json_encode($tattiche);

        return new JsonResponse(array("tattiche" => $tattiche));

    }

    /**
     * Questo controller rimanda l'elenco dei calciatori convocati per quella partita
     *
     * @Route("/formazione/allenatore/ottieniCalciatori")
     * @Method("GET")
     */
    public function ottieniCalciatori()
    {
        $gestioneRosa=new GestioneRosa();

        $partita=$_SESSION["partita"];

        $calciatori=$gestioneRosa->ottieniConvocati($partita);

        return new JsonResponse(array("calciatori" => $calciatori));
    }

    /**
     * Questo controller rimanda un modulo serializzato quando l'allenatore ne seleziona uno
     *
     * @Route("/formazione/allenatore/cambiaTattica/{tattica}")
     * @Method("GET")
     */
    public function cambiaTattica($tattica)
    {

    }


}
