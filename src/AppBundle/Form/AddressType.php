<?php

namespace AppBundle\Form;

use Symfony\Component\Intl\Intl;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AddressType extends AbstractType {
    /**
     * @return array
     */
    private function getAllCountries()
    {
        \Locale::setDefault('en');
        $countries = Intl::getRegionBundle()->getCountryNames();
        $arr = array();
        if (is_array($countries)) {
            $arr = array_combine($countries, $countries);
        } else {
            $arr = array('United States' => 'United States', 'United Kingdom' => 'United Kingdom'); //return common countries
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
        ))->add('streetAddress', 'text', array(
            'required' => false,
        ))->add('addressLocality', 'text', array(
            'required' => false,
        ))->add('city', 'text', array(
            'required' => false,
        ))->add('region', 'text', array(
            'required' => false,
        ))->add('postalCode', 'text', array(
            'required' => false,
        ))->add('country', 'choice', array('required' => true,
            'choices' => $this->getAllCountries(), 'preferred_choices' => array('United States', 'United Kingdom')
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
        return 'address_type';
    }
}