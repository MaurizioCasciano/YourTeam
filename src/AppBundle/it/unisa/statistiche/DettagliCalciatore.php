<?php
namespace AppBundle\it\unisa\statistiche;

/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 14/12/2016
 * Time: 18:45
 */
class DettagliCalciatore
{
    //statistiche
    private $usernameCodiceContratto;
    private $tiriTotali;
    private $tiriPorta;
    private $falliFatti;
    private $falliSubiti;
    private $percentualPassaggiRiusciti;
    private $golFatti;
    private $golSubiti;
    private $assist;
    private $ammonizioni;
    private $espulsioni;
    private $partiteGiocate;

    //dettagli calciatore
    private $numeroMaglia;
    private $valore;
    private $stipendio;
    private $piedePreferito;
    private $capitano;
    private $ruoli;

    /**
     * DettagliCalciatore constructor.
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
     * @param $numeroMaglia
     * @param $valore
     * @param $stipendio
     * @param $piedePreferito
     * @param $capitano
     * @param $ruoli
     */
    public function __construct($usernameCalciatore, $tiriTotali, $tiriPorta, $falliFatti, $falliSubiti, $percentualPassaggiRiusciti, $golFatti, $golSubiti, $assist, $ammonizioni, $espulsioni, $partiteGiocate, $numeroMaglia, $valore, $stipendio, $piedePreferito, $capitano, $ruoli)
    {
        $this->usernameCodiceContratto = $usernameCalciatore;
        $this->tiriTotali = $tiriTotali;
        $this->tiriPorta = $tiriPorta;
        $this->falliFatti = $falliFatti;
        $this->falliSubiti = $falliSubiti;
        $this->percentualPassaggiRiusciti = $percentualPassaggiRiusciti;
        $this->golFatti = $golFatti;
        $this->golSubiti = $golSubiti;
        $this->assist = $assist;
        $this->ammonizioni = $ammonizioni;
        $this->espulsioni = $espulsioni;
        $this->partiteGiocate = $partiteGiocate;
        $this->numeroMaglia = $numeroMaglia;
        $this->valore = $valore;
        $this->stipendio = $stipendio;
        $this->piedePreferito = $piedePreferito;
        $this->capitano = $capitano;
        $this->ruoli = $ruoli;
    }

    /**
     * @return mixed
     */
    public function getUsernameCodiceContratto()
    {
        return $this->usernameCodiceContratto;
    }

    /**
     * @param mixed $usernameCodiceContratto
     */
    public function setUsernameCodiceContratto($usernameCodiceContratto)
    {
        $this->usernameCodiceContratto = $usernameCodiceContratto;
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

    /**
     * @return mixed
     */
    public function getNumeroMaglia()
    {
        return $this->numeroMaglia;
    }

    /**
     * @param mixed $numeroMaglia
     */
    public function setNumeroMaglia($numeroMaglia)
    {
        $this->numeroMaglia = $numeroMaglia;
    }

    /**
     * @return mixed
     */
    public function getValore()
    {
        return $this->valore;
    }

    /**
     * @param mixed $valore
     */
    public function setValore($valore)
    {
        $this->valore = $valore;
    }

    /**
     * @return mixed
     */
    public function getStipendio()
    {
        return $this->stipendio;
    }

    /**
     * @param mixed $stipendio
     */
    public function setStipendio($stipendio)
    {
        $this->stipendio = $stipendio;
    }

    /**
     * @return mixed
     */
    public function getPiedePreferito()
    {
        return $this->piedePreferito;
    }

    /**
     * @param mixed $piedePreferito
     */
    public function setPiedePreferito($piedePreferito)
    {
        $this->piedePreferito = $piedePreferito;
    }

    /**
     * @return mixed
     */
    public function getCapitano()
    {
        return $this->capitano;
    }

    /**
     * @param mixed $capitano
     */
    public function setCapitano($capitano)
    {
        $this->capitano = $capitano;
    }

    /**
     * @return mixed
     */
    public function getStatisticheCalciatore()
    {
        return $this->statisticheCalciatore;
    }

    /**
     * @param mixed $statisticheCalciatore
     */
    public function setStatisticheCalciatore($statisticheCalciatore)
    {
        $this->statisticheCalciatore = $statisticheCalciatore;
    }

    /**
     * @return mixed
     */
    public function getRuoli()
    {
        return $this->ruoli;
    }

    /**
     * @param mixed $ruoli
     */
    public function setRuoli($ruoli)
    {
        $this->ruoli = $ruoli;
    }
}