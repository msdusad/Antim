<?php

namespace Donation\Service;

use Donation\Mapper\Cause;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator;
use Donation\Entity\Cause as CauseEntity;

/**
 * @category   Shopping
 * @package    Shopping_Service
 */
class CauseMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
     
        //$options = $services->get('Shopping-ModuleOptions');
              
        $entityClass = new CauseEntity;

        $mapper = new Cause();
        $mapper->setDbAdapter($services->get('Donation_ZendDbAdapter'));
        $mapper->setEntityPrototype(new $entityClass);
        $mapper->setHydrator(new Hydrator\ClassMethods);

        return $mapper;
    }
}
