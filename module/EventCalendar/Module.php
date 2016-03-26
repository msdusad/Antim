<?php

namespace EventCalendar;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;


class Module implements AutoloaderProviderInterface, ConfigProviderInterface 
{
  
public function getAutoloaderConfig() {
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

    public function getConfig() {

        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig() {
        return array(
            'invokables' => array(
            ),
            'factories' => array(
               'events-form' => function($sm) {
                    $form = new Form\Events();
                    $form->setInputFilter(new Form\EventsFilter());
                    return $form;
                },
                'CommonTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    //$resultSetPrototype->setArrayObjectPrototype(new Model\Category());
                    return new TableGateway('death_user', $dbAdapter, null, $resultSetPrototype);
                }
            )
        );
    }

    public function onBootstrap($e) {

        
    }
}
