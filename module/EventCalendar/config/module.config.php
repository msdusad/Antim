<?php

return array(
    'controllers' => array(
        'invokables' => array(            
            'EventCalendar\Controller\Events' => 'EventCalendar\Controller\EventsController',
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
             'event-calendar-events' => array(
                'type' => 'Segment',
                'priority' => 2000,
                'options' => array(
                    'route' => '/events[/:action][/:id][/:type]',
                    'constraints' => array(                        
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'type'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'EventCalendar\Controller\Events',
                        'action' => 'index',
                    ),
                ),
            ),
            'event-calendar-json' => array(
                'type' => 'Segment',
                'priority' => 2000,
                'options' => array(
                    'route' => '/eventjson[/:action][/:id]',
                    'constraints' => array(                        
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'EventCalendar\Controller\Events',
                        'action' => 'events',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'aliases' => array(
            'EventCalendar_ZendDbAdapter' => 'Zend\Db\Adapter\Adapter',
            'EventCalendar_ZendSessionManager' => 'Zend\Session\SessionManager',
        ),
        'factories' => array(
            'EventCalendar-ModuleOptions' => 'EventCalendar\Service\ModuleOptionsFactory',
            'EventsMapper' => 'EventCalendar\Service\EventsMapperFactory',            
        ),
    ),    
    'view_manager' => array(
        'template_path_stack' => array(
            'event-calendar' => __DIR__ . '/../view'
        ),
    ),
);
