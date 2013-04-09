<?php

namespace Avanzu\ProfileBundle\Listener;


use Avanzu\ProfileBundle\Event\ProfileEvent; 
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
/**
 * Description of ProfileActivationListener
 *
 * @author avanzu
 */
class ProfileActivationListener {

    protected $context; 
    
    protected $container; 
    
    public function __construct(SecurityContext $context,  $container) {
        $this->context = $context;
        $this->container = $container;
    }
    
    public function onProfileActivated(ProfileEvent $event) {
        
        $user = $event->getUser();
        $accessToken = new UsernamePasswordToken($user, $user->getPassword(), 'main', $user->getRoles());
        $this->context->setToken($accessToken);
        $request = $this->container->get('request');
        $session = $request->getSession();
        $session->set('_security_main',  serialize($accessToken));
        
    }
    
}