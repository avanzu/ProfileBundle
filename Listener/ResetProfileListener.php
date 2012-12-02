<?php

namespace Avanzu\ProfileBundle\Listener;

use Avanzu\ProfileBundle\Manager\UserManager; 
use Avanzu\ProfileBundle\Event\ProfileEvent;
use Avanzu\ToolsBundle\Mailer\TwigMailer;

/**
 * Description of ResetProfileListener
 *
 * @author avanzu
 */
class ResetProfileListener {
    
    /**
     *
     * @var TwigMailer 
     */
    protected $mailer; 
    
    
    public function __construct(TwigMailer $mailer) {
        $this->mailer = $mailer;
    }
    
    public function onResetInitialized(ProfileEvent $event) {
        
        $user = $event->getUser();
        $toEmail = array($user->getEmail() => $user->getUsername());
        $this->mailer->sendMessage('AvanzuProfileBundle:Email:resetting.html.twig', array('user'=>$user), $toEmail);
        
    }
    
    
}