<?php

namespace Avanzu\ProfileBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('username')
            ->add('email')
            ->add('plainPassword', 'repeated',
                  array(
                'first_name'  => 'password',
                'second_name' => 'confirm',
                'type'        => 'password',
            ));
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class'         => 'Avanzu\ProfileBundle\Entity\User',
            'cascade_validation' => true,
        ));
    }

    public function getName() {
        return 'avanzu_profile_usertype';
    }

}
