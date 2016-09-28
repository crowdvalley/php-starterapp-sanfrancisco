<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OrgPrivateCompanyType extends AbstractType
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
                /*->add('sector', 'text', array(
                    'required' => false
                ))*/
                ->add('foundingDate', 'text', array(
                    'required' => false
                ))
                ->add('companyNumber', 'text', array(
                    'required' => false
                ))
                ->add('website', 'text', array(
                    'required' => false
                ))
                /*->add('sector', 'collection', array(
                    'multiple' => true,
                    'expanded' => true,
                    'required' => false,
                    'choices' => array(
                        'Apparel, Fashion & Textiles' => 'Apparel, Fashion & Textiles',
                        'Art & Craft, Luxury Goods & Jewelry' => 'Art & Craft, Luxury Goods & Jewelry',
                        'Automotive, Aviation & Aerospace' => 'Automotive, Aviation & Aerospace',
                        'Chemicals' => 'Chemicals',
                        'Computer, Network & Telecommunications' => 'Computer, Network & Telecommunications',
                        'Construction' => 'Construction',
                        'Consumer Goods' => 'Electrical/Electronical Manufacturing',
                        'Environmentals & Facilities Services' => 'Environmentals & Facilities Services',
                        'Farming & Fishery' => 'Farming & Fishery',
                        'Financial Services' => 'Financial Services',
                        'Food & Beverages' => 'Food & Beverages',
                        'Health, Wellness and Fitness' => 'Health, Wellness and Fitness',
                        'Industrial Goods' => 'Industrial Goods',
                        'Leisure, Travel & Tourism' => 'Leisure, Travel & Tourism',
                        'Logistics & Supply Chain' => 'Logistics & Supply Chain',
                        'Oil & Energy' => 'Oil & Energy',
                        'Pharmaceuticals' => 'Pharmaceuticals',
                        'Renewables & Environment' => 'Renewables & Environment',
                        'Wholesale & Retail' => 'Wholesale & Retail',
                    )
                ))*/
                ->add('additionalType', 'hidden', array('data'=>'private_company'))
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
        return 'org_private_company_type';
    }
}
