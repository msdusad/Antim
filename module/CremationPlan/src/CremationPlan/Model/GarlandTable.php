<?php

namespace CremationPlan\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class GarlandTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($paginated = false, $search = '') {
        if ($paginated) {
            // create a new Select object for the table cms
            $select = new Select('garland');

            $dbSelect = $select->columns(array('id', 'garland_image'));
            
            //  echo  $dbSelect->getSqlString();die;
            // create a new result set based on the Album entity
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Garland());
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

   

    public function getItem($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function save(Garland $garland) {

        $data = array(           
            'garland_image' => $garland->garland_image,
        );

//        if ($data['garland_image'] == '') {
//            unset($data['garland_image']);
//        }


        $id = (int) $garland->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->lastInsertValue;
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

        $garland = $this->getItem($id);
        if ($garland != '') {

            $dirName = dirname(__DIR__) . '/../../assets/garland/';

            if (file_exists($dirName . 'thumb/' . $garland->id . '_' . $garland->garland_image)) {

                unlink($dirName . 'thumb/' . $garland->id . '_' . $garland->garland_image);
            }
            if (file_exists($dirName . $garland->garland_image)) {

                unlink($dirName . $garland->garland_image);
            }
            $this->tableGateway->delete(array('id' => $id));
        }
    }

    public function multiDelete($ids) {

        $id = implode(",", $ids);
        $sql = "SELECT id,garland_image FROM garland WHERE id IN (" . $id . ")";
        $sqlStatement = $this->tableGateway->getAdapter()->query($sql);
        $res = $sqlStatement->execute();
        $dirName = dirname(__DIR__) . '/../../assets/garland/';

        foreach ($res as $photo) {
            if (file_exists($dirName . 'thumb/' . $photo['id'] . '_' . $photo['garland_image'])) {

                unlink($dirName . 'thumb/' . $photo['id'] . '_' . $photo['garland_image']);
            }
            if (file_exists($dirName . $photo['garland_image'])) {

                unlink($dirName . $photo['garland_image']);
            }
        }

        $sql = "DELETE FROM garland WHERE id IN (" . $id . ")";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $statement->execute();
        return true;
    }
}