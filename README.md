Avanzu Profile Bundle 
=====================

Create User Entity
----------------------

    use Doctrine\ORM\Mapping as ORM;
    use Avanzu\ProfileBundle\Entity\User as BaseUser;
    
    /**
     * @ORM\Entity()
     */
    class User extends BaseUser {}

Create User Type
----------------------

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolverInterface;

    class UserType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
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

        public function setDefaultOptions(OptionsResolverInterface $resolver)
        {
            $resolver->setDefaults(array(
                'data_class' => 'Pma\CommonBundle\Entity\User'
            ));
        }

        public function getName()
        {
            return 'avanzu_profile_user';
        }
    }

------------------------------------------------

Configuration: 
=======================

------------------------------------------------
    #config.yml
    avanzu_profile: 
        user_class: Pma\CommonBundle\Entity\User
        form:
          class:
            user: Pma\CommonBundle\Form\Type\UserType

-------------------------------------------------

    # routing.yml 
    avanzu_profile_profile: 
        resource: "@AvanzuProfileBundle/Controller/ProfileController.php"
        type: annotation
        prefix: /profile

    avanzu_profile_security: 
      resource: "@AvanzuProfileBundle/Controller/SecurityController.php"
      type: annotation
      prefix: /

    avanzu_profile_registration: 
      resource: "@AvanzuProfileBundle/Controller/RegistrationController.php"
      type: annotation
      prefix: /

    avanzu_profile_resetting: 
      resource: "@AvanzuProfileBundle/Controller/ResettingController.php"
      type: annotation
      prefix: /

----------------------------------------------

    # security.yml
    
    security:
        encoders:
            Avanzu\ProfileBundle\Entity\User: sha512

    providers:
        avanzu_profile_bundle:
            entity: { class: __your bundle and userclass__, property: username }

    firewalls:
        main:
            pattern: ^/
            provider: avanzu_profile_bundle
            form_login: 
              login_path: /login
              check_path: /login-check
            anonymous: ~
            logout: ~


    access_control:
        - { path: ^/login, roles: IS_AUTHENTICATED_ANONYMOUSLY}
        - { path: ^/profile, roles: ROLE_USER }
        - { path: ^/, roles: IS_AUTHENTICATED_ANONYMOUSLY }        

-------------------------------------------------
