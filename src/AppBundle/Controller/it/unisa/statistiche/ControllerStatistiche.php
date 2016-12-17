<?php
namespace AppBundle\Controller\it\unisa\statistiche;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 15/12/2016
 * Time: 11:37
 */
class ControllerStatistiche extends Controller
{
    /**
     * @Route("/statistiche/hello")
     */
    public function Hello()
    {
        $response = new Response("Hello Statistiche");
        return $response;
    }
}