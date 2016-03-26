<?php

namespace Memoralize\Service;

use Memoralize\Mapper\Media;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator;
use Memoralize\Entity\Media as MediaEntity;

/**
 * @category   Memoralize
 * @package    Memoralize_Service
 */
class MediaMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
     
        //$options = $services->get('Memoralize-ModuleOptions');
              
        $entityClass = new MediaEntity;

        $mapper = new Media();
        $mapper->setDbAdapter($services->get('Memoralize_ZendDbAdapter'));
        $mapper->setEntityPrototype(new $entityClass);
        $mapper->setHydrator(new Hydrator\ClassMethods);

        return $mapper;
    }
}
