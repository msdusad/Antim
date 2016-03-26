<?php

namespace Shopping\Entity;

class Whishlist implements WhishlistInterface {

    public $id;
    public $user_id;
    public $item_ids;
    public $created_at;
    public $updated_at;
    
    public $title;    
    public $description; 
    public $address;
    public $price;
    public $url;
    

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
     * @param  int $id
     * @return Whishlist
     */
    public function setUserId($id) {
        $this->user_id = $id;
        return $this;
    }

    /**
     * @return the $user_id
     */
    public function getUserId() {       
        return $this->user_id;
    }
    
    /**
     * @param  array $ids
     * @return Whishlist
     */
    public function setItemIds($ids) {
      
        $this->item_ids = $ids;
        return $this;
    }

    /**
     * @return the $title
     */
    public function getItemIds() {
       
        return $this->item_ids;
    }   
    
    
    /**
     * @param  string $created
     * @return Whishlist
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
     * @return Whishlist
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
     * @param  string $title
     * @return Item
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
     * @param  int $description
     * @return Item
     */
    public function setDescription($description) {
      
        $this->description = $description;
        return $this;
    }
    /**
     * @return the $description
     */
    public function getDescription() {
       
        return $this->description;
    } 
     /**
     * @param  string $address
     * @return Item
     */
    public function setAddress($address) {
      
        $this->address = $address;
        return $this;
    }
    /**
     * @return the $count
     */
    public function getAddress() {
       
        return $this->address;
    }
     /**
     * @param  string $price
     * @return Category
     */
    public function setPrice($price) {
      
        $this->price = $price;
        return $this;
    }
    /**
     * @return the $count
     */
    public function getPrice() {
       
        return $this->price;
    }
    /**
     * @param  string $url
     * @return Item
     */
    public function setUrl($url) {
      
        $this->url = $url;
        return $this;
    }
    /**
     * @return the $url
     */
    public function getUrl() {
       
        return $this->url;
    }
}
