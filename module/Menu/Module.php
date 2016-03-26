<?php

namespace Menu;

use Menu\Model\MenuTable;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Header'   => new \Menu\Factory\NavigationFactory('first'),
                'Footer'   => new \Menu\Factory\NavigationFactory('second'),
                'Sidebar'  => new \Menu\Factory\NavigationFactory('third'),
				
			    'Menu\model\MenuTable' => function($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $table = new MenuTable($dbAdapter);
                        return $table;
                }
               ),
        );
    }    

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
   
}