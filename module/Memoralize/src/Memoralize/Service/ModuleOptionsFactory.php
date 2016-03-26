<?php
/**
 * Memoralize Module
 *
 * @category   Memoralize
 * @package    Memoralize_Service
 */

namespace Memoralize\Service;

use Memoralize\Options;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @category   Memoralize
 * @package    Memoralize_Service
 */
class ModuleOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        //$config = $services->get('Configuration');

        return new Options\ModuleOptions();
    }
}
