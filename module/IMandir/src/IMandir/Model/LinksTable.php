<?php

namespace IMandir\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class LinksTable {

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

    public function fetchAll($paginated = false,$id, $search = '') {
        if ($paginated) {
            // create a new Select object for the table cms
            $select = new Select('preplanning_links');

            $dbSelect = $select->columns(array('id', 'category', 'title','url'));
            if ($id != '') {
                $dbSelect->where("preplanning_links.preplanning_id = '$id'");
            }
            if ($search != '') {
                $dbSelect->where("preplanning_links.category = '$search'");
            }
            //  echo  $dbSelect->getSqlString();die;
            // create a new result set based on the Album entity
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Links());
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
   

    public function getListById($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveList(Links $class) {

        $data = array(
            'preplanning_id' => $class->preplanning_id,
            'category' => $class->category,
            'title' => $class->title,
            'url' => $class->url,
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
     public function fetchLinks($categoryId,$category) {
       
        $sql = "SELECT links.* FROM preplanning_links AS links LEFT JOIN preplanning AS plan ON links.preplanning_id=plan.id WHERE links.category='".$category."' AND plan.category_id=".$categoryId;
//echo $sql;exit;       
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();

        $rows = array();
        foreach ($res as $row) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function deleteList($id) {

        $list = $this->getListById($id);
        if ($list != '') {

            $this->tableGateway->delete(array('id' => $id));
        }
    }

    public function multiDelete($ids) {

        $id = implode(",", $ids);

        $sql = "DELETE FROM preplanning_links WHERE id IN (" . $id . ")";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $statement->execute();
        return true;
    }


}