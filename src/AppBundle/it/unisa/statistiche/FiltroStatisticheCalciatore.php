<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 20/12/2016
 * Time: 17:24
 */

namespace AppBundle\it\unisa\statistiche;


class FiltroStatisticheCalciatore extends Filtro
{
    //MIN
    private $minTiriTotali;
    private $minTiriPorta;
    private $minGolFatti;
    private $minAssist;
    private $minFalliFatti;
    private $minFalliSubiti;
    private $minPercentualePassaggiRiusciti;
    private $minAmmonizioni;
    private $minEspulsioni;

    //MAX
    private $maxTiriTotali;
    private $maxTiriPorta;
    private $maxGolFatti;
    private $maxAssist;
    private $maxFalliFatti;
    private $maxFalliSubiti;
    private $maxPercentualePassaggiRiusciti;
    private $maxAmmonizioni;
    private $maxEspulsioni;

    /**
     * FiltroStatisticheCalciatore constructor.
     * @param $minTiriTotali
     * @param $minTiriPorta
     * @param $minGolFatti
     * @param $minAssist
     * @param $minFalliFatti
     * @param $minFalliSubiti
     * @param $minPercentualePassaggiRiusciti
     * @param $minAmmonizioni
     * @param $minEspulsioni
     * @param $maxTiriTotali
     * @param $maxTiriPorta
     * @param $maxGolFatti
     * @param $maxAssist
     * @param $maxFalliFatti
     * @param $maxFalliSubiti
     * @param $maxPercentualePassaggiRiusciti
     * @param $maxAmmonizioni
     * @param $maxEspulsioni
     */
    public function __construct($minTiriTotali, $minTiriPorta, $minGolFatti, $minAssist, $minFalliFatti, $minFalliSubiti, $minPercentualePassaggiRiusciti, $minAmmonizioni, $minEspulsioni, $maxTiriTotali, $maxTiriPorta, $maxGolFatti, $maxAssist, $maxFalliFatti, $maxFalliSubiti, $maxPercentualePassaggiRiusciti, $maxAmmonizioni, $maxEspulsioni)
    {
        $this->minTiriTotali = $minTiriTotali;
        $this->minTiriPorta = $minTiriPorta;
        $this->minGolFatti = $minGolFatti;
        $this->minAssist = $minAssist;
        $this->minFalliFatti = $minFalliFatti;
        $this->minFalliSubiti = $minFalliSubiti;
        $this->minPercentualePassaggiRiusciti = $minPercentualePassaggiRiusciti;
        $this->minAmmonizioni = $minAmmonizioni;
        $this->minEspulsioni = $minEspulsioni;
        $this->maxTiriTotali = $maxTiriTotali;
        $this->maxTiriPorta = $maxTiriPorta;
        $this->maxGolFatti = $maxGolFatti;
        $this->maxAssist = $maxAssist;
        $this->maxFalliFatti = $maxFalliFatti;
        $this->maxFalliSubiti = $maxFalliSubiti;
        $this->maxPercentualePassaggiRiusciti = $maxPercentualePassaggiRiusciti;
        $this->maxAmmonizioni = $maxAmmonizioni;
        $this->maxEspulsioni = $maxEspulsioni;
    }


    public function accept(StatisticheCalciatore $stats)
    {
        if ($stats->getTiriTotali() >= $this->minTiriTotali && $stats->getTiriTotali() <= $this->maxTiriTotali) {
            if ($stats->getTiriPorta() >= $this->minTiriPorta && $stats->getTiriPorta() <= $this->maxTiriPorta) {
                if ($stats->getGolFatti() >= $this->minGolFatti && $stats->getGolFatti() <= $this->maxTiriPorta) {
                    if ($stats->getAssist() >= $this->minAssist && $stats->getAssist() <= $this->maxAssist) {
                        if ($stats->getFalliFatti() >= $this->minFalliFatti && $stats->getFalliFatti() <= $this->maxFalliFatti) {
                            if ($stats->getFalliSubiti() >= $this->minFalliSubiti && $stats->getFalliSubiti() <= $this->maxFalliSubiti) {
                                if ($stats->getPercentualPassaggiRiusciti() >= $this->minPercentualePassaggiRiusciti && $stats->getPercentualPassaggiRiusciti() <= $this->maxPercentualePassaggiRiusciti) {
                                    if ($stats->getAmmonizioni() >= $this->minAmmonizioni && $stats->getAmmonizioni() <= $this->maxAmmonizioni) {
                                        if ($stats->getEspulsioni() >= $this->minEspulsioni && $stats->getEspulsioni() <= $this->maxEspulsioni) {
                                            /*
                                             * La condizione è soddisfatta.
                                             */
                                            return true;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        //return true;//TESTING
        return false;
    }
}