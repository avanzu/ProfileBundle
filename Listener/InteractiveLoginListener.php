<?php

namespace Avanzu\ProfileBundle\Listener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent; 
use Doctrine\ORM\EntityManager;

/**
 * Description of InteractiveLoginListener
 *
 * @author avanzu
 */
class InteractiveLoginListener {
    
    protected $em;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    
    public function onLogin(InteractiveLoginEvent $event) {
        
        $user = $event->getAuthenticationToken()->getUser(); /*@var $user \Avanzu\ProfileBundle\Entity\User */
        if ($user instanceof \Avanzu\ProfileBundle\Entity\User) {
            $user->setLastLogin(new \DateTime())->setConfirmationToken(null);
            $this->em->persist($user);
            $this->em->flush();
        }
    }
}