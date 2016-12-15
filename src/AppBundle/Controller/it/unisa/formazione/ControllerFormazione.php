<?php

/**
 * Created by PhpStorm.
 * User: luigidurso
 * Date: 15/12/16
 * Time: 09:37
 */



namespace AppBundle\Controller\it\unisa\formazione;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

    }

    /**
     * Elenco calciatori della propria rosa per ruolo selezionato.
     *
     * @Route("/formazione/allenatore/elencoCalciatori/{ruolo}")
     * @Method("GET")
     */
    public function elencoCalciatoriRuolo($ruolo)
    {

    }





}
