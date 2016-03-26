<?php

return array(
    'controllers' => array(
        'invokables' => array( 
            'Donation\Controller\Cause' => 'Donation\Controller\CauseController',  
            'Donation\Controller\Charity' => 'Donation\Controller\CharityController',  
            'Donation\Controller\Index' => 'Donation\Controller\IndexController',  
                       
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
               'donation' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/donation[/:action][/:id][/:type]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'type' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Donation\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
                         
            'admin' => array(                
                'child_routes' => array(
                    'donation-cause' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/donation-cause[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Donation\Controller',
                                'controller' => 'Donation\Controller\Cause',
                                'action' => 'index',
                            ),
                        ),
                    ),  
                    'donation-charity' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/donation-charity[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Donation\Controller',
                                'controller' => 'Donation\Controller\Charity',
                                'action' => 'index',
                            ),
                        ),
                    ),  
                   
                ),
            ),
            
        ),
    ),
    'service_manager' => array(
        'aliases' => array(
            'Donation_ZendDbAdapter' => 'Zend\Db\Adapter\Adapter',
            'Donation_ZendSessionManager' => 'Zend\Session\SessionManager',
        ),
        'factories' => array(
            'Shopping-ModuleOptions' => 'Shopping\Service\ModuleOptionsFactory',
            'CauseMapper' => 'Donation\Service\CauseMapperFactory',
            'CharityMapper' => 'Donation\Service\CharityMapperFactory',
            'DonationsMapper' => 'Donation\Service\DonationsMapperFactory',
            
        ),
    ),    
    'view_manager' => array(
        
        'template_map' => array(
          
            
        ),
        'template_path_stack' => array(
            'donation' => __DIR__ . '/../view'
        ),
    ),
);
