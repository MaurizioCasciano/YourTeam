<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 26/12/2016
 * Time: 12:21
 */

namespace AppBundle\Controller\it\unisa\partite;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ControllerPartiteUtenteRegistrato extends Controller
{
    /**
     * @Route("/partite/user")
     * @Method("GET")
     */
    public function getListaPartiteView()
    {


        return $this->render();
    }
}