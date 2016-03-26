<?php

namespace CremationPlan;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module implements AutoloaderProviderInterface {

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    // if we're in a namespace deeper than one level we need to fix the \ in the path
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
                // register UserTable to service manager                
                'CremationPlan\Model\FindTable' => function($sm) {
                    $tableGateway = $sm->get('FindTableGateway');
                    $table = new Model\FindTable($tableGateway);
                    return $table;
                },
                'FindTableGateway' => function ($sm) {

                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Find());
                    return new TableGateway('find', $dbAdapter, null, $resultSetPrototype);
                },
                'CremationPlan\Model\ProductTable' => function($sm) {
                    $tableGateway = $sm->get('ProductTableGateway');
                    $table = new Model\ProductTable($tableGateway);
                    return $table;
                },
                'ProductTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Product());
                    return new TableGateway('product', $dbAdapter, null, $resultSetPrototype);
                },
                'CremationPlan\Model\AllTable' => function($sm) {
                    $tableGateway = $sm->get('AllTableGateway');
                    $table = new Model\AllTable($tableGateway);
                    return $table;
                },
                'AllTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\All());
                    return new TableGateway('product', $dbAdapter, null, $resultSetPrototype);
                },
                'CremationPlan\Model\GarlandTable' => function($sm) {
                    $tableGateway = $sm->get('GarlandTableGateway');
                    $table = new Model\GarlandTable($tableGateway);
                    return $table;
                },
                'GarlandTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Garland());
                    return new TableGateway('garland', $dbAdapter, null, $resultSetPrototype);
                }
            )
        );
    }

}
