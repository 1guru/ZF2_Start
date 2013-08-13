<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Api\Controller\User' => 'Api\Controller\UserController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'api-user' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/api/user[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Api\Controller\User',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);