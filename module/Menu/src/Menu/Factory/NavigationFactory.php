<?php
namespace Menu\Factory;
 
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Menu\Service\Navigation;
 
class NavigationFactory implements FactoryInterface
{
    protected $navigation;
    public function __construct($nav)
    {
       $this->navigation =$nav;
    }
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $navigation =  new Navigation($this->navigation);
        return $navigation->createService($serviceLocator);
    }
}