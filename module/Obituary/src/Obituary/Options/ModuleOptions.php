<?php

namespace Obituary\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{    
      /**
     * @var string
     */
    protected $infoEntities = 'Obituary\Entity\Infos';
     /**
     * @var string
     */
    protected $mediaEntities = 'Obituary\Entity\Media';
    /**
     * @var string
     */
    protected $obituaryEntities = 'Obituary\Entity\Obituary';
    
     /**
     * @param boolean $infoEntities
     */
    public function setInfosEntities($infoEntities)
    {
        $this->infoEntities = $infoEntities;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getInfosEntities()
    {
       
        return $this->infoEntities;
    }
     /**
     * @param boolean $infoEntities
     */
    public function setMediaEntities($mediaEntities)
    {
        $this->mediaEntities = $mediaEntities;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getMediaEntities()
    {
       
        return $this->mediaEntities;
    }
     /**
     * @param boolean $obituaryEntities
     */
    public function setObituaryEntities($obituaryEntities)
    {
        $this->obituaryEntities = $obituaryEntities;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getObituaryEntities()
    {
       
        return $this->obituaryEntities;
    }
}
