<?php

namespace Avanzu\ProfileBundle\Event;

use Symfony\Component\EventDispatcher\Event;
/**
 * Description of ProfileEvent
 *
 * @author avanzu
 */
class ProfileEvent extends Event {
    
    protected $user; 

    public function __construct($user) {
        $this->user = $user;
    }
    
    
    public function getUser() {
        return $this->user;
    }


    
}