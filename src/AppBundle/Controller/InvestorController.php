<?php

namespace AppBundle\Controller;

use AppBundle\Util\Util;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use CrowdValley\Bundle\ClientBundle\Entity\User;
use CrowdValley\Bundle\ClientBundle\Entity\Offering;
use CrowdValley\Bundle\ClientBundle\Entity\Organization;
use CrowdValley\Bundle\ClientBundle\Entity\CVException;
use CrowdValley\Bundle\ClientBundle\Entity\CVResponse;

class InvestorController extends BaseController
{
    /**
     * @Route("/invest", name="investment_opportunities")
     */
    public function viewInvestmentOpportunitiesAction(Request $request)
    {
        $authenticated = $this->get('session')->get('authenticated');
        if (!$authenticated) {
            return $this->redirectToRoute('homepage',array('required' => 'login'));
        }
        $offeringArray = array(); $offeringList = array();
        if ($this->get('session')->get('authenticated') == true) {
            $cvResponse = $this->get('offering')->getOfferings();
                        
            if ($cvResponse->outcome == CVResponse::RESPONSE_OUTCOME_SUCCESS) {

                $offerings = $cvResponse->objectList;

                foreach ($offerings as $offering) {
					$cvResponse = $this->get('organization')->getOrganizationWithId($offering->organizationId);
					if ($cvResponse->outcome == CVResponse::RESPONSE_OUTCOME_SUCCESS) {
						$offering->organization = $cvResponse->object;
					}
                }
            }
        }

        $this->params['offerings']= $offerings;
        $this->params['menu_item']= 'investment_opportunities';
        return $this->render('AppBundle:Investor:invest.html.twig',$this->params);        
    }
       
    /**
     * @Route("/company/{offering_id}", name="view_company")
     */
    public function viewOfferingAction($offering_id)
    {
        $authenticated = $this->get('session')->get('authenticated');
        if (!$authenticated) {
            return $this->redirectToRoute('homepage',array('required' => 'login'));
        }

        $offering = [];
        $organization = [];
        if ($this->get('session')->get('authenticated') == true) {

            $cvResponse = $this->get('offering')->getOfferingWithId($offering_id);

            if ($cvResponse->outcome == CVResponse::RESPONSE_OUTCOME_SUCCESS) {

                $offering = $cvResponse->object;

                $cvResponse = $this->get('organization')->getOrganizationWithId($offering->organizationId);

                if ($cvResponse->outcome == CVResponse::RESPONSE_OUTCOME_SUCCESS) {

                    $organization = $cvResponse->object;
                }
            }
        }
                        
        $this->params['offering']= $offering;
        $this->params['organization']= $organization;
        $this->params['type']= 'debt';
        return $this->render('AppBundle:Investor:company_detail.html.twig',$this->params);
    }

    /**
     * @Route("/make-investment/{offering_id}", name="make-investment")
     *
     * @param Request $request
     * @param $offering_id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function investAction(Request $request, $offering_id)
    {

        return $this->redirectToRoute('view_company', array('offering_id' => $offering_id));
    }
      
}
