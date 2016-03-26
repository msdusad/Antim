<?php

namespace Memoralize\Entity;

class Media implements MediaInterface {

    public $id;
    public $user_id;
    public $theme_id;
    public $memoralize_id;
    public $image_url;
    public $media_url;    
    public $main_image;
    

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

    public function setMemoralizeId($id) {

        $this->memoralize_id = $id;
        return $this;
    }

    /**
     * @return the $memoralize_id
     */
    public function getMemoralizeId() {
        return $this->memoralize_id;
    }

    /**
     * @param  string $url
     * @return Memoralize
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
     * @return Memoralize
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
     * @return Memoralize
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
    
}
