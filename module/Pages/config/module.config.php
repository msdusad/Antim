<?php 
	return array(
	    'controllers' => array(
	        'invokables' => array(
	            'Pages\Controller\Page' => 'Pages\Controller\PageController',
                'Pages\Controller\AdminPages' => 'Pages\Controller\AdminPagesController',
	        ),
	    ),
    
	    'router' => array(
	        'routes' => array(
	              /** Page custom Routing **/
                   'page' => array(
        					'type' => 'Segment',
        					'options' => array(
        						'route'    => '/page[/:alias]',
        						'defaults' => array(
        							'controller' => 'Pages\Controller\Page',
        							'action'     => 'index',
        						),
        						'constraints' => array(
        							'alias'     => '[a-zA-Z][a-zA-Z0-9_-]*',
        						),
        					),
        		    ),
                  /** end page custom routing **/
                // For Administrator Hook Functionality 
                'admin-pages' => array(
    			     'type' => 'Segment',
            			'options' => array(
            				'route'    => '/admin-pages[/:action[/:id]]',
            				'defaults' => array(
            					'controller' => 'Pages\Controller\AdminPages',
            					'action'     => 'index',
            				),
            				'constraints' => array(
            					'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
            					'id'     => '[0-9]+',
            				),
            			),
               ),
	        ),
	    ),
	    'view_manager' => array(
        'template_map' => array(
            //'pages/preview'           => __DIR__ . '/../view/partial/preview-page.phtml',
            //'error/404'               => __DIR__ . '/../view/error/404.phtml',
            //'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
           'pages' => __DIR__ . '/../view', 
        ),
    ),
       'bjyauthorize' => array(
            'guards' => array(
                'BjyAuthorize\Guard\Controller' => array(
                     
					 array('controller' => 'Pages\Controller\AdminPages', 'roles' => array('admin')),
					 array('controller' => 'Pages\Controller\Pages', 'roles' => array('guest','user','admin'))
					 
					 //array('controller' => 'Pages\Controller\AdminPages', 'roles' => array('2','3')),
                     //array('controller' => 'Pages\Controller\Pages', 'roles' => array('guest','1','2','3','4'))
					 
                ),
            ),
        ),
	);