<?php

namespace Avanzu\ProfileBundle\Listener;


use Avanzu\ProfileBundle\Event\ProfileEvent; 
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
/**
 * Description of ProfileActivationListener
 *
 * @author avanzu
 */
class ProfileActivationListener {

    protected $context; 
    
    public function __construct(SecurityContext $context) {
        $this->context = $context;
    }
    
    public function onProfileActivated(ProfileEvent $event) {
        
        $user = $event->getUser();
        $accessToken = new UsernamePasswordToken($user, null, 'avanzu_profile', $user->getRoles());
        $this->context->setToken($accessToken);
        
    }
    
}