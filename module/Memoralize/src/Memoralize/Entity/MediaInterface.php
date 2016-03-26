<?php

namespace Memoralize\Entity;

interface MediaInterface {

    /**
     * @return the $id
     */
    public function getId();

    /**
     * @param  integer  $id
     * @return MediaInterface
     */
    public function setId($id);
     /**
     * @return the $id
     */
    public function getUserId();

    /**
     * @param  integer  $id
     * @return MediaInterface
     */
    public function setUserId($id);
     /**
     * @return the $id
     */
    public function getThemeId();

    /**
     * @param  integer  $id
     * @return MediaInterface
     */
    public function setThemeId($id);

    /**
     * @return the $id
     */
    public function getMemoralizeId();

    /**
     * @param  integer   $id
     * @return MediaInterface
     */
    public function setMemoralizeId($id);

    /**
     * @return the $steps
     */
    public function getImageUrl();

    /**
     * @param  integer  $steps
     * @return MediaInterface
     */
    public function setImageUrl($url);
    
     /**
     * @return the $url
     */
    public function getMediaUrl();

    /**
     * @param  integer  $value
     * @return MediaInterface
     */
    public function setMediaUrl($url);
    /**
     * @return the $url
     */
    public function getMainImage();

    /**
     * @param  integer  $value
     * @return MediaInterface
     */
    public function setMainImage($value);
    
}
