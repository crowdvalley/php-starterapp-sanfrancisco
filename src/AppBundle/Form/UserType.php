<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType {

    private $user;

    public function __construct(array $user)
    {
        $this->user = $user;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('given_name', 'text', array(
            'required' => false, 'data'=>isset($this->user['givenName'])?$this->user['givenName']:''
        ))->add('family_name', 'text', array(
            'required' => false,
            'data'=>isset($this->user['familyName'])?$this->user['familyName']:''
        ))->add('additional_name', 'text', array(
            'required' => false,
            'data'=>isset($this->user['additionalName'])?$this->user['additionalName']:''
        ))->add('phone_1', 'text', array(
            'required' => false,
            'data'=>isset($this->user['phone1'])?$this->user['phone1']:''
        ))->add('phone_2', 'text', array(
            'required' => false,
            'data'=>isset($this->user['phone2'])?$this->user['phone2']:''
        ))->add('gender','choice',
            array('required' => false,
            'empty_value' => "Select",
            'choices' => array('U' => 'Unspecified', 'M' => 'Male','F' => 'Female'),
            'data'=>isset($this->user['gender'])?$this->user['gender']:''
        ))->add('birth_date', 'hidden')
          ->add('address', new UserAddressType(isset($this->user['address'])?$this->user['address']:array()))
        ;
    }
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'user_form_type';
    }
}