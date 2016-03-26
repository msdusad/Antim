<?php

namespace Donation\Mapper;

interface CharityInterface {

    /**
     * @param  int $id
     * @return ShoppingInterface
     */
    public function fetchAll($id);

    /**
     * 
     * @return ShoppingInterface
     */
    public function fetchCategories();

    /**
     * @param  array $data
     * @return ShoppingInterface
     */
    public function save($data);
    
    /**
     * @param  array $data
     * @return ShoppingInterface
     */
    public function updatePhoto($data);

    /**
     * @param  array $id
     * @return ShoppingInterface
     */
    public function getItem($id);
  
    /**
     * @param  integer $id
     * @return ShoppingInterface
     */
    public function delete($id);
}

