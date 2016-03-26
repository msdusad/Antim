<?php

namespace Memoralize\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;

class Memoralize extends AbstractDbMapper implements MemoralizeInterface {

    protected $memoralizeTable = 'memoralize';
    protected $recentTable = 'recent_offers';
 

    public function saveMemoralize($data,HydratorInterface $hydrator = null) {

        $orgData = array('user_id' => $data['user_id'],
            'steps' => $data['steps'],
            'status' => '0');

        if ($data['id'] == '') {
         
            $object = $this->insert($orgData, $this->memoralizeTable);
            $lastId = $object->getGeneratedValue();
            
        } else {

            $where = 'id=' . $data['id'];
            
            $lastId = $data['id'];

            $this->update($orgData, $where, $this->memoralizeTable);
        }

        return $lastId;
    }
    public function getMemoralize($id) {

        $sql = $this->getSql();
        $select = $sql->select();
        $select->from($this->memoralizeTable)
                ->where(array(
                    'id' => $id,
        ));
        //echo  $select->getSqlString();die;
        $entity = $this->select($select)->current();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }

    public function getRecentOffers($id) {

        $sql = $this->getSql();
        $select = $sql->select();
        $select->from($this->recentTable)
                ->join('user', $this->recentTable . '.user_id = user.user_id', array('display_name'), 'left')
               
                ->where(array(
                    $this->recentTable . '.memoralize_id' => $id,
        ));
        //echo  $select->getSqlString();die;
        $entity = $this->select($select)->toArray();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }
     public function getOffers($id,$userId) {

        $sql = $this->getSql();
        $select = $sql->select();
        $select->from($this->recentTable)
                ->join('user', $this->recentTable . '.user_id = user.user_id', array('display_name'), 'left')
               
                ->where(array(
                    $this->recentTable . '.memoralize_id' => $id,
                    $this->recentTable . '.user_id' => $userId,
        ));
        //echo  $select->getSqlString();die;
        $entity = $this->select($select)->current();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }
    public function updateOffer($data,HydratorInterface $hydrator = null) {

        $orgData = array('user_id' => $data['user_id'],
            'memoralize_id' => $data['id'],
            'type' => $data['type']);
        
       $offer = $this->getOffers($data['id'],$data['user_id']);

        if (!isset($offer->id)) {
         
             $this->insert($orgData, $this->recentTable);
            
            
        } else {

            $where = 'user_id=' . $data['user_id'].' AND memoralize_id='.$data['id'];            

            $this->update($orgData, $where, $this->recentTable);
        }

        return true;
    }
    public function getDonationCategory() {

        $sql = $this->getSql();
        $select = $sql->select();
        $select->from('category')
                ->where(array(
                    'type' => 'donation',
        ));
        //echo  $select->getSqlString();die;
        $entity = $this->select($select)->toArray();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }
public function getDonationList($id,$name) {

        $sql = $this->getSql();
        $select = $sql->select();
        $select->from('donation');
        if($id!='' && $name==''){
                $select->where(array('category_id' => $id));
                
        }
        if($id=='' && $name!=''){
                $select->where("name LIKE '%".$name."%'");
                
        }
        if($id!='' && $name!=''){
                $select->where("category_id=".$id." AND name LIKE '%".$name."%'");
                
        }
       // echo  $select->getSqlString();die;
        $entity = $this->select($select)->toArray();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }
     public function getDonation($id) {

        $sql = $this->getSql();
        $select = $sql->select();
        $select->from('donation');
         $select->where(array('id' => $id));
      
       // echo  $select->getSqlString();die;
        $entity = $this->select($select)->current();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }


}