<?php

namespace Avanzu\ProfileBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Avanzu\ProfileBundle\Form\Type\UserType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationType extends UserType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('user', 'avanzu_profile_user')
            ->add('termsAccepted', null, array('label' => 'form.label.terms_accepted'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'validation_groups' => array('Default', 'Registration'),
            'data_class'         => 'Avanzu\ProfileBundle\Form\Model\Registration',
            'cascade_validation' => true,
        ));
    }

    public function getName() {
        return 'avanzu_profile_registration';
    }

}