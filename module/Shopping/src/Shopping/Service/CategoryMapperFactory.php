<?php

namespace Shopping\Service;

use Shopping\Mapper\Category;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator;
use Shopping\Entity\Category as CategoryEntity;

/**
 * @category   Shopping
 * @package    Shopping_Service
 */
class CategoryMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
     
        //$options = $services->get('Shopping-ModuleOptions');
              
        $entityClass = new CategoryEntity;

        $mapper = new Category();
        $mapper->setDbAdapter($services->get('Shopping_ZendDbAdapter'));
        $mapper->setEntityPrototype(new $entityClass);
        $mapper->setHydrator(new Hydrator\ClassMethods);

        return $mapper;
    }
}
