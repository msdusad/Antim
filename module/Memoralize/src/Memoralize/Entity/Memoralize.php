<?php

namespace Memoralize\Entity;

class Memoralize implements MemoralizeInterface {

    public $id;
    public $user_id;
    public $display_name;
    public $theme_id;
    public $steps;
    public $status;
    public $type;
    public $title;
    public $name;
    public $address;
    public $photo;
    public $amount;

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
     * @return the $memoralize_id
     */
    public function getThemeId() {
        return $this->theme_id;
    }
    public function setThemeId($id) {

        $this->theme_id = $id;
        return $this;
    }

    /**
     * @return the $memoralize_id
     */
    public function getUserId() {
        return $this->user_id;
    }
    /**
     * @param  string $steps
     * @return Memoralize
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
     * @return Memoralize
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
     * @param  string $steps
     * @return Memoralize
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
     * @return Memoralize
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
     * @return Memoralize
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
     * @return Memoralize
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
     * @return Memoralize
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
     * @return Memoralize
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
     * @return Memoralize
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
    
}
