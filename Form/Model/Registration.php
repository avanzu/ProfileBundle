<?php

namespace Avanzu\ProfileBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

use Avanzu\ProfileBundle\Entity\User;

/**
 * Description of Registration
 *
 * @author avanzu
 */
class Registration {

    /**
     *
     * @var User 
     * 
     * @Assert\Type(type="Avanzu\ProfileBundle\Entity\User")
     */
    protected $user; 

    /**
     *
     * @var bool
     * @Assert\NotBlank(message="registration.terms.blank")
     * @Assert\True(message="registration.terms.true") 
     */
    protected $termsAccepted;
    
    
    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function getTermsAccepted() {
        return $this->termsAccepted;
    }

    public function setTermsAccepted($termsAccepted) {
        $this->termsAccepted = $termsAccepted;
    }

    
}