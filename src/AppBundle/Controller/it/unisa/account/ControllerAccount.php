<?php

/**
 * Created by PhpStorm.
 * User: Raffaele
 * Date: 16/12/2016
 * Time: 09:09
 */
namespace AppBundle\Controller\it\unisa\account;

use AppBundle\it\unisa\account\AccountCalciatore;
use \AppBundle\it\unisa\account\Calciatore;
use \AppBundle\it\unisa\account\GestoreAccount;
use \AppBundle\it\unisa\account\Account;
use \AppBundle\it\unisa\account\Squadra;
use AppBundle\Utility\Utility;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;


/*Aggiungere  i controller per :

    aggiungere le altre viste
    e chiaramente quelli per visualizzare le schermate*/

class ControllerAccount extends Controller
{


    /**
     * @Route("/account/registrazione",name="formAggiungiAccount")
     * @Method("GET")
     */
    public function aggiungiAccountForm()
    {

        $g = GestoreAccount::getInstance();
        try {
            $squadre = $g->ottieniTutteLeSquadre();
            return $this->render("guest/registrazione.html.twig", array("squadre" => $squadre));/*vista non completa*/
        } catch (\Exception $e) {

        }


        return new Response("error");
    }
    /**
     * @Route("/account/{attore}/aggiungi",name="aggiungiAccount")
     * @Method("POST")
     */
    /*attore potrà essere:
        -calciatore
        -staff_allenatore_tifoso
    */
    public function aggiungiAccount(Request $r, $attore)
    {


        if ($attore == "staff_allenatore_tifoso") {
            $data = str_replace("/", "-", $r->request->get("d"));

            $staff = $r->request->get("tipo");
            if ($staff == "staff") {
                $s = new Squadra($r->request->get("nomeSquadra"),
                    $r->request->get("sedeSquadra"),
                    $r->request->get("stadioSquadra"),
                    "", "", "", "", "", "", "", "", "", $r->request->get("scudettiSquadra"));

                $a = new Account($r->request->get("u"),
                    $r->request->get("p"),
                    $r->request->get("nomeSquadra"),
                    $r->request->get("e"), $r->request->get("n"),
                    $r->request->get("c"), $data,
                    $r->request->get("do"), $r->request->get("i"),
                    $r->request->get("pr"), $r->request->get("t"),
                    "", $r->request->get("tipo"));


                $db = GestoreAccount::getInstance();
                $pathSquadra = Utility::loadFileSquadra("fileSquadra", "account");
                $path = Utility::loadFile("file", "account");
                if ($pathSquadra != null || $path != null) {
                    $s->setImmagine($pathSquadra);
                    $a->setImmagine($path);

                    $db->aggiungiSquadra($s);
                    $db->aggiungiAccount_A_T_S($a);
                    return $this->redirect("/yourteam/web/app_dev.php/");
                }

            } else {

                $a = new Account($r->request->get("u"),
                    $r->request->get("p"),
                    $r->request->get("s"),
                    $r->request->get("e"), $r->request->get("n"),
                    $r->request->get("c"), $data,
                    $r->request->get("do"), $r->request->get("i"),
                    $r->request->get("pr"), $r->request->get("t"),
                    "", $r->request->get("tipo"));

                try {


                    $g = GestoreAccount::getInstance();
                    $path = Utility::loadFile("file", "account");
                    if ($path != null) {
                        $a->setImmagine($path);
                        $g->aggiungiAccount_A_T_S($a);
                        return $this->redirect("/yourteam/web/app_dev.php/");
                    }
                } catch (\Exception $e) {
                    return new Response($e->getMessage(), 404);
                }

            }
        } else
            if ($attore == "calciatore") {

                $data = str_replace("/", "-", $r->request->get("d"));
                $a = new AccountCalciatore($r->request->get("u"),
                    $r->request->get("p"),
                    $r->request->get("s"),
                    $r->request->get("e"), $r->request->get("n"),
                    $r->request->get("c"), $data,
                    $r->request->get("do"), $r->request->get("i"),
                    $r->request->get("pr"), $r->request->get("t"),
                    $r->request->get("im"), $r->request->get("nazionalita"));
                try {
                    $g = GestoreAccount::getInstance();
                    $path = Utility::loadFile("file", "account");
                    if ($path != null) {
                        $a->setImmagine($path);
                        $g->aggiungiAccount_C($a);
                        return $this->redirect("/yourteam/web/app_dev.php/");
                    }
                } catch (\Exception $e) {
                    return new Response($e->getMessage(), 404);
                }
            } else return new Response("la rotta non esiste", 404);

    }

    /**
     * @Route("/account/all/ricerca",name="ricercaAccountForm")
     * @Method("GET")
     */
    public function ricercaAccountVista($attore)
    {

        /*vista non completa*/
        $u = $_SESSION["username"];
        $g = GestoreAccount::getInstance();
        $staff = $g->ricercaAccount_A_T_S($u);

        return $this->render("staff/ricercaAccount.html.twig", array("staff" => $staff));

    }
    /**
     * @Route("/account/ricercaAccountStaff/ricerca",name="ricercaAccountStaff")
     * @Method("POST")
     */
    /*attore potrà essere:
        -calciatore
        -staff_allenatore_tifoso
    */
    public function ricercaAccountStaff(Request $r)
    {
        $attore=$r->request->get("tipo");
        $g = GestoreAccount::getInstance();

        if($attore== "staff_allenatore_tifoso") {
            try {
                $ast = $g->ricercaAccount_A_T_S($r->request->get("u"));
                $staff = $g->ricercaAccount_A_T_S($_SESSION["username"]);
                $tipo = $ast->getTipo();
                if ($tipo == "allenatore")
                    return $this->render("staff/visualizzaAccountStaffRicercato.html.twig", array('ricercato' => $ast,'staff' => $staff ));
                else
                    if ($tipo == "tifoso")
                        return $this->render("staff/visualizzaAccountStaffRicercato.html.twig", array('ricercato' => $ast,'staff' => $staff));
                    else
                        if ($tipo == "staff")
                            return $this->render("staff/visualizzaAccountStaffRicercato.html.twig", array('ricercato' => $ast,'staff' => $staff));


            } catch (\Exception $e) {
                return new Response($e->getMessage(), 404);
            }
        }

            if ($attore == "calciatore") {
                try {
                    $ag = $g->ricercaAccount_G($r->request->get("u"));
                    $staff = $g->ricercaAccount_A_T_S($_SESSION["username"]);
                    return $this->render("staff/visualizzaAccountStaffRicercato.html.twig", array('ricercato' => $ag,'staff' => $staff));
                } catch (\Exception $e) {
                    return new Response($e->getMessage(), 404);
                }
            }
        return new Response("tipo erratoo");
    }
    /**
     * @Route("/account/{attore}/{username}",name="ricercaAccount")
     * @Method("GET")
     */
    /*attore potrà essere:
        -calciatore
        -staff_allenatore_tifoso
    */
    public function ricercaAccount($attore, $username)
    {

        $g = GestoreAccount::getInstance();
        if ($attore == "staff_allenatore_tifoso") {
            try {
                $ast = $g->ricercaAccount_A_T_S($username);
                $tipo = $ast->getTipo();
                if ($tipo == "allenatore")
                    return $this->render("allenatore/visualizzaAccountAllenatore.html.twig", array('allenatore' => $ast));
                else
                    if ($tipo == "tifoso")
                        return $this->render("tifoso/visualizzaAccountTifoso.html.twig", array('tifoso' => $ast));
                    else
                        if ($tipo == "staff")
                            return $this->render("staff/visualizzaAccountStaff.html.twig", array('staff' => $ast));


            } catch (\Exception $e) {
                return new Response($e->getMessage(), 404);
            }
        } else
            if ($attore == "calciatore") {
                try {
                    $ag = $g->ricercaAccount_G($username);
                    return $this->render("giocatore/visualizzaAccountgiocatore.html.twig", array('giocatore' => $ag));
                } catch (\Exception $e) {
                    return new Response($e->getMessage(), 404);
                }
            }
        return new Response("tipo erratoo");
    }

    /**
     * @Route("/account/modificaForm/{tipo}/{u}/modifica")
     * @Method("GET")
     */
    public function modificaForm($tipo, $u)
    {

        //  $tipo = $_SESSION["tipo"];
        //  $u = $_SESSION["username"];
        $g = GestoreAccount::getInstance();

        $s = $g->ottieniTutteLeSquadre();
        try {
            if ($tipo == "allenatore") {
                $ag = $g->ricercaAccount_A_T_S($u);
                return $this->render("allenatore/modificaAllenatore.html.twig", array('g' => $ag, 'squadre' => $s));
            }
            if ($tipo == "tifoso") {
                $ag = $g->ricercaAccount_A_T_S($u);
                return $this->render("tifoso/modificaTifoso.html.twig", array('g' => $ag, 'squadre' => $s));
            }
            if ($tipo == "staff") {
                $ag = $g->ricercaAccount_A_T_S($u);
                return $this->render("staff/modificaStaff.html.twig", array('g' => $ag, 'squadre' => $s));
            }
            if ($tipo == "calciatore") {
                $ag = $g->ricercaAccount_G($u);
                return $this->render("giocatore/modificaCalciatore.html.twig", array('g' => $ag, 'squadre' => $s));
            }
        } catch
        (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
        return new Response("nessun tipo");

    }


    /**
     * @Route("/account/{attore}/{tipo}/modificaAccount", name="modificaUtente")
     * @Method("POST")
     */
    /*attore potrà essere:
       -calciatore
       -staff_allenatore_tifoso
   */
    public function modificaAccount(Request $r, $attore, $tipo)
    {
        if ($attore == "staff_allenatore_tifoso") {
            /*il tipo e la squadra non possono essere modificati quindi non glieli inviamo proprio non devono */
            $gats = GestoreAccount::getInstance();
            $a = new Account("",
                $r->request->get("p"), "",
                $r->request->get("e"), $r->request->get("n"),
                $r->request->get("c"), $r->request->get("d"),
                $r->request->get("do"), $r->request->get("i"),
                $r->request->get("pr"), $r->request->get("t"),
                $r->request->get("im"), "");

            try {
                $gats->modificaAccount_A_T_S($_SESSION["username"], $a);
                if ($tipo == "allenatore") {
                    return $this->render("allenatore/allenatoreModificato.html.twig", array("g" => $a));
                }
                if ($tipo == "tifoso") {
                    return $this->render("tifoso/tifosoModificato.html.twig", array("g" => $a));
                }
                if ($tipo == "staff") {
                    return $this->render("staff/staffModificato.html.twig", array("g" => $a));
                }

            } catch (\Exception $e) {
                return new Response($e->getMessage(), 404);
            }
        } else if ($attore == "giocatore") {
            $gg = GestoreAccount::getInstance();


            /*il tipo e la squadra non possono essere modificati quindi non glieli inviamo proprio non devono */

            $a = new AccountCalciatore("",
                $r->request->get("p"), "",
                $r->request->get("e"), $r->request->get("n"),
                $r->request->get("c"), $r->request->get("d"),
                $r->request->get("do"), $r->request->get("i"),
                $r->request->get("pr"), $r->request->get("t"),
                $r->request->get("im"), $r->request->get("nazionalità"));

            try {
                $gg->modificaAccount_G($_SESSION["username"], $a);
                return $this->render("giocatore/giocatoreModificato.html.twig", array("g" => $a));
            } catch (\Exception $e) {
                return new Response($e->getMessage(), 404);
            }
        }
        return new Response("nessun tipo");
    }

    /**
     * @Route("/account/elimina/{attore}/eliminaAccount/{username}")
     * @Method("GET")
     */
    /*attore potrà essere:
        -calciatore
        -staff_allenatore_tifoso
    */
    public function eliminaAccount($attore, $username)
    {


        //  $username=$_SESSION["username"];

        if ($attore == "staff_allenatore_tifoso") {
            $g = GestoreAccount::getInstance();
            try {
                $g->eliminaAccount_A_T_S($username);
                return $this->render("guest/eliminato.html.twig");
            } catch (\Exception $e) {
                return new Response($e->getMessage(), 404);
            }
        } else if ($attore == "calciatore") {
            $g = GestoreAccount::getInstance();
            try {
                $g->eliminaAccount_G($username);
                return $this->render("guest/eliminato.html.twig");
            } catch (\Exception $e) {
                return new Response($e->getMessage(), 404);
            }
        }

        return new Response("tipo non esiste");


    }

    /**
     * @Route("/account/staff/convalida",name="convalidaAccount")
     * @Method("POST")
     */
    public function convalidaAccount(Request $request)
    {
        $g = GestoreAccount::getInstance();
        $u = $_SESSION["username"];
        try {
            $g->convalidaAccount_A_G($request->request->get("u"));
            return $this->redirect("/yourteam/web/app_dev.php/account/staff_allenatore_tifoso/" . $u);
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }

    }

    /**
     * @Route("/account/ConvalidaForm")
     * @Method("GET")
     */
    public function ConvalidaForm()
    {
        $u = $_SESSION["username"];

        $g = GestoreAccount::getInstance();
        try {
            $a = $g->dammiAccountDaConvalidare();
            $staff = $g->ricercaAccount_A_T_S($u);
            return $this->render("staff/utentiDaConvalidare.html.twig", array("utente" => $a, "staff" => $staff));
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }

    }

}