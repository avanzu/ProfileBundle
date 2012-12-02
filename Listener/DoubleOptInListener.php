<?php

namespace Avanzu\ProfileBundle\Listener;

use Avanzu\ToolsBundle\Mailer\TwigMailer;

use Avanzu\ProfileBundle\Event\ProfileEvent;

/**
 * Description of DoubleOptInListener
 *
 * @author avanzu
 */
class DoubleOptInListener {
    
    /**
     *
     * @var TwigMailer 
     */
    protected $mailer;
    
    protected $doubleOptIn;
    
    public function __construct(TwigMailer $mailer, $doubleOptIn) {
        
        $this->mailer   = $mailer;
        $this->doubleOptIn = $doubleOptIn;
    }
    
    
    public function onNewProfile(ProfileEvent $event) {
        
        if (!$this->doubleOptIn) return; 
        if ('profile.created' !== $event->getName()) return; 
        
        $user = $event->getUser();
        $toEmail = array($user->getEmail() => $user->getUsername());
        
        $this->mailer->sendMessage('AvanzuProfileBundle:Email:registration.html.twig', array('user'=>$user), $toEmail);
        
    }
}