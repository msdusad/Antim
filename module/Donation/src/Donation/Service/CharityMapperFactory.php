<?php

namespace Donation\Service;

use Donation\Mapper\Charity;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator;
use Donation\Entity\Charity as CharityEntity;

/**
 * @category   Shopping
 * @package    Shopping_Service
 */
class CharityMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
     
        //$options = $services->get('Shopping-ModuleOptions');
              
        $entityClass = new CharityEntity;

        $mapper = new Charity();
        $mapper->setDbAdapter($services->get('Donation_ZendDbAdapter'));
        $mapper->setEntityPrototype(new $entityClass);
        $mapper->setHydrator(new Hydrator\ClassMethods);

        return $mapper;
    }
}
