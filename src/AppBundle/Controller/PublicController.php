<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\SignInType;
use AppBundle\Form\SignUpType;
use AppBundle\Util\Util;
use Symfony\Component\HttpFoundation\Response;
use CrowdValley\Bundle\ClientBundle\Entity\User;
use CrowdValley\Bundle\ClientBundle\Entity\Offering;
use CrowdValley\Bundle\ClientBundle\Entity\CVException;
use CrowdValley\Bundle\ClientBundle\Entity\CVResponse;

class PublicController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
		$self = $this->get('session')->get('self');				
		$loginRequired = $request->query->get('login_required');				
        $referrer = $request->query->get('referrer');

        if (!empty($referrer)) {
            $this->get('session')->set('login_referrer', urldecode($referrer));
        }
        else {
			$this->get('session')->set('login_referrer', 'homepage');      
        }
        
        $featuredOfferings = [];
        
        $cvResponse = $this->get('public')->getFeaturedOfferings();
        
        if ($cvResponse->outcome == CVResponse::RESPONSE_OUTCOME_SUCCESS) {
        
        	$featuredOfferings = $cvResponse->objectList;
        }
		
        $signupForm = $this->createForm(new SignUpType()); 
        
        $this->params['self'] = $self;
        $this->params['login_required'] = $loginRequired;
        $this->params['featured_offerings'] = $featuredOfferings;
        $this->params['menu_item']= 'homepage';
        return $this->render('AppBundle:Public:index.html.twig',$this->params);
    }


    /**
     * @Route("/contact-us", name="contact_us")
     */
    public function contactUsAction()
    {
        $this->params['menu_item']= 'contact_us';
        return $this->render('AppBundle:Public:contact_us.html.twig',$this->params);
    }

    /**
     * @Route("/legal", name="legal")
     */
    public function viewLegalAction()
    {
        $this->params['menu_item']= 'legal';
        return $this->render('AppBundle:Public:legal.html.twig',$this->params);
    }
    
    /**
     * @Route("/forgot-password", name="forgot_password")
     */
    public function forgotPasswordAction()
    {
        $this->params['menu_item']= 'forgot_password';
        return $this->render('AppBundle:Public:forgot_password.html.twig',$this->params);
    }
    
    /**
     * @Route("/sign-in", name="sign_in")
     */
    public function signInAction(Request $request)
    {
        $form = $this->createForm(new SignInType());
		$error = '';
		$self = '';
		$authenticated = false;
        
        if ($request->isMethod('POST')) {
            $form->bind($request);
            $signInData = $form->getData();

			$referrer = $signInData['redirect'];
	        if (empty($referrer)) {
				$referrer = 'homepage'; 			
			}
			
			$cvResponse = $this->get('authenticate')->login($signInData['email'], $signInData['password']);
						
			if ($cvResponse->outcome == CVResponse::RESPONSE_OUTCOME_SUCCESS) {
        		$this->get('session')->set('authenticated', true);
        		
				$cvResponse = $this->get('self')->getSelf();
	
				if ($cvResponse->outcome == CVResponse::RESPONSE_OUTCOME_SUCCESS) {

					$self = $cvResponse->object;
					$this->get('session')->set('self', $self);	
				}        		
			}
        	else if ($cvResponse->outcome == CVResponse::RESPONSE_OUTCOME_EXCEPTION) {
				$error = $cvResponse->exception->userMessage;
				$this->addFlash('errors', $error);
			}
						
	        return $this->redirect($this->generateUrl($referrer));		
        }

        return $this->render('AppBundle:Public:sign_in.html.twig');
    }


    /**
     * @Route("/sign-up", name="sign_up")
     */
    public function signUpAction(Request $request)
    {
        if ($request->isMethod('POST')) {
	        $form = $this->createForm(new SignUpType());
        
            $form->bind($request);
            $signUpData = $form->getData();
			
			$cvResponse = $this->get('user')->createUser($signUpData['email'], $signUpData['password'], $this->generateUrl('homepage'), array(
				'given_name' => $signUpData['given_name'],
				'family_name' => $signUpData['family_name']
			));
			
			if ($cvResponse->outcome == CVResponse::RESPONSE_OUTCOME_SUCCESS) {
        		$this->get('session')->set('authenticated', true);	
        		
        		return $this->redirect($this->generateUrl('homepage'));			
			}
        	else {
				$error = $cvResponse->exception->userMessage;
        		$this->get('session')->set('authenticated', false);	
				$this->addFlash('errors', $error);
				
	        	return $this->redirect($this->generateUrl('homepage'));						
			}						
        } else {
        
        	return $this->render('AppBundle:Public:sign_up.html.twig');
        }
    }

    /**
     * Logout
     *
     * @Route("/logout", name="logout")
     */
    public function signOutAction(Request $request)
    {
        $required = $request->query->get('required', '');
        if($this->get('session')->has('authenticated') && $this->get('session')->get('authenticated'))
        {
            $this->get('session')->set('authenticated', false);
            $this->get('security.token_storage')->setToken(null);
            $this->get('request')->getSession()->invalidate();
        }
        
        if ($required === 'login') {
            return $this->redirectToRoute('homepage', array('required' => 'login'));
        } else {
            return $this->redirectToRoute('homepage');
        }        
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/verify-email", name="verify_email")
     */
    public function verifyEmailAction(Request $request)
    {
        $user_id = $request->query->get('user_id');
        $secret  = $request->query->get('secret');
                
        $this->get('public')->verifyEmail($user_id, $secret);

        return $this->redirect($this->generateUrl('homepage'));
    }
}
