<?php

namespace Shopping;

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
                'category-form' => function($sm) {
                    $form = new Form\Category();
                    $form->setInputFilter(new Form\CategoryFilter());
                    return $form;
                },'item-form' => function($sm) {
                    $form = new Form\Item();
                    $form->setInputFilter(new Form\ItemFilter());
                    return $form;
                }
            )
        );
    }

    public function onBootstrap($e) {
        
    }

}
