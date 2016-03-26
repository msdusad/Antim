<?php

namespace Shopping\Service;

use Shopping\Mapper\Item;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator;
use Shopping\Entity\Item as ItemEntity;

/**
 * @category   Shopping
 * @package    Shopping_Service
 */
class ItemMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
     
        //$options = $services->get('Shopping-ModuleOptions');
              
        $entityClass = new ItemEntity;

        $mapper = new Item();
        $mapper->setDbAdapter($services->get('Shopping_ZendDbAdapter'));
        $mapper->setEntityPrototype(new $entityClass);
        $mapper->setHydrator(new Hydrator\ClassMethods);

        return $mapper;
    }
}
