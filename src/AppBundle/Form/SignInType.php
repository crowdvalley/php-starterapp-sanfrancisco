<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class SignInType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email')
            ->add('password', 'password')
            ->add('redirect', 'hidden')
            ->add('submit', 'submit', array())
            ->getForm();
    }

    public function getName()
    {
        return 'sign_in_type';
    }
}
