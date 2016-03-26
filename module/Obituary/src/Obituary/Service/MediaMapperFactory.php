<?php

namespace Obituary\Service;

use Obituary\Mapper\Media;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator;
use Obituary\Entity\Media as MediaEntity;

/**
 * @category   Obituary
 * @package    Obituary_Service
 */
class MediaMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
     
        //$options = $services->get('Obituary-ModuleOptions');
              
        $entityClass = new MediaEntity;

        $mapper = new Media();
        $mapper->setDbAdapter($services->get('Obituary_ZendDbAdapter'));
        $mapper->setEntityPrototype(new $entityClass);
        $mapper->setHydrator(new Hydrator\ClassMethods);

        return $mapper;
    }
}
