<?php

namespace Obituary;

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
                 
                'infos-form' => function($sm) {
                    $form = new Form\Infos();
                    $form->setInputFilter(new Form\InfosFilter());
                    return $form;
                },
                'main-form' => function($sm) {
                    $form = new Form\Obituary();
                    $form->setInputFilter(new Form\ObituaryFilter());
                    return $form;
                },
                'media-form' => function($sm) {
                    $form = new Form\Media();
                    $form->setInputFilter(new Form\MediaFilter());
                    return $form;
                },
            )
        );
    }

    public function onBootstrap($e) {
        
    }

}
