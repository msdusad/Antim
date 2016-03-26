<?php

namespace Mailbox\Form;
use  Zend\Form\Form;
use  Zend\Db\Adapter\AdapterInterface;
use  Zend\Db\Adapter\Adapter;
use  Zend\Db\Sql\Sql;

class AdminMailForm extends Form
{
   protected $dbAdapter;
   protected $table = 'user';
   protected $user_linker ='user_role_linker';
     
    //public function __construct(AdapterInterface $dbAdapter)
    public function __construct(Adapter $dbAdapter)
    {
        parent::__construct('sendemail');
        $this->setAttribute('method','post');
       
        $this->setAdapter($dbAdapter);

           
       /**    $this->add(array(
            'name' => 'reciever',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                         'type' => 'email',
                         'id'=>'reciever',
						 'class'=>'form-control',
                         
                         
            ),
            
         ));  **/
         
       
           $this->add(array(     
    		'type' => 'Zend\Form\Element\Select',       
    		'name' => 'reciever',
            'attributes' => array( 
               'class'=>'form-control',
               'multiple'=>'multiple',
               
            ),
            'options' =>array(
                        'value_options'=>$this->getemails(),
                        
                ),
         ));
         
         $this->add(array(
            'name' => 'subject',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                         'type' => 'text',
                         'id'=>'subject',
						 'class'=>'form-control',
                         
                         
            ),
            
         )); 
         $this->add(array(
        				'name' => 'body',
        				'attributes' => array(
        						'type'  => 'textarea',
								'required'=>false,
                                'id'=>'email_message',
                                'class'=>'form-control',
                                'style'=>'height: 120px;' 
                                
        					
        				),
        				'options' => array(
        						'label' => '',
        				),
        	
		));
        $this->add(array(
            'name' => 'sent',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Send Message',
				'class' => 'btn btn-info pull-left',
            ),
        ));
        $this->add(array(
            'name' => 'draft',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Draft',
				'class' => 'btn btn-primary pull-left',
            ),
        ));

    }//end constructor...
  
    public function setAdapter($dbAdapter)
    {
        $this->dbAdapter =$dbAdapter;
        return  $this;
    }
    public function getDbAdapter()
    {
       return $this->dbAdapter; 
    }
    public function getemails()
    {
        $adapter = $this->getDbAdapter();
        $sql = new Sql($adapter);
        $subselect2 =   $sql->select()
                            ->from(array('u' =>'user'))
       	                    ->join($this->user_linker, 'user_role_linker.user_id = u.user_id', array('role_id'))
		                    //->where(array('user_role_linker.role_id'=>4));
		                    ->where(array('user_role_linker.role_id'=>2));
		$statement = $sql->prepareStatementForSqlObject($subselect2);
        $results = $statement->execute();
		foreach($results as $result){
		$res[$result['email']] =$result['first_name'].' '.$result['last_name'] ;
		}
		return $res;
    } 
    
    
}//end class


?>