<?php

namespace Avanzu\ProfileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Avanzu\ProfileBundle\Form\Model\ResetPassword;

/**
 * Description of ResettingController
 *
 * @author avanzu
 */
class ResettingController extends Controller {

    /**
     * @Route("/reset-password", name="reset_index")
     * @Template("")
     */
    public function indexAction(Request $request) {

        if (!$request->request->has('name_or_email')) {
            return array();
        }
        
        $manager = $this->get('avanzu_profile.usermanager');
        /* @var $manager \Avanzu\ProfileBundle\Manager\UserManager */
        try {
            $manager->initializeReset($request->request->get('name_or_email'));
        }
        catch (\Exception $exc) {
            $this->get('session')->getFlashBag()->add('error', $exc->getMessage());
        }
        
        return array();
    }
    
    
    /**
     * 
     * @param type $token
     * @param \Symfony\Component\HttpFoundation\Request $request
     * 
     * @Route("/reset-password/{token}", name="reset_reset")
     * @Template("")
     */
    public function resetAction($token, Request $request) {
        
        $manager = $this->get('avanzu_profile.usermanager'); /* @var $manager \Avanzu\ProfileBundle\Manager\UserManager */
        
        try {
            $user = $manager->findUserByToken($token);
        }
        catch (\Exception $exc) {
            throw $this->createNotFoundException($exc->getMessage());
        }

        $model   = new ResetPassword($manager, $user);
        $form    = $this->createForm('avanzu_profile_resetpassword', $model);
        
        if ('POST' == $request->getMethod()) {
            
            $form->bind($request); 
            
            if($form->isValid()) {
                $manager->resetPassword($user);
                $this->get('session')->getFlashBag()->add('success', 'password resetted');
                return $this->redirect($this->generateUrl('login'));
            }
        }
        
        return array(
            'form'  => $form->createView(),
            'token' => $token,
        );
    }

}