<?php

namespace Obituary\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;


class Obituary extends AbstractDbMapper implements ObituaryInterface {

    protected $obituaryTable = 'obituary';
    protected $tributesTable = 'obituary_tributes';
    protected $obituaryInfoTable = 'obituary_info';
    protected $guestBookTable = 'obituary_guestbook';
    protected $PrivacyTable = 'obituary_visibility_categories';
   
public function fetchObituary(){
	$sql = $this->getSql();
        $select = $sql->select();
        $select->from('obituary')->columns(array('id'))->join('obituary_infos', 'obituary_infos.obituary_id = obituary.id',array('first_name','middle_name','last_name'), 'left')
                ->where(array('obituary.steps' => 3));

         // echo  $select->getSqlString();die;
        $entity = $this->select($select)->toArray();
//print_r($entity);exit;
        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
}

    public function saveObituary($data, HydratorInterface $hydrator = null) {

        $orgData = array('user_id' => $data['user_id'],
            'steps' => $data['steps'],
            'status' => '0','created_by' => $data['created_by']);

        if ($data['id'] == '') {

            $object = $this->insert($orgData, $this->obituaryTable);
            $lastId = $object->getGeneratedValue();
        } else {

            $where = 'id=' . $data['id'];

            $lastId = $data['id'];

            $this->update($orgData, $where, $this->obituaryTable);
        }

        return $lastId;
    }

    public function getObituary($id) {

        $sql = $this->getSql();
        $select = $sql->select();
        $select->from($this->obituaryTable)
                ->where(array(
                    'id' => $id,
                ))->where(array(
            'steps' => 3,
        ))->where(array(
            'status' => 0,
        ));
        //echo  $select->getSqlString();die;
        $entity = $this->select($select)->current();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }

    /**
     * @param  int  $id   
     * @return ObituaryEntity
     */
    public function delete($id) {

        $orgData = array('status' => 1);

        $where = 'id=' . $id;

        $this->update($orgData, $where, $this->obituaryTable);

        return true;
    }


    public function getObituaries($userId) {


        $sql = $this->getSql();
        $select = $sql->select();
        $select->from('obituary');
        $select->where(array('user_id' => $userId))->where(array('steps' => 3))->where(array('status' => 0));

        //  echo  $select->getSqlString();die;
        $entity = $this->select($select)->current();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }
public function fetchObituaries() {


        $sql = $this->getSql();
        $select = $sql->select();
        $select->from('obituary');
        $select->where(array('steps' => 3))->where(array('status' => 0));

        //  echo  $select->getSqlString();die;
        $entity = $this->select($select)->current();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }
    public function saveGuestBook($data, HydratorInterface $hydrator = null) {

        $orgData = array('user_id' => $data['user_id'],
            'obituary_id' => $data['obituary_id'],
            'description' => $data['description'],
            'offer_img' => $data['offer_img']);

        if ($data['id'] == '') {

            $orgData['created_at'] = date('Y-m-d H:i:s');
            $object = $this->insert($orgData, $this->guestBookTable);
            $lastId = $object->getGeneratedValue();
        } else {

            $where = 'id=' . $data['id'];

            $lastId = $data['id'];

            $this->update($orgData, $where, $this->guestBookTable);
        }

        return $lastId;
    }

    public function deleteGuestBook($data, HydratorInterface $hydrator = null) {

        $orgData = array('status' => 1);

        $where = 'id=' . $data['id'];

        $this->update($orgData, $where, $this->guestBookTable);


        return true;
    }

    public function fetchGuestBooks($id) {


        $sql = $this->getSql();
        $select = $sql->select();
        $select->from('obituary_guestbook')->join('user', 'obituary_guestbook.user_id = user.user_id', array('display_name'), 'left')
                ->where(array('obituary_guestbook.obituary_id' => $id))->where(array('obituary_guestbook.status' => 0));

        //  echo  $select->getSqlString();die;
        $entity = $this->select($select)->toArray();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }
    public function saveTributes($data, HydratorInterface $hydrator = null) {

        $orgData = array('user_id' => $data['user_id'],
            'obituary_id' => $data['obituary_id'],
            'description' => $data['description']
            );

        if ($data['id'] == '') {

            $orgData['created_at'] = date('Y-m-d H:i:s');
            $object = $this->insert($orgData, $this->tributesTable);
            $lastId = $object->getGeneratedValue();
        } else {

            $where = 'id=' . $data['id'];

            $lastId = $data['id'];

            $this->update($orgData, $where, $this->tributesTable);
        }

        return $lastId;

    
    }
  public function savePrivacy($data, HydratorInterface $hydrator = null) {
        $orgData = array('user_id' => $data['user_id'],
            'obituary_id' => $data['obituary_id'],
            'status' => $data['privacy'],
            'visibility_categories' => $data['privacyCheck'],
            );
        if ($data['id'] == '') {
            $orgData['created_at'] = date('Y-m-d H:i:s');
            $object = $this->insert($orgData, $this->PrivacyTable);
            $lastId = $object->getGeneratedValue();
        }else {
            $where = 'id=' . $data['id'];
            $lastId = $data['id'];
            $this->update($orgData, $where, $this->PrivacyTable);
        }
        return $lastId;
  }
    public function fetchTributes($id) {


        $sql = $this->getSql();
        $select = $sql->select();
        $select->from('obituary_tributes')->join('user', 'obituary_tributes.user_id = user.user_id', array('display_name'), 'left')
                ->where(array('obituary_tributes.obituary_id' => $id))->where(array('obituary_tributes.status' => 0));

        //  echo  $select->getSqlString();die;
        $entity = $this->select($select)->toArray();



        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }
    public function fetchPrivacy($id) {


        $sql = $this->getSql();
        $select = $sql->select();
        $select->from(array('ob' => 'obituary_visibility_categories'))->join('user', 'ob.user_id = user.user_id', array('display_name'), 'left')
                ->where(array('ob.obituary_id' => $id));

         // echo  $select->getSqlString();die;
		//$entity =  $this->fetchAll($select);
        $entity = $this->select($select)->toArray();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }
    public function deleteTributes($data, HydratorInterface $hydrator = null) {

        $orgData = array('status' => 1);

        $where = 'id=' . $data['id'];

        $this->update($orgData, $where, $this->tributesTable);


        return true;
    }

}