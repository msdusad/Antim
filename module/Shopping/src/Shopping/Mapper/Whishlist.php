<?php

namespace Shopping\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;

class Whishlist extends AbstractDbMapper implements WhishlistInterface {

    protected $table = 'shopping_whishlist';
    protected $itemTable = 'shopping_item';

    public function fetchAll($ids) {

        $sql = $this->getSql();

        $select = $sql->select()
                ->from($this->itemTable)
                ->where('id IN(' . $ids . ')');
        // echo  $select->getSqlString();die;
        $entity = $this->select($select)->toArray();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }
    public function fetchPrePlanning($ids,$type) {

        $sql = $this->getSql();

        $select = $sql->select()
                ->from('preplanning_'.$type)
                ->where('id IN(' . $ids . ')');
        // echo  $select->getSqlString();die;
        $entity = $this->select($select)->toArray();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }

    public function save($data, HydratorInterface $hydrator = null) {

        $orgData = array('user_id' => $data['user_id'],
            'item_ids' => $data['item_ids']);

        $whishList = $this->getList($data['user_id']);

        if (!$whishList) {

            $orgData['created_at'] = date('Y-m-d H:i:s');

            $this->insert($orgData, $this->table);
        } else {

            $where = 'user_id=' . $data['user_id'];

            if($whishList->item_ids!=''){
            $orgData['item_ids'] = $whishList->item_ids . ',' . $orgData['item_ids'];
            }

            $this->update($orgData, $where, $this->table);
        }

        return true;
    }

    public function getList($userId) {

        $sql = $this->getSql();
        $select = $sql->select();
        $select->from($this->table)
                ->columns(array('user_id', 'item_ids'))
                ->where(array(
                    'user_id' => $userId,
        ));
        //echo  $select->getSqlString();die;
        $entity = $this->select($select)->current();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }
     public function getPrePlanningList($userId,$type) {

        $sql = $this->getSql();
        $select = $sql->select();
        $select->from('preplanning_whishlist')
                ->columns(array('item_ids'))
                ->where(array('user_id' => $userId,'type' => $type,'status'=>0));
        //echo  $select->getSqlString();die;
        $entity = $this->select($select)->current();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }

    /**
     * @param  array  $data   
     * @return ShoppingEntity
     */
    public function delete($data) {

        $whishList = $this->getList($data['user_id']);
        
        if (!$whishList) {

            return false;
        } else {

            $orgData = array();
            $exsistingArray = explode(',', $whishList->item_ids);
            $newArray = explode(',', $data['ids']);
            $orgData['item_ids'] = implode(',',array_diff($exsistingArray, $newArray)); 
           
            $where = 'user_id=' . $data['user_id'];

            $this->update($orgData, $where, $this->table);
        }
    }
    public function getItems($ids) {

        $sql = $this->getSql();
        $select = $sql->select();
        $select->from($this->itemTable)               
                ->where('id IN('.$ids.')');
        //echo  $select->getSqlString();die;
        $entity = $this->select($select)->toArray();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));
        
        $html = '';
                
        foreach($entity as $val){
            
          $html .='<div class="items"><h5>'.$val['title'].'</h5><p>'.$val['description'].'</p>';
          $html .='<p><i>Address :</i>'.$val['address'].'</p>';
          $html .= '<p><i>Price : </i> '.$val['price'].'</p>';
          if($val['url']!=''){
             $html .= '<a href=" '.$val['url'].'">Add to cart</a>';  
          }
           $html .= '</div>';         
            
        }

        return $html;
    }
    /**
     * @param  array  $data   
     * @return ShoppingEntity
     */
    public function deletePrePlan($data,$type) {

        $whishList = $this->getPrePlanningList($data['user_id'],$type);
        
        $orgData = array('status'=>1);
        if (!$whishList) {

            return false;
        } else {

            $orgData = array();
            $exsistingArray = explode(',', $whishList->item_ids);
            $newArray = explode(',', $data['ids']);
            $orgData['item_ids'] = implode(',',array_diff($exsistingArray, $newArray)); 
         
            $where = 'user_id=' . $data['user_id'].' AND type="'.$type.'"';

            $this->update($orgData, $where, 'preplanning_whishlist');
        }
    }

}