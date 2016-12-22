<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 19/12/2016
 * Time: 00:46
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*Dati di accesso*/
            ->add("username_codiceContratto", TextType::class, array("label" => "Username"))
            ->add("password", TextType::class, array("label" => "Password"))
            ->add("squadra", TextType::class, array("label" => "Squadra"))
            ->add("email", EmailType::class)
            /*Dati personali*/
            ->add("nome", TextType::class, array("label" => "Nome"))
            ->add("cognome", TextType::class, array("label" => "Cognome"))
            ->add("dataDiNascita", DateType::class, array("label" => "Data di nascita"))
            ->add("domicilio", TextType::class, array("label" => "Domicilio"))
            ->add("indirizzo", TextType::class, array("label" => "Indirizzo"))
            ->add("provincia", TextType::class, array("label" => "Provincia"))
            ->add("telefono", TextType::class, array("label" => "Telefono"))
            ->add("immagine", TextType::class, array("label" => "Immagine"))
            ->add("tipo", ChoiceType::class, array("label" => "Tipo", 'choices' => array("Allenatore" => "Allenatore", "Calciatore" => "Calciatore", "Tifoso" => "Tifoso", "")))
            ->add("SignUp", SubmitType::class);
    }
}