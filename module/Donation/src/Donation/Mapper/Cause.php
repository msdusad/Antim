<?php

namespace Donation\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;

class Cause extends AbstractDbMapper implements CauseInterface {

    protected $categoryTable = 'donation_cause';

    public function fetchAll() {

        $sql = $this->getSql();       
        
        $select = $sql->select()
                ->from($this->categoryTable)
                ->columns(array('id','title'));

       // echo  $select->getSqlString();die;
        $entity = $this->select($select)->toArray();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }
    

    public function save($data, HydratorInterface $hydrator = null) {

        $orgData = array(
            'title' => $data['title']);
        
         
        if ($data['id'] == '') {
            
            $orgData['created_at'] = date('Y-m-d H:i:s');
            
            $this->insert($orgData, $this->categoryTable);
            
        } else {

            $where = 'id=' . $data['id'];

            $this->update($orgData, $where, $this->categoryTable);
        }

        return true;
    }

    public function fetchById($id) {

        $sql = $this->getSql();
        $select = $sql->select();
        $select->from($this->categoryTable)
                 ->columns(array('title','id'))
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

        $sql = $this->getSql()->setTable($this->categoryTable);
        
        $delete = $sql->delete();

        $delete->where($where);
 
        $statement = $sql->prepareStatementForSqlObject($delete);

        return $statement->execute();
           
        
    }

}