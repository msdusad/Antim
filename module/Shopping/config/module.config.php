<?php

return array(
    'controllers' => array(
        'invokables' => array( 
            'Shopping\Controller\Category' => 'Shopping\Controller\CategoryController',
            'Shopping\Controller\Item' => 'Shopping\Controller\ItemController',
            'Shopping\Controller\Index' => 'Shopping\Controller\IndexController',
            'Shopping\Controller\Whishlist' => 'Shopping\Controller\WhishlistController',
                       
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
               'shopping' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/shopping[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Shopping\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            'whish-list' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/whish-list[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Shopping\Controller\Whishlist',
                        'action' => 'index',
                    ),
                ),
            ),
              
            'admin' => array(                
                'child_routes' => array(
                    'shopping-category' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/shopping-category[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Shopping\Controller',
                                'controller' => 'Shopping\Controller\Category',
                                'action' => 'index',
                            ),
                        ),
                    ), 
                    'shopping-item' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/shopping-item[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Shopping\Controller',
                                'controller' => 'Shopping\Controller\Item',
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
            'Shopping_ZendDbAdapter' => 'Zend\Db\Adapter\Adapter',
            'Shopping_ZendSessionManager' => 'Zend\Session\SessionManager',
        ),
        'factories' => array(
            'Shopping-ModuleOptions' => 'Shopping\Service\ModuleOptionsFactory',
            'CategoryMapper' => 'Shopping\Service\CategoryMapperFactory',
            'ItemMapper' => 'Shopping\Service\ItemMapperFactory',
            'WhishlistMapper' => 'Shopping\Service\WhishlistMapperFactory',
        ),
    ),    
    'view_manager' => array(
        
        'template_map' => array(
          
            
        ),
        'template_path_stack' => array(
            'shopping' => __DIR__ . '/../view'
        ),
    ),
);
