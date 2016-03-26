<?php

namespace Shopping\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\View\Model\ViewModel;
use Zend\Form\Form;
use Shopping\Mapper\ItemInterface;


class ItemController extends AbstractActionController {

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
        
        $categoryId = 0;

        if ($request->isPost()) {

            $action = $request->getPost('action');
            $categoryId = $request->getPost('category_id');
           

            switch($action){
                
                case 'multidelete':
                      $ids = implode(',',$request->getPost('ids'));
                      $this->getMapper()->delete($ids);
                      return $this->redirect()->toRoute('admin/shopping-item');
                    break;
                default :
                    break;   
                
            }
            
        }

        $items = $this->getMapper()->fetchAll($categoryId);
        $categories = $this->getMapper()->fetchCategories();
        
        return new ViewModel(array('message' => $message, 'items' => $items,'id'=>$id,'categories'=>$categories,'category'=>$categoryId));
    }

    public function addAction() {

        $this->layout()->setTemplate('layout/admin');

        $form = $this->getForm();

        $id = (int) $this->params()->fromRoute('id', 0);
        $options = array();
        // set the first option
        $options[0] = array(
            'value' => '0',
            'label' => 'Root Category'            
        );
        
        $categories = $this->getMapper()->fetchCategories($id);
        
        foreach ($categories as $row) {
            $options[$row['id']] = array(
                'value' => $row['id'],
                'label' => $row['title'],
            );
        }
       
        $form->get('category_id')->setAttributes(array('options' => $options));
        $form->get('category_id')->setValue($id);

        $request = $this->getRequest();

        if ($request->isPost()) {

            $data = $request->getPost();

            $form->setData($data);

            if ($form->isValid()) {

                $this->getMapper()->save($data);

                $this->flashMessenger()->addMessage('Items added successfully');

                // Redirect to list of connections
                return $this->redirect()->toRoute('admin/shopping-item', array('id' => $id));
            } else {

                return array('form' => $form, 'id' => $id);
            }
        }

        return new ViewModel(array('form' => $form, 'id' => $id));
    }
    public function editAction() {

        $this->layout()->setTemplate('layout/admin');

        $form = $this->getForm();

        $id = (int) $this->params()->fromRoute('id', 0);
        
        $item = $this->getMapper()->getItem($id);

        $categories = $this->getMapper()->fetchCategories();
        $options = array();
        // set the first option
        $options[0] = array(
            'value' => '0',
            'label' => 'Root Category',
            'selected' => TRUE
        );

        foreach ($categories as $row) {
            $options[$row['id']] = array(
                'value' => $row['id'],
                'label' => $row['title'],
            );
        }

        $form->get('category_id')->setAttributes(array('options' => $options));
        
        $form->get('category_id')->setValue($item->getCategoryId());
        $form->get('id')->setValue($item->getId());
        $form->get('title')->setValue($item->getTitle());
        $form->get('description')->setValue($item->getDescription());
        $form->get('address')->setValue($item->getAddress());
        $form->get('price')->setValue($item->getPrice());
        $form->get('url')->setValue($item->getUrl());
        $form->get('submit')->setValue('Save');
        
        $request = $this->getRequest();

        if ($request->isPost()) {

            $data = $request->getPost();

            $form->setData($data);

            if ($form->isValid()) {

                $this->getMapper()->save($data);

                $this->flashMessenger()->addMessage('Item saved successfully');
                // Redirect to list of connections
                return $this->redirect()->toRoute('admin/shopping-item');
                
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
            return $this->redirect()->toRoute('admin/shopping-item');
        }
        $item = $this->getMapper()->getItem($id);       
       
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getMapper()->delete($id);
            }

            // Redirect to list of find
            return $this->redirect()->toRoute('admin/shopping-item');
        }

        return array(
            'id' => $id, 'item' => $item
        );
    }

    /**
     * set mapper
     *
     * @param  CategoryInterface $mapper
     * @return dbmapper
     */
    public function setMapper(ItemInterface $mapper) {

        $this->mapper = $mapper;

        return $this;
    }

    /**
     * get mapper
     *
     * @return ShoppingInterface
     */
    public function getMapper() {
        if (!$this->mapper instanceof ItemInterface) {

            $this->setMapper($this->getServiceLocator()->get('ItemMapper'));
        }
        return $this->mapper;
    }

    public function getForm() {
        if (!$this->form) {
            $this->setForm($this->getServiceLocator()->get('item-form'));
        }
        return $this->form;
    }

    public function setForm(Form $form) {
        $this->form = $form;
        $this->flashMessenger()->setNamespace('item-form')->getMessages();
        return $this;
    }
    
    

}
