<?php
namespace AppBundle\it\unisa\statistiche;
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 14/12/2016
 * Time: 18:52
 */
class StatistichePartita
{
    /**
     * @var $golFatti int numero di gol fatti dalla squadra.
     */
    private $golFatti;
    /**
     * @var $golSubiti int numero di gol subiti dalla squadra.
     */
    private $golSubiti;
    /**
     * @var $possessoPalla int possesso palla della squadra.
     */
    private $possessoPalla;
    /**
     * @var $marcatori array calciatori che hanno segnato per la squadra.
     */
    private $marcatori;
    /**
     * @var $assistMen array calciatori che hanno effettuato un assist durante l'incontro.
     */
    private $assistMen;
    /**
     * @var $ammonizioni array calciatori che sono stati ammoniti durante l'incontro.
     */
    private $ammonizioni;
    /**
     * @var $espulsioni array calciatori che sono stati espulsi durante l'incontro.
     */
    private $espulsioni;

    /**
     * StatistichePartita constructor.
     * @param int $golFatti
     * @param int $golSubiti
     * @param int $possessoPalla
     * @param array $marcatori
     * @param array $assistMen
     * @param array $ammonizioni
     * @param array $espulsioni
     */
    public function __construct($golFatti, $golSubiti, $possessoPalla, $marcatori, $assistMen, $ammonizioni, $espulsioni)
    {
        $this->golFatti = $golFatti;
        $this->golSubiti = $golSubiti;
        $this->possessoPalla = $possessoPalla;
        $this->marcatori = $marcatori;
        $this->assistMen = $assistMen;
        $this->ammonizioni = $ammonizioni;
        $this->espulsioni = $espulsioni;
    }

    /**
     * @return int
     */
    public function getGolFatti()
    {
        return $this->golFatti;
    }

    /**
     * @param int $golFatti
     */
    public function setGolFatti($golFatti)
    {
        $this->golFatti = $golFatti;
    }

    /**
     * @return int
     */
    public function getGolSubiti()
    {
        return $this->golSubiti;
    }

    /**
     * @param int $golSubiti
     */
    public function setGolSubiti($golSubiti)
    {
        $this->golSubiti = $golSubiti;
    }

    /**
     * @return int
     */
    public function getPossessoPalla()
    {
        return $this->possessoPalla;
    }

    /**
     * @param int $possessoPalla
     */
    public function setPossessoPalla($possessoPalla)
    {
        $this->possessoPalla = $possessoPalla;
    }

    /**
     * @return array
     */
    public function getMarcatori()
    {
        return $this->marcatori;
    }

    /**
     * @param array $marcatori
     */
    public function setMarcatori($marcatori)
    {
        $this->marcatori = $marcatori;
    }

    /**
     * @return array
     */
    public function getAssistMen()
    {
        return $this->assistMen;
    }

    /**
     * @param array $assistMen
     */
    public function setAssistMen($assistMen)
    {
        $this->assistMen = $assistMen;
    }

    /**
     * @return array
     */
    public function getAmmonizioni()
    {
        return $this->ammonizioni;
    }

    /**
     * @param array $ammonizioni
     */
    public function setAmmonizioni($ammonizioni)
    {
        $this->ammonizioni = $ammonizioni;
    }

    /**
     * @return array
     */
    public function getEspulsioni()
    {
        return $this->espulsioni;
    }

    /**
     * @param array $espulsioni
     */
    public function setEspulsioni($espulsioni)
    {
        $this->espulsioni = $espulsioni;
    }
}