<?php

return array(
    'service_manager' => array(
        'factories' => array(
            'EnliteSitemapSitemapService' => 'EnliteSitemap\Service\SitemapServiceFactory',
            'EnliteSitemapCommonOptions' => 'EnliteSitemap\CommonOptionsFactory',
            'EnliteSitemapNavigation' => 'EnliteSitemap\Navigation\ContainerFactory',
            'EnliteSitemapIndexNavigation' => 'EnliteSitemap\Navigation\ContainerIndexFactory',
        ),
        'invokables' => array(
            
        )
    ),
    'controllers' => array(
        'factories' => array(
            
        ),
        'invokables' => array(
            'EnliteSitemapSitemap' => 'EnliteSitemap\Controller\SitemapController'
        )
    )
);