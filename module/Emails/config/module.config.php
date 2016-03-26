<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Emails\Controller\Index' => 'Emails\Controller\IndexController',
            'Emails\Controller\Group' => 'Emails\Controller\GroupsController',
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'inbox' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/inbox[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Emails\Controller',
                        'controller' => 'index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'sent-items' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/sent-items[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Emails\Controller\Index',
                        'action'     => 'sentitems',
                    ),
                ),
                
            ),
            'maildetail' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/maildetail[/:id][/:title]',
                    'constraints' => array(                        
                        'id'     => '[0-9]+',
                        'title' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Emails\Controller\Index',
                        'action'     => 'maildetail',
                    ),
                ),
                
            ),
            'compose-mail' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/compose-mail[/:share][/:id]',
                    'constraints' => array(
                        'share' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',                        
                    ),
                    'defaults' => array(
                        'controller' => 'Emails\Controller\Index',
                        'action'     => 'compose',
                    ),
                ),
                
            ),
            'reply-mail' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/reply-mail[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Emails\Controller\Index',
                        'action'     => 'reply',
                    ),
                ),
                
            ),
            'forward-mail' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/forward-mail[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Emails\Controller\Index',
                        'action'     => 'forward',
                    ),
                ),
                
            ),
              'contact-groups' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/contact-groups[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Emails\Controller\Group',
                        'action'     => 'index',
                    ),
                ),
                
            ),
             'contact-group-users' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/contact-group-users[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Emails\Controller\Group',
                        'action'     => 'users',
                    ),
                ),
                
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'emails' => __DIR__ . '/../view',
        ),
    ), 'module_layouts' => array(
        'Emails' => array(
            'default' => 'layout/layout',
            
        )
    ),
);