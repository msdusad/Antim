<?php

namespace Donation;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface {

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
                'cause-form' => function($sm) {
                    $form = new Form\Cause();
                    $form->setInputFilter(new Form\CauseFilter());
                    return $form;
                },
                        'charity-form' => function($sm) {
                    $form = new Form\Charity();
                    $form->setInputFilter(new Form\CharityFilter());
                    return $form;
                }
            )
        );
    }

    public function onBootstrap($e) {
        
    }

}
