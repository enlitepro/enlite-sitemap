<?php


return array(
    'bjyauthorize' => array(
        'guards' => array(
            'BjyAuthorize\Guard\Route' => array(
                array('route' => 'enliteSitemap generate', 'roles' => array('guest')),
            ),
        ),
    )
);