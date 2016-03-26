<?php

return array(
    'controllers' => array(
        'invokables' => array( 
            'Memoralize\Controller\Index' => 'Memoralize\Controller\IndexController',
            'Memoralize\Controller\Infos' => 'Memoralize\Controller\InfosController',
            'Memoralize\Controller\Media' => 'Memoralize\Controller\MediaController',
            'Memoralize\Controller\Donation' => 'Memoralize\Controller\DonationController',
        ),
        'factories' => array(
           
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
          
        ),
    ),
    'router' => array(
        'routes' => array(
            'donations' => array(
                'type' => 'Segment',
                'priority' => 2000,
                'options' => array(
                    'route' => '/donations[/:action][/:id]',
                    'constraints' => array(                        
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Memoralize\Controller\Donation',
                        'action' => 'index',
                    ),
                ),
             ),   
            'memoralize' => array(
                'type' => 'Segment',
                'priority' => 2000,
                'options' => array(
                    'route' => '/memoralize[/:action][/:id]',
                    'constraints' => array(                        
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Memoralize\Controller\Index',
                        'action' => 'index',
                    ),
                ),
             ),   
             'memoralize-create' => array(
                'type' => 'Segment',
                'priority' => 2000,
                'options' => array(
                    'route' => '/memoralize-create[/:action][/:id][/:step]',
                    'constraints' => array(                        
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'step'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Memoralize\Controller\Index',
                        'action' => 'create',
                    ),
                ),
            ),     
              'memoralize-create-media' => array(
                'type' => 'Segment',
                'priority' => 2000,
                'options' => array(
                    'route' => '/memoralize-step2[/:action][/:id][/:step]', 
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'step'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Memoralize\Controller\Media',
                        'action' => 'index',
                    ),
                ),
            ), 
             'memoralize-create-infos' => array(
                'type' => 'Segment',
                'priority' => 2000,
                'options' => array(
                    'route' => '/memoralize-step1',                    
                    'defaults' => array(
                        'controller' => 'Memoralize\Controller\Infos',
                        'action' => 'index',
                    ),
                ),
            ),
            'memoralize-create-themes' => array(
                'type' => 'Segment',
                'priority' => 2000,
                'options' => array(
                    'route' => '/memoralize-step3[/:action][/:id][/:step]', 
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'step'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Memoralize\Controller\Media',
                        'action' => 'themes',
                    ),
                ),
            ), 
        ),
    ),
    'service_manager' => array(
        'aliases' => array(
            'Memoralize_ZendDbAdapter' => 'Zend\Db\Adapter\Adapter',
            'Memoralize_ZendSessionManager' => 'Zend\Session\SessionManager',
        ),
        'factories' => array(
            'Memoralize-ModuleOptions' => 'Memoralize\Service\ModuleOptionsFactory',
            'InfosMapper' => 'Memoralize\Service\InfosMapperFactory',
            'MediaMapper' => 'Memoralize\Service\MediaMapperFactory',
            'MemoralizeMapper' => 'Memoralize\Service\MemoralizeMapperFactory',           
        ),
    ),    
    'view_manager' => array(
        'template_path_stack' => array(
            'memoralize' => __DIR__ . '/../view'
        ),
    ),
);
