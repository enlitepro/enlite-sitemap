<?php


return array(
    'router' => array(
        'routes' => array(),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'enliteSitemap generate' => array(
                    'options' => array(
                        'route' => 'enliteSitemap generate',
                        'defaults' => array(
                            'controller' => 'EnliteSitemapSitemap',
                            'action' => 'generate'
                        )
                    )
                ),
            )
        )
    ),
);
