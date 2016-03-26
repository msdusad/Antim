<?php

namespace Shopping\Mapper;

interface ItemInterface {

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
     * @param  array $id
     * @return ShoppingInterface
     */
    public function getItem($id);
   /**
     * @param  array $id
     * @return ShoppingInterface
     */
    public function fetchItems($id,$search);
    /**
     * @param  integer $id
     * @return ShoppingInterface
     */
    public function delete($id);
}

