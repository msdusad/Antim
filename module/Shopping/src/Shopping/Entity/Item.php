<?php

namespace Shopping\Entity;

class Item implements ItemInterface {

    public $id;
    public $category_id;
    public $title;    
    public $description; 
    public $address;
    public $price;
    public $url;
    public $created_at;
    public $updated_at;
    public $category;
    

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
     * @return Item
     */
    public function setCategoryId($id) {
        $this->category_id = $id;
        return $this;
    }

    /**
     * @return the $category_id
     */
    public function getCategoryId() {       
        return $this->category_id;
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
     * @param  int $description
     * @return Category
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
     * @return Category
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
     * @return Category
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
     * @param  string $category
     * @return Category
     */
    public function setCategory($category) {
      
        $this->category = $category;
        return $this;
    }
    /**
     * @return the $category
     */
    public function getCategory() {
       
        return $this->category;
    }
   
}
