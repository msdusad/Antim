<?php

namespace CremationPlan\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class FindTable {

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

    public function fetchAll($paginated = false,$search='') {
        if ($paginated) {
            // create a new Select object for the table cms
            $select = new Select('find');
            
            $dbSelect = $select->columns(array('id','photo', 'category_id', 'name','address','phone','mobile','email','skype','languages'));
           if($search!=''){
            $dbSelect->where("find.category_id = '$search'");    
           }
        //  echo  $dbSelect->getSqlString();die;
            // create a new result set based on the Album entity
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Find());
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

    public function saveList(Find $find) {

        $data = array(
            'category_id' => $find->category_id,
            'name' => $find->name,
            'address' => $find->address,           
            'phone' => $find->phone,
            'mobile' => $find->mobile,
            'email' => $find->email,
            'skype' => $find->skype,
            'languages' => serialize($find->languages),
            'photo' => $find->photo,
        );
 
        if($data['photo']==''){unset($data['photo']);}
        
        
        $id = (int) $find->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->lastInsertValue;
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

            $dirName = dirname(__DIR__) . '/../../assets/';
            
            if (file_exists($dirName . 'thumb/' . $list->id . '_' . $list->photo)) {

                unlink($dirName . 'thumb/' . $list->id . '_' . $list->photo);
            }
            if (file_exists($dirName . $list->photo)) {

                unlink($dirName . $list->photo);
            }
            $this->tableGateway->delete(array('id' => $id));
        }
    }

    public function multiDelete($ids) {
        
        $id = implode(",", $ids);
        $sql = "SELECT id,photo FROM find WHERE id IN (" . $id . ")";
        $sqlStatement = $this->tableGateway->getAdapter()->query($sql);
        $res = $sqlStatement->execute();
        $dirName = dirname(__DIR__) . '/../../assets/';
        
        foreach ($res as $photo) {
            if (file_exists($dirName . 'thumb/' . $photo['id'] . '_' . $photo['photo'])) {

                unlink($dirName . 'thumb/' . $photo['id'] . '_' . $photo['photo']);
            }
            if (file_exists($dirName . $photo['photo'])) {

                unlink($dirName . $photo['photo']);
            }
        }

        $sql = "DELETE FROM find WHERE id IN (" . $id . ")";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $statement->execute();
        return true;
    }

    public function getCategories() {

        $sql = "SELECT * FROM category WHERE type='find'";
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
    public function getLanguages() {

        $sql = "SELECT * FROM languages WHERE 1";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();

         $rows = array();
        foreach ($res as $row) {
            $rows[$row['id']] = array(
                'value' => $row['name'],
                'label' => $row['name'],
            );
        }
        return $rows;
    }
public function saveLog($userId){
        
        $ip = $_SERVER['REMOTE_ADDR'];
        $sql = "INSERT INTO logged_users(`id`, `user_id`, `ip_address`, `logged_at`) VALUES (NULL, '".$userId."', '".$ip."', CURRENT_TIMESTAMP)";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $statement->execute();
    }
    public function deleteLog($userId){
               
        $sql = "DELETE FROM logged_users  WHERE user_id = ".$userId;
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $statement->execute();
    }
//	
//	    public function SpecialVendor() {
//
//        $sql = "SELECT * FROM special_vendor_category";
//        $statement = $this->tableGateway->getAdapter()->query($sql);
//        $res = $statement->execute();
//         $rows = array();
//        foreach ($res as $row) {
//			$rows[]=$row;
//			$id=$row['id'];
//            	$qry1=mysql_query("select * from special_vendor_subcategory where category_id='$id'"); 
//			$statement1 = $this->tableGateway->getAdapter()->query($qry1);
//        $res1 = $statement1->execute();
//			$cats=array();
//			foreach($res1 as $row1){
//			$cats[]=$row1;
//			}
//			return $cats;
//        }
//        return $rows;
//    }
	
	
}