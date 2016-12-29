<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 26/12/2016
 * Time: 15:26
 */

namespace AppBundle\it\unisa\partite;


interface PartitaInterface
{
    public function getNome();

    public function getData();

    public function getDataString();

    public function getSquadra();

    public function getStadio();
}