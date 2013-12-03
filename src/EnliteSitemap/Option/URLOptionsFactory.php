<?php

namespace EnliteSitemap\Option;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class URLOptionsFactory implements FactoryInterface
{

    /**
     * @inhertidoc
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        return new URLOptions(
            isset($config['EnliteSitemap']) && isset($config['EnliteSitemap']['url'])
                ? $config['EnliteSitemap']['url']
                : []
        );
    }


}
