<?php

namespace Shopping\Mapper;

interface WhishlistInterface {

    /**
     * @param  array $id
     * @return WhishlistInterface
     */
    public function fetchAll($ids);  
    
     /**
     * @param  array $id
     * @return WhishlistInterface
     */
    public function fetchPrePlanning($ids,$type);

    /**
     * @param  array $data
     * @return WhishlistInterface
     */
    public function save($data);

    /**
     * @param  array $id
     * @return WhishlistInterface
     */
    public function getList($userId);    

     /**
     * @param  array $data
     * @return WhishlistInterface
     */
    public function getPrePlanningList($userId,$type);
    /**
     * @param  array $data
     * @return WhishlistInterface
     */
    public function delete($data);
    
    /**
     * @param  int $ids
     * @return WhishlistInterface
     */
    public function getItems($ids);
    
     /**
     * @param  int $ids
     * @return WhishlistInterface
     */
     public function deletePrePlan($data,$type);
}

