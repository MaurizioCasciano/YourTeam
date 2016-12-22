<?php

namespace AppBundle\Controller\it\unisa\account;

use AppBundle\Form\Type\AccountType;
use AppBundle\it\unisa\account\Account;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class NewAccountTestController extends Controller
{
    /**
     * @Route("/newaccount")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        // 1) build the form
        $account = new Account();
        $form = $this->createForm(AccountType::class, $account);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                return new Response("Account has been created.");
            } else {
                return $this->render(
                    'account/newaccounttest.html.twig',
                    array('form' => $form->createView())
                );
            }
        }

        return $this->render(
            'account/newaccounttest.html.twig',
            array('form' => $form->createView())
        );
    }
}
