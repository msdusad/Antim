<?php

namespace Memoralize\Service;

use Memoralize\Mapper\Memoralize;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator;
use Memoralize\Entity\Memoralize as MemoralizeEntity;

/**
 * @category   Memoralize
 * @package    Memoralize_Service
 */
class MemoralizeMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
     
        //$options = $services->get('Memoralize-ModuleOptions');
              
        $entityClass = new MemoralizeEntity;

        $mapper = new Memoralize();
        $mapper->setDbAdapter($services->get('Memoralize_ZendDbAdapter'));
        $mapper->setEntityPrototype(new $entityClass);
        $mapper->setHydrator(new Hydrator\ClassMethods);

        return $mapper;
    }
}
