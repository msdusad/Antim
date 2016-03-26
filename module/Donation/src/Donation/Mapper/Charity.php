<?php

namespace Donation\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;

class Charity extends AbstractDbMapper implements CharityInterface {

    protected $table = 'donation_charity';
    protected $categoryTable = 'donation_cause';

    public function fetchAll($id) {

        $sql = $this->getSql();
        $select = $sql->select()
                ->from($this->table)
               
                ->join($this->categoryTable, $this->table . '.cause_id = ' . $this->categoryTable . '.id', array('cause' => 'title'), 'left');
        if ($id != 0) {
            $select->where($this->table . '.cause_id=' . $id);
        }

        // echo  $select->getSqlString();die;
        $entity = $this->select($select)->toArray();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }

    public function fetchCategories() {

        $sql = $this->getSql();

        $select = $sql->select()
                ->from($this->categoryTable)
                ->columns(array('name' => 'title', 'id'));

        // echo  $select->getSqlString();die;
        $entity = $this->select($select)->toArray();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }

    public function save($data, HydratorInterface $hydrator = null) {

        $orgData = array('cause_id' => $data['cause_id'],
            'name' => $data['name'],
            'description' => $data['description'],
            'address' => $data['address'],
            'contact_name' => $data['contact_name'],
            'url' => $data['url'],
        );

        if ($data['id'] == '') {

            $orgData['created_at'] = date('Y-m-d H:i:s');

            $object = $this->insert($orgData, $this->table);
            $lastId = $object->getGeneratedValue();
        } else {

            $where = 'id=' . $data['id'];
            $lastId= $data['id'];

            $this->update($orgData, $where, $this->table);
        }

        return $lastId;
    }

    public function updatePhoto($data, HydratorInterface $hydrator = null) {

        $orgData = array(
            'photo_url' => $data['photo_url'],
        );

        $where = 'id=' . $data['id'];

        $this->update($orgData, $where, $this->table);

        return true;
    }

    public function getItem($id) {

        $sql = $this->getSql();
        $select = $sql->select();
        $select->from($this->table)
                
                ->where(array(
                    'id' => $id,
        ));
       // echo  $select->getSqlString();die;
        $entity = $this->select($select)->current();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }

    /**
     * @param  int  $id   
     * @return ShoppingEntity
     */
    public function delete($id) {

        $where = "id IN(" . $id . ")";

        $sql = $this->getSql()->setTable($this->table);

        $delete = $sql->delete();

        $delete->where($where);

        $statement = $sql->prepareStatementForSqlObject($delete);

        return $statement->execute();
    }

}