<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class SignUpType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email',array('required'=> false))
            ->add('password', 'password',array('required'=> false))
            ->add('confirmPassword', 'password',array('required'=> false))
            ->add('given_name', 'text',array('required'=> false))
            ->add('family_name', 'text',array('required'=> false))

            ->add('submit', 'submit', array())
            ->getForm();
    }

    public function getName()
    {
        return 'sign_up_type';
    }
}
