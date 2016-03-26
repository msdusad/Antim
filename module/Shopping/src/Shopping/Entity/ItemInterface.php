<?php

namespace Shopping\Entity;

interface ItemInterface {

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
     public function getCategoryId();

    /**
     * @param  integer   $id
     * @return ItemInterface
     */
    public function setCategoryId($id);
    
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
     * @param  string $category
     * @return ItemInterface
     */
    public function setCategory($category);
    /**
     * @return the $count
     */
    public function getCategory();
}
