<?php

namespace Memoralize\Mapper;

interface MediaInterface {

    /**
     * @param  integer $id
     * @return MemoralizeInterface
     */
    public function getMimages($id);

    /**
     * @param  integer $id
     * @return MemoralizeInterface
     */
    public function getThemes($id);

    /**
     * @param  integer $id
     * @return MemoralizeInterface
     */
    public function getTheme($id);

    /**
     * @param  integer $id
     * @return MemoralizeInterface
     */
    public function getMedia($id);

    /**
     * @param  array $data
     * @return MemoralizeInterface
     */
    public function saveImages($data);

    /**
     * @param  array $data
     * @return MemoralizeInterface
     */
    public function saveThemes($data);

    /**
     * @param  array $data
     * @return MemoralizeInterface
     */
    public function saveMedia($data);

    /**
     * @param  integer $id
     * @return MemoralizeInterface
     */
    public function updateCover($id);

    /**
     * @param  integer $id
     * @param  integer $theme
     * @return MemoralizeInterface
     */
    public function updateTheme($id, $theme);

    /**
     * @param  integer $id
     * @return MemoralizeInterface
     */
    public function deleteImages($ids);

    /**
     * @param  integer $id
     * @return MemoralizeInterface
     */
    public function deleteThemes($ids);
}

