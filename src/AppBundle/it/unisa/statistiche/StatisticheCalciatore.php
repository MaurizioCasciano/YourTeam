<?php
namespace AppBundle\it\unisa\statistiche;
/**
 * Questa classe rappresenta le statistiche di un calciatore.
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 14/12/2016
 * Time: 18:45
 */
class StatisticheCalciatore
{
    private $usernameCalciatore;
    private $tiriTotali;
    private $tiriPorta;
    private $falliFatti;
    private $falliSubiti;
    private $percentualePassaggiRiusciti;
    private $golFatti;
    private $golSubiti;
    private $assist;
    private $ammonizioni;
    private $espulsioni;
    private $partiteGiocate;

    /**
     * StatisticheCalciatore constructor.
     * @param $usernameCalciatore
     * @param $tiriTotali
     * @param $tiriPorta
     * @param $falliFatti
     * @param $falliSubiti
     * @param $percentualPassaggiRiusciti
     * @param $golFatti
     * @param $golSubiti
     * @param $assist
     * @param $ammonizioni
     * @param $espulsioni
     * @param $partiteGiocate
     */
    public function __construct($usernameCalciatore, $tiriTotali, $tiriPorta, $falliCommessi, $falliSubiti, $percentualPassaggiRiusciti, $golFatti, $golSubiti, $assist, $ammonizioni, $espulsioni, $partiteGiocate)
    {
        $this->usernameCalciatore = $usernameCalciatore;
        $this->tiriTotali = $tiriTotali;
        $this->tiriPorta = $tiriPorta;
        $this->falliFatti = $falliCommessi;
        $this->falliSubiti = $falliSubiti;
        $this->percentualePassaggiRiusciti = $percentualPassaggiRiusciti;
        $this->golFatti = $golFatti;
        $this->golSubiti = $golSubiti;
        $this->assist = $assist;
        $this->ammonizioni = $ammonizioni;
        $this->espulsioni = $espulsioni;
        $this->partiteGiocate = $partiteGiocate;
    }


    /**
     * @return mixed
     */
    public function getUsernameCalciatore()
    {
        return $this->usernameCalciatore;
    }

    /**
     * @param mixed $usernameCalciatore
     */
    public function setUsernameCalciatore($usernameCalciatore)
    {
        $this->usernameCalciatore = $usernameCalciatore;
    }

    /**
     * @return mixed
     */
    public function getTiriTotali()
    {
        return $this->tiriTotali;
    }

    /**
     * @param mixed $tiriTotali
     */
    public function setTiriTotali($tiriTotali)
    {
        $this->tiriTotali = $tiriTotali;
    }

    /**
     * @return mixed
     */
    public function getTiriPorta()
    {
        return $this->tiriPorta;
    }

    /**
     * @param mixed $tiriPorta
     */
    public function setTiriPorta($tiriPorta)
    {
        $this->tiriPorta = $tiriPorta;
    }

    /**
     * @return mixed
     */
    public function getFalliFatti()
    {
        return $this->falliFatti;
    }

    /**
     * @param mixed $falliFatti
     */
    public function setFalliFatti($falliFatti)
    {
        $this->falliFatti = $falliFatti;
    }

    /**
     * @return mixed
     */
    public function getFalliSubiti()
    {
        return $this->falliSubiti;
    }

    /**
     * @param mixed $falliSubiti
     */
    public function setFalliSubiti($falliSubiti)
    {
        $this->falliSubiti = $falliSubiti;
    }

    /**
     * @return mixed
     */
    public function getPercentualePassaggiRiusciti()
    {
        return $this->percentualePassaggiRiusciti;
    }

    /**
     * @param mixed $percentualePassaggiRiusciti
     */
    public function setPercentualePassaggiRiusciti($percentualePassaggiRiusciti)
    {
        $this->percentualePassaggiRiusciti = $percentualePassaggiRiusciti;
    }

    /**
     * @return mixed
     */
    public function getGolFatti()
    {
        return $this->golFatti;
    }

    /**
     * @param mixed $golFatti
     */
    public function setGolFatti($golFatti)
    {
        $this->golFatti = $golFatti;
    }

    /**
     * @return mixed
     */
    public function getGolSubiti()
    {
        return $this->golSubiti;
    }

    /**
     * @param mixed $golSubiti
     */
    public function setGolSubiti($golSubiti)
    {
        $this->golSubiti = $golSubiti;
    }

    /**
     * @return mixed
     */
    public function getAssist()
    {
        return $this->assist;
    }

    /**
     * @param mixed $assist
     */
    public function setAssist($assist)
    {
        $this->assist = $assist;
    }

    /**
     * @return mixed
     */
    public function getAmmonizioni()
    {
        return $this->ammonizioni;
    }

    /**
     * @param mixed $ammonizioni
     */
    public function setAmmonizioni($ammonizioni)
    {
        $this->ammonizioni = $ammonizioni;
    }

    /**
     * @return mixed
     */
    public function getEspulsioni()
    {
        return $this->espulsioni;
    }

    /**
     * @param mixed $espulsioni
     */
    public function setEspulsioni($espulsioni)
    {
        $this->espulsioni = $espulsioni;
    }

    /**
     * @return mixed
     */
    public function getPartiteGiocate()
    {
        return $this->partiteGiocate;
    }

    /**
     * @param mixed $partiteGiocate
     */
    public function setPartiteGiocate($partiteGiocate)
    {
        $this->partiteGiocate = $partiteGiocate;
    }
}