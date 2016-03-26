<?php

namespace EventCalendar\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{    
      /**
     * @var string
     */
    protected $eventEntities = 'EventCalendar\Entity\Events';
    
     /**
     * @param boolean $eventEntities
     */
    public function setEventEntities($eventEntities)
    {
        $this->eventEntities = $eventEntities;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getEventEntities()
    {
        echo 'sdf';die;
        return $this->eventEntities;
    }
}
