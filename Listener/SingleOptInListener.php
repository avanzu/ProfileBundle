<?php

namespace Avanzu\ProfileBundle\Listener;

use Avanzu\ProfileBundle\Event\ProfileEvent;
use Avanzu\ProfileBundle\Manager\UserManager;

/**
 * Description of SingleOptInListener
 *
 * @author avanzu
 */
class SingleOptInListener {

    
    protected $manager; 
    
    protected $dobuleOptIn; 
    
    public function __construct(UserManager $manager, $doubleOptIn) {
        $this->manager = $manager;
        $this->dobuleOptIn = $doubleOptIn;
    }
    
    
    public function onNewProfile(ProfileEvent $event) {
        
        if (true == $this->dobuleOptIn) return; 
        if ('profile.created' !== $event->getName()) return; 
        
        $this->manager->activateUserByToken($event->getUser()->getConfirmationToken());
        
    }
    
}