<?php

return array(
    'controllers' => array(
        'invokables' => array( 
            'Obituary\Controller\Index' => 'Obituary\Controller\IndexController',
            'Obituary\Controller\Infos' => 'Obituary\Controller\InfosController',
            'Obituary\Controller\Media' => 'Obituary\Controller\MediaController',            
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
                        'controller' => 'Obituary\Controller\Donation',
                        'action' => 'index',
                    ),
                ),
             ),   
            'obituary' => array(
                'type' => 'Segment',
                'priority' => 2000,
                'options' => array(
                    'route' => '/obituary[/:action][/:id]',
                    'constraints' => array(                        
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Obituary\Controller\Index',
                        'action' => 'index',
                    ),
                ),
             ),  
           
              'viewobituary' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route' => '/viewobituary[/:id]',
                            'constraints' => array(                        
                       			 'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        		 'id'     => '[0-9]+',
                   			 ),
                            'defaults' => array(
                                'controller' => 'Obituary\Controller\Index',
                                'action'     => 'viewobituary',
                            ),
                        ),
                    ),  
              'obituary-create-media' => array(
                'type' => 'Segment',
                'priority' => 2000,
                'options' => array(
                    'route' => '/obituary-step2[/:action][/:id][/:step]', 
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'step'     => '[0-9]+',                        
                    ),
                    'defaults' => array(
                        'controller' => 'Obituary\Controller\Media',
                        'action' => 'index',
                    ),
                ),
            ), 
             'obituary-create-infos' => array(
                'type' => 'Segment',
                'priority' => 2000,
                'options' => array(
                    'route' => '/obituary-step1[/:action][/:id]',
                    'constraints' => array(  
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+', 
                    ),
                    'defaults' => array(
                        'controller' => 'Obituary\Controller\Infos',
                        'action' => 'index',
                    ),
                ),
            ),
            'obituary-create-themes' => array(
                'type' => 'Segment',
                'priority' => 2000,
                'options' => array(
                    'route' => '/obituary-step3[/:action][/:id][/:step][/:language]', 
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'step'     => '[0-9]+',
                        'language'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Obituary\Controller\Media',
                        'action' => 'themes',
                    ),
                ),
            ), 
        ),
    ),
    'service_manager' => array(
        'aliases' => array(
            'Obituary_ZendDbAdapter' => 'Zend\Db\Adapter\Adapter',
            'Obituary_ZendSessionManager' => 'Zend\Session\SessionManager',
        ),
        'factories' => array(
            'Obituary-ModuleOptions' => 'Obituary\Service\ModuleOptionsFactory',
            'InfosMapper' => 'Obituary\Service\InfosMapperFactory',
            'MediaMapper' => 'Obituary\Service\MediaMapperFactory',
            'ObituaryMapper' => 'Obituary\Service\ObituaryMapperFactory',           
        ),
    ),    
    'view_manager' => array(
         'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'obituary/popup'           => __DIR__ . '/../view/obituary/infos/popup.phtml',    
            
        ),
        'template_path_stack' => array(
            'obituary' => __DIR__ . '/../view'
        ),
    ),
);
