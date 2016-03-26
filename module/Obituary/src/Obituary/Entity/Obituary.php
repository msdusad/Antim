<?php

namespace Obituary\Entity;

class Obituary implements ObituaryInterface {

    public $id;
    public $user_id;
    public $display_name;
	public $visibility_categories;
    public $theme_id;
    public $steps;
    public $status;
    public $type;
    public $title;
    public $name;
    public $address;
    public $photo;
    public $amount;
    public $created_by;
    public $relation;
    public $description;
    public $created_at;
    public $offer_img;
	public $first_name;
	public $middle_name;
	public $last_name;

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

    public function setUserId($id) {

        $this->user_id = $id;
        return $this;
    }

    /**
     * @return the $obituary_id
     */
    public function getThemeId() {
        return $this->theme_id;
    }
    public function setThemeId($id) {

        $this->theme_id = $id;
        return $this;
    }

    /**
     * @return the $obituary_id
     */
    public function getUserId() {
        return $this->user_id;
    }
    /**
     * @param  string $steps
     * @return Obituary
     */
    public function setDisplayName($display_name) {
      
        $this->display_name = $display_name;
        return $this;
    }

    /**
     * @return the display_name
     */
    public function getDisplayName() {
       
        return $this->display_name;
    }

	/**
     * @param  string $steps
     * @return Obituary
     */
    public function setVisibilityCategories($visibility_categories) {
      
        $this->visibility_categories = $visibility_categories;
        return $this;
    }

    /**
     * @return the display_name
     */
    public function getVisibilityCategories() {
       
        return $this->visibility_categories;
    }

    /**
     * @param  string $steps
     * @return Obituary
     */
    public function setSteps($steps) {
      
        $this->steps = $steps;
        return $this;
    }

    /**
     * @return the $first_name
     */
    public function getSteps() {
       
        return $this->steps;
    }
	/**
     * @param  string $first_name
     * @return Obituary
     */
    public function setFirstName($first_name) {
      
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @return the $first_name
     */
    public function getFirstName() {
       
        return $this->first_name;
    }
	/**
     * @param  string $middle_name
     * @return Obituary
     */
    public function setMiddleName($middle_name) {
      
        $this->middle_name = $middle_name;
        return $this;
    }

    /**
     * @return the $middle_name
     */
    public function getMiddleName() {
       
        return $this->middle_name;
    }
	/**
     * @param  string $last_name
     * @return Obituary
     */
    public function setLastName($last_name) {
      
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * @return the $last_name
     */
    public function getLastName() {
       
        return $this->last_name;
    }
/**
     * @param  string $steps
     * @return Obituary
     */
    public function setStatus($status) {
      
        $this->status = $status;
        return $this;
    }

    /**
     * @return the $status
     */
    public function getStatus() {
       
        return $this->status;
    }
    /**
     * @param  string $steps
     * @return Obituary
     */
    public function setType($type) {
      
        $this->type = $type;
        return $this;
    }

    /**
     * @return the $status
     */
    public function getType() {
       
        return $this->type;
    }
    /**
     * @param  string $title
     * @return Obituary
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
     * @param  string $name
     * @return Obituary
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
     * @param  string $name
     * @return Obituary
     */
    public function setAddress($address) {
      
        $this->address = $address;
        return $this;
    }

    /**
     * @return the $title
     */
    public function getAddress() {
       
        return $this->address;
    }
    /**
     * @param  string $photo
     * @return Obituary
     */
    public function setPhoto($photo) {
      
        $this->photo = $photo;
        return $this;
    }
    /**
     * @return the $title
     */
    public function getPhoto() {
       
        return $this->photo;
    }
    /**
     * @param  string $amount
     * @return Obituary
     */
    public function setAmount($amount) {
      
        $this->amount = $amount;
        return $this;
    }
    /**
     * @return the $amount
     */
    public function getAmount() {
       
        return $this->amount;
    }
    
    /**
     * @param  string $created
     * @return Obituary
     */
    public function setCreatedBy($created) {
      
        $this->created_by = $created;
        return $this;
    }
    /**
     * @return the $created_by
     */
    public function getCreatedBy() {
       
        return $this->created_by;
    }
    
    /**
     * @param  string $relation
     * @return Obituary
     */
    public function setRelation($relation) {
      
        $this->relation = $relation;
        return $this;
    }
    /**
     * @return the $relation
     */
    public function getRelation() {
       
        return $this->relation;
    }
    /**
     * @param  string $relation
     * @return Obituary
     */
    public function setDescription($description) {
      
        $this->description = $description;
        return $this;
    }
    /**
     * @return the $relation
     */
    public function getDescription() {
       
        return $this->description;
    }
    /**
     * @param  string $created
     * @return Obituary
     */
    public function setCreatedAt($created) {
      
        $this->created_at = $created;
        return $this;
    }
    /**
     * @return the $relation
     */
    public function getCreatedAt() {
       
        return $this->created_at;
    }
    /**
     * @param  string $img
     * @return Obituary
     */
    public function setOfferImg($img) {
      
        $this->offer_img = $img;
        return $this;
    }
    /**
     * @return the $relation
     */
    public function getOfferImg() {
       
        return $this->offer_img;
    }
}
