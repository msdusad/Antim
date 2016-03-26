<?php
/**
 * Shopping Module
 *
 * @category   Shopping
 * @package    Shopping_Service
 */

namespace Shopping\Service;

use Shopping\Options;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @category   Shopping
 * @package    Shopping_Service
 */
class ModuleOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        //$config = $services->get('Configuration');

        return new Options\ModuleOptions();
    }
}
