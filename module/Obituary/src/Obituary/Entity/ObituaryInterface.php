<?php

namespace Obituary\Entity;

interface ObituaryInterface {

    /**
     * @return the $id
     */
    public function getId();

    /**
     * @param  integer  $id
     * @return ObituaryInterface
     */
    public function setId($id);

    /**
     * @return the $id
     */
    public function getUserId();

    /**
     * @param  integer   $id
     * @return ObituaryInterface
     */
    public function setUserId($id);

    /**
     * @return the $display_name
     */
    public function getDisplayName();

    /**
     * @param  integer  $display_name
     * @return ObituaryInterface
     */
    public function setDisplayName($display_name); 
    /**
     * @return the $steps
     */
    public function getSteps();

    /**
     * @param  integer  $steps
     * @return ObituaryInterface
     */
    public function setSteps($steps);
    /**
     * @return the $status
     */
    public function getStatus();

    /**
     * @param  integer  $status
     * @return ObituaryInterface
     */
    public function setStatus($status);
     /**
     * @return the $type
     */
    public function getType();

    /**
     * @param  integer  $type
     * @return ObituaryInterface
     */
    public function setType($type);
     /**
     * @return the $title
     */
    public function getTitle();

    /**
     * @param  integer  $title
     * @return ObituaryInterface
     */
    public function setTitle($title);
    /**
     * @return the $name
     */
    public function getName();

    /**
     * @param  integer  $name
     * @return ObituaryInterface
     */
    public function setName($name);
    /**
     * @return the $address
     */
    public function getAddress();

    /**
     * @param  integer  $address
     * @return ObituaryInterface
     */
    public function setAddress($address);
    /**
     * @return the $address
     */
    public function getPhoto();

    /**
     * @param  integer  $photo
     * @return ObituaryInterface
     */
    public function setPhoto($photo);
    /**
     * @return the $amount
     */
    public function getAmount();

    /**
     * @param  integer  $amount
     * @return ObituaryInterface
     */
    public function setAmount($amount);
    
    /**
     * @return the $created
     */
    public function getCreatedBy();
    /**
     * @param  integer  $created
     * @return ObituaryInterface
     */
    public function setCreatedBy($created);
    /**
     * @return the $relation
     */
    public function getRelation();
    /**
     * @param  integer  $relation
     * @return ObituaryInterface
     */
    public function setRelation($relation);
    /**
     * @param  string $relation
     * @return Obituary
     */
    public function setDescription($description);
    /**
     * @return the $relation
     */
    public function getDescription();
     /**
     * @param  string $created
     * @return Obituary
     */
    public function setCreatedAt($created);
    /**
     * @return the $relation
     */
    public function getCreatedAt();
    /**
     * @param  string $img
     * @return Obituary
     */
    public function setOfferImg($img);
    /**
     * @return the $relation
     */
    public function getOfferImg();
}
