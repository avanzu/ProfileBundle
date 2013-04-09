<?php

namespace Avanzu\ProfileBundle\Form\Model;

use Avanzu\ProfileBundle\Manager\UserManager;
use Symfony\Component\Validator\Constraints as Assert;
use Avanzu\ProfileBundle\Entity\User;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

/**
 * Description of ResetPassword
 *
 * @author avanzu
 */
class ResetPassword {

    protected $manager; 
    
    protected $user; 
    
    public function __construct(UserManager $manager, User $user) {
        $this->manager = $manager;
        $this->user    = $user;
    }


    /**
     * 
     * @return string
     * @Assert\NotBlank()
     * @Assert\Length(min=6, minMessage="user.password.minlength")
     */
    public function getNewPassword() {
        return $this->user->getPlainPassword();
    }

    public function setNewPassword($newPassword) {
        $this->user->setPlainPassword($newPassword);
    }

    public function getUser() {
        return $this->user;
    }

    

}