<?php

namespace Pages\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Pages\Model\Pages;


/**
 * Page Controller class will be used for handling the Pages actions
 *
 * @pagesTable   Object of the pages table to run queries from the pagesmodel
 * @author developed by Trs Software Solutions
 */

class PageController extends AbstractActionController
{

    protected $pagesTable;
	
    
    
    /**
	 * index action is basically used for viewing the individual cms pages.
	 *
	 * @alias   alias of the page to be viewed
	 * @page    Object of the page to be viewed
     * @author  developed by Trs Software Solutions
	 * @return  Object
	 **/	 
	 public function indexAction()
     {
		$alias = $this->params()->fromRoute('alias');
		$obj = new Pages();
        $result = $this->getPagesTable()->getPageByAlias($alias);
		//print_r($result);die;
        $page =$obj->getArrayCopy($result);
     
		if($page['title']==''){
		
			$view = new ViewModel();
			$view->setTemplate('error/404');
			return $view;
		
		}
		$this->layout('layout/custom');
		return array('page' => $page);
	}	  

	/**
	 * getPagesTable method is used for getting the object of pages model from the service manager.
	 *
	 * @author developed by Trs Software Solutions
	 * @return Entity Object
	 **/
	 private function getPagesTable()
     {
        if (!$this->pagesTable) {
            $sm = $this->getServiceLocator();
            $this->pagesTable = $sm->get('Pages\Model\PagesTable');
        }
        return $this->pagesTable;
     }	
	 
	 
	

}