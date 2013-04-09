<?php

namespace Avanzu\ProfileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Avanzu\ProfileBundle\Form\Model\ChangePassword;

/**
 * Description of ProfileController
 *
 * @author avanzu
 * 
 */
class ProfileController extends Controller {
   
    /**
     * @Route("/", name="profile_index")
     * @Template("")
     */
    public function indexAction() {
        
        return array(
            'user' => $this->getUser()
        );
        
    }
    
    
    /**
     * @Route("/update", name="profile_update")
     * @Template("")
     */
    public function updateAction(Request $request) {
        $user = $this->getUser();
        $form = $this->createForm('avanzu_profile_profile', $user);
        if ('POST' == $request->getMethod()) {
            
            $form->bind($request);
            if ($form->isValid()){
                $em = $this->getDoctrine()->getEntityManager(); 
                $em->persist($user); 
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'User updated');
                return $this->redirect($this->generateUrl('profile_index'));
            }
            
        }
        
        return array(
            'form' => $form->createView()
        ); 
        
    }
    
    
    /**
     * @Route("/change-password", name="profile_change_password")
     * @Template("AvanzuProfileBundle:Profile:change-password.html.twig")
     */
    public function changePasswordAction(Request $request) {
        
        $user    = $this->getUser();
        $manager = $this->get('avanzu_profile.usermanager');
        $model   = new ChangePassword($manager, $user);
        
        
        $form = $this->createForm('avanzu_profile_changepassword', $model); 
        
        if ('POST' == $request->getMethod()) {
            $form->bind($request); 
            if ($form->isValid()) {
                $manager->changePassword($user);
                $this->get('session')->getFlashBag()->add('success', 'password changed');
                return $this->redirect($this->generateUrl('profile_index'));
            }
        }
        
        return array('form'=>$form->createView());
        
    }
}