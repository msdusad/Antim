<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'sharedtasks' => 'SharedTasks\Controller\IndexController',
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'sharedtasks' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/sharedtasks[/:action][/:id][/:type]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',                        
                        'id' => '[0-9]+',
                        'type' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => 'sharedtasks',
                        'action'     => 'index',
                    ),
                ),
            ),
            
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'shared-tasks' => __DIR__ . '/../view',
        ),
    ),
);