<?php

namespace Obituary\Entity;

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
    public function getObituaryId();

    /**
     * @param  integer   $id
     * @return MediaInterface
     */
    public function setObituaryId($id);

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
     * @param  string $url
     * @return Obituary
     */
    public function setGarlandImage($url);

    /**
     * @return the $image_url
     */
    public function getGarlandImage();
    
   
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

    /**
     * @param  string $value
     * @return Obituary
     */
    public function setContent($value);

    /**
     * @return the $main_image
     */
    public function getContent();

    /**
     * @param  string $name
     * @return Obituary
     */
    public function setName($name);

    /**
     * @return the name
     */
    public function getName();
}
