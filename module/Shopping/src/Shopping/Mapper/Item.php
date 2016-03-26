<?php

namespace Shopping\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;

class Item extends AbstractDbMapper implements ItemInterface {

    protected $table = 'shopping_item';
    protected $categoryTable = 'shopping_category';

    public function fetchAll($id) {

        $sql = $this->getSql();
        $select = $sql->select()
                ->from($this->table)
                ->columns(array('id','title','price','description','url'))
                ->join($this->categoryTable, $this->table . '.category_id = '.$this->categoryTable.'.id', array('category'=>'title'), 'left');
        if($id!=0){
            $select->where($this->table.'.category_id='.$id);
        }

      // echo  $select->getSqlString();die;
        $entity = $this->select($select)->toArray();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }
    public function fetchItems($id,$search='') {

        $sql = $this->getSql();
        $select = $sql->select()
                ->from($this->table)
                ->columns(array('id','title','price','description','url'))
                ->join($this->categoryTable, $this->table . '.category_id = '.$this->categoryTable.'.id', array('category'=>'title'), 'left');
        
        if($id!=''){
                $select->where($this->table.'.category_id='.$id);
        }
        if($search!=''){
                $select->where($this->table.'.title LIKE "%'.$search.'%"');
        }
       

       //echo  $select->getSqlString();die;
        $entity = $this->select($select)->toArray();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }
    public function fetchCategories() {

        $sql = $this->getSql();       
               
        $select = $sql->select()
                ->from($this->categoryTable)
                ->columns(array('title','id'));

       // echo  $select->getSqlString();die;
        $entity = $this->select($select)->toArray();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }

    public function save($data, HydratorInterface $hydrator = null) {

        $orgData = array('category_id' => $data['category_id'],
            'title' => $data['title'],
             'description' => $data['description'],
             'address' => $data['address'],
             'price' => $data['price'], 
             'url' => $data['url'],             
            );
         
        if ($data['id'] == '') {
            
            $orgData['created_at'] = date('Y-m-d H:i:s');
            
            $this->insert($orgData, $this->table);
            
        } else {

            $where = 'id=' . $data['id'];

            $this->update($orgData, $where, $this->table);
        }

        return true;
    }

    public function getItem($id) {

        $sql = $this->getSql();
        $select = $sql->select();
        $select->from($this->table)
                 ->columns(array('title','id','category_id','description','address','price','url'))
                ->where(array(
                    'id' => $id,
        ));
        //echo  $select->getSqlString();die;
        $entity = $this->select($select)->current();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }
    

    /**
     * @param  int  $id   
     * @return ShoppingEntity
     */
    public function delete($id) {
                 
        $where = "id IN(" . $id.")";       

        $sql = $this->getSql()->setTable($this->table);
        
        $delete = $sql->delete();

        $delete->where($where);
 
        $statement = $sql->prepareStatementForSqlObject($delete);

        return $statement->execute();
           
        
    }

}