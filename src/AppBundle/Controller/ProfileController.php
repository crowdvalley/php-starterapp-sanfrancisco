<?php

namespace AppBundle\Controller;

use AppBundle\Util\Util;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Form\CompleteRegistrationInvestorType;
use AppBundle\Form\UserType;
use AppBundle\Form\UserCustomInfoType;
use AppBundle\Form\OrganizationType;
use AppBundle\Form\OfferingType;
use AppBundle\Form\SignInType;
use CrowdValley\Bundle\ClientBundle\Entity\User;
use CrowdValley\Bundle\ClientBundle\Entity\CVException;
use CrowdValley\Bundle\ClientBundle\Entity\CVResponse;

class ProfileController extends BaseController
{
    /**
     * @Route("/my-profile", name="my_profile")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function myProfileAction(Request $request)
    {
        // Check user is logged in
        if ($this->get('session')->get('authenticated') == false) {
        
			return $this->redirect($this->generateUrl('homepage', array('login_required' => true)));								        
        }				
		
		$self = '';
		$documents = '';
		$cvResponse = $this->get('self')->getSelf();
		
		if ($cvResponse->outcome == CVResponse::RESPONSE_OUTCOME_SUCCESS) {

			$self = $cvResponse->object;
			$this->get('session')->set('self', $self);	
			
			$cvResponse = $this->get('self')->getDocuments();
			
			if ($cvResponse->outcome == CVResponse::RESPONSE_OUTCOME_SUCCESS) {

				$documents = $cvResponse->objectList;
			}

		}
		else {
		
			$error = $cvResponse->exception->userMessage;
			$this->get('session')->set('authenticated', false);	
			
			return $this->redirect($this->generateUrl('homepage'));								
		}
		
		$this->params['self'] = $self;
		$this->params['documents'] = $documents;
        $this->params['menu_item'] = 'my-profile';
        return $this->render('AppBundle:Profile:my_profile.html.twig',$this->params);
    }
    
    /**
     * @Route("/my-investments", name="my_investments")
     */    
    public function myInvestmentsAction()
	{
        // Check user is logged in
        if ($this->get('session')->get('authenticated') == false) {
        
			return $this->redirect($this->generateUrl('homepage', array('login_required' => true)));								        
        }				
		

        $investments = [];

        // Get my investments
        $cvResponse = $this->get('self')->getInvestments();
        
		if ($cvResponse->outcome == CVResponse::RESPONSE_OUTCOME_SUCCESS) {

			$investments = $cvResponse->objectList;
		}        
		
        return $this->render('AppBundle:Profile:my_investments.html.twig',
            array(
				'investments' => $investments,
				'menu_item' => 'my_investments',
            ));
    }        
        
}
