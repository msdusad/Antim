<?php

namespace Emails\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class GroupsTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($paginated = false, $id) {

        if ($paginated) {
            // create a new Select object for the table album
            $select = new Select('email_group');

            $dbSelect = $select->columns(array('id', 'title', 'user_id', 'status', 'created_at'));
            $dbSelect->where("email_group.user_id ='$id'");
            $dbSelect->order(array('email_group.id asc'));
            // create a new result set based on the Album entity
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Groups());
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

    public function groupUsers($paginated = false, $id) {

        if ($paginated) {
            // create a new Select object for the table album
            $select = new Select('email_group_users');
            $dbSelect = $select->columns(array('id', 'identity', 'created_at'));
            $dbSelect->where("email_group_users.group_id ='$id'");
            $dbSelect->order(array('email_group_users.id asc'));
            //  echo  $dbSelect->getSqlString();die;
            // create a new result set based on the Album entity
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Groups());
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

    public function getGroup($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function getGroupUsers($id) {

        $sql = "SELECT * FROM email_group_users WHERE group_id='$id'";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();
        $id = array();

        foreach ($res as $row) {
            $id[] = $row['id'];
        }

        return $id;
    }

    public function saveGroup(Groups $group) {

        $data = array(
            'title' => $group->title,
            'user_id' => $group->user_id,
            'status' => 1,
        );

        $id = (int) $group->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getGroup($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function saveUser($group) {


        $ids = explode(",", $group['identity']);
        $groupId = $group['group_id'];
        $sql = '';
        foreach ($ids as $id) {
            $sql .= "INSERT INTO email_group_users (`id`, `group_id`, `identity`, `created_at`) VALUES (NULL, '$groupId', '$id', CURRENT_TIMESTAMP);";
        }

        $statement = $this->tableGateway->getAdapter()->query($sql);
        $statement->execute();
        return true;
    }

    public function delete($id) {

        $users = $this->getGroupUsers($id);

        if (count($users) > 0) {

            $sql = "DELETE FROM email_group_users WHERE group_id IN (" . $id . ")";
            $statement = $this->tableGateway->getAdapter()->query($sql);
            $statement->execute();
        }

        $this->tableGateway->delete(array('id' => $id));
    }

    public function multiUserDelete($ids) {

        $id = implode(",", $ids);
        $sql = "DELETE FROM email_group_users WHERE id IN (" . $id . ")";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $statement->execute();
        return true;
    }

    public function multiGroupDelete($ids) {

        $id = implode(",", $ids);
        $sql = "DELETE FROM email_group WHERE id IN (" . $id . "); DELETE FROM email_group_users WHERE group_id IN (" . $id . ")";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $statement->execute();
        return true;
    }

}