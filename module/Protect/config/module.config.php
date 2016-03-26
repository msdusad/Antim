<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'document' => 'Protect\Controller\DocumentController',
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'documents' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/documents[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'document',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'protect' => __DIR__ . '/../view',
        ),
    ),
);