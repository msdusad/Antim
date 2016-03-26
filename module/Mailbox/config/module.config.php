<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Mailbox\Controller\Mail' => 'Mailbox\Controller\MailController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'mail' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/mail[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Mailbox\Controller\Mail',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_map' => array(
        ),
        'template_path_stack' => array(
           'Mailbox' => __DIR__ . '/../view',
        ),
    ),
    'bjyauthorize' => array(
        'guards' => array(
            'BjyAuthorize\Guard\Controller' => array(
                // array('controller' => 'Mailbox\Controller\Mail', 'roles' => array('2','3')),
				array('controller' => 'Mailbox\Controller\Mail', 'roles' => array('admin')), 
            ),
        ),
    ),


    
);