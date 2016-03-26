<?php

namespace Emails;


use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module {

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

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Emails\Model\EmailsTable' => function($sm) {
                    $tableGateway = $sm->get('EmailsTableGateway');
                    $table = new Model\EmailsTable($tableGateway);
                    return $table;
                },
                'EmailsTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Emails());
                    return new TableGateway('emails', $dbAdapter, null, $resultSetPrototype);
                },
                'Emails\Model\GroupsTable' => function($sm) {
                    $tableGateway = $sm->get('GroupsTableGateway');
                    $table = new Model\GroupsTable($tableGateway);
                    return $table;
                },
                'GroupsTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Groups());
                    return new TableGateway('email_group', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

}