<?php

namespace IMandir;

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
                'IMandir\Model\IMandirTable' => function($sm) {
                    $tableGateway = $sm->get('TableGateway');
                    $table = new Model\PrePlanningTable($tableGateway);
                    return $table;
                },
                'TableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\IMandir());
                    return new TableGateway('preplanning', $dbAdapter, null, $resultSetPrototype);
                },
                 'IMandir\Model\FormsTable' => function($sm) {
                    $tableGateway = $sm->get('FormsTableGateway');
                    $table = new Model\FormsTable($tableGateway);
                    return $table;
                },
                'FormsTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Forms());
                    return new TableGateway('preplanning_forms', $dbAdapter, null, $resultSetPrototype);
                } ,
                 'IMandir\Model\CheckListTable' => function($sm) {
                    $tableGateway = $sm->get('CheckListTableGateway');
                    $table = new Model\CheckListTable($tableGateway);
                    return $table;
                },
                'CheckListTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\CheckList());
                    return new TableGateway('preplanning_checklist', $dbAdapter, null, $resultSetPrototype);
                }
                 ,
                 'IMandir\Model\LinksTable' => function($sm) {
                    $tableGateway = $sm->get('LinksTableGateway');
                    $table = new Model\LinksTable($tableGateway);
                    return $table;
                },
                 'LinksTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Links());
                    return new TableGateway('preplanning_links', $dbAdapter, null, $resultSetPrototype);
                }
            ),
                    
        );
    }

}
