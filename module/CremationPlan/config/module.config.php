<?php

return array(
    'controllers' => array(
        'invokables' => array(           
            'CremationPlan\Controller\Index' => 'CremationPlan\Controller\IndexController',
             'CremationPlan\Controller\Find' => 'CremationPlan\Controller\FindController',
            'CremationPlan\Controller\Product' => 'CremationPlan\Controller\ProductController',
            'CremationPlan\Controller\Garland' => 'CremationPlan\Controller\GarlandController',
			'CremationPlan\Controller\Travel' => 'CremationPlan\Controller\TravelController'
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'cremation-plans' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/cremation-plans[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'CremationPlan\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            'admin' => array(
                
                'child_routes' => array(
					
                    'find' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/find[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'CremationPlan\Controller',
                                'controller' => 'CremationPlan\Controller\Find',
                                'action' => 'index',
                            ),
                        ),
                    ), 
					
                     'products' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/products[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'CremationPlan\Controller',
                                'controller' => 'CremationPlan\Controller\Product',
                                'action' => 'index',
                            ),
                        ),
                    ), 
				
					
					
                       'garlands' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/garlands[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'CremationPlan\Controller',
                                'controller' => 'CremationPlan\Controller\Garland',
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
            'deleteaccount' => 'layout/admin',  
            'garlands' => 'layout/admin',  
        )
    )
);