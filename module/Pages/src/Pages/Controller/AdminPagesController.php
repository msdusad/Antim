<?php
namespace Pages\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Pages\Model\Pages;
use Pages\Form\PageForm;

class AdminPagesController extends AbstractActionController
{

	protected $pagesTable;
    /**
	  * View All Page list and edit/delete/status action Process Here
	  *
	  * @author Developed by Trs Software Solutions
	  * @return array
	  **/
	  public function indexAction()
      {
      
        $page=0;
        $itemsPerPage=15;
        $pages = $this->getPagesTable()->getPagesLimit($itemsPerPage,$page);
        $totalPages = $this->getPagesTable()->countPages();
        
        $Paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\Null($totalPages['total']));
	    $Paginator->setCurrentPageNumber($page);
	    $Paginator->setItemCountPerPage($itemsPerPage);
        
        $this->layout('layout/admin');
        return array('pages'=>$pages,'paginator'=>$Paginator,'records_number'=>$totalPages['total']);
      }
	 
	/**
	  * Create New Page action call
	  *
	  * @form $form  Page form Object
	  * @pages ORM Class Object
	  * @author Developed by Trs Software Solutions
	  * @return object
	  **/
	 public function addAction()
     {
        if(!$this->zfcUserAuthentication()->hasIdentity())return $this->redirect()->toRoute('home'); 
        
        $user_id = $this->zfcUserAuthentication()->getIdentity()->getId();
        
        $form = new PageForm();
        
        $request = $this->getRequest();
        
        if($request->isPost())
        {
            $pages = new Pages();
            $form->setInputFilter($pages->getInputFilter());
            $form->setData($request->getPost());
            if($form->isValid())
            {
                $pages->exchangeArray($form->getData());
                
                $this->removeSlashes($pages);//remove slashes of Contents

                $validateAlias =$this->getPagesTable()->checkAlias($pages->title);
                
				if(!empty($validateAlias)){
                    $alias = $this->buildUrl($pages->title).count($validateAlias);
				}else{
				    $alias = $this->buildUrl($pages->title);
				}
                
                $pages->alias = $alias;
                $pages->user_id = $user_id;
                
                $this->getPagesTable()->savePage($pages);
                //$this->flashMessenger()->addSuccessMessage('Page added Successfully');
                return $this->redirect()->toRoute('admin-pages', array('controller' => 'admin-pages', 'action' => 'index'));
               
            }
        }
		$this->layout('layout/admin');
        return array('form'=>$form);
     }
	 public function pagePaginatorAction()
     {
        
        
        $page =  (int)$this->getRequest()->getPost('page',0);
        $itemsPerPage = (int)$this->getRequest()->getPost('per_page',10);
        if(empty($page)){
            $page =0;
        }else{
            
            $page = ($page-1)*$itemsPerPage;
        }
	    
        $pages = $this->getPagesTable()->getPagesLimit($itemsPerPage,$page);
       
        $view = new ViewModel();
        $view->setTerminal(true)
           ->setTemplate('partial/page-paginator')
           ->setVariables(array(
                'pages'          => $pages,
		    ));  
        return $view; 
     }
     public function pagePaginatorLayoutAction()
     {
        $page =  (int)$this->getRequest()->getPost('page',0);
        $itemsPerPage = (int)$this->getRequest()->getPost('per_page',10);
        if(empty($page)){
            $page =0;
        }else{
            $page = ($page-1)*$itemsPerPage;
        }
	    

        $totalPages = $this->getPagesTable()->countPages();
        
        $Paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\Null($totalPages['total']));
	    $Paginator->setCurrentPageNumber($page);
	    $Paginator->setItemCountPerPage($itemsPerPage);
        
        
        $view = new ViewModel();
        $view->setTerminal(true)
           ->setTemplate('partial/page-paginator-layout')
           ->setVariables(array(
                'paginator'      => $Paginator,
                'records_number' => $totalPages['total'],
		    ));  
        return $view;  
     }
     
	/**
	  * Edit  Page action call
	  *
	  * @form $form  Page form Object
	  * @pages ORM Class Object
	  * @author Developed by Trs Software Solutions
	  * @return object
	  **/
	 public function editAction()
     {
        $form = new PageForm();
		$id = (int)$this->params('id');
        
        $request = $this->getRequest();
        
        if($request->isPost())
        {
            $pages = new Pages();
            $form->setInputFilter($pages->getInputFilter());
            $form->setData($request->getPost());
            if($form->isValid())
            {
                $pages->exchangeArray($form->getData());

                $this->removeSlashes($pages);
				$title = $pages->title;
				$result =$this->getPagesTable()->checkAlias($title);
				
				if(count($result)>0){
					if($title !=$result->title)
					{
						$count = count($result);
						$alias = $this->buildUrl($title).$count;
					
					}else{
					
						$alias = $this->buildUrl($title);
					}
					
				}
			
                $pages->alias = $alias;
                $pages->user_id = 1;
               
				$this->getPagesTable()->updatePage($pages,$id);
               // $this->flashMessenger()->addSuccessMessage('Page updated Successfully');
                return $this->redirect()->toRoute('admin-pages', array('controller' => 'admin-pages', 'action' => 'index'));
            }
        }
        $page =$this->getPagesTable()->getPageById($id);
        
		$this->layout('layout/admin');
        return array('form'=>$form,'page'=>$page);
     }
	 
	/**
	  * Delete Single Page from application Action Call
	  *
	  * @param $id page id
	  * @author Developed by Trs Software Solutions
	  * @return void
	  **/
	 public function deleteAction()
	 {
		$id = (int) $this->params()->fromRoute('id',0);
	 
        if (!$id) {
            return $this->redirect()->toRoute('admin-pages', array(
                'action' => 'index'
            ));
        } 
        
        try {
             $this->getPagesTable()->deletePage($id);
             $this->flashMessenger()->addSuccessMessage('Page Deleted Successfully');
             return $this->redirect()->toRoute('admin-pages', array(
                'action' => 'index'
             ));
            
        }
        catch (\Exception $ex) {
             return $this->redirect()->toRoute('admin-pages', array(
                'action' => 'index'
            ));
        }
	 }
     
     public function previewAction()
     {
         $id = (int) $this->params()->fromRoute('id',0);
         if (!$id) {
            return $this->redirect()->toRoute('admin-pages', array(
                'action' => 'index'
            ));
        } 
		
		$result = $this->getPagesTable()->getPageById($id);
	    
        $view = new ViewModel();
        $view->setTerminal(true)
             ->setTemplate('partial/preview-page')
             ->setVariables(array(
                'result'    => $result,
		    ));  
            
        return $view; 
     }
     public function statusAction()
	 {
	    $id = (int) $this->params()->fromRoute('id',0);
	 
        if (!$id) {
            return $this->redirect()->toRoute('admin-pages', array(
                'action' => 'index'
            ));
        } 
        
        try {
            $state = $this->getPagesTable()->getPageById($id);
			
            $status =($state->status==1)? 0: 1;
            $this->getPagesTable()->updateStatus($status,$id);
            echo 'success';
            exit;     
        }
        catch (\Exception $ex) {
             return $this->redirect()->toRoute('admin-pages', array(
                'action' => 'index'
            ));
        }
	 }
    /**
     * Get Seo Friendly Url 
     * 
     * @String As A String content convert into url like alias
     * @return get String
     **/
    private function buildUrl($string)
    {
			$string = str_replace(array('[\', \']'), '', $string);
			$string = preg_replace('/\[.*\]/U', '', $string);
			$string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
			$string = htmlentities($string, ENT_COMPAT, 'utf-8');
			$string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
			$string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
            return strtolower(trim($string, '-'));
    }
    
    
    /**
     * Get Role Table object through service manager to perform CURD Operations
     * 
     * @author developed by Trs Software Solutions
     * @return get Instance of RoleTable Model
     **/
    private function getPagesTable()
    {
        if (!$this->pagesTable) {
            $sm = $this->getServiceLocator();
            $this->pagesTable = $sm->get('Pages\Model\PagesTable');
        }

        return $this->pagesTable;
    }
    
     /** 
      * This Function remove salshes 
      * 
      * @input it take String,Object,Array
      * @author developed by Trs Software Solutions
      * @return according to parameter it will return
      */
    private function removeSlashes($input)
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

}