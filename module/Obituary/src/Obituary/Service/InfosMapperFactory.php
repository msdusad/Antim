<?php

namespace Obituary\Service;

use Obituary\Mapper\Infos;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator;

/**
 * @category   Obituary
 * @package    Obituary_Service
 */
class InfosMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
     
        $options = $services->get('Obituary-ModuleOptions');
        $entityClass = $options->getInfosEntities(); 
       
        $mapper = new Infos();
        $mapper->setDbAdapter($services->get('Obituary_ZendDbAdapter'));
        $mapper->setEntityPrototype(new $entityClass);
        $mapper->setHydrator(new Hydrator\ClassMethods);

        return $mapper;
    }
}
