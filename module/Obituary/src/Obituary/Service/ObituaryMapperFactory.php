<?php

namespace Obituary\Service;

use Obituary\Mapper\Obituary;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator;
use Obituary\Entity\Obituary as ObituaryEntity;

/**
 * @category   Obituary
 * @package    Obituary_Service
 */
class ObituaryMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
     
        //$options = $services->get('Obituary-ModuleOptions');
              
        $entityClass = new ObituaryEntity;

        $mapper = new Obituary();
        $mapper->setDbAdapter($services->get('Obituary_ZendDbAdapter'));
        $mapper->setEntityPrototype(new $entityClass);
        $mapper->setHydrator(new Hydrator\ClassMethods);

        return $mapper;
    }
}
