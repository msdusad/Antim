<?php

namespace Shopping\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;

class Category extends AbstractDbMapper implements CategoryInterface {

    protected $categoryTable = 'shopping_category';

    public function fetchAll($id) {

        $sql = $this->getSql();       
        
        $subQuery = $sql->select()
                ->from(array('child' =>$this->categoryTable))
                ->columns(array('childcount' => new \Zend\Db\Sql\Expression('COUNT(child.id)')))
                ->where('child.parent_id=parent.id');
        
        $select = $sql->select()
                ->from(array('parent' =>$this->categoryTable))
                ->columns(array('id','level','parent_id','title','total' => new \Zend\Db\Sql\Expression('?', array($subQuery))))
                ->where('parent.parent_id='.$id);

       // echo  $select->getSqlString();die;
        $entity = $this->select($select)->toArray();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }
    public function fetchCategories() {

        $sql = $this->getSql();       
               
        $select = $sql->select()
                ->from($this->categoryTable)
                ->columns(array('title','id','parent_id'));

       // echo  $select->getSqlString();die;
        $entity = $this->select($select)->toArray();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }

    public function save($data, HydratorInterface $hydrator = null) {

        $orgData = array('parent_id' => $data['parent_id'],
            'title' => $data['title']);
        
        $category = $this->getCategory($data['parent_id']);

        if($data['parent_id']==0){
             
            $orgData['level'] = 1;
            
        }else if($data['parent_id']!=0 && $category->getParentId()==0){
             
            $orgData['level'] = 2;
        }else{
            
             $orgData['level'] = 3;
        }
        
        if ($data['id'] == '') {
            
            $orgData['created_at'] = date('Y-m-d H:i:s');
            
            $this->insert($orgData, $this->categoryTable);
            
        } else {

            $where = 'id=' . $data['id'];

            $this->update($orgData, $where, $this->categoryTable);
        }

        return true;
    }

    public function getCategory($id) {

        $sql = $this->getSql();
        $select = $sql->select();
        $select->from($this->categoryTable)
                 ->columns(array('title','id','parent_id'))
                ->where(array(
                    'id' => $id,
        ));
        //echo  $select->getSqlString();die;
        $entity = $this->select($select)->current();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }
    public function getParent($id) {

        $sql = $this->getSql();
        $select = $sql->select();
        $select->from($this->categoryTable)
                 ->columns(array('parent_id','title','id'))
                ->where(array(
                    'parent_id' => $id,
        ));
        //echo  $select->getSqlString();die;
        $entity = $this->select($select)->toArray();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }

    /**
     * @param  int  $id   
     * @return ShoppingEntity
     */
    public function delete($id) {
                 
        $where = "id IN(" . $id.") OR parent_id IN(" . $id.")";       

        $sql = $this->getSql()->setTable($this->categoryTable);
        
        $delete = $sql->delete();

        $delete->where($where);
 
        $statement = $sql->prepareStatementForSqlObject($delete);

        return $statement->execute();
           
        
    }

}