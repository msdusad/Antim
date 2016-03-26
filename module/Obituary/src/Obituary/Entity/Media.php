<?php

namespace Obituary\Entity;

class Media implements MediaInterface {

    public $id;
    public $user_id;
    public $theme_id;
    public $obituary_id;
    public $image_url;
    public $media_url;    
    public $main_image;
    public $garland_image;    
    public $content;
    public $name;
    

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
     * @return the $id
     */
    public function getUserId() {
        return $this->user_id;
    }
    public function setThemeId($id) {

        $this->theme_id = $id;

        return $this;
    }

    /**
     * @return the $id
     */
    public function getThemeId() {
        return $this->theme_id;
    }

    public function setObituaryId($id) {

        $this->obituary_id = $id;
        return $this;
    }

    /**
     * @return the $obituary_id
     */
    public function getObituaryId() {
        return $this->obituary_id;
    }

    /**
     * @param  string $url
     * @return Obituary
     */
    public function setImageUrl($url) {
      
        $this->image_url = $url;
        return $this;
    }

    /**
     * @return the $image_url
     */
    public function getImageUrl() {
       
        return $this->image_url;
    }
    /**
     * @param  string $url
     * @return Obituary
     */
    public function setGarlandImage($url) {
      
        $this->garland_image = $url;
        return $this;
    }

    /**
     * @return the $image_url
     */
    public function getGarlandImage() {
       
        return $this->garland_image;
    }
    
/**
     * @param  string $url
     * @return Obituary
     */
    public function setMediaUrl($url) {
      
        $this->media_url = $url;
        return $this;
    }

    /**
     * @return the $audio_url
     */
    public function getMediaUrl() {
       
        return $this->media_url;
    }
   
    /**
     * @param  string $value
     * @return Obituary
     */
    public function setMainImage($value) {
      
        $this->main_image = $value;
        return $this;
    }

    /**
     * @return the $main_image
     */
    public function getMainImage() {
       
        return $this->main_image;
    }
    /**
     * @param  string $value
     * @return Obituary
     */
    public function setContent($value) {
      
        $this->content = $value;
        return $this;
    }

    /**
     * @return the $main_image
     */
    public function getContent() {
       
        return $this->content;
    }
    
     public function setName($name) {

        $this->name = $name;

        return $this;
    }

    /**
     * @return the $name
     */
    public function getName() {
        return $this->name;
    }
    
}
