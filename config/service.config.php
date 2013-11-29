<?php

return array(
    'service_manager' => array(
        'factories' => array(
            'EnliteSitemapSitemapService' => 'EnliteSitemap\Service\SitemapServiceFactory',
            'EnliteSitemapCommonOptions' => 'EnliteSitemap\CommonOptionsFactory'
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