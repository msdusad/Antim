<?php

namespace EventCalendar\Service;

use EventCalendar\Mapper\Events;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator;
use EventCalendar\Entity\Events as EventEntity;

/**
 * @category   EventCalendar
 * @package    EventCalendar_Service
 */
class EventsMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
     
        //$options = $services->get('EventCalendar-ModuleOptions');
              
        $entityClass = new EventEntity;

        $mapper = new Events();
        $mapper->setDbAdapter($services->get('EventCalendar_ZendDbAdapter'));
        $mapper->setEntityPrototype(new $entityClass);
        $mapper->setHydrator(new Hydrator\ClassMethods);

        return $mapper;
    }
}
