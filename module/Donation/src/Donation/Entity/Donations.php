<?php

namespace Donation\Entity;

class Donations implements DonationsInterface {

    public $id;
    public $obituary_id;
    public $memoralize_id;
    public $user_id;
    public $cause_id;    
    public $charity_id; 
    public $amount;
    public $currency;
    public $created_at;
      
    /**
     * @param  int $id
     * @return Donations
     */
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
     * @return Donations
     */
    public function setObituaryId($id) {

        $this->obituary_id = $id;
        return $this;
    }

    /**
     * @return the $id
     */
    public function getObituaryId() {
        return $this->obituary_id;
    }
     /**
     * @param  int $id
     * @return Donations
     */
    public function setMemoralizeId($id) {

        $this->memoralize_id = $id;
        return $this;
    }

    /**
     * @return the $id
     */
    public function getMemoralizeId() {
        return $this->memoralize_id;
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
     * @param  int $id
     * @return Donations
     */
    public function setCauseId($id) {
        $this->cause_id = $id;
        return $this;
    }

    /**
     * @return the cause_id
     */
    public function getCauseId() {       
        return $this->cause_id;
    } 
    /**
     * @param  int $id
     * @return Donations
     */
    public function setCharityId($id) {
        $this->charity_id = $id;
        return $this;
    }

    /**
     * @return the charity_id
     */
    public function getCharityId() {       
        return $this->charity_id;
    } 
    /**
     * @param  int $amount
     * @return Donations
     */
    public function setAmount($amount) {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return the amount
     */
    public function getAmount() {       
        return $this->amount;
    } 
    /**
     * @param  int $amount
     * @return Donations
     */
    public function setCurreny($currency) {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return the currency
     */
    public function getCurreny() {       
        return $this->currency;
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
    
}
