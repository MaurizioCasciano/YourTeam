<?php
/**
 * Created by PhpStorm.
 * User: luigidurso
 * Date: 15/12/16
 * Time: 10:01
 */

namespace AppBundle\it\unisa\formazione;


class Modulo implements \JsonSerializable
{
    private $id;
    private $descrizione;
    private $portiere;
    private $difensori;
    private $mediani;
    private $centrocampisti;
    private $trequartisti;
    private $attaccanti;

    /**
     * Modulo constructor.
     * @param $id
     * @param $descrizione
     */
    public function __construct($id, $descrizione)
    {
        $this->id = $id;
        $this->descrizione = $descrizione;
        $this->portiere="POR";
        $this->difensori=null;
        $this->mediani=null;
        $this->centrocampisti=null;
        $this->trequartisti=null;
        $this->attaccanti=null;
    }

    /**
     * @return mixed
     */
    public function getPortiere()
    {
        return $this->portiere;
    }

    /**
     * @param mixed $portiere
     */
    public function setPortiere($portiere)
    {
        $this->portiere = $portiere;
    }

    /**
     * @return mixed
     */
    public function getDifensori()
    {
        return $this->difensori;
    }

    /**
     * @param mixed $difensori
     */
    public function setDifensori($difensori)
    {
        $this->difensori = $difensori;
    }

    /**
     * @return mixed
     */
    public function getMediani()
    {
        return $this->mediani;
    }

    /**
     * @param mixed $mediani
     */
    public function setMediani($mediani)
    {
        $this->mediani = $mediani;
    }

    /**
     * @return mixed
     */
    public function getCentrocampisti()
    {
        return $this->centrocampisti;
    }

    /**
     * @param mixed $centrocampisti
     */
    public function setCentrocampisti($centrocampisti)
    {
        $this->centrocampisti = $centrocampisti;
    }

    /**
     * @return mixed
     */
    public function getTrequartisti()
    {
        return $this->trequartisti;
    }

    /**
     * @param mixed $trequartisti
     */
    public function setTrequartisti($trequartisti)
    {
        $this->trequartisti = $trequartisti;
    }

    /**
     * @return mixed
     */
    public function getAttaccanti()
    {
        return $this->attaccanti;
    }

    /**
     * @param mixed $attaccanti
     */
    public function setAttaccanti($attaccanti)
    {
        $this->attaccanti = $attaccanti;
    }



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDescrizione()
    {
        return $this->descrizione;
    }

    /**
     * @param mixed $descrizione
     */
    public function setDescrizione($descrizione)
    {
        $this->descrizione = $descrizione;
    }


    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return [
            'nome' => $this->id,
            'difensori' => $this->difensori,
            'mediani' => $this->mediani,
            'centrocampisti' => $this->centrocampisti,
            'trequartisti' => $this->trequartisti,
            'attaccanti' => $this->attaccanti
        ];
    }
}