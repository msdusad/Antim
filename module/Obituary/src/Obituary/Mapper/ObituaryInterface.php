<?php

namespace Obituary\Mapper;

interface ObituaryInterface {

    /**
     * @param  array $data
     * @return ObituaryInterface
     */
    public function saveObituary($data);

    /**
     * @param  array $id
     * @return ObituaryInterface
     */
    public function getObituary($id);

    /**
     * @param  integer $id
     * @return ObituaryInterface
     */
    public function delete($id);

   
    
    /**
     * @param  array $data
     * @return ObituaryInterface
     */
    public function getObituaries($userId);
     /**
     * @param  array $data
     * @return ObituaryInterface
     */
    public function saveGuestBook($data);
     /**
     * @param  array $data
     * @return ObituaryInterface
     */
    public function deleteGuestBook($data);
     /**
     * @param  int $id
     * @return ObituaryInterface
     */
    public function fetchGuestBooks($id);
     /**
     * @param  array $data
     * @return ObituaryInterface
     */
    public function saveTributes($data);
    /**
     * @param  int $id
     * @return ObituaryInterface
     */
    public function fetchTributes($id);
    /**
     * @param  array $data
     * @return ObituaryInterface
     */
    public function deleteTributes($data);
}