<?php

namespace Donation\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\View\Model\ViewModel;
use Zend\Form\Form;
use Donation\Mapper\CauseInterface;

class CauseController extends AbstractActionController {

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

        $this->layout()->setTemplate('layout/admin');

        $authService = new AuthenticationService();

        if (!$authService->hasIdentity()) {
            return $this->redirect()->toRoute('zfcuser/login');
        }
        
        $flashMessenger = $this->flashMessenger();

        if ($flashMessenger->hasMessages()) {

            $message = $flashMessenger->getMessages();
        } else {

            $message = '';
        }

        $id = (int) $this->params()->fromRoute('id', 0);
        
        $request = $this->getRequest();

        if ($request->isPost()) {

            $action = $request->getPost('action');
            $ids = implode(',',$request->getPost('ids'));

            switch($action){
                
                case 'multidelete':
                      $this->getMapper()->delete($ids);
                    break;
                default :
                    break;   
                
            }
             return $this->redirect()->toRoute('admin/donation-cause');
        }

        $causes = $this->getMapper()->fetchAll();
      
        
        return new ViewModel(array('message' => $message, 'causes' => $causes,'id'=>$id));
    }

    public function addAction() {

        $this->layout()->setTemplate('layout/admin');

        $form = $this->getForm();

        $request = $this->getRequest();

        if ($request->isPost()) {

            $data = $request->getPost();

            $form->setData($data);

            if ($form->isValid()) {

                $this->getMapper()->save($data);

                $this->flashMessenger()->addMessage('Cause added successfully');

                // Redirect to list of connections
                return $this->redirect()->toRoute('admin/donation-cause', array('id' => $id));
            } else {

                return array('form' => $form);
            }
        }

        return new ViewModel(array('form' => $form));
    }
    public function editAction() {

        $this->layout()->setTemplate('layout/admin');

        $form = $this->getForm();

        $id = (int) $this->params()->fromRoute('id', 0);
        
        $category = $this->getMapper()->fetchById($id);
       
        $form->get('id')->setValue($category->getId());
        $form->get('title')->setValue($category->getTitle());

        $request = $this->getRequest();

        if ($request->isPost()) {

            $data = $request->getPost();

            $form->setData($data);

            if ($form->isValid()) {

                $this->getMapper()->save($data);

                $this->flashMessenger()->addMessage('Cause saved successfully');

                // Redirect to list of connections
                return $this->redirect()->toRoute('admin/donation-cause');
            } else {

                return array('form' => $form, 'id' => $id);
            }
        }

        return new ViewModel(array('form' => $form, 'id' => $id));
    }
     public function deleteAction() {
        
        $this->layout()->setTemplate('layout/admin');
       
        $id = (int) $this->params()->fromRoute('id', 0);
        
        if (!$id) {
            return $this->redirect()->toRoute('admin/donation-cause');
        }
        $cause = $this->getMapper()->fetchById($id);
       
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getMapper()->delete($id);
            }

            // Redirect to list of find
            return $this->redirect()->toRoute('admin/donation-cause');
        }

        return array(
            'id' => $id, 'cause' => $cause
        );
    }

    /**
     * set mapper
     *
     * @param  CategoryInterface $mapper
     * @return dbmapper
     */
    public function setMapper(CauseInterface $mapper) {

        $this->mapper = $mapper;

        return $this;
    }

    /**
     * get mapper
     *
     * @return ShoppingInterface
     */
    public function getMapper() {
        if (!$this->mapper instanceof CauseInterface) {

            $this->setMapper($this->getServiceLocator()->get('CauseMapper'));
        }
        return $this->mapper;
    }

    public function getForm() {
        if (!$this->form) {
            $this->setForm($this->getServiceLocator()->get('cause-form'));
        }
        return $this->form;
    }

    public function setForm(Form $form) {
        $this->form = $form;
        $this->flashMessenger()->setNamespace('cause-form')->getMessages();
        return $this;
    }

}
