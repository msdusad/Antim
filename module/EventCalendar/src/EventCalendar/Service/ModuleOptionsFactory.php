<?php
/**
 * EventCalendar Module
 *
 * @category   EventCalendar
 * @package    EventCalendar_Service
 */

namespace EventCalendar\Service;

use EventCalendar\Options;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @category   EventCalendar
 * @package    EventCalendar_Service
 */
class ModuleOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        $config = $services->get('Configuration');

        return new Options\ModuleOptions(isset($config['event-calendar-auth']) ? $config['event-calendar-auth'] : array());
    }
}
