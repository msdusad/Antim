<?php

namespace Donation\Service;

use Donation\Mapper\Donations;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator;
use Donation\Entity\Donations as DonationsEntity;

/**
 * @category   Shopping
 * @package    Shopping_Service
 */
class DonationsMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {     
        //$options = $services->get('Shopping-ModuleOptions');
              
        $entityClass = new DonationsEntity;

        $mapper = new Donations();
        $mapper->setDbAdapter($services->get('Shopping_ZendDbAdapter'));
        $mapper->setEntityPrototype(new $entityClass);
        $mapper->setHydrator(new Hydrator\ClassMethods);

        return $mapper;
    }
}
