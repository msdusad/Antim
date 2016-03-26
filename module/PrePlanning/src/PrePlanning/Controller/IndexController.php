<?php

namespace PrePlanning\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    /**
     * @var preplanningTable
     */
    protected $preplanningTable;

    /**
     * @var formsTable
     */
    protected $formsTable;

    /**
     * @var checklistTable
     */
    protected $checklistTable;

    /**
     * @var linksTable
     */
    protected $linksTable;

    public function indexAction() {

         $auth = new AuthenticationService();

        if ($auth->hasIdentity()) {

            $userId = $auth->getIdentity();
        } else {

            $userId = 0;
           
        }  
        $categories = $this->getPrePlanningTable()->getCategories();

        $request = $this->getRequest();

        if ($request->isPost()) {

            $categoryId = $request->getPost('category_id');
        }else{
            
            foreach($categories as $key => $category){
               $categoryId = $key;
               break;
            }
        }

        $preplans = $this->getPrePlanningTable()->fetchPrePlans($categoryId);
        $forms = $this->getFormsTable()->fetchForms();
        $checklist = $this->getCheckListTable()->fetchCheckList();
     
        $resourceLinks = $this->getLinksTable()->fetchLinks($categoryId,'resource');
        $articleLinks = $this->getLinksTable()->fetchLinks($categoryId,'article');
        $toolsLinks = $this->getLinksTable()->fetchLinks($categoryId,'tools');
        
        $flashMessenger = $this->flashMessenger();

        if ($flashMessenger->hasMessages()) {

            $message = $flashMessenger->getMessages();
        } else {

            $message = '';
        }

        return new ViewModel(array(
            'paginator' => $preplans, 'categories' => $categories, 'category' => $categoryId,'forms' => $forms,'userid'=>$userId, 
            'checklist' => $checklist,'resourceLinks'=>$resourceLinks,'articleLinks'=>$articleLinks,'toolsLinks'=>$toolsLinks,'message'=>$message
        ));
    }
    public function saveAction(){
        
         $auth = new AuthenticationService();

        if ($auth->hasIdentity()) {

            $userId = $auth->getIdentity();
        } else {

            $userId = 0;
           
        }
        $request = $this->getRequest();
       
        if ($request->isPost()) {
           
            $data['user_id'] = $userId;
            $data['item_ids'] = implode(',',$request->getPost('ids'));
            $data['type'] = $request->getPost('type');
            $data['preplanning_id'] = $request->getPost('preplanning_id');
            $this->getPrePlanningTable()->saveWhishList($data);
            
            $this->flashMessenger()->addMessage(ucfirst($data['type']).' Whislist added successfully');
            echo 'sucess';exit;
        }
    }

    public function getPrePlanningTable() {
        if (!$this->preplanningTable) {
            $sm = $this->getServiceLocator();
            $this->preplanningTable = $sm->get('PrePlanning\Model\PrePlanningTable');
        }
        return $this->preplanningTable;
    }

    public function getFormsTable() {
        if (!$this->formsTable) {
            $sm = $this->getServiceLocator();
            $this->formsTable = $sm->get('PrePlanning\Model\FormsTable');
        }
        return $this->formsTable;
    }

    public function getCheckListTable() {
        if (!$this->checklistTable) {
            $sm = $this->getServiceLocator();
            $this->checklistTable = $sm->get('PrePlanning\Model\CheckListTable');
        }
        return $this->checklistTable;
    }

    public function getLinksTable() {
        if (!$this->linksTable) {
            $sm = $this->getServiceLocator();
            $this->linksTable = $sm->get('PrePlanning\Model\LinksTable');
        }
        return $this->linksTable;
    }

}
