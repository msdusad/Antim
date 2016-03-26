<?php

namespace Memoralize\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{    
      /**
     * @var string
     */
    protected $infoEntities = 'Memoralize\Entity\Infos';
     /**
     * @var string
     */
    protected $mediaEntities = 'Memoralize\Entity\Media';
    /**
     * @var string
     */
    protected $memoralizeEntities = 'Memoralize\Entity\Memoralize';
    
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
     * @param boolean $memoralizeEntities
     */
    public function setMemoralizeEntities($memoralizeEntities)
    {
        $this->memoralizeEntities = $memoralizeEntities;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getMemoralizeEntities()
    {
       
        return $this->memoralizeEntities;
    }
}
