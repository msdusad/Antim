<?php

namespace SharedTasks\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Db\Sql\Predicate\Expression;
use Zend\Paginator\Paginator;
use Zend\Mail;

class SharedTaskTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($type, $id, $userId) {

       
        $sql = "SELECT t.title as task,c.title as category,st.id, st.due_date, st.due_time, st.fre, st.priority, st.status,st.assigned_to, st.notes, st.task_id, st.user_id 
           ,Group_Concat(u.display_name SEPARATOR ', ') as userName FROM shared_tasks as st LEFT JOIN user as u ON FIND_IN_SET( u.user_id, st.assigned_to ) 
           LEFT JOIN tasks as t ON st.task_id = t.id 
            LEFT JOIN category as c ON t.category_id = c.id WHERE st.user_id=" . $userId;

        if ($type == 'obituary') {

            $sql .=" AND st.obituary_id = '" . $id . "'";
        } else if ($type == 'memoralize') {

            $sql .=" AND st.memoralize_id = '" . $id . "'";
        }
        $sql .= " GROUP BY st.id";
       
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();

        $rows = array();
        foreach ($res as $row) {
            $rows[] =  $row;
        }
        return $rows;
    }

    public function fetchUsers() {
        $sql = "SELECT * FROM user WHERE user_id!=1";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();

        $rows = array();
        foreach ($res as $row) {
            $rows[$row['user_id']] = $row['username'] . ' ' . $row['display_name'];
        }
        return $rows;
    }

    public function fetchObituary($userId) {
        $sql = "SELECT * FROM death_user  WHERE user_id=$userId AND status=1";
//echo $sql;exit;        
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();
        $rows = array();
        foreach ($res as $key => $row) {
            $rows[$key]['name'] = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
            $rows[$key]['id'] = $row['deathuser_id'];
        }
      //  print_r($rows);exit;
        return $rows;
    }
	public function fetchDeathUser($userId) {
		if($userId!="") {
        $sql = "SELECT * FROM death_user  WHERE user_id=$userId AND status=1";
     }else {
			  $sql = "SELECT * FROM death_user  WHERE status=1";   
     }
//echo $sql;exit;        
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();
        $rows = array();
        foreach ($res as $key => $row) {
            $rows[$key]['name'] = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
            $rows[$key]['id'] = $row['deathuser_id'];
        }
      //  print_r($rows);exit;
        return $rows;
    }
public function getObituary() {
        $sql = "SELECT oi.* FROM obituary_infos  as oi LEFT JOIN obituary as o ON oi.obituary_id=o.id WHERE o.steps=3 AND o.status=0";
//echo $sql;exit;        
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();
        $rows = array();
        foreach ($res as $key => $row) {
            $rows[$key]['name'] = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
            $rows[$key]['id'] = $row['obituary_id'];
        }
      //  print_r($rows);exit;
        return $rows;
    }
    public function fetchUpdates($userId) {
        $sql = "SELECT t.title,s.task_id,s.user_id as user, s.status,s.updated_on,u.* FROM shared_tasks_users 
            as st LEFT JOIN shared_tasks as s ON st.user_id=s.assigned_to 
            LEFT JOIN user as u ON st.user_id=u.user_id
            LEFT JOIN tasks as t ON s.task_id=t.id
            WHERE st.owner_id= $userId AND st.user_id != $userId AND s.status!='pending' AND DATE(s.updated_on) = CURDATE()";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();
        $rows = array();
        foreach ($res as $key => $row) {
            $rows[$key]['name'] = $row['username'] . ' ' . $row['display_name'];
            $rows[$key]['task'] = $row['title'];
            $rows[$key]['time'] = $row['updated_on'];
        }

        return $rows;
    }
public function getUpdates() {
        $sql = "SELECT t.title,s.task_id,s.user_id as user, s.status,s.updated_on,u.* FROM shared_tasks_users 
            as st LEFT JOIN shared_tasks as s ON st.user_id=s.assigned_to 
            LEFT JOIN user as u ON st.user_id=u.user_id
            LEFT JOIN tasks as t ON s.task_id=t.id
            WHERE s.status!='pending' AND DATE(s.updated_on) = CURDATE()";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();
        $rows = array();
        foreach ($res as $key => $row) {
            $rows[$key]['name'] = $row['username'] . ' ' . $row['display_name'];
            $rows[$key]['task'] = $row['title'];
            $rows[$key]['time'] = $row['updated_on'];
        }

        return $rows;
    }
    public function searchMemoralize($query) {
        $sql = "SELECT oi.* FROM memoralize_infos  as oi LEFT JOIN memoralize as o ON oi.memoralize_id=o.id
           WHERE oi.first_name LIKE '%$query%' OR oi.middle_name LIKE '%$query%' OR oi.last_name LIKE '%$query%' AND o.status=0";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();
        $rows = array();
        foreach ($res as $row) {

            $rows['id'] = $row['id'];
        }
        return $rows;
    }
     public function searchObituary($query) {
     	//echo $query;exit;
        $sql = "SELECT oi.* FROM obituary_infos  as oi LEFT JOIN obituary as o ON oi.obituary_id=o.id
           WHERE oi.first_name LIKE '%$query%' OR oi.middle_name LIKE '%$query%' OR oi.last_name LIKE '%$query%' AND o.status=0";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();
        $rows = array();
        foreach ($res as $row) {

            $rows['id'] = $row['id'];
        }
        return $rows;
    }

    public function fetchMemoralize($userId) {
    	if($userId!="") {
        $sql = "SELECT mi.* FROM memoralize_infos  as mi LEFT JOIN memoralize as m ON mi.memoralize_id=m.id WHERE m.user_id=$userId AND m.steps=3 AND m.status=0";
		}else {
		$sql = "SELECT mi.* FROM memoralize_infos  as mi LEFT JOIN memoralize as m ON mi.memoralize_id=m.id WHERE m.steps=3 AND m.status=0";
		}        
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();
        $rows = array();
        foreach ($res as $key => $row) {
            $rows[$key]['name'] = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
            $rows[$key]['id'] = $row['memoralize_id'];
        }
        return $rows;
    }

    public function loggedUsers($userId) {

        $rows = array();
        $sql = "SELECT su.*,u.* , lu.user_id AS logged FROM shared_tasks_users as su  LEFT JOIN user as u ON su.user_id =u.user_id LEFT JOIN logged_users as lu ON su.user_id= lu.user_id WHERE su.owner_id=" . $userId;
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();
        foreach ($res as $row) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function getTask($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function savesharedTask($data) {

        $id = (int) $data['id'];
        if ($id == 0) {
            $data['created_on'] = date('Y-m-d H:i:s');
            $this->tableGateway->insert($data);
        } else {
            if ($this->getTask($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function saveUsers($data) {


        $shares = array();
        if (isset($data['id'])) {
            if (count($data['id']['id']) > 1) {
                $shares = $this->getShare(implode(",", $data['id']['id']));
            } else {
                $shares = $this->getShare($data['id']['id'][0]);
            }
        }

        if (count($shares) > 0) {

            $levels = array();
            foreach ($data['id']['level'] as $key => $level) {

                $levels[$data['id']['id'][$key]] = $level;
            }

            $sql = '';
            foreach ($levels as $id => $level) {

                $sql .= "UPDATE `shared_tasks_users` SET `user_level` = '" . $level . "' WHERE `id` =" . $id . ";";
            }

            $statement = $this->tableGateway->getAdapter()->query($sql);
            $statement->execute();
        } else {

            $exsisting = $this->checkShare($data['owner_id']);
            $users = array();

            $data['users'] = explode(',', $data['users']);

            foreach ($data['users'] as $user) {
                if (!in_array($user, $exsisting)) {
                    $users[] = $user;
                }
            }

            if (count($users) != 0) {
                $sql = "INSERT INTO shared_tasks_users (`id`, `owner_id`, `user_id`, `user_level`, `link_id`, `status`) VALUES ";
                $lastElement = end($users);
                foreach ($users as $user) {

                    $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                    $linkId = str_shuffle($str);

                    if ($user == $lastElement) {
                        $sql .= "(NULL, '" . $data['owner_id'] . "', '" . $user . "', '" . $data['level'] . "', '" . $linkId . "' ,'0')";
                    } else {
                        $sql .= "(NULL, '" . $data['owner_id'] . "', '" . $user . "', '" . $data['level'] . "', '" . $linkId . "', '0'),";
                    }
                }
                $sql .= '';

                $statement = $this->tableGateway->getAdapter()->query($sql);
                $statement->execute();

                $fromMail = $this->getEmail($data['owner_id']);

                $baseUrl = $data['base'] . '/sharedtasks/sharestate/';

                foreach ($users as $user) {

                    $toMail = $this->getEmail($user);
                    $linkId = $this->getSharedLink($data['owner_id'], $user);
                    $url = $baseUrl . $linkId;
                    $mail = new Mail\Message();
                    $html = '<table><tr><td>please click the link to see the sharedtask list</td></tr>';
                    $html .= '<tr><td><a href="' . $url . '">Click here</a></td></table>';
                    $part = new \Zend\Mime\Part($html);
                    $part->type = 'text/html';
                    $body = new \Zend\Mime\Message;
                    $body->setParts(array($part));

                    $mail->setBody($body);
                    $mail->setFrom($fromMail['email'], $fromMail['display_name']);
                    $mail->addTo($toMail['email'], $toMail['display_name']);
                    $mail->setSubject(ucfirst($fromMail['display_name']) . 'shared a task list to you');

                    $transport = new Mail\Transport\Sendmail();
                    $transport->send($mail);
                }
            }
        }
    }

    public function updateTask($data) {
       
        $datas = array(
            'status'=>$data['status'],
            'due_date'=>$data['due_date'],
             'due_time'=>$data['due_time'],
             'priority'=>$data['priority'],
             'notes'=>$data['notes'],
            'assigned_to'=>implode(",", $data['assigned_to']));
        
        $id = (int) $data['id'];
       
        if ($this->getTask($id)) {
                     
            $this->tableGateway->update($datas, array('id' => $id));
        } else {
            throw new \Exception('Form id does not exist');
        }
    }

    public function deleteTask($id = null, $taskid = null) {
        if ($id != '') {

            $this->tableGateway->delete(array('id' => $id));
        } else if ($taskid != '') {

            $this->tableGateway->delete(array('task_id' => $taskid));
        }
    }

    public function saveTask($datas) {

        $sql = "INSERT INTO tasks (`id`, `title`, `description`, `category_id`, `user_id`) VALUES (NULL, '" . $datas->title . "', '" . $datas->description . "', '" . $datas->category_id . "', '" . $datas->user_id . "');";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $statement->execute();
        return true;
    }

    public function getShare($ids) {

        $sql = "SELECT * FROM shared_tasks_users WHERE id IN(" . $ids . ")";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();
        $rows = array();
        foreach ($res as $row) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function getShares($userId) {

        $sql = "SELECT s.*,u.email,u.display_name,u.username FROM shared_tasks_users as s LEFT JOIN user as u 
            ON s.user_id = u.user_id WHERE s.owner_id=" . $userId;
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();
        $rows = array();
        foreach ($res as $row) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function checkShare($ownerId) {

        $sql = "SELECT * FROM shared_tasks_users WHERE owner_id =" . $ownerId;
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();
        $rows = array();
        foreach ($res as $row) {
            $rows[] = $row['user_id'];
        }

        return $rows;
    }

    public function deleteShare($id) {

        $sql = "DELETE FROM `shared_tasks_users` WHERE `id` = " . $id;
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $statement->execute();
        return true;
    }

    public function getEmail($userId) {

        $sql = "SELECT email,display_name FROM user WHERE user_id =" . $userId;
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();
        $rows = array();
        foreach ($res as $row) {
            $rows = $row;
        }
        return $rows;
    }

    public function getSharedLink($ownerId, $userId) {

        $sql = "SELECT link_id FROM  shared_tasks_users WHERE owner_id =" . $ownerId . " AND user_id =" . $userId;
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();
        $rows = array();
        foreach ($res as $row) {
            $rows = $row['link_id'];
        }
        return $rows;
    }

    public function shareState($id) {

        $sql = "UPDATE `shared_tasks_users` SET `status` = '1' WHERE `link_id` ='" . $id . "';";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $statement->execute();
        return true;
    }

    public function shareLevel($level, $ownerid, $userid) {

        $sql = "UPDATE `shared_tasks_users` SET `user_level` = '" . $level . "' WHERE `owner_id` ='" . $ownerid . "' AND `user_id` ='" . $userid . "';";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $statement->execute();
        return true;
    }

    public function sharedWithme($userId) {

        $sql = 'SELECT st.*,Group_Concat(u.display_name SEPARATOR ", ") as userName ,t.title as task,stu.user_level,stu.owner_id,u1.display_name as ownerName FROM shared_tasks as st LEFT JOIN shared_tasks_users as stu ON stu.owner_id =st.user_id 
LEFT JOIN user as u ON FIND_IN_SET( u.user_id, st.assigned_to ) LEFT JOIN tasks as t ON st.task_id = t.id 
LEFT JOIN user as u1 ON stu.owner_id = u1.user_id
WHERE stu.user_id=' . $userId . ' AND stu.owner_id!=' . $userId .' GROUP BY st.id';
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();
        $rows = array();
        foreach ($res as $row) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function getSharedDocument($type, $id, $userId) {
		if($id!="") {
        $sql = 'SELECT t.title as task,st.id, st.due_date, st.due_time, st.fre, st.priority, st.status,st.assigned_to, st.notes, st.task_id, st.user_id 
           ,Group_Concat(u.display_name SEPARATOR ", ") as userName FROM shared_tasks as st LEFT JOIN user as u ON FIND_IN_SET( u.user_id, st.assigned_to ) 
           LEFT JOIN tasks as t ON st.task_id = t.id WHERE st.user_id='.$userId.' ' ;
        if ($type == 'obituary') {
            $sql .= ' AND st.obituary_id=' . $id;
        } else if ($type == 'memoralize') {
            $sql .= ' AND st.memoralize_id	=' . $id;
        }elseif($type == 'deathuser') {
				$sql .= ' AND st.obituary_id=' . $id;
        }
        $sql .=" Group by st.id ";
        //echo $sql;exit;
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();
        $rows = array();
        foreach ($res as $row) {
            $rows[] = $row;
        }
        return $rows;
     }else {
			return "";     
     }
    }
	public function fetchSharedDocument($type, $id) {

        $sql = 'SELECT t.title as task,st.id, st.due_date, st.due_time, st.fre, st.priority, st.status,st.assigned_to, st.notes, st.task_id, st.user_id 
           ,Group_Concat(u.display_name SEPARATOR ", ") as userName FROM shared_tasks as st LEFT JOIN user as u ON FIND_IN_SET( u.user_id, st.assigned_to ) 
           LEFT JOIN tasks as t ON st.task_id = t.id';
        if ($type == 'obituary') {

            $sql .= ' AND st.obituary_id=' . $id;
        } else if ($type == 'memoralize') {

            $sql .= ' AND st.memoralize_id	=' . $id;
        }
        $sql .=" Group by st.id ";
		  //echo $sql;exit;
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();
        $rows = array();
        foreach ($res as $row) {
            $rows[] = $row;
        }
        return $rows;
    }

}

