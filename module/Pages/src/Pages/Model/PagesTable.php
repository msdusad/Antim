<?php

namespace Pages\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

class PagesTable extends AbstractTableGateway
{
    protected $table = 'pages';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new Pages());

        $this->initialize();
    }
	// Get all pages
    public function fetchAll()
    {
		 $sql = new Sql($this->adapter);
         $mainResult = $sql->select()
                          ->from($this->table)
                          ->where(array('deleted'=>0))
                          ->order('id DESC');   
         $statement = $sql->prepareStatementForSqlObject($mainResult);
         $results = $statement->execute();
         return $results;
    }
    public function getPagesLimit($limit='',$offset='')
    {
		 $sql = new Sql($this->adapter);
         $mainResult = $sql->select()
                          ->from($this->table)
                          ->where(array('deleted'=>0))
                          ->limit($limit)
                          ->offset($offset)
                          ->order('id DESC'); 
         //echo $mainResult->getSqlString();     
         $statement = $sql->prepareStatementForSqlObject($mainResult);
         $results = $statement->execute();
         return $results;
    }
    public function countPages()
    {
         $sql = new Sql($this->adapter);
         $mainResult = $sql->select()
                          ->columns(array('total'=> new \Zend\Db\Sql\Expression('COUNT(*)')))
                          ->from($this->table)
                          ->where(array('deleted'=>0))
                          ->order('id DESC');   
         $statement = $sql->prepareStatementForSqlObject($mainResult);
         $results = $statement->execute();
         return $results->current();  
    }

    public function savePage(Pages $pages)
    {
		
        $data = array(
            'user_id'                => $pages->user_id,
            'title'          		 => $pages->title,
            'alias'         		 => $pages->alias,
			'content'         		 => $pages->content,
            'status'           		 => $pages->status,
            'meta_title'           	 => $pages->meta_title,
            'meta_description'       => $pages->meta_description,
			'meta_keywords'          => $pages->meta_keywords,			
            'robots'           		 => $pages->robots,
            'deleted'           	 => 0,
        );
		
		
        $this->insert($data);            
        $lastInsertId = $this->getLastInsertValue();
        return $lastInsertId;
    }
    public function updatePage(Pages $pages,$page_id)
    {
		
        $data = array(
            'user_id'                => $pages->user_id,
            'title'          		 => $pages->title,
            'alias'         		 => $pages->alias,
			'content'         		 => $pages->content,
            'status'           		 => $pages->status,
            'meta_title'           	 => $pages->meta_title,
            'meta_description'       => $pages->meta_description,
			'meta_keywords'          => $pages->meta_keywords,			
            'robots'           		 => $pages->robots,
        );
		
		
        $resultSet = $this->update($data,array('id'=>$page_id));            
        return $resultSet;
    }
	   
    public function checkAlias($title){        
        $result =$this->select(array('title'=>$title));           
        return $result->current();    
    }
	
	// Get page by Alias
    public function getPageByAlias($alias)
    {
        $result =$this->select(array('alias'=>$alias,'deleted'=>0,'status'=>1));            
        return $result->current();
        
    }
	
	// Get page by ID
    public function getPageById($id)
    {
        $result =$this->select(array('id'=>$id));           
       	return $result->current();
    }	
	

	
	// Delete page
	public function deletePage($id)
    {	
	
      $resultSet = $this->update(array('deleted'=>1),array('id' => $id));
      return $resultSet;
	
	}
    
    public function updateStatus($status,$id)
    {
       $resultSet = $this->update(array('status'=>$status),array('id'=>$id));
       return $resultSet; 
    }
    
	
}
