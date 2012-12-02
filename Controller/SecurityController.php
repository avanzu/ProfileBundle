<?php

namespace Avanzu\ProfileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Description of SecurityController
 *
 * @author avanzu
 */
class SecurityController extends Controller {
    
    
    /**
     * @Route("/login", name="login")
     * @Template("")
     */
    public function loginAction() {
        
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        $csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');
        
        return array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
            'csrf_token'    => $csrfToken,
        );
        
        
    }
    
    /**
     * @Route("/login-check", name="login_check")
     * @throws \RuntimeException
     */
    public function checkAction() {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }
    
    /**
     * @Route("/logout", name="logout")
     * @throws \RuntimeException
     * 
     */
    public function logoutAction() {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }
    
}