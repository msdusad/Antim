<?php

namespace Menu\Form;

use Zend \Form\Form;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class MenuForm extends Form
{
    protected $dbAdapter;
    protected $table = 'pages';
	
    //public function __construct(AdapterInterface $dbAdapter)
	public function __construct(Adapter $dbAdapter)
    {
        parent::__construct('addmenu');
        $this->setAttribute('method', 'post');
        
        $this->setAdapter($dbAdapter);
        
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                                'type' => 'text',
                                'id'=>'name',
                                'required' => 'required',
                                'class'=>'form-control'
                                ),
            'options' => array('label' => 'Name',
            'label_attributes' => array(
                    'class'  => 'input-group-addon'
               )),
            ));
        $this->add(array(
            'name' => 'label',
            'attributes' => array(
                                'type' => 'text',
                                'id'=>'label',
                                'required' =>false,
                                'class'=>'form-control'
                                ),
            'options' => array('label' => 'Label',
            'label_attributes' => array(
                    'class'  => 'input-group-addon'
               )),
            ));
            
       $this->add(array(     
    		'type' => 'Zend\Form\Element\Select',       
    		'name' => 'alias',
            'attributes' => array( 
               'class'=>'form-control',
            ),
           
            'options' =>array(
                        'value_options'=>$this->getMenuPages(),
                        
                ),
         ));
           
             $this->add(array(     
    		'type' => 'Zend\Form\Element\Select',       
    		'name' => 'type',
            'attributes' => array( 
               'class'=>'form-control',
               
            ),
            'options' =>array(
                       
                        'value_options'=>array(
                        'first' =>'Header Menu',
                        'second'=>'Footer Menu',
                        'third' =>'Sidebar Menu',
                       ),
                      
                        
                ),
          ));
            
            $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                    'type' => 'submit',
                    'class'=>'btn btn-info',
                    'value' => 'Add' 
                ),
            ));
    }
    public function setAdapter($dbAdapter)
    {
        $this->dbAdapter =$dbAdapter;
        return  $this;
    }
    public function getDbAdapter()
    {
       return $this->dbAdapter; 
    }
    public function getMenuPages()
    {
        $adapter = $this->getDbAdapter();
        $sql = new Sql($adapter);
        $subselect2 =   $sql->select()
                            ->from($this->table)
       	                    ->where(array('status'=>1,'deleted'=>0));
		$statement = $sql->prepareStatementForSqlObject($subselect2);
        $results = $statement->execute();
		foreach($results as $result){
		      $res[$result['id']] =ucwords($result['title']);
		}
		return $res;
    }
}

?>