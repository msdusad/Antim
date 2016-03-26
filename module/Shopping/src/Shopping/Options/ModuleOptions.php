<?php

namespace Shopping\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{    
      /**
     * @var string
     */
    protected $categoryEntities = 'Shopping\Entity\Category';
    
     /**
     * @var string
     */
    protected $itemEntities = 'Shopping\Entity\Item';
     
    
     /**
     * @param boolean $categoryEntities
     */
    public function setCategoryEntities($entities)
    {
        $this->categoryEntities = $entities;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getCategoryEntities()
    {       
        return $this->categoryEntities;
    }
     /**
     * @param boolean $categoryEntities
     */
    public function setItemEntities($entities)
    {
        $this->itemEntities = $entities;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getItemEntities()
    {       
        return $this->itemEntities;
    }
}
