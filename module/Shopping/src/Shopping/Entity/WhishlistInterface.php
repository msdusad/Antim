<?php

namespace Shopping\Entity;

interface WhishlistInterface {

    /**
     * @return the $id
     */
    public function getId();

    /**
     * @param  integer  $id
     * @return WhishlistInterface
     */
    public function setId($id);

    /**
     * @return the $id
     */
     public function getUserId();

    /**
     * @param  integer   $id
     * @return WhishlistInterface
     */
    public function setUserId($id);
    
     /**
     * @return the $item_ids
     */
    public function getItemIds();

    /**
     * @param  array  $ids
     * @return WhishlistInterface
     */
    public function setItemIds($ids);      
    
    /**
     * @return the $created
     */
    public function getCreatedAt();
    /**
     * @param  date  $created
     * @return WhishlistInterface
     */
    public function setCreatedAt($created);
    /**
     * @return the $updated
     */
    public function getUpdatedAt();
    /**
     * @param  integer  $updated
     * @return WhishlistInterface
     */
    public function setUpdatedAt($updated);
    /**
     * @return the $title
     */
    public function getTitle();

    /**
     * @param  integer  $title
     * @return ItemInterface
     */
    public function setTitle($title);
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
     * @param  string $price
     * @return ItemInterface
     */
    public function setPrice($price);
    /**
     * @return the $count
     */
    public function getPrice();
    
     /**
     * @param  string $url
     * @return Category
     */
    public function setUrl($url);
    /**
     * @return the $url
     */
    public function getUrl();
   
}
