<?php

namespace Memoralize\Mapper;


interface InfosInterface
{    
    /**
     * @param  int $userId
     * @return InfosInterface
     */
    public function findInfos($id);
    
    /**
     * @param  array $data
     * @return InfosInterface
     */
    public function save($data);
    /**
     * @param  integer $id
     * @return InfosInterface
     */
    public function findInfoById($id);

   
}

