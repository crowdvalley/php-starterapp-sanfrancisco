<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class OrgRealEstateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('displayName', 'text', array(
                    'required' => false,
                    'attr' => array('maxlength' => 32)
                ))
                ->add('briefDescription', 'textarea', array(
                    'attr' => array('rows' => '5'),
                    'required' => false
                ))
                ->add('alternateName', 'text', array(
                    'required' => false
                ))
                ->add('companyNumber', 'text', array(
                    'required' => false
                ))
                ->add('additionalType', 'hidden', array('data'=>'real_estate'))
                ->add('visibility', 'hidden', array('data'=>0))
                ->add('lifeCycleStage', 'hidden', array('data'=>5))
                ->add('address', new AddressType())
                ->add('custom', new OrganizationCustomType())
                ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'org_real_estate_type';
    }
}
