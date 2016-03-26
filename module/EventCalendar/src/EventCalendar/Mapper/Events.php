<?php

namespace EventCalendar\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;


class Events extends AbstractDbMapper implements EventsInterface {

    protected $tableName = 'event_list';

    public function fetchAll($id,$type,$date,$userid) {
       
        $sql = $this->getSql();
        $select = $sql->select();
        
          $select->from($this->tableName)->where($this->tableName.'.user_id='.$userid);
          if($type=='obituary'){
                $select->join('obituary', $this->tableName . '.obituary_id = obituary.id', array(), 'left')                     
                ->where($this->tableName.'.obituary_id='.$id);
          }else if($type=='memoralize'){
               
              $select->join('memoralize', $this->tableName . '.memoralize_id = memoralize.id', array(), 'left')                     
                ->where($this->tableName.'.memoralize_id='.$id);
          }
          $month=date('m');
          $year=date('Y');
          if($date=='daily'){
              
                 $select->where('DATE('.$this->tableName.'.edate)=CURDATE()');
                 // echo $select->getSqlString();
               }elseif($date=='weekly') {
               	$select->where($this->tableName.'.edate between CURDATE() AND DATE_SUB(NOW(), INTERVAL -1 WEEK) ');
						// echo $select->getSqlString();die;              
              }elseif($date=='monthly') {
              $select->where($this->tableName.'.edate like "%'.$month.'%"');
              //echo $select->getSqlString();die;
              }elseif($date=='yearly') {
              		$select->where($this->tableName.'.edate like "%'.$year.'%"');
              }else {
						$select->where($this->tableName.'.edate = "'.$date.'"');             
              } 	
             
                  
        
          
       $select->order($this->tableName.'.edate asc');
       
        $entity = $this->select($select)->toArray();
//print_r($entity);exit;
        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }
    public function getDeathuser($deathid){
    $sql = $this->getSql();
        $select = $sql->select();
        
          $select->from('death_user')->where('death_user'.'.deathuser_id='.$deathid);
         // print_r($select);exit;
          $entity = $this->select($select);
         
          return $entity;
    }
    public function findEvents($id,$type) {
       if($id!=""){
        $sql = $this->getSql();
        $select = $sql->select();
         $select->columns(array('title','edate','id'));
          $select->from($this->tableName);
          if($type=='obituary'){
                $select->join('obituary', $this->tableName . '.obituary_id = obituary.id', array(), 'left')                     
                ->where($this->tableName.'.obituary_id='.$id);
          }else if($type=='memoralize'){
               
              $select->join('memoralize', $this->tableName . '.memoralize_id = memoralize.id', array(), 'left')                     
                ->where($this->tableName.'.memoralize_id='.$id);
          }
       $select->order($this->tableName.'.edate asc');
      // echo  $select->getSqlString();die;
        $entity = $this->select($select)->toArray();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
	   }else{
		   return "";
		   }
    }
 public function getEvents($id) {
       if($id!=""){
        $sql = $this->getSql();
        $select = $sql->select();
         //$select->columns(array('title','start'));
          $select->from($this->tableName);
          $select->where($this->tableName.'.id='.$id);
        //echo  $select->getSqlString();die;
        $entity = $this->select($select)->toArray();
//print_r($entity);exit;
        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
	   }else{
		   return "";
		   }
    }
    public function save($data) {
//print_r($data);exit;
        $orgData = array('memoralize_id' => $data['memoralize_id'],
        		'obituary_id' => $data['obituary_id'],
        		'profile_type' => $data['profile_type'],
				'user_id' => $data['user_id'],
        		'name' => $data['name'],
            'title' => $data['title'],
            'edate' => $data['edate'],
            'start' => $data['start'],
				'end' => $data['end'],
				'location' => $data['location'],
				'contact' => $data['contact'],           
            'content' => $data['content'],
            'allDay' => '');
       
        if($data['id']==''){
            
            $this->insert($orgData, $this->tableName);
        }else{
            
            $where = 'id='.$data['id'];
            
            $this->update($orgData,$where ,$this->tableName);
        }
        
        return true;
    }
     /**
     * @param  int  $id   
     * @return EventsEntity
     */
    public function findEventById($id)
    {
        $sql    = $this->getSql();
        $select = $sql->select();
        $select->from($this->tableName)
               ->where(array(
                   'id' => $id
               ));

        $entity = $this->select($select)->current();
        
        $data->start = date('Y-m-d', strtotime($entity->start));
        $data->start_time = date('h:i A', strtotime($entity->start));

        $data->end = date('Y-m-d', strtotime($entity->end));
        $data->end_time = date('h:i A', strtotime($entity->end));
        $data->title = $entity->title;
        $data->content = $entity->content;       
        $data->id = $entity->id;
         
        $this->getEventManager()->trigger('find', $this, array('entity' => $data));

        return $data;
    }

}