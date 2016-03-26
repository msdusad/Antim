<?php

namespace Memoralize\Service;

use Memoralize\Mapper\Infos;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator;
use Memoralize\Entity\Infos as InfosEntity;

/**
 * @category   Memoralize
 * @package    Memoralize_Service
 */
class InfosMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
     
        //$options = $services->get('EventCalendar-ModuleOptions');
              
        $entityClass = new InfosEntity;

        $mapper = new Infos();
        $mapper->setDbAdapter($services->get('Memoralize_ZendDbAdapter'));
        $mapper->setEntityPrototype(new $entityClass);
        $mapper->setHydrator(new Hydrator\ClassMethods);

        return $mapper;
    }
}
