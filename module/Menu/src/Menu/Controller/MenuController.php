<?php
namespace Menu\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Menu\Form\MenuForm;
use Menu\Model\Menu;
  
/**
 * *****************************************************************************************
 * 									Menu Controller
 ******************************************************************************************* 
 **/
     
class MenuController extends AbstractActionController
{
   protected $menuTable;
 
      /**
	  * Create New Menu Dynamic action call
	  *
	  * @form   $form   MenuForm Object
	  * @Menu   ORM Class Object
	  * @author Developed by Trs Software Solutions
	  * @return object
	  **/
	 public function indexAction()
     {
        
		//$che = $this->getMenuTable()->check();
			
		//$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\AdapterInterface');
		$adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
		$this->layout('layout/admin');
        $form = new MenuForm($adapter);
		
        $updateform = new MenuForm($adapter);
        
        $request = $this->getRequest();
        
        if($request->isPost())
        {
            $menu = new Menu();
            $form->setInputFilter($menu->getInputFilter());
            $form->setData($request->getPost());
            if($form->isValid())
            {
                $menu->exchangeArray($form->getData());
                $menu->route ='page';
                $menu->action='index';
               
                $this->removeSlashes($menu);//remove slashes of plan
                
                $status = $this->getMenuTable()->saveMenu($menu);
                if($status):
                    //$this->flashMessenger()->addSuccessMessage('Menu  added Successfully');
                else:
                    //$this->flashMessenger()->addErrorMessage('While Adding Menu data occur error !');
                endif;
                return $this->redirect()->toRoute('menu', array('controller' => 'menu', 'action' => 'index'));
            }
        }
        
        $menu = $this->getMenuTable()->fetchAll(); 
        
        return array('form'=>$form,'menu'=>$menu,'updateForm'=>$updateform);
     }
    
    
	/**
	  * Update existing Menu elements action call
	  *
	  * @param $menu_id  Menu id
	  * @Menu ORM Class Object
	  * @author Developed by Trs Software Solutions
	  * @return void
	  **/
	public function updateMenuAction()
    {
        $menu_id = (int) $this->params('id');
        
        if(empty($menu_id) || !is_int($menu_id) ):
          return $this->redirect()->toRoute('menu', array('controller' => 'menu', 'action' => 'index'));
        endif;
        
        $adapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $form = new MenuForm($adapter);
        $request = $this->getRequest();
        if($request->isPost())
        {
            $menu = new Menu();
            $form->setInputfilter($menu->getInputFilter());
            $form->setData($request->getPost());
            
            if($form->isValid())
            {
                $menu->exchangeArray($form->getData());
                $menu->route ='page';
                $menu->action='index';
                $this->removeSlashes($menu);
                $status = $this->getMenuTable()->updateMenu($menu,$menu_id);
                if($status):
                    //$this->flashMessenger()->addSuccessMessage('Menu Updated Successfully');
                else:
                    //$this->flashMessenger()->addErrorMessage('While Updating Menu data occur error !');
                endif;
                return $this->redirect()->toRoute('menu', array('controller' => 'menu', 'action' => 'index'));
                
            }
        }
    }
    
    /**
	  * Delete Menu action call
	  *
	  * @param $menu_id  Manu id
	  * @author Developed by Trs Software Solutions
	  * @return void
	  **/
	public function deleteMenuAction()
    {
        
        
        $id = (int) $this->params()->fromRoute('id', 0);
        
        if (!$id &&!is_int($id)) {
            return $this->redirect()->toRoute('menu', array(
                'action' => 'index'
            ));
        }
        
        try {
            $this->getMenuTable()->deleteMenu($id); 
            //$this->flashMessenger()->addSuccessMessage('Menu deleted successfully');
	        
            return $this->redirect()->toRoute('menu',array('controller' => 'menu','action' => 'index'));
            exit;
        }
        catch (\Exception $ex) {
             return $this->redirect()->toRoute('menu', array(
                'action' => 'index'
            ));
        }
         
    }
     
     /**
	  * Change Menu status like active /inactive action call
	  *
	  * @param $menu_id  Menu id
	  * @author Developed by Trs Software Solutions
	  * @return true/false
	  **/
	 public function statusAction()
     {
        $menu_id = (int) $this->params()->fromRoute('id', 0);
        
        if (!$menu_id) {
            return $this->redirect()->toRoute('administrator', array(
                'action' => 'menu'
            ));
        }
        
        try {
            $state =$this->getMenuTable()->getMenu($menu_id);
           
            $status =($state->status==1)? 0: 1;
            $this->getMenuTable()->updateStatus($status,$menu_id);
            return true;    
        }
        catch (\Exception $ex) {
             return $this->redirect()->toRoute('administrator', array(
                'action' => 'menu'
            ));
        }
      
     }
     
     /**
      * Change changeOrderAction  Status like 1,2,3 action process here
      * @author pawan kumar
      * @return void
      **/
     public function changeOrderAction()
     {
        $id = (int) $this->params()->fromRoute('id', 0);
        
        if (!$id) {
            return $this->redirect()->toRoute('menu', array(
                'action' => 'menu'
            ));
        }
        $order = $this->getRequest()->getPost('order');
        try {
            $this->getMenuTable()->changeOrder($order,$id);
            echo 'success';
          exit;     
        }
        catch (\Exception $ex) {
             return $this->redirect()->toRoute('menu', array(
                'action' => 'index'
            ));
        }
      
     }
     
     
     /**
	 * getMenuTable method is used for getting the object of menu Table from the service manager. 
	 *
	 * @author developed by Trs Software Solutions
	 * @return entity Object
	 */
    private function getMenuTable()
    {
        if (!$this->menuTable) {
            $sm = $this->getServiceLocator();
            $this->menuTable = $sm->get('Menu\Model\MenuTable');
        }
        return $this->menuTable;
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