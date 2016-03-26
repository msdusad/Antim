<?php

namespace Donation\Entity;

interface CharityInterface {

    /**
     * @return the $id
     */
    public function getId();

    /**
     * @param  integer  $id
     * @return ItemInterface
     */
    public function setId($id);

    /**
     * @return the $id
     */
     public function getCauseId();

    /**
     * @param  integer   $id
     * @return ItemInterface
     */
    public function setCauseId($id);
    
     /**
     * @return the $title
     */
    public function getName();

    /**
     * @param  integer  $name
     * @return ItemInterface
     */
    public function setName($name);
      /**
     * @param  int $description
     * @return ItemInterface
     */
    public function setDescription($description);
    /**
     * @return the $description
     */
    public function getDescription();
     /**
     * @param  string $address
     * @return ItemInterface
     */
    public function setAddress($address);
    /**
     * @return the $count
     */
    public function getAddress();
     /**
     * @param  string $name
     * @return ItemInterface
     */
    public function setContactName($name);
    /**
     * @return the $name
     */
    public function getContactName();
    
     /**
     * @param  string $url
     * @return Charity
     */
    public function setUrl($url);
    /**
     * @return the $count
     */
    public function getUrl();
     /**
     * @param  string $url
     * @return Charity
     */
    public function setPhotoUrl($url);
    /**
     * @return the $photo
     */
    public function getPhotoUrl();
    /**
     * @return the $created
     */
    public function getCreatedAt();
    /**
     * @param  date  $created
     * @return ItemInterface
     */
    public function setCreatedAt($created);
    /**
     * @return the $updated
     */
    public function getUpdatedAt();
    /**
     * @param  integer  $updated
     * @return ItemInterface
     */
    public function setUpdatedAt($updated);
    /**
     * @param  string $cause
     * @return Charity
     */
    public function setCause($cause);
    /**
     * @return the $relation
     */
    public function getCause();
   
}
