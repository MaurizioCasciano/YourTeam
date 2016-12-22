<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 22/12/2016
 * Time: 21:44
 */

namespace AppBundle\it\unisa\statistiche;


abstract class Filtro
{
    public abstract function accept(StatisticheCalciatore $statisticheCalciatore);
}