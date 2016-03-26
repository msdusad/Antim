<?php

namespace Shopping\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\View\Model\ViewModel;
use Zend\Form\Form;
use Shopping\Mapper\CategoryInterface;

class CategoryController extends AbstractActionController {

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
             return $this->redirect()->toRoute('admin/shopping-category');
        }

        $categories = $this->getMapper()->fetchAll($id);
        $category = $this->getMapper()->getCategory($id);

        
        return new ViewModel(array('message' => $message, 'categories' => $categories,'id'=>$id,'category'=>$category));
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
        if($id!=0){

        $categories = $this->getMapper()->fetchCategories($id);
        
        foreach ($categories as $row) {
            $options[$row['id']] = array(
                'value' => $row['id'],
                'label' => $row['title'],
            );
        }
        }
        $form->get('parent_id')->setAttributes(array('options' => $options));
        $form->get('parent_id')->setValue($id);

        $request = $this->getRequest();

        if ($request->isPost()) {

            $data = $request->getPost();

            $form->setData($data);

            if ($form->isValid()) {

                $this->getMapper()->save($data);

                $this->flashMessenger()->addMessage('Category added successfully');

                // Redirect to list of connections
                return $this->redirect()->toRoute('admin/shopping-category', array('id' => $id));
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
        
        $category = $this->getMapper()->getCategory($id);

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

        $form->get('parent_id')->setAttributes(array('options' => $options));
        
        $form->get('parent_id')->setValue($category->getParentId());
        $form->get('id')->setValue($category->getId());
        $form->get('title')->setValue($category->getTitle());

        $request = $this->getRequest();

        if ($request->isPost()) {

            $data = $request->getPost();

            $form->setData($data);

            if ($form->isValid()) {

                $this->getMapper()->save($data);

                $this->flashMessenger()->addMessage('Category saved successfully');

                // Redirect to list of connections
                return $this->redirect()->toRoute('admin/shopping-category', array('id' => $category->getParentId()));
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
            return $this->redirect()->toRoute('admin/shopping-category');
        }
        $category = $this->getMapper()->getCategory($id);
        $parentId = $category->getParentId();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getMapper()->delete($id);
            }

            // Redirect to list of find
            return $this->redirect()->toRoute('admin/shopping-category',array('id'=>$parentId));
        }

        return array(
            'id' => $id, 'category' => $category
        );
    }

    /**
     * set mapper
     *
     * @param  CategoryInterface $mapper
     * @return dbmapper
     */
    public function setMapper(CategoryInterface $mapper) {

        $this->mapper = $mapper;

        return $this;
    }

    /**
     * get mapper
     *
     * @return ShoppingInterface
     */
    public function getMapper() {
        if (!$this->mapper instanceof CategoryInterface) {

            $this->setMapper($this->getServiceLocator()->get('CategoryMapper'));
        }
        return $this->mapper;
    }

    public function getForm() {
        if (!$this->form) {
            $this->setForm($this->getServiceLocator()->get('category-form'));
        }
        return $this->form;
    }

    public function setForm(Form $form) {
        $this->form = $form;
        $this->flashMessenger()->setNamespace('category-form')->getMessages();
        return $this;
    }

}
