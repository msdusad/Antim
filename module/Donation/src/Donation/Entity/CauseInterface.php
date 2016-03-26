<?php

namespace Donation\Entity;

interface CauseInterface {

    /**
     * @return the $id
     */
    public function getId();

    /**
     * @param  integer  $id
     * @return CategoryInterface
     */
    public function setId($id);

     /**
     * @return the $title
     */
    public function getTitle();

    /**
     * @param  integer  $title
     * @return CategoryInterface
     */
    public function setTitle($title);      
   
    /**
     * @return the $created
     */
    public function getCreatedAt();
    /**
     * @param  date  $created
     * @return CategoryInterface
     */
    public function setCreatedAt($created);
    /**
     * @return the $updated
     */
    public function getUpdatedAt();
    /**
     * @param  integer  $updated
     * @return CategoryInterface
     */
    public function setUpdatedAt($updated);
   /**
     * @param  string $count
     * @return Category
     */
    public function setTotal($count);
    /**
     * @return the $count
     */
    public function getTotal();
}
