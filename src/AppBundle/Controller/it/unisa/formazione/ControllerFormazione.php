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
     * @Route("/formazione/allenatore/verificaConvocazioni", name="verificaConvocazioni", name="verificaConvocazioni")
     * @Method("GET")
     */
    public function verificaConvocazioniVista()
    {
        if (isset($_SESSION)) {
            $gestionePartita = GestionePartita::getInstance();
            $gestoreRosa = GestioneRosa::getInstance();

            try {
                $squadra = $_SESSION["squadra"];

                $partita = $gestionePartita->disponibilitaConvocazione($squadra);
                $calciatori = $gestoreRosa->visualizzaRosa($squadra);

                $_SESSION["partita"] = $partita;

                return $this->render("allenatore/visualizzaCalciatoriConvocazione.html.twig", array('calciatori' => $calciatori, 'partita' => $partita));


            } catch (PartitaNonDispException $e1) {
                return $this->render("allenatore/visualizzaRisposta.html.twig", array('messaggio' => $e1->messaggioDiErrore()));
            } catch (ConvocNonDispException $e2) {
                return $this->render("allenatore/visualizzaRisposta.html.twig", array('messaggio' => $e2->messaggioDiErrore()));
            }
        } else {
            return $this->render("allenatore/visualizzaRisposta.html.twig", array('messaggio' => "devi effettuare prima l accesso!"));
        }
    }

    /**
     * Verifica esistenza partita abilitata alla formazione  e
     * comunicazione della schermata di selezione tattica o
     * messaggio di errore in base alla disponibilità della partita.
     *
     * @Route("/formazione/allenatore/verificaFormazione", name="verificaFormazione")
     * @Method("GET")
     */
    public function verificaFormazioneVista()
    {
        if (isset($_SESSION)) {
            $gestionePartita = GestionePartita::getInstance();

            try {
                $squadra = $_SESSION["squadra"];

                $partita = $gestionePartita->disponibilitaFormazione($squadra);

                $gestioneRosa = GestioneRosa::getInstance();

                $tattiche = $gestioneRosa->visualizzaTattica();

                $_SESSION["partita"] = $partita;

                return $this->render("allenatore/visualizzaTatticaFormazione.html.twig", array('partita' => $partita, 'tattiche' => $tattiche));


            } catch (PartitaNonDispException $e1) {
                return $this->render("allenatore/visualizzaRisposta.html.twig", array('messaggio' => $e1->messaggioDiErrore()));

            } catch (FormazioneNonDispException $e2) {
                return $this->render("allenatore/visualizzaRisposta.html.twig", array('messaggio' => $e2->messaggioDiErrore()));

            } catch (Exception $e) {
                return $this->render("allenatore/visualizzaRisposta.html.twig", array('messaggio' => $e->getMessage()));

            }

        } else {
            return $this->render("allenatore/visualizzaRisposta.html.twig", array('messaggio' => "devi effettuare prima l accesso!"));
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
        $convocazioni = $r->get("calciatori"); //elenco id calciatori convocati

        if (!is_null($convocazioni)) {
            $partita = $_SESSION["partita"];
            if (!is_null($partita)) {
                $gestionePartita = GestionePartita::getInstance();

                $gestionePartita->diramaConvocazioni($convocazioni, $partita);

                return $this->render("allenatore/visualizzaRisposta.html.twig", array('messaggio' => "convocazioni diramate!"));

            }

        }

        return $this->render("allenatore/visualizzaRisposta.html.twig", array('messaggio' => "nessun calciatore convocato !"));

    }

    /**
     * Acquisizione in input della formazione scelta e
     * notifica ai calciatori via email.
     *
     * @Route("/formazione/allenatore/schieraFormazione")
     * @Method("POST")
     * @param Request $r
     */
    public function schieraFormazioneVista(Request $r)
    {

        $calciatori = $r->get("calciatori");
        $tattica = $r->get("modulo");

        $gestionePartita = GestionePartita::getInstance();

        $gestionePartita->scritturaModulo($_SESSION["partita"], $tattica);

        $calciatori = json_decode($calciatori);

        $gestoreRosa = GestioneRosa::getInstance();

        try {
            $gestoreRosa->inviaEmailSchieramentoFormazione($calciatori);
        } catch (Exception $e1) {
            return new Response("email non inviate!");
        }

        return new Response("email inviate!");
    }

    /**
     * Questo controller rimanda l'elenco dei calciatori convocati per quella partita
     *
     * @Route("/formazione/allenatore/ottieniCalciatori")
     * @Method("GET")
     */
    public function ottieniCalciatori()
    {
        try {
            $gestioneRosa = GestioneRosa::getInstance();

            $partita = $_SESSION["partita"];

            $calciatori = $gestioneRosa->ottieniConvocati($partita);

        } catch (Exception $e1) {
            return new Response($e1->getMessage());
        }


        return new JsonResponse(array("calciatori" => $calciatori));
    }

    /**
     * Questo controller rimanda un modulo serializzato quando l'allenatore ne seleziona uno
     *
     * @Route("/formazione/allenatore/cambiaTattica")
     * @Method("GET")
     */
    public function cambiaTattica()
    {
        $gestioneRosa = GestioneRosa::getInstance();

        $moduli = $gestioneRosa->visualizzaTattica();
        foreach ($moduli as $schieramento) {
            $modulo[] = $gestioneRosa->ottieniTattica($schieramento);
        }

        return new JsonResponse(array("modulo" => $modulo));

    }


}
