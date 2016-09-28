<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class EquityOfferingType extends AbstractType
{
    private $organizations;

    public function __construct(array $organizations)
    {
        $this->organizations = $organizations;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name', 'text', array(
                    'required' => false
                ))
                ->add('id', 'choice', array(
                    'multiple' => false,
                    'expanded' => false,
                    'required' => false,
                    'placeholder' => 'Choose your organization',
                    'empty_data' => null,
                    'choices' => $this->organizations,
                ))
                ->add('fundingGoal', 'text', array('required' => false))
                ->add('offeringDescription', 'textarea', array(
                    'attr' => array('rows' => '5'),
                    'required' => false
                ))
                ->add('openDate', 'text', array('required' => false))
                ->add('closeDate', 'text', array('required' => false))
                ->add('externalCommitments', 'text', array('required' => false))
                ->add('maximumOverfundingAmount', 'text', array('required' => false))
                ->add('interestRate', 'text', array('required' => false))
                ->add('additionalType', 'hidden', array('data'=>'equity'))
                ->add('lifeCycleStage', 'hidden', array('data'=>5))

                ;
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'equity_offering_type';
    }
}
