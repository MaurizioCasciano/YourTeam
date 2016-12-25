<?php
namespace AppBundle\it\unisa\account;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Created by PhpStorm.
 * User: Raffaele
 * Date: 22/12/2016
 * Time: 16:09
 */
class Squadra
{
   private $nome;
    private $sede;
    private $stadio;
    private $golfatti;
    private $golsubiti;
    private $possessopalla;
    private $vittorie;
    private $sconfitte;
    private $pareggi;
    private $emblema;
    private $scudetti;

    /**
     * Squadra constructor.
     * @param $nome
     * @param $sede
     * @param $stadio
     * @param $golfatti
     * @param $golsubiti
     * @param $possessopalla
     * @param $vittorie
     * @param $sconfitte
     * @param $pareggi
     * @param $emblema
     * @param $scudetti
     */
    public function __construct($nome, $sede, $stadio, $golfatti, $golsubiti, $possessopalla, $vittorie, $sconfitte, $pareggi, $emblema, $scudetti)
    {
        $this->nome = $nome;
        $this->sede = $sede;
        $this->stadio = $stadio;
        $this->golfatti = $golfatti;
        $this->golsubiti = $golsubiti;
        $this->possessopalla = $possessopalla;
        $this->vittorie = $vittorie;
        $this->sconfitte = $sconfitte;
        $this->pareggi = $pareggi;
        $this->emblema = $emblema;
        $this->scudetti = $scudetti;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getSede()
    {
        return $this->sede;
    }

    /**
     * @param mixed $sede
     */
    public function setSede($sede)
    {
        $this->sede = $sede;
    }

    /**
     * @return mixed
     */
    public function getStadio()
    {
        return $this->stadio;
    }

    /**
     * @param mixed $stadio
     */
    public function setStadio($stadio)
    {
        $this->stadio = $stadio;
    }

    /**
     * @return mixed
     */
    public function getGolfatti()
    {
        return $this->golfatti;
    }

    /**
     * @param mixed $golfatti
     */
    public function setGolfatti($golfatti)
    {
        $this->golfatti = $golfatti;
    }

    /**
     * @return mixed
     */
    public function getGolsubiti()
    {
        return $this->golsubiti;
    }

    /**
     * @param mixed $golsubiti
     */
    public function setGolsubiti($golsubiti)
    {
        $this->golsubiti = $golsubiti;
    }

    /**
     * @return mixed
     */
    public function getPossessopalla()
    {
        return $this->possessopalla;
    }

    /**
     * @param mixed $possessopalla
     */
    public function setPossessopalla($possessopalla)
    {
        $this->possessopalla = $possessopalla;
    }

    /**
     * @return mixed
     */
    public function getVittorie()
    {
        return $this->vittorie;
    }

    /**
     * @param mixed $vittorie
     */
    public function setVittorie($vittorie)
    {
        $this->vittorie = $vittorie;
    }

    /**
     * @return mixed
     */
    public function getSconfitte()
    {
        return $this->sconfitte;
    }

    /**
     * @param mixed $sconfitte
     */
    public function setSconfitte($sconfitte)
    {
        $this->sconfitte = $sconfitte;
    }

    /**
     * @return mixed
     */
    public function getPareggi()
    {
        return $this->pareggi;
    }

    /**
     * @param mixed $pareggi
     */
    public function setPareggi($pareggi)
    {
        $this->pareggi = $pareggi;
    }

    /**
     * @return mixed
     */
    public function getEmblema()
    {
        return $this->emblema;
    }

    /**
     * @param mixed $emblema
     */
    public function setEmblema($emblema)
    {
        $this->emblema = $emblema;
    }

    /**
     * @return mixed
     */
    public function getScudetti()
    {
        return $this->scudetti;
    }

    /**
     * @param mixed $scudetti
     */
    public function setScudetti($scudetti)
    {
        $this->scudetti = $scudetti;
    }



}