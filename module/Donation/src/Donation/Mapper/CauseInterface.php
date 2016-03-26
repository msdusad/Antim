<?php

namespace Donation\Mapper;

interface CauseInterface {

    /**
     * @param  int $id
     * @return ShoppingInterface
     */
    public function fetchAll();

   
    /**
     * @param  array $data
     * @return ShoppingInterface
     */
    public function save($data);

    /**
     * @param  array $id
     * @return ShoppingInterface
     */
    public function fetchById($id);

    
    /**
     * @param  integer $id
     * @return ShoppingInterface
     */
    public function delete($id);
}

