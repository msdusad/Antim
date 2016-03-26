<?php

namespace Donation\Entity;

class Cause implements CauseInterface {

    public $id;
    public $parent_id;
    public $title;    
    public $level;    
    public $created_at;
    public $updated_at;
    public $total;

    public function setId($id) {

        $this->id = $id;
        return $this;
    }

    /**
     * @return the $id
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * @param  string $title
     * @return Category
     */
    public function setTitle($title) {
      
        $this->title = $title;
        return $this;
    }

    /**
     * @return the $title
     */
    public function getTitle() {
       
        return $this->title;
    }
    /**
     * @param  string $created
     * @return Category
     */
    public function setCreatedAt($created) {
      
        $this->created_at = $created;
        return $this;
    }
    /**
     * @return the $created_at
     */
    public function getCreatedAt() {
       
        return $this->created_at;
    }
    
    /**
     * @param  string $updated_at
     * @return Category
     */
    public function setUpdatedAt($updated) {
      
        $this->updated_at = $updated;
        return $this;
    }
    /**
     * @return the $relation
     */
    public function getUpdatedAt() {
       
        return $this->updated_at;
    }
    /**
     * @param  string $count
     * @return Category
     */
    public function setTotal($count) {
      
        $this->total = $count;
        return $this;
    }
    /**
     * @return the $count
     */
    public function getTotal() {
       
        return $this->total;
    }
}
