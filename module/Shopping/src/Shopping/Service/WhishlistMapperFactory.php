<?php

namespace Shopping\Service;

use Shopping\Mapper\Whishlist;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator;
use Shopping\Entity\Whishlist as WhishlistEntity;

/**
 * @category   Shopping
 * @package    Shopping_Service
 */
class WhishlistMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {     
        //$options = $services->get('Shopping-ModuleOptions');
              
        $entityClass = new WhishlistEntity;

        $mapper = new Whishlist();
        $mapper->setDbAdapter($services->get('Shopping_ZendDbAdapter'));
        $mapper->setEntityPrototype(new $entityClass);
        $mapper->setHydrator(new Hydrator\ClassMethods);

        return $mapper;
    }
}
