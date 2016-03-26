<?php

namespace Memoralize\Mapper;


use Memoralize\Mapper\Memoralize;

class Infos extends Memoralize implements InfosInterface {

    protected $tableName = 'memoralize_infos';

    public function findInfos($id) {
        $sql = $this->getSql();

        $select = $sql->select();
        $select->from($this->tableName)
                ->where(array(
                    'memoralize_id' => $id,
        ));

        //echo  $select->getSqlString();die;
        $entity = $this->select($select)->current();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }

    public function save($data) {

        $mData = array();

        $mData['user_id'] = $data['user_id'];
        $mData['steps'] = 1;
        $mData['id'] = '';

        $memoralize = $this->saveMemoralize($mData);

        if ($memoralize) {

            $orgData = array(
                'memoralize_id' => $memoralize,
                'description' => $data['description'],
                'first_name' => $data['first_name'],
                'middle_name' => $data['middle_name'],
                'last_name' => $data['last_name'],
                'dob' => $data['dob'],
                'age' => $data['age'],
                'death_place' => $data['death_place'],
                'education' => $data['education'],
                'family' => $data['family'],
                'tributes' => $data['tributes'],
                'privacy' => $data['privacy'],
                'guest_book' => $data['guest_book'],
            );

            if ($data['id'] == '') {

                $this->insert($orgData, $this->tableName);
            } else {

                $where = 'id=' . $data['id'];

                $this->update($orgData, $where, $this->tableName);
            }

            return $memoralize;
        }
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

        $entity = $this->select($select)->current();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }

}