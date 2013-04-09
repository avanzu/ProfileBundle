<?php

namespace Avanzu\ProfileBundle\Form\Model;

use Avanzu\ProfileBundle\Manager\UserManager; 
use Symfony\Component\Validator\Constraints as Assert;
use Avanzu\ProfileBundle\Entity\User;

/**
 * Description of ChangePassword
 *
 * @author avanzu
 */
class ChangePassword {
    
    /**
     *
     * @var string
     * @Assert\NotBlank() 
     */
    protected $oldPassword; 
    
    protected $manager; 
    
    protected $user; 
    
    
    public function __construct(UserManager $manager, User $user) {
        $this->manager = $manager;
        $this->user    = $user;
    }
    
    public function getOldPassword() {
        return $this->oldPassword;
    }

    public function setOldPassword($oldPassword) {
        $this->oldPassword = $oldPassword;
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
        if ($this->isOldPasswordValid()) {
            $this->user->setPlainPassword($newPassword);
        }
    }

    public function getUser() {
        return $this->user;
    }

    /**
     * @Assert\True(message="Old Password is not correct")
     */
    public function isOldPasswordValid() {
        
        $pass = $this->manager->getEncodedPassword($this->oldPassword, $this->user);
        return $pass == $this->user->getPassword();
        
    }
    
}