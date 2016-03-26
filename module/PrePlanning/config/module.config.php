<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'PrePlanning\Controller\Index' => 'PrePlanning\Controller\IndexController',
            'PrePlanning\Controller\forms' => 'PrePlanning\Controller\IndexController',
            'PrePlanning\Controller\Pre' => 'PrePlanning\Controller\PrePlanningController',
            'PrePlanning\Controller\Links' => 'PrePlanning\Controller\LinksController',
			 'PrePlanning\Controller\Forms' => 'PrePlanning\Controller\FormsController',
			 'PrePlanning\Controller\State' => 'PrePlanning\Controller\StateController',
			
        ),
    ),
	
	 
	  
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(

			 'state' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/state[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'PrePlanning\Controller\State',
                        'action' => 'index',
                    ),
					
                ),
            ),
			
            'pre-planning' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/pre-planning[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'PrePlanning\Controller\Index',
                        'action' => 'index',
                    ),
					
                ),
            ),
			
			   

            'admin' => array(
                'child_routes' => array(
                    'pre-planning' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/pre-planning[/:action][/:category][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'category' => '[0-9]+',
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'PrePlanning\Controller',
                                'controller' => 'PrePlanning\Controller\Pre',
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'preplanning-links' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/preplanning-links[/:action][/:category][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'category' => '[0-9]+',
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'PrePlanning\Controller',
                                'controller' => 'PrePlanning\Controller\Links',
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
        )
    )
);
