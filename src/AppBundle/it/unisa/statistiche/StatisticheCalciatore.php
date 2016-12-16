<?php

/**
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
    private $falliCommessi;
    private $falliSubiti;
    private $percentualPassaggiRiusciti;
    private $golFatti;
    private $golSubiti;
    private $assist;
    private $ammonizioni;
    private $espulsioni;
    private $partiteGiocate;

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
    public function getFalliCommessi()
    {
        return $this->falliCommessi;
    }

    /**
     * @param mixed $falliCommessi
     */
    public function setFalliCommessi($falliCommessi)
    {
        $this->falliCommessi = $falliCommessi;
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
    public function getPercentualPassaggiRiusciti()
    {
        return $this->percentualPassaggiRiusciti;
    }

    /**
     * @param mixed $percentualPassaggiRiusciti
     */
    public function setPercentualPassaggiRiusciti($percentualPassaggiRiusciti)
    {
        $this->percentualPassaggiRiusciti = $percentualPassaggiRiusciti;
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