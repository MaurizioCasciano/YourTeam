<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 26/12/2016
 * Time: 15:26
 */

namespace AppBundle\it\unisa\partite;


use AppBundle\it\unisa\statistiche\StatistichePartita;

interface PartitaInterface
{
    public function getNome();

    public function getCasa();

    public function getTrasferta();

    public function getData();

    public function getDataString();

    public function getDataSenzaOra();

    public function getOra();

    public function getSquadra();

    public function getStadio();

    public function hasStatistiche();

    public function getStatistiche(): StatistichePartita;
}