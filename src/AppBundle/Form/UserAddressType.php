<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Intl\Intl;

class UserAddressType extends AbstractType {

    private $address;

    public function __construct(array $address)
    {
        $this->address = $address;
    }

    private function getAllCountries(){
        \Locale::setDefault('en');
        $countries = Intl::getRegionBundle()->getCountryNames();
        $arr = array();
        if(is_array($countries)){
            $arr = array_combine($countries, $countries);
        }else{
            $arr =  array('GB'=>'United Kingdom');//return common countries
        }
        return $arr;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('building', 'text', array(
            'required' => false,
            'data'=>isset($this->address['building'])?$this->address['building']:''
        ))->add('street_address', 'text', array(
            'required' => false,
            'data'=>isset($this->address['streetAddress'])?$this->address['streetAddress']:''
        ))->add('address_locality', 'text', array(
            'required' => false,
            'data'=>isset($this->address['addressLocality'])?$this->address['addressLocality']:''
        ))->add('country', 'choice', array('required' => false,
                'choices' => $this->getAllCountries(),'preferred_choices' => array('United Kingdom'),
                'data'=>isset($this->address['country'])?$this->address['country']:'',
                'empty_value' => "Select your country"
        ))->add('city', 'text', array(
            'required' => false,
            'data'=>isset($this->address['city'])?$this->address['city']:''
        ))->add('region', 'text', array(
            'required' => false,
            'data'=>isset($this->address['region'])?$this->address['region']:''
        ))->add('postal_code', 'text', array(
            'required' => false,
            'data'=>isset($this->address['postalCode'])?$this->address['postalCode']:''
        ))
        ;
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'user_address_form_type';
    }
}