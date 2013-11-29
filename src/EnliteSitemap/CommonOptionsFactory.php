<?php

namespace EnliteSitemap;

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
            isset($config['EnliteSitemapCommon'])
                ? $config['EnliteSitemapCommon']
                : []
        );
    }


}
