<?php

namespace Donation\Entity;

class Charity implements CharityInterface {

    public $id;
    public $cause_id;
    public $name;    
    public $description; 
    public $address;
    public $contact_name;   
    public $url; 
    public $photo_url;
    public $created_at;
    public $updated_at;
    public $cause;
    
    
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
    public function setCauseId($id) {
        $this->cause_id = $id;
        return $this;
    }

    /**
     * @return the $category_id
     */
    public function getCauseId() {       
        return $this->cause_id;
    }
    
    /**
     * @param  string $name
     * @return Category
     */
    public function setName($name) {
      
        $this->name = $name;
        return $this;
    }

    /**
     * @return the $title
     */
    public function getName() {
       
        return $this->name;
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
     * @param  string $contact_name
     * @return Category
     */
    public function setContactName($contact_name) {
      
        $this->contact_name = $contact_name;
        return $this;
    }
    /**
     * @return the $count
     */
    public function getContactName() {
       
        return $this->contact_name;
    }
     /**
     * @param  string $url
     * @return Charity
     */
    public function setUrl($url) {
      
        $this->url = $url;
        return $this;
    }
    /**
     * @return the $count
     */
    public function getUrl() {
       
        return $this->url;
    }
    /**
     * @param  string $url
     * @return Charity
     */
    public function setPhotoUrl($url) {
      
        $this->photo_url = $url;
        return $this;
    }
    /**
     * @return the $photo
     */
    public function getPhotoUrl() {
       
        return $this->photo_url;
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
     * @param  string $cause
     * @return Charity
     */
    public function setCause($cause) {
      
        $this->cause = $cause;
        return $this;
    }
    /**
     * @return the $relation
     */
    public function getCause() {
       
        return $this->cause;
    }  
    
   
}
