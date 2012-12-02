<?php

namespace Avanzu\ProfileBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ResetPasswordType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('newPassword', 'repeated',
                  array(
                'first_name'  => 'newPassword',
                'second_name' => 'confirm',
                'type'        => 'password',
            ));
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class'         => 'Avanzu\ProfileBundle\Form\Model\ResetPassword',
            'cascade_validation' => true,
        ));
    }

    public function getName() {
        return 'avanzu_profile_resetpassword';
    }

}