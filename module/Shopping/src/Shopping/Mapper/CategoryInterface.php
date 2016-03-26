<?php

namespace Shopping\Mapper;

interface CategoryInterface {

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
    public function getCategory($id);

    /**
     * @param  array $id
     * @return ShoppingInterface
     */
    public function getParent($id);

    /**
     * @param  integer $id
     * @return ShoppingInterface
     */
    public function delete($id);
}

