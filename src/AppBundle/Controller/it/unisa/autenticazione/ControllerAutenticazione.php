<?php

/**
 * Created by PhpStorm.
 * User: Raffaele
 * Date: 16/12/2016
 * Time: 09:09
 */
namespace AppBundle\Controller\it\unisa\autenticazione;


use AppBundle\it\unisa\autenticazione\GestoreAutenticazione;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;


class ControllerAutenticazione extends Controller
{


    /**
     * @Route("/login",name="login")
     * @Method("POST")
     */
    public function login(Request $richiesta)
    {
        $u = $richiesta->request->get("u");
        $p = $richiesta->request->get("p");
        $g = new GestoreAutenticazione();
        $r = $g->login($u, $p);
        if ($r) {
            if ($_SESSION["tipo"] == "allenatore") {
                //return $this->redirect("/yourteam/web/app_dev.php/account/staff_allenatore_tifoso/".$u);
                return $this->redirect($this->generateUrl("ricercaAccount",
                    array("attore" => "staff_allenatore_tifoso", "username" => $u)));
            } else
                if ($_SESSION["tipo"] == "calciatore") {
                    //return $this->redirect("/yourteam/web/app_dev.php/account/calciatore/" . $u);
                    return $this->redirect($this->generateUrl("ricercaAccount",
                        array("attore" => "calciatore", "username" => $u)));
                } else
                    if ($_SESSION["tipo"] == "tifoso") {
                        //return $this->redirect("/yourteam/web/app_dev.php/account/staff_allenatore_tifoso/" . $u);
                        return $this->redirect($this->generateUrl("ricercaAccount",
                            array("attore" => "staff_allenatore_tifoso", "username" => $u)));
                    } else
                        if ($_SESSION["tipo"] == "staff") {
                            //return $this->redirect("/yourteam/web/app_dev.php/account/staff_allenatore_tifoso/" . $u);
                            return $this->redirect($this->generateUrl("ricercaAccount",
                                array("attore" => "staff_allenatore_tifoso", "username" => $u)));
                        }
        } else
            if (!$r)
                return new Response("non hai i permessi");
            else if ($r == -1)
                return new Response("gia sei autenticato");

    }

    /**
     * @Route("/logout",name="logout")
     * @Method("GET")
     */
    public function logout(Request $richiesta)
    {
        $g = new GestoreAutenticazione();
        $g->logout();
        return $this->redirect("/yourteam/web/app_dev.php/");
    }
}