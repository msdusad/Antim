<?php
/**
 * Obituary Module
 *
 * @category   Obituary
 * @package    Obituary_Service
 */

namespace Obituary\Service;

use Obituary\Options;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @category   Obituary
 * @package    Obituary_Service
 */
class ModuleOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        //$config = $services->get('Configuration');

        return new Options\ModuleOptions();
    }
}
