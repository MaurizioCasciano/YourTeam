<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 20/12/2016
 * Time: 17:24
 */

namespace AppBundle\it\unisa\statistiche;


class FiltroStatisticheCalciatore
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


    public function accept(DettagliCalciatore $object)
    {
        if ($object->getTiriTotali() >= $this->minTiriTotali && $object->getTiriTotali() <= $this->maxTiriTotali) {
            if ($object->getTiriPorta() >= $this->minTiriPorta && $object->getTiriPorta() <= $this->maxTiriPorta) {
                if ($object->getGolFatti() >= $this->minGolFatti && $object->getGolFatti() <= $this->maxTiriPorta) {
                    if ($object->getAssist() >= $this->minAssist && $object->getAssist() <= $this->maxAssist) {
                        if ($object->getFalliFatti() >= $this->minFalliFatti && $object->getFalliFatti() <= $this->maxFalliFatti) {
                            if ($object->getFalliSubiti() >= $this->minFalliSubiti && $object->getFalliSubiti() <= $this->maxFalliSubiti) {
                                if ($object->getPercentualPassaggiRiusciti() >= $this->minPercentualePassaggiRiusciti && $object->getPercentualPassaggiRiusciti() <= $this->maxPercentualePassaggiRiusciti) {
                                    if ($object->getAmmonizioni() >= $this->minAmmonizioni && $object->getAmmonizioni() <= $this->maxAmmonizioni) {
                                        if ($object->getEspulsioni() >= $this->minEspulsioni && $object->getEspulsioni() <= $this->maxEspulsioni) {
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
        return true;//TESTING
        //return false;
    }
}