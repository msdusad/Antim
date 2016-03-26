<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'IMandir\Controller\Index' => 'IMandir\Controller\IndexController',
            'IMandir\Controller\Pre' => 'IMandir\Controller\IMandirController',
            'IMandir\Controller\Links' => 'IMandir\Controller\LinksController',
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'i-mandir' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/i-mandir[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'IMandir\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            'admin' => array(
                'child_routes' => array(
                    'i-mandir' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/i-mandir[/:action][/:category][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'category' => '[0-9]+',
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'IMandir\Controller',
                                'controller' => 'IMandir\Controller\Pre',
                                'action' => 'index',
                            ),
                        ),
                    ),
                    
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'module_layouts' => array(
        'CremationPlan' => array(
            'default' => 'layout/layout',
        )
    )
);