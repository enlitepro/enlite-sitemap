<?php


return array(
    'router' => array(
        'routes' => array(),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'enliteSitemap generation' => array(
                    'options' => array(
                        'route' => 'enliteSitemap generation',
                        'defaults' => array(
                            'controller' => 'EnliteSitemapSitemap',
                            'action' => 'generation'
                        )
                    )
                ),
            )
        )
    ),
);
