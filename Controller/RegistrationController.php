<?php

namespace Avanzu\ProfileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Avanzu\ProfileBundle\Form\Model\Registration;

/**
 * Description of RegistrationController
 *
 * @author avanzu
 */
class RegistrationController extends Controller {

    /**
     * @Route("/register", name="profile_register")
     * @Template("")
     */
    public function registerAction() {

        $form = $this->createForm('avanzu_profile_registration', new Registration());

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/create-profile", name="profile_create")
     * @Template("AvanzuProfileBundle:Registration:register.html.twig")
     */
    public function createAction(Request $request) {

        $registration = new Registration();
        $form         = $this->createForm('avanzu_profile_registration', $registration);

        $form->bind($request);

        if ($form->isValid()) {
            try {
                
                $this->get('avanzu_profile.usermanager')->createUser($registration);
                
                $this->get('session')->set('newuserid', $registration->getUser()->getId());
                return $this->getReturnUrl();
            }
            catch (\Exception $e) {
                $this->get('session')->setFlash('error', $e->getMessage());
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/activate-profile/{token}", name="profile_activate")
     * 
     */
    public function activateAction($token) {
        
        $this->get('avanzu_profile.usermanager')->activateUserByToken($token);
        return $this->redirect($this->generateUrl('profile_confirm'));
    }
    
    /**
     * @Route("/confirm-profile", name="profile_confirm")
     * @Template("")
     */
    public function confirmAction() {
        return array();
    }
    
    /**
     * 
     * @return array
     * @Route("/check-email", name="profile_check_email")
     * @Template("AvanzuProfileBundle:Registration:check-email.html.twig")
     */
    public function checkEmailAction() {
        
        $userid = $this->get('session')->get('newuserid'); 
        $class  = $this->container->getParameter('avanzu_profile.user_class');
        $user   = $this->getDoctrine()->getRepository($class)->find($userid);
        
        return array(
            'user' => $user
        );
    }
    
    
    protected function getReturnUrl() {
        
        $doubleOptIn = $this->container->getParameter('avanzu_profile.registration.doubleoptin');
        
        if ($doubleOptIn) {
            return $this->redirect($this->generateUrl('profile_check_email'));
        }
        
        return $this->redirect($this->generateUrl('profile_confirm'));
        
    }

}