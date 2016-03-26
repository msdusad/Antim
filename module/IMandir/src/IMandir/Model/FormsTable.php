<?php

namespace IMandir\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class FormsTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($paginated = false, $search = '') {
        if ($paginated) {
            // create a new Select object for the table cms
            $select = new Select('preplanning_forms');

            $dbSelect = $select->columns(array('id', 'title', 'url'));
            
            if ($search != '') {
                $dbSelect->where("preplanning_forms.preplanning_id = '$search'");
            }
            
             
            // create a new result set based on the Album entity
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Forms());
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
   public function fetchForms() {
       
       $sql = "SELECT * FROM preplanning_forms";
       
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();

        $rows = array();
        foreach ($res as $row) {
            $rows[] = $row;
        }
        return $rows;
    }
   

    public function getItem($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function save(Forms $class) {

        $data = array(   
             'title' => $class->title,
             'preplanning_id' => $class->preplanning_id,
            'url' => $class->url,
        );

        $id = (int) $class->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
           
        } else {
            if ($this->getItem($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
        return $id;
    }

    public function delete($id) {

        $forms = $this->getItem($id);
        if ($forms != '') {

            $dirName = dirname(__DIR__) . '/../../assets/forms/';

            if (file_exists($dirName . $forms->url)) {

                unlink($dirName . $forms->url);
            }
            $this->tableGateway->delete(array('id' => $id));
        }
    }

    public function multiDelete($ids) {

        $id = implode(",", $ids);
        $sql = "SELECT id,url FROM preplanning_forms WHERE id IN (" . $id . ")";
        $sqlStatement = $this->tableGateway->getAdapter()->query($sql);
        $res = $sqlStatement->execute();
        $dirName = dirname(__DIR__) . '/../../assets/forms/';

        foreach ($res as $photo) {
            
            if (file_exists($dirName . $photo['url'])) {

                unlink($dirName . $photo['url']);
            }
        }
        $sql = "DELETE FROM preplanning_forms WHERE id IN (" . $id . ")";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $statement->execute();
        return true;
    }
}