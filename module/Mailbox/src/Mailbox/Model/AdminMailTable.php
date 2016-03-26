<?php

namespace Mailbox\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Crypt\Password\Bcrypt;
use Zend\Db\Sql\Where;

class AdminMailTable extends AbstractTableGateway
{
    protected $table = 'mailbox';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new AdminMail());
        $this->initialize();
        
    }
	
	public function check()
	{
		$sql = "select * FROM user_role_linker";
		$statement = $this->adapter->query($sql); 
		return $statement->execute(); 
	}
    
	public function saveMails($mail)
    {
       $data = array(
                'sender'      => $mail->sender,
                'reciever'    => implode(',',$mail->reciever),
                'subject'     => $mail->subject,
                'body'        => $mail->body,
                'status'      => $mail->status,
                'view'        => 0,
        );
       $res=  $this->insert($data);
        return $res;  
    }
	
    public function updateMails($mail,$mail_id)
    {
       $data = array(
                'sender'      => $mail->sender,
                'reciever'    => implode(',',$mail->reciever),
                'subject'     => $mail->subject,
                'body'        => $mail->body,
                'status'      => $mail->status,
                'view'        => 0,
       );
       
       $res=  $this->update($data,array('admin_email_id'=>$mail_id));
       return $res;  
    }
    
    
    
    //get All sent Email
    
    public function sentMail()
    {
        return $this->select(array('status'=>'sent','deleted'=>0));
    }
    
    //get All recieved mail
    public function recieveMail()
    {
        return $this->select(array('status'=>'recieve','deleted'=>0));
    }
    
    //get all draft mail
    public function draftMail()
    {
        return $this->select(array('status'=>'draft','deleted'=>0)); 
    }
    
     //get all draft mail
    public function getMail($mail_id)
    {
        $resultset = $this->select(array('deleted'=>0,'admin_email_id'=>$mail_id)); 
        return $resultset->current();
    }
    
    //view mail update here
    public function updateViewMail($mail_id)
    {
      $res = $this->update(array('view'=>1),array('admin_email_id'=>$mail_id));
      return $res;
    }
    
    
    public function saveReplyMails($data)
    {
        $res=  $this->insert($data);
        return $res;  
    }
    
    public function unreadMail()
    {
        $res =$this->select(array('deleted'=>0,'status'=>'recieve','view'=>0));
        return $res->count();
    }
    
    
    
    
	
	public function getAssoc($user_id,$field)
    {
	
		if(count($field)==0)return ;
		
            $sql = new Sql($this->adapter);
            $select = $sql->select();
            $select->columns($field);
            $select->from($this->table);
            $select->where(array('user.user_id' => $user_id,'user.deleted'=>0));

            $statement = $sql->prepareStatementForSqlObject($select);
            $results = $statement->execute()->current();
            return $results;
	}	
    
   
    
    

    
}
