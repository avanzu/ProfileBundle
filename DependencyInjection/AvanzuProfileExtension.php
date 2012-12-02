<?php

namespace Avanzu\ProfileBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AvanzuProfileExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        
        if(isset($config['form']['class']['user'])) {
            $container->setParameter('avanzu_profile.form.class.user', $config['form']['class']['user']);
        }
        
        if(isset($config['form']['class']['registration'])) {
            $container->setParameter('avanzu_profile.form.class.registration', $config['form']['class']['registration']);
        }
        
        if (isset($config['user_class'])) {
            $container->setParameter('avanzu_profile.user_class', $config['user_class']);
        }
        
        if (isset($config['registration'])) {
            
            if (isset($config['registration']['doubleoptin'])) {
                $container->setParameter('avanzu_profile.registration.doubleoptin', $config['registration']['doubleoptin']);
            }
        }
        
    }
}
