<?php

namespace Memoralize\Entity;

interface MemoralizeInterface {

    /**
     * @return the $id
     */
    public function getId();

    /**
     * @param  integer  $id
     * @return MemoralizeInterface
     */
    public function setId($id);

    /**
     * @return the $id
     */
    public function getUserId();

    /**
     * @param  integer   $id
     * @return MemoralizeInterface
     */
    public function setUserId($id);

    /**
     * @return the $display_name
     */
    public function getDisplayName();

    /**
     * @param  integer  $display_name
     * @return MemoralizeInterface
     */
    public function setDisplayName($display_name); 
    /**
     * @return the $steps
     */
    public function getSteps();

    /**
     * @param  integer  $steps
     * @return MemoralizeInterface
     */
    public function setSteps($steps);
    /**
     * @return the $status
     */
    public function getStatus();

    /**
     * @param  integer  $status
     * @return MemoralizeInterface
     */
    public function setStatus($status);
     /**
     * @return the $type
     */
    public function getType();

    /**
     * @param  integer  $type
     * @return MemoralizeInterface
     */
    public function setType($type);
     /**
     * @return the $title
     */
    public function getTitle();

    /**
     * @param  integer  $title
     * @return MemoralizeInterface
     */
    public function setTitle($title);
    /**
     * @return the $name
     */
    public function getName();

    /**
     * @param  integer  $name
     * @return MemoralizeInterface
     */
    public function setName($name);
    /**
     * @return the $address
     */
    public function getAddress();

    /**
     * @param  integer  $address
     * @return MemoralizeInterface
     */
    public function setAddress($address);
    /**
     * @return the $address
     */
    public function getPhoto();

    /**
     * @param  integer  $photo
     * @return MemoralizeInterface
     */
    public function setPhoto($photo);
    /**
     * @return the $amount
     */
    public function getAmount();

    /**
     * @param  integer  $amount
     * @return MemoralizeInterface
     */
    public function setAmount($amount);
}
