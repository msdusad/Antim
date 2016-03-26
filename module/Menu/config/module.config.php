<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Menu\Controller\Menu' => 'Menu\Controller\MenuController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'menu' => array(
                'type'    => 'segment',
                    'options' => array(
                        'route'    => '/menu[/:action][/:id]',
                        'constraints' => array(
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id'     => '[0-9]+',
                        ),
                        'defaults' => array(
                            'controller' => 'Menu\Controller\Menu',
                            'action'     => 'index',
                        ),
                    ),
            ),
        ),
    ),   
    'view_manager' => array(
        'template_map' => array(
           // 'layout/admin'              => __DIR__ . '/../view/layout/layout.phtml',
            //'error/404'               => __DIR__ . '/../view/error/404.phtml',
           // 'error/index'             => __DIR__ . '/../view/error/index.phtml',
            
        ),
        'template_path_stack' => array(
           'Menu' => __DIR__ . '/../view',
        ),
    ),
    'bjyauthorize' => array(
            'guards' => array(
                'BjyAuthorize\Guard\Controller' => array(
                     //array('controller' => 'Menu\Controller\Menu', 'roles' => array('2','3')),
					 
                     array('controller' => 'Menu\Controller\Menu', 'roles' => array('admin')), 
                ),
            ),
        ),
   
    
);