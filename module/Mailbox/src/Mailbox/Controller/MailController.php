<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Mailbox\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Mailbox\Form\AdminMailForm;
use Mailbox\Model\AdminMail;



class MailController extends AbstractActionController
{
    
 
    protected $adminMailTable;
   
     /**
      * *****************************************************************************************
      *                         ADMIN MAIL SECTION
      *******************************************************************************************
      **/
      
       public function indexAction()
       {
		
        
        if(!$this->zfcUserAuthentication()->hasIdentity()) return $this->redirect()->toRoute('home');
        
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        
        $form = new AdminMailForm($dbAdapter);
        
        $request =$this->getRequest();
        
        if($request->isPost()):
       
           $adminmail = new AdminMail();
           $form->setInputFilter($adminmail->getInputFilter());
           $form->setData($request->getPost());
           
           if($form->isValid()):
            
             $adminmail->exchangeArray($form->getData());
             
             $this->removeSlashes($adminmail);
              $draft =$request->getPost('draft');
             if(isset($draft)):
               $adminmail->status ='draft';
             else:
              $adminmail->status ='sent';
             endif;
             //mail process goes here to send all mails
             
             
             $adminmail->sender= 'administrator@gmail.com';
             $this->getAdminMailTable()->saveMails($adminmail);
             $this->flashMessenger()->addSuccessMessage('Email Sent successfully');
	         return $this->redirect()->toRoute('mail',array('controller' => 'mail','action' => 'index'));
             exit;
           endif;
         endif;
         
         // get All recieved Mail
        $revieve = $this->getAdminMailTable()->recieveMail();
        
        $recieveArr =array();
        $this->objToArray($revieve,$recieveArr);
      
        $page =1;
    	$perPage = 15;
    	$recievePaginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($recieveArr));
    	$recievePaginator->setCurrentPageNumber($page);
    	$recievePaginator->setItemCountPerPage($perPage);	
	
        $this->layout('layout/admin');
        return array(
            'paginator'    => $recievePaginator,
			'records_number' => $perPage,			
            'form'	=> $form
        );   
       
      }
      public function viewMailAction()
      {
        if(!$this->zfcUserAuthentication()->hasIdentity()) return $this->redirect()->toRoute('home');
        
        
        $revieve = $this->getAdminMailTable()->recieveMail();
        
        $recieveArr =array();
        $this->objToArray($revieve,$recieveArr);
        
        $page =1;
    	$perPage = 15;
    	$recievePaginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($recieveArr));
    	$recievePaginator->setCurrentPageNumber($page);
    	$recievePaginator->setItemCountPerPage($perPage);	
	
        $view = new ViewModel();
        $view->setTerminal(true)
           ->setTemplate('partial/viewmail')
           ->setVariables(array(
               'paginator' => $recievePaginator,
               'count' => $revieve->count(),
               'records_number' => $perPage,
		    ));
           
        return $view;
        
      }
      public function sentMailAction()
      {
        
        if(!$this->zfcUserAuthentication()->hasIdentity()) return $this->redirect()->toRoute('home');
        
        // get All sent Mail
        $sent = $this->getAdminMailTable()->sentMail();
        
        $sentArr =array();
        
        $this->objToArray($sent,$sentArr);
        
        $page =1;
    	$perPage = 15;
    	$sentPaginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($sentArr));
    	$sentPaginator->setCurrentPageNumber($page);
    	$sentPaginator->setItemCountPerPage($perPage);	
	
        $view = new ViewModel();
        $view->setTerminal(true)
           ->setTemplate('partial/sentmail')
           ->setVariables(array(
               'paginator' => $sentPaginator,
               'count' => $sent->count(),
               'records_number' => $perPage,
		    ));
           
        return $view;
        
      }
       public function draftMailAction()
       {
         
        
        if(!$this->zfcUserAuthentication()->hasIdentity()) return $this->redirect()->toRoute('home');
         // get All draft Mail
        $draft = $this->getAdminMailTable()->draftMail();
        
        $draftArr =array();
        $this->objToArray($draft,$draftArr);
        
        $page =1;
    	$perPage = 15;
    	$draftPaginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($draftArr));
    	$draftPaginator->setCurrentPageNumber($page);
    	$draftPaginator->setItemCountPerPage($perPage);	
	
        $view = new ViewModel();
        $view->setTerminal(true)
           ->setTemplate('partial/draftmail')
           ->setVariables(array(
               'paginator' => $draftPaginator,
               'count' => $draft->count(),
               'records_number' => $perPage,
		    ));
           
        return $view;
         
       }
       public function checkMailAction()
       {
          if(!$this->zfcUserAuthentication()->hasIdentity()) return $this->redirect()->toRoute('home');
          
          $request = $this->getRequest();
          $mail_id = $request->getPost('id');
          if (!$mail_id):
            die('Internal Error !');    
          endif;
         $this->getAdminMailTable()->updateViewMail($mail_id);
         $mailresult =$this->getAdminMailTable()->getMail($mail_id);
         //call ajax model to render this mail
        $view = new ViewModel();
        $view->setTerminal(true)
           ->setTemplate('partial/checkmail')
           ->setVariables(array(
               'mail' => $mailresult,
		    ));
           
        return $view;  
       }
       
       public function viewDraftMailAction()
       {
          if(!$this->zfcUserAuthentication()->hasIdentity()) return $this->redirect()->toRoute('home');
          
          $request = $this->getRequest();
          $mail_id = $request->getPost('id');
          if (!$mail_id):
            die('Internal Error !');    
          endif;
         
         $mailresult =$this->getAdminMailTable()->getMail($mail_id);
         
         $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
         $form = new AdminMailForm($dbAdapter);
         
        
         
         //call ajax model to render this mail
        $view = new ViewModel();
        $view->setTerminal(true)
           ->setTemplate('partial/send-draft-mail')
           ->setVariables(array(
               'mail' => $mailresult,
               'form' =>$form, 
		    ));
           
        return $view; 
       }
       
       
       public function sendDraftMailAction()
       {
          
            if(!$this->zfcUserAuthentication()->hasIdentity()) return $this->redirect()->toRoute('home');
            
            $mail_id = (int) $this->params()->fromRoute('id', 0);
            if (!$mail_id) {
                return $this->redirect()->toRoute('mail', array(
                    'action' => 'index'
                ));
            }
          
          
          $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
          $form = new AdminMailForm($dbAdapter);
        
          $request =$this->getRequest();
        
        if($request->isPost()):
       
           $adminmail = new AdminMail();
           $form->setInputFilter($adminmail->getInputFilter());
           $form->setData($request->getPost());
           
           if($form->isValid()):
            
             $adminmail->exchangeArray($form->getData());
             
             $this->removeSlashes($adminmail);
             
             //mail process goes here to send all mails
             
             $adminmail->status ='sent';
             $adminmail->sender= 'administrator@gmail.com';
             $this->getAdminMailTable()->updateMails($adminmail,$mail_id);
             $this->flashMessenger()->addSuccessMessage('Email Sent successfully');
	         return $this->redirect()->toRoute('mail',array('controller' => 'mail','action' => 'index'));
             exit;
           endif;
         endif;
       }
       
       
      public function replyAction()
      {
        if(!$this->zfcUserAuthentication()->hasIdentity()) return $this->redirect()->toRoute('home');
        
        $request = $this->getRequest();
       
         if($request->isPost()):
           
           $reciever = $request->getPost('reciever');
           $parent_id =$request->getPost('parent_id');
           $subject =$request->getPost('subject');
           $body = $request->getPost('body');
         
          //get data
          $data =array('sender'=>'admin@gmail.com','reciever'=>$reciever,'parent_id'=>$parent_id,'subject'=>$subject,'body'=>$body,'status'=>'reply');
          $this->getAdminMailTable()->saveReplyMails($data);
          
          $this->flashMessenger()->addSuccessMessage('Reply Mail sent Successfully !');
          return $this->redirect()->toRoute('mail', array('controller' => 'mail', 'action' => 'index'));
          exit; 
       
       endif; 
       
        
      }
      
      
    public function mailPaginatorAction()
    {
       
       if(!$this->zfcUserAuthentication()->hasIdentity()) return $this->redirect()->toRoute('home');
       
       $action =  (int)$this->getRequest()->getPost('action');
       $resultset = $this->getPaginatorRequest($action);
       
       $paginatorArr =array();
       $this->objToArray($resultset,$paginatorArr);
       
	   $page =  (int)$this->getRequest()->getPost('page', 0);
	   $perPage = (int)$this->getRequest()->getPost('per_page', 0);
	
	
	   $Paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($paginatorArr));
	   $Paginator->setCurrentPageNumber($page);
	   $Paginator->setItemCountPerPage($perPage);	
	
        $view = new ViewModel();
        $view->setTerminal(true)
           ->setTemplate('partial/mail-paginator')
           ->setVariables(array(
                'paginator'    => $Paginator,
                'count' => $resultset->count(),
                'records_number' => $perPage,
                'type'=>$action
		    ));
           
        return $view;  
		
    }	
	
	public function mailPaginatorLayoutAction()
    {
	
        if(!$this->zfcUserAuthentication()->hasIdentity()) return $this->redirect()->toRoute('home');
        
        $action =  (int)$this->getRequest()->getPost('action');
        $resultset = $this->getPaginatorRequest($action);
        
        $paginatorArr =array();
        $this->objToArray($resultset,$paginatorArr);
       
    	$page =  (int)$this->getRequest()->getPost('page', 0);
    	$perPage = (int)$this->getRequest()->getPost('per_page', 0);
    	
    	$Paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($paginatorArr));
    	$Paginator->setCurrentPageNumber($page);
    	$Paginator->setItemCountPerPage($perPage);	
	
        $view = new ViewModel();
        $view->setTerminal(true)
           ->setTemplate('partial/mail-paginator-layout')
           ->setVariables(array(
                'paginator'    => $Paginator,
                'count' => $resultset->count(),
                'records_number' => $perPage,
                'type'=>$action
		    ));
           
        return $view;  	
    }
     
    
    /**
      * *****************************************************************************************
      *                         FUNCTION FOR ENTITY OBJECT SECTION
      *******************************************************************************************
      **/
      

    
    /**
	 * GetadminmailTable method is used for getting the object of adminmail Table from the service manager. 
	 * 
     * @author developed by Trs Software Solutions
	 * @return  entity object
	 * */
    private function getAdminMailTable()
    {
        if (!$this->adminMailTable) {
            $sm = $this->getServiceLocator();
            $this->adminMailTable = $sm->get('Mailbox\Model\AdminMailTable');
        }

        return $this->adminMailTable;
    }
     
     /** 
      * This Function remove salshes 
      * 
      * @input it take String,Object,Array
      * @author developed by Trs Software Solutions
      * @return according to parameter it will return
      */
    public function removeSlashes($input)
    {
        if (is_array($input)) {
            $input = array_map($this->removeSlashes, $input);
        } elseif (is_object($input)) {
            $vars = get_object_vars($input);
            foreach ($vars as $k=>$v) {
                $input->{$k} = $this->removeSlashes($v);
            }
        } else {
            $input = stripslashes($input);
        }
     return $input;
    }
    
    /** 
     * Convert Object Into Array Format
     * @obj Object Parameter
     * @arr Array Parameter
     * @author developed by Trs Software Solutions
     * @return type array
     **/ 
    public function objToArray($obj, &$arr)
    {

        if(!is_object($obj) && !is_array($obj)){
            $arr = $obj;
            return $arr;
        }
        foreach ($obj as $key => $value){
            if (!empty($value)){
                $arr[$key] = array();
                $this->objToArray($value, $arr[$key]);
            }else{
                $arr[$key] = $value;
            }
        }
        return $arr;
    }
    public function getPaginatorRequest($action)
    {
        switch($action):
         
             case 'recieve':
               $resultset = $this->getAdminMailTable()->recieveMail();
               return $resultset;
               break;
             case 'sent':
               $resultset = $this->getAdminMailTable()->sentMail();
               return $resultset;
               break;
             case 'draft':
               $resultset = $this->getAdminMailTable()->draftMail();
               return $resultset;
               break;
       endswitch;
    }
}
