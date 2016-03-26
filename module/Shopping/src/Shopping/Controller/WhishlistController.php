<?php

namespace Shopping\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\View\Model\ViewModel;
use Zend\Form\Form;
use Shopping\Mapper\WhishlistInterface;
use Zend\Stdlib\Parameters;

class WhishlistController extends AbstractActionController {

    /**
     * @var Mapper
     */
    protected $mapper;

    /**
     * @var Form
     */
    protected $form;

    /**
     * display page
     */
    public function indexAction() {


        $auth = new AuthenticationService();
        if ($auth->hasIdentity()) {

            $userId = $auth->getIdentity();
        } else {

            $userId = 0;
            return $this->redirect()->toRoute('zfcuser/login');
        }
        $data = array();
        $request = $this->getRequest();

        if ($request->isPost()) {

            $action = $request->getPost('action');
            
            if ($request->getPost('ids') != '') {
                $ids = implode(',', $request->getPost('ids'));
                $type = "shopping";
            } else if ($request->getPost('check_ids') != '') {
                $ids = implode(',', $request->getPost('check_ids'));
                $type = "checklist";
            } else if ($request->getPost('form_ids') != '') {
                $ids = implode(',', $request->getPost('form_ids'));
                $type = "forms";
            }
            $data['ids'] = $ids;
            $data['user_id'] = $userId;

            switch ($action) {
                case 'multidelete':
                    if ($type == 'shopping') {
                        $this->getMapper()->delete($data);
                    } else {
                        $this->getMapper()->deletePrePlan($data,$type);
                    }
                    $this->flashMessenger()->addMessage('Whishlist deleted successfully');
                    return $this->redirect()->toRoute('whish-list');
                    break;

                default :
                    break;
            }
        }

        $flashMessenger = $this->flashMessenger();

        if ($flashMessenger->hasMessages()) {

            $message = $flashMessenger->getMessages();
        } else {

            $message = '';
        }

        $itemIds = $this->getMapper()->getList($userId);
        $formIds = $this->getMapper()->getPrePlanningList($userId, 'forms');
        $checklistIds = $this->getMapper()->getPrePlanningList($userId, 'checklist');

        $whishlist = array();
        $formList = array();
        $checkList = array();

        if ($itemIds) {
            if($itemIds->item_ids!=''){
            $whishlist = $this->getMapper()->fetchAll($itemIds->item_ids);
            }
        }
      
        if ($formIds) {
            if($formIds->item_ids!=''){
             $formList = $this->getMapper()->fetchPrePlanning($formIds->item_ids, 'forms');
            }
        }

        if ($checklistIds) {
           if($checklistIds->item_ids!=''){
              $checkList = $this->getMapper()->fetchPrePlanning($checklistIds->item_ids, 'checklist');
               
           }
        }

        return new ViewModel(array('message' => $message, 'whishlist' => $whishlist, 'userid' => $userId, 'checkList' => $checkList, 'formList' => $formList));
    }

    public function addAction() {

        $id = (int) $this->params()->fromRoute('id', 0);
        $auth = new AuthenticationService();

        if ($auth->hasIdentity()) {

            $userId = $auth->getIdentity();
        } else {

            $userId = 0;
        }
        $data = array();

        $data['item_ids'] = $id;
        $data['user_id'] = $userId;

        $this->getMapper()->save($data);

        $this->flashMessenger()->addMessage('Whishlist added successfully');

        // Redirect to list of connections
        return $this->redirect()->toRoute('shopping');
    }

    public function shareAction() {


        $request = $this->getRequest();

        if ($request->isPost()) {

            $ids = implode(',', $request->getPost('ids'));

            $itemList = $this->getMapper()->getItems($ids);
        }
        echo $itemList;
        exit;
    }

    /**
     * set mapper
     *
     * @param  CategoryInterface $mapper
     * @return dbmapper
     */
    public function setMapper(WhishlistInterface $mapper) {

        $this->mapper = $mapper;

        return $this;
    }

    /**
     * get mapper
     *
     * @return ShoppingInterface
     */
    public function getMapper() {
        if (!$this->mapper instanceof WhishlistInterface) {

            $this->setMapper($this->getServiceLocator()->get('WhishlistMapper'));
        }
        return $this->mapper;
    }

}
