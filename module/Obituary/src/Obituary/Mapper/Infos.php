<?php

namespace Obituary\Mapper;

use Obituary\Mapper\Obituary;

class Infos extends Obituary implements InfosInterface {

    protected $tableName = 'obituary_infos';

    public function findInfos($id) {
        $sql = $this->getSql();

        $select = $sql->select();
        $select->from($this->tableName)
                ->where(array(
                    'obituary_id' => $id
        ));

        //echo  $select->getSqlString();die;
        $entity = $this->select($select)->current();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }

    public function save($data) {

        $mData = array();

        $mData['user_id'] = $data['user_id'];
        $mData['created_by'] = $data['created_by'];
        $mData['steps'] = 1;
        $mData['id'] = '';

        if ($data['id'] == 0) {
            $obituary = $this->saveObituary($mData);
        } else {
            $obituary = $data['obituary_id'];
        }
        if ($obituary) {

            $orgData = array(
                'obituary_id' => $obituary,
                'description' => $data['description'],
                'first_name' => $data['first_name'],
                'middle_name' => $data['middle_name'],
                'last_name' => $data['last_name'],
                'dob' => $data['dob'],
                'dod' => $data['dod'],
                'age' => $data['age'],
                'death_place' => $data['death_place'],
                'school' => $data['school'],
                'ug' => $data['ug'],
                'ug_specialization' => $data['ug_specialization'],
                'pg' => $data['pg'],
                'pg_specialization' => $data['pg_specialization'],
                'family' => $data['family'],                            
            );
           

            if ($data['id'] == '') {

                $this->insert($orgData, $this->tableName);
            } else {

                $where = 'id=' . $data['id'];

                $this->update($orgData, $where, $this->tableName);
            }

            return $obituary;
        }
    }

    public function getdrafts($id) {

        $sql = $this->getSql();
        $select = $sql->select();
        $select->from($this->tableName)
                ->join('obituary',  $this->tableName. '.obituary_id = obituary.id', array('steps'), 'left')  
                ->where(array(
                    'user_id' => $id,
        ))->where("status  = 2");
       // echo  $select->getSqlString();die;
        $entity = $this->select($select)->toArray();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }

    /**
     * @param  int  $id   
     * @return InfosEntity
     */
    public function findInfoById($id) {

        $sql = $this->getSql();
        $select = $sql->select();
        $select->from($this->tableName)
                ->where(array(
                    'id' => $id
        ));
// echo  $select->getSqlString();die;
        $entity = $this->select($select)->current();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }
    
     public function findInfoByObituary($id) {

        $sql = $this->getSql();
        $select = $sql->select();
        $select->from($this->tableName)
                ->where(array(
                    'obituary_id' => $id
        ));
// echo  $select->getSqlString();die;
        $entity = $this->select($select)->current();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }

}