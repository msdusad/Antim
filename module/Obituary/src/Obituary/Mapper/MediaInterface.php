<?php

namespace Obituary\Mapper;

interface MediaInterface {

    /**
     * @param  integer $id
     * @return ObituaryInterface
     */
    public function getMimages($id);
     /**
     * @param  integer $id
     * @return ObituaryInterface
     */
    public function getMainImage($id);

    /**
     * @param  integer $id
     * @return ObituaryInterface
     */
    public function getThemes($templateId);

    /**
     * @param  integer $id
     * @return ObituaryInterface
     */
    public function getTheme($id);

     /**     
     * @return ObituaryInterface
     */
    public function getLanguages();
    /**
     * @param  integer $id
     * @return ObituaryInterface
     */
    public function getMedia($id);

    /**
     * @param  array $data
     * @return ObituaryInterface
     */
    public function saveImages($data);

    /**
     * @param  array $data
     * @return ObituaryInterface
     */
    public function saveThemes($data);

    /**
     * @param  array $data
     * @return ObituaryInterface
     */
    public function saveMedia($data);

    /**
     * @param  integer $id
     * @return ObituaryInterface
     */
    public function updateCover($obituaryid,$id);
    
      /**
     * @param  integer $id
     * @return ObituaryInterface
     */
   public function updateGarland($garlandid,$id);

    /**
     * @param  integer $id
     * @param  integer $theme
     * @return ObituaryInterface
     */
    public function updateTheme($data);

    /**
     * @param  integer $id
     * @return ObituaryInterface
     */
    public function deleteImages($ids);

    /**
     * @param  integer $id
     * @return ObituaryInterface
     */
    public function deleteThemes($ids);
    
     /**
     * @param  integer $id
     * @return ObituaryInterface
     */
    public function getGarlands();
}

