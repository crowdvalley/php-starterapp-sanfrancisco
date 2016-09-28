<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class EditProfileType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('givenName', 'text',array('required'=> false))
            ->add('familyName', 'text',array('required'=> false))
            ->add('phone1', 'text',array('required'=> false))

            ->add('submit', 'submit', array())
            ->getForm();
    }

    public function getName()
    {
        return 'edit_profile_type';
    }
}
