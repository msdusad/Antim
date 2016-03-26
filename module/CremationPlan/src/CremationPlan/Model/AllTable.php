<?php

namespace CremationPlan\Model;

use Zend\Db\TableGateway\TableGateway;

class AllTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function getFinds() {

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

    public function getLearns() {

        $sql = "SELECT * FROM category WHERE type='learn'";
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
    public function getImpacts() {

        $sql = "SELECT * FROM category WHERE type='impact'";
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
    public function getProtects() {

        $sql = "SELECT * FROM protect";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();

        $rows = array();
        foreach ($res as $row) {
            $rows[] = $row;
        }
        return $rows;
    }
    


    public function getTraditionalList() {

        $sql = "SELECT rt.* FROM rituals_traditional as rt RIGHT JOIN rituals as r ON rt.id = r.traditional_id";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();

        $rows = array();
        foreach ($res as $row) {
            $rows[$row['id']] = array(
                'value' => $row['id'],
                'label' => $row['name'],
            );
        }
        return $rows;
    }

    public function getTraditionalSelected() {

        $sql = "SELECT * FROM rituals_traditional order by id asc limit 1";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();

        $rows = array();
        foreach ($res as $row) {
            $rows = $row['id'];
        }
        return $rows;
    }

    public function getRitualList($traditionalSelected) {

        $sql = "SELECT r.* FROM rituals as r LEFT JOIN rituals_days as rd ON rd.ritual_id = r.id WHERE r.traditional_id=" . $traditionalSelected . " Group by rd.ritual_id";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();

        $rows = array();
        foreach ($res as $row) {
            $rows = $row;
        }
        return $rows;
    }

    public function getRitualDays($ritualId) {

        $sql = "SELECT * FROM rituals_days WHERE ritual_id=" . $ritualId;
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();

        $rows = array();
        foreach ($res as $row) {
            $rows[] = $row;
        }
        return $rows;
    }
    public function getGothras() {

        $sql = "SELECT * FROM gothra";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();

        $rows = array();
        foreach ($res as $row) {
            $rows[] = $row;
        }
        return $rows;
    }
    public function getHindusims() {

        $sql = "SELECT * FROM hindusim";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();

        $rows = array();
        foreach ($res as $row) {
            $rows[] = $row;
        }
        return $rows;
    }
    
    
//      public function getHindusimsdetail() {
//
//        $sql = "SELECT * FROM hindusim_detail";
//        $statement = $this->tableGateway->getAdapter()->query($sql);
//        $res = $statement->execute();
//
//        $rows = array();
//        foreach ($res as $row) {
//            $rows[] = $row;
//        }
//        return $rows;
//    }
    
    

    public function getFindList($id, $name, $city,$code) {

        $sql = "SELECT f.*,TRUNCATE(AVG(fr.rating), 1 ) as rating FROM find as f LEFT JOIN find_reviews as fr ON f.id=fr.find_id WHERE 1";
        
        if ($id != 0) {

            $sql .= " AND f.category_id=" . $id;
        }
        if ($name != '') {

            $sql .=" AND f.name LIKE '%" . $name . "%'";
        }
        if ($city != '') {

            $sql .=" AND f.address LIKE '%" . $city . "%'";
        }
        if ($code != '') {

            $sql .=" AND f.address LIKE '%" . $code . "%'";
        }
        $sql .=" GROUP BY f.id";
        //echo $sql;die;
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();

        $rows = array();
        foreach ($res as $row) {
            $rows[] = $row;
        }
        return $rows;
    }
    
    public function getImpactList($id, $name) {

        $sql = "SELECT im.*,ig.photo_url FROM impacts as im LEFT JOIN impact_gallery as ig ON ig.impact_id = im.id WHERE im.category_id=" . $id." ";
        if ($name != '') {

            $sql .=" AND im.title LIKE '%" . $name . "%'";
        }
        
        $sql .= " GROUP BY im.id";
        // echo $sql;die;
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();

        $rows = array();
        foreach ($res as $row) {
            $rows[] = $row;
        }
        return $rows;
    }
    public function getImpactDetails($id) {

        $sql = "SELECT im.*,ig.photo_url FROM impacts as im LEFT JOIN impact_gallery as ig ON ig.impact_id = im.id WHERE im.id='$id' GROUP BY im.id";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();
        $rows = array();
        foreach ($res as $row) {
           $rows = $row;
        }
        return $rows;
    }

    public function getPurchase() {

        $sql = "SELECT * FROM category WHERE type='product'";
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

    public function getProductList($id, $name) {

        $sql = "SELECT * FROM product WHERE category_id=" . $id;
        if ($name != '') {

            $sql .=" AND title LIKE '%" . $name . "%'";
        }

        // echo $sql;die;
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();

        $rows = array();
        foreach ($res as $row) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function getCategoryBy($id) {

        $sql = "SELECT title FROM category WHERE id='$id'";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();
        $id = '';
        foreach ($res as $row) {
            $id = $row['title'];
        }

        return $id;
    }

    public function getDaysById($id) {

        $sql = "SELECT * FROM rituals_days WHERE ritual_id=" . $id;
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();
        $rows = array();

        foreach ($res as $row) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function saveDays($data) {

        $ids = $data['id'];
        $days = $data['content'];
        $sql = '';
        foreach ($days as $key => $value) {
            
            $sql .= 'UPDATE rituals_days SET content = "'.$value.'" WHERE id ='. $ids[$key].';';
        }
       
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $statement->execute();
    }
    
     public function getVideos($id) {

        $sql = "SELECT * FROM impact_videos WHERE impact_id='$id'";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();

        $rows = array();
        foreach ($res as $row) {
            $rows[] = $row;
        }
        return $rows;
    }
    
     public function getGallery($id) {

        $sql = "SELECT * FROM impact_gallery WHERE impact_id='$id'";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();

        $rows = array();
        foreach ($res as $row) {
            $rows[] = $row;
        }
        return $rows;
    }
    
     public function getObituary($userId) {

        $sql = "SELECT * FROM obituary WHERE user_id='$userId' AND status=3 ORDER BY id asc LIMIT 1";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();

        $rows = array();
        foreach ($res as $row) {
            $rows = $row;
        }
        return $rows;
    }

    public function saveReview($data) {

        $id = $data['id'];
        $userid = $data['userid'];
        $level = $data['level'];
        
        $review = $this->getReview($id,$userid);
        
        if(count($review)>0){
        $sql = 'UPDATE find_reviews SET rating="'.$level.'" WHERE find_id ='. $id. ' AND user_id ='.$userid;
        }else{
              $sql = "INSERT INTO find_reviews  (`find_id`, `user_id`, `rating`, `created_on`) VALUES ($id, $userid, $level, now())";
        }      
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $statement->execute();
    }
    
      public function getReview($id,$userid) {

        $sql = "SELECT * FROM find_reviews WHERE find_id='$id' AND user_id ='$userid' ORDER BY id asc LIMIT 1";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();

        $rows = array();
        foreach ($res as $row) {
            $rows = $row;
        }
        return $rows;
    }
    
}