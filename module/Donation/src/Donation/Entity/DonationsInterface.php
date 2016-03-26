<?php

namespace Donation\Entity;

interface DonationsInterface {

    /**
     * @param  int $id
     * @return Donations
     */
    public function setId($id);

    /**
     * @return the $id
     */
    public function getId();
    /**
     * @param  int $id
     * @return Donations
     */
    public function setObituaryId($id);

    /**
     * @return the $id
     */
    public function getObituaryId();
     /**
     * @param  int $id
     * @return Donations
     */
    public function setMemoralizeId($id);

    /**
     * @return the $id
     */
    public function getMemoralizeId();
    /**
     * @param  int $id
     * @return Whishlist
     */
    public function setUserId($id);

    /**
     * @return the $user_id
     */
    public function getUserId();
    /**
     * @param  int $id
     * @return Donations
     */
    public function setCauseId($id);

    /**
     * @return the cause_id
     */
    public function getCauseId();
    /**
     * @param  int $id
     * @return Donations
     */
    public function setCharityId($id);

    /**
     * @return the charity_id
     */
    public function getCharityId();
    /**
     * @param  int $amount
     * @return Donations
     */
    public function setAmount($amount);

    /**
     * @return the amount
     */
    public function getAmount();
    /**
     * @param  int $amount
     * @return Donations
     */
    public function setCurreny($currency);

    /**
     * @return the currency
     */
    public function getCurreny();
    
    /**
     * @param  string $created
     * @return Whishlist
     */
    public function setCreatedAt($created);
    /**
     * @return the $created_at
     */
    public function getCreatedAt();
    
   
}
