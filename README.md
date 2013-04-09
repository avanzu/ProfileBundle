Avanzu Profile Bundle 
=====================

Configuration: 

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
            entity: { class: [your bundle and userclass], property: username }

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