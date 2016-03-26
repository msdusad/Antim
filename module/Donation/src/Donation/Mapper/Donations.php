<?php

namespace Donation\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;

class Donations extends AbstractDbMapper implements DonationsInterface {

    protected $table = 'donations';
    protected $itemTable = 'shopping_item';

    public function fetchAll($id) {

        $sql = $this->getSql();

        $select = $sql->select()
                ->from($this->table)
                ->where('user_id =' . $id);
        // echo  $select->getSqlString();die;
        $entity = $this->select($select)->toArray();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }

    public function save($data, HydratorInterface $hydrator = null) {

        $orgData = array(
            'obituary_id' => $data['obituary_id'],
            'memoralize_id' => $data['memoralize_id'],
            'user_id' => $data['user_id'],
            'cause_id' => $data['cause_id'],
            'charity_id' => $data['charity_id'],
            'amount' => $data['amount'],
            'currency' => $data['currency']);
       
            $this->insert($orgData, $this->table);
        

        return true;
    }

}