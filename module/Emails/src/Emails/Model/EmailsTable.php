<?php

namespace Emails\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class EmailsTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($paginated = false, $email) {

        if ($paginated) {
            // create a new Select object for the table album
            $select = new Select('emails');
            $dbSelect = $select->columns(array('id', 'to_id', 'subject', 'message', 'from_id', 'created_date'))
                    ->join('user', 'emails.from_id = user.user_id', array('user' => 'display_name', 'email'), 'left');
            $dbSelect->where("emails.to_id LIKE '%$email%' AND emails.inbox_item != 1");
            $dbSelect->order(array('emails.id asc'));
              //  echo  $dbSelect->getSqlString();die;
            // create a new result set based on the Albu
            // create a new result set based on the Album entity
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Emails());
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

    public function sentItems($paginated = false,$id) {

        if ($paginated) {
            // create a new Select object for the table album
            $select = new Select('emails');
            $dbSelect = $select->columns(array('id', 'to_id', 'subject', 'message', 'from_id', 'created_date'))
                    ->join('user', 'emails.from_id = user.user_id', array('user' => 'display_name', 'email'), 'left');
            $dbSelect->where("emails.from_id ='$id' AND emails.sent_item != 1");
            $dbSelect->order(array('emails.id asc'));
            // create a new result set based on the Album entity
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Emails());
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

    public function getEmail($id) {
       
        $sql = "SELECT e.id,u.email,e.to_id,e.subject,e.message FROM user as u LEFT JOIN emails as e ON u.user_id=e.from_id WHERE e.id='$id'";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();
        $email = array();
        foreach ($res as $row) {
             $email['id'] = $row['id'];
            $email['from_id'] = $row['email'];
            $email['to_id'] = $row['to_id'];
            $email['subject'] = $row['subject'];
            $email['message'] = $row['message'];
        }
        
        return $email;
    }
    
     public function getReplies($id) {

        $sql = "SELECT * FROM emails WHERE reply_parent='$id'";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();
        $rows = array();
        foreach ($res as $row) {
            $rows[] =  $row;
        }
        return $rows;
    }


    public function saveEmail(Emails $email) {
        $data = array(
            'to_id' => $email->to_id,
            'from_id' => $email->from_id,
            'subject' => $email->subject,
            'message' => $email->message,
            'sent_item' => 0,
            'inbox_item' => 0,            
        );

        $id = (int) $email->id;
        if ($id == 0) {           
            $data['reply_parent'] =0;
            
        } else {
           $data['reply_parent'] = $id;
        
        }
       
         $this->tableGateway->insert($data);
    }

    public function deleteEmail($id) {
        $this->tableGateway->delete(array('id' => $id));
    }
    
    public function multiInboxDelete($ids) {

        $id = implode(",", $ids);
        $sql = "UPDATE emails SET inbox_item = 1 WHERE id IN (".$id.")";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $statement->execute();
        return true;
    }
    
     public function multiSentDelete($ids) {

        $id = implode(",", $ids);
        $sql = "UPDATE emails SET sent_item = 1 WHERE id IN (".$id.")";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $statement->execute();
        return true;
    }
    public function getEmails($id) {

        $sql = "SELECT identity FROM  email_group_users WHERE group_id='$id'";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();
        $rows = array();
        foreach ($res as $row) {
            $rows[] =  $row['identity'];
        }
        return $rows;
    }

}