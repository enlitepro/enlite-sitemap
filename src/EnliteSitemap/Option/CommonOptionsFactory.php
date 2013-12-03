<?php

namespace EnliteSitemap\Option;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CommonOptionsFactory implements FactoryInterface
{

    /**
     * @inhertidoc
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        return new CommonOptions(
            isset($config['EnliteSitemap']) && isset($config['EnliteSitemap']['common'])
                ? $config['EnliteSitemap']['common']
                : []
        );
    }


}
