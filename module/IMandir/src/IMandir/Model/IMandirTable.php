<?php

namespace IMandir\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class PrePlanningTable {

    protected $tableGateway;
    protected $_basePath;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @param string
     */
    public function setBasePath($path) {
        $this->_basePath = $path;
    }

    public function fetchAll($paginated = false, $search = '') {
        if ($paginated) {
            // create a new Select object for the table cms
            $select = new Select('preplanning');

            $dbSelect = $select->columns(array('id', 'category_id', 'title', 'description'));
            if ($search != '') {
                $dbSelect->where("preplanning.category_id = '$search'");
            }
            //  echo  $dbSelect->getSqlString();die;
            // create a new result set based on the Album entity
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new PrePlanning());
            // create a new pagination adapter object
            $paginatorAdapter = new DbSelect(
                    // our configured select object
                    $dbSelect,
                    // the adapter to run it against
                    $this->tableGateway->getAdapter(),
                    // the result set to hydrate
                    $resultSetPrototype
            );
            $paginator = new Paginator($paginatorAdapter);
            return $paginator;
        }
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function fetchPrePlans($id) {

        $sql = "SELECT * FROM preplanning";
        if ($id != '') {
            $sql .= " WHERE category_id=" . $id;
        }
       // echo $sql;exit;
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();

        $rows = array();
        foreach ($res as $row) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function getListById($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveList(PrePlanning $class) {

        $data = array(
            'category_id' => $class->category_id,
            'title' => $class->title,
            'description' => $class->description,
        );

        $id = (int) $class->id;
        if ($id == 0) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->tableGateway->insert($data);
        } else {
            if ($this->getListById($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
        return $id;
    }

    public function saveWhishList($data) {
        
        
        $sql = "SELECT * FROM preplanning_whishlist WHERE type='".$data['type']."' AND user_id='".$data['user_id']."'";
        $selectStatement = $this->tableGateway->getAdapter()->query($sql);
        $res = $selectStatement->execute();
        $exsistingData = '';
        if(count($res)==0){
        
        $sql = "INSERT INTO `preplanning_whishlist` (`id`, `user_id`, `item_ids`, `type`, `created_at`, `updated_at`) VALUES (NULL, '".$data['user_id']."', '".$data['item_ids']."', '".$data['type']."',  '".date('Y-m-d H:i:s')."',CURRENT_TIMESTAMP);";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $statement->execute();
        }else{
             foreach ($res as $row) {
                
                 $exsistingData = $row['item_ids'];
             }
            $where = "user_id='" . $data['user_id'] ."' AND type='".$data['type']."'";
            $exsistingArray = explode(',', $exsistingData);
            $newArray = explode(',', $data['item_ids']);
             
            $itemIds = implode(',',array_unique(array_merge($exsistingArray, $newArray))); 

        $sql = "UPDATE `preplanning_whishlist` SET item_ids='".$itemIds."' WHERE ".$where;
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $statement->execute(); 
        }
       return true;
    }

    public function saveFiles(PrePlanning $class) {

        $data = array(
            'title' => $class->title,
            'url' => $class->url,
            'preplanning_id' => $class->preplanning_id,
        );

        $id = (int) $class->id;
        if ($id == 0) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->tableGateway->insert($data);
        } else {
            if ($this->getListById($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
        return $id;
    }

    public function deleteList($id) {

        $list = $this->getListById($id);
        if ($list != '') {

            $this->tableGateway->delete(array('id' => $id));
        }
    }

    public function multiDelete($ids) {

        $id = implode(",", $ids);

        $sql = "DELETE FROM preplanning WHERE id IN (" . $id . ")";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $statement->execute();
        return true;
    }

    public function getCategories() {

        $sql = "SELECT * FROM category WHERE type='preplanning'";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();

        $rows = array();
        foreach ($res as $row) {
            $rows[$row['id']] = array(
                'value' => $row['id'],
                'label' => $row['title'],
            );
        }
        return $rows;
    }

}