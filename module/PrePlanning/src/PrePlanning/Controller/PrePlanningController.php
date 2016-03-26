<?php

namespace PrePlanning\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use PrePlanning\Model\PrePlanning;
use PrePlanning\Model\Forms;
use PrePlanning\Model\CheckList;
use PrePlanning\Form\PrePlanning as PrePlanningForm;
use PrePlanning\Form\Upload;
use PrePlanning\Form\CheckListForm;
use Zend\Validator\File\Size;
use Zend\Validator\File\Extension;

class PrePlanningController extends AbstractActionController {

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

    public function indexAction() {

        $this->layout()->setTemplate('layout/admin');

        $categories = $this->getPrePlanningTable()->getCategories();

        $request = $this->getRequest();

        if ($request->isPost()) {

            $action = $request->getPost('action');

            $categoryId = $request->getPost('category_id');

            if ($categoryId != '') {

                //$this->layout('layout/admin');
                // grab the paginator from the AlbumTable
                $paginator = $this->getPrePlanningTable()->fetchAll(true, $categoryId);
                // set the current page to what has been passed in query string, or to 1 if none set
                $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
                // set the number of items per page to 10
                $paginator->setItemCountPerPage();

                return new ViewModel(array(
                    'paginator' => $paginator, 'categories' => $categories, 'category' => $categoryId
                ));
            }

            $ids = $request->getPost('ids');

            switch ($action) {

                case 'multidelete':
                    $paginator = $this->getPrePlanningTable()->multiDelete($ids);
                    return $this->redirect()->toRoute('admin/pre-planning');
                    break;
                default :
                    break;
            }
            //
        }

        //$this->layout('layout/admin');
        // grab the paginator from the AlbumTable
        $paginator = $this->getPrePlanningTable()->fetchAll(true);
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        // set the number of items per page to 10
        $paginator->setItemCountPerPage();

        return new ViewModel(array(
            'paginator' => $paginator, 'categories' => $categories, 'category' => 0
        ));
    }

    public function addAction() {

        $this->layout()->setTemplate('layout/admin');
        $form = new PrePlanningForm();
        $form->get('submit')->setValue('Add');

        $category = (int) $this->params()->fromRoute('category', 0);

        $categories = $this->getPrePlanningTable()->getCategories();

        $form->get('category_id')->setAttributes(array('options' => $categories));

        $form->get('category_id')->setValue($category);

        $request = $this->getRequest();

        if ($request->isPost()) {
            $find = new PrePlanning();

            $form->setInputFilter($find->getInputFilter());

            $data = $request->getPost();

            $form->setData($data);

            if ($form->isValid()) {


                $find->exchangeArray($form->getData());

                $this->getPrePlanningTable()->saveList($find);

                return $this->redirect()->toRoute('admin/pre-planning');
            }
        }
        return array('form' => $form, 'category' => $category);
    }

    public function editAction() {

        $this->layout()->setTemplate('layout/admin');

        $id = (int) $this->params()->fromRoute('id', 0);
        
        if (!$id) {
            return $this->redirect()->toRoute('admin/pre-planning', array(
                        'action' => 'add'
            ));
        }
        $find = $this->getPrePlanningTable()->getListById($id);
        $class = new PrePlanning();
        $form = new PrePlanningForm();
        $form->bind($find);
        $form->get('submit')->setAttribute('value', 'Edit');

        $category = (int) $this->params()->fromRoute('category', 0);

        $categories = $this->getPrePlanningTable()->getCategories();

        $form->get('category_id')->setAttributes(array('options' => $categories));

        $form->get('category_id')->setValue($category);

        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setInputFilter($class->getInputFilter());

            $data = $request->getPost();

            $form->setData($data);

            if ($form->isValid()) {

                $class->exchangeArray($data);

                $this->getPrePlanningTable()->saveList($class);
            }
            return $this->redirect()->toRoute('admin/pre-planning');
        }

        return array(
            'find' => $find,
            'form' => $form, 'category' => $category
        );
    }

    public function deleteAction() {
        $this->layout()->setTemplate('layout/admin');
        $id = (int) $this->params()->fromRoute('id', 0);
         $category = (int) $this->params()->fromRoute('category', 0);

        if (!$id) {
            return $this->redirect()->toRoute('admin/pre-planning');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getPrePlanningTable()->deleteList($id);
            }

            // Redirect to list of find
            return $this->redirect()->toRoute('admin/pre-planning',array('category'=>$category));
        }

        return array(
            'id' => $id, 'find' => $this->getPrePlanningTable()->getListById($id),'category'=>$category
        );
    }

    public function formsAction() {

        $this->layout()->setTemplate('layout/admin');

        $id = (int) $this->params()->fromRoute('id', 0);
        $category = (int) $this->params()->fromRoute('category', 0);

        $item = $this->getPrePlanningTable()->getListById($id);

        $request = $this->getRequest();

        if ($request->isPost()) {

            $action = $request->getPost('action');

            $ids = $request->getPost('ids');

            switch ($action) {

                case 'multidelete':
                    $paginator = $this->getFormsTable()->multiDelete($ids);
                    return $this->redirect()->toRoute('admin/pre-planning', array('action' => 'forms', 'id' => $id));
                    break;
                default :
                    break;
            }
            //
        }

        //$this->layout('layout/admin');
        // grab the paginator from the AlbumTable
        $paginator = $this->getFormsTable()->fetchAll(true, $id);
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        // set the number of items per page to 10
        $paginator->setItemCountPerPage();

        return new ViewModel(array(
            'paginator' => $paginator, 'id' => $id, 'item' => $item, 'category' => $category
        ));
    }

    public function addformsAction() {

        $this->layout()->setTemplate('layout/admin');

        $id = (int) $this->params()->fromRoute('id', 0);
        $category = (int) $this->params()->fromRoute('category', 0);

        $item = $this->getPrePlanningTable()->getListById($id);

        $form = new Upload();

        $form->get('submit')->setValue('Add');
        $form->get('preplanning_id')->setValue($id);

        $request = $this->getRequest();

        if ($request->isPost()) {

            $class = new Forms();

            $form->setInputFilter($class->getInputFilter());

            $nonFile = $request->getPost()->toArray();

            $File = $this->params()->fromFiles('url');
            $data = array_merge(
                    $nonFile, //POST 
                    array('url' => $File['name']) //FILE...
            );

            $form->setData($data);

            if ($form->isValid()) {


                $validator = new Extension('docx,pdf,xlsx,xls,doc');

                $size = new Size(array('min' => '1kB', 'max' => '10MB')); //minimum bytes filesize

                $adapter = new \Zend\File\Transfer\Adapter\Http();
                $adapter->setValidators(array($size, $validator), $File['name']);
                if (!$adapter->isValid()) {
                    $dataError = $adapter->getMessages();
                    $error = array();
                    foreach ($dataError as $key => $row) {
                        $error[] = $row;
                    }
                    $form->setMessages(array('fileupload' => $error));

                    $class->exchangeArray($form->getData());

                    return array('form' => $form, 'id' => $id, 'message' => $error, 'item' => $item, 'category' => $category);
                } else {
                    $dirName = dirname(__DIR__) . '/../../assets/forms';
                    $adapter->setDestination($dirName);
                    if ($adapter->receive($File['name'])) {

                        $class->exchangeArray($form->getData());

                        $this->getFormsTable()->save($class);
                    }
                }
                return $this->redirect()->toRoute('admin/pre-planning', array('action' => 'forms', 'category' => $category, 'id' => $id));
            }
        }
        return array('form' => $form, 'id' => $id, 'item' => $item, 'category' => $category);
    }

    public function editformAction() {

        $this->layout()->setTemplate('layout/admin');

        $id = (int) $this->params()->fromRoute('id', 0);
        $category = (int) $this->params()->fromRoute('category', 0);

        if (!$id) {
            return $this->redirect()->toRoute('admin/pre-planning', array(
                        'action' => 'addforms'
            ));
        }
        $item = $this->getFormsTable()->getItem($id);
        $class = new Forms();
        $form = new Upload();
        $form->bind($item);

        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();

        if ($request->isPost()) {

            $dirName = dirname(__DIR__) . '/../../assets/forms';
            $form->setInputFilter($class->getInputFilter());

            $nonFile = $request->getPost()->toArray();
            $File = $this->params()->fromFiles('url');
            $data = array_merge(
                    $nonFile, //POST 
                    array('url' => $File['name']) //FILE...
            );

            $form->setData($data);



            if ($form->isValid()) {

                if (file_exists($dirName . '/' . $item->url)) {

                    unlink($dirName . '/' . $item->url);
                }

                $validator = new Extension('docx,pdf,xlsx,xls,doc');

                $size = new Size(array('min' => '1kB', 'max' => '10MB'));

                $adapter = new \Zend\File\Transfer\Adapter\Http();
                $adapter->setValidators(array($size, $validator), $File['name']);
                if (!$adapter->isValid()) {
                    $dataError = $adapter->getMessages();
                    $error = array();
                    foreach ($dataError as $key => $row) {
                        $error[] = $row;
                    }
                    $form->setMessages(array('fileupload' => $error));
                    return array('form' => $form, 'id' => $id, 'message' => $error, 'item' => $item, 'category' => $category);
                } else {


                    $adapter->setDestination($dirName);
                    if ($adapter->receive($File['name'])) {

                        $class->exchangeArray($data);

                        $this->getFormsTable()->save($class);
                    }
                }
                return $this->redirect()->toRoute('admin/pre-planning', array('action' => 'forms', 'category' => $category, 'id' => $item->preplanning_id));
            }

            if ($File['name'] == '') {

                $data['url'] = $item->url;
                $class->exchangeArray($data);
                $this->getFormsTable()->save($class);
                return $this->redirect()->toRoute('admin/pre-planning', array('action' => 'forms', 'category' => $category, 'id' => $item->preplanning_id));
            }
        }

        return array(
            'item' => $item,
            'form' => $form, 'category' => $category
        );
    }

    public function deleteformAction() {
        $this->layout()->setTemplate('layout/admin');
        $id = (int) $this->params()->fromRoute('id', 0);
        $category = (int) $this->params()->fromRoute('category', 0);
        if (!$id) {
            return $this->redirect()->toRoute('admin/pre-planning');
        }

        $item = $this->getFormsTable()->getItem($id);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getFormsTable()->delete($id);
            }

            // Redirect to list of find
            return $this->redirect()->toRoute('admin/pre-planning', array('action' => 'forms', 'category' => $category, 'id' => $item->preplanning_id));
        }

        return array(
            'id' => $id,
            'find' => $item, 'category' => $category
        );
    }

    public function checklistAction() {

        $this->layout()->setTemplate('layout/admin');

        $id = (int) $this->params()->fromRoute('id', 0);
        $category = (int) $this->params()->fromRoute('category', 0);

        $item = $this->getPrePlanningTable()->getListById($id);

        $request = $this->getRequest();

        if ($request->isPost()) {

            $action = $request->getPost('action');

            $ids = $request->getPost('ids');

            switch ($action) {

                case 'multidelete':
                    $paginator = $this->getCheckListTable()->multiDelete($ids);
                    return $this->redirect()->toRoute('admin/pre-planning', array('action' => 'checklist', 'id' => $id,'category' =>$category));
                    break;
                default :
                    break;
            }
            //
        }

        //$this->layout('layout/admin');
        // grab the paginator from the AlbumTable
        $paginator = $this->getCheckListTable()->fetchAll(true);
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        // set the number of items per page to 10
        $paginator->setItemCountPerPage();

        return new ViewModel(array(
            'paginator' => $paginator, 'id' => $id, 'item' => $item,'category' =>$category
        ));
    }
    public function addchecklistAction() {

        $this->layout()->setTemplate('layout/admin');

        $id = (int) $this->params()->fromRoute('id', 0);
        $category = (int) $this->params()->fromRoute('category', 0);

        $item = $this->getPrePlanningTable()->getListById($id);

        $form = new CheckListForm();

        $form->get('submit')->setValue('Add');
        $form->get('preplanning_id')->setValue($id);

        $request = $this->getRequest();

        if ($request->isPost()) {

            $class = new CheckList();

            $form->setInputFilter($class->getInputFilter());

            $data = $request->getPost()->toArray();

            $form->setData($data);

            if ($form->isValid()) {
                   
                $class->exchangeArray($form->getData());
                $this->getCheckListTable()->save($class);                   
                
                return $this->redirect()->toRoute('admin/pre-planning', array('action' => 'checklist', 'category' => $category, 'id' => $id));
            }
        }
        return array('form' => $form, 'id' => $id, 'item' => $item, 'category' => $category);
    }
    public function editchecklistAction() {

        $this->layout()->setTemplate('layout/admin');

        $id = (int) $this->params()->fromRoute('id', 0);
        $category = (int) $this->params()->fromRoute('category', 0);

        if (!$id) {
            return $this->redirect()->toRoute('admin/pre-planning', array(
                        'action' => 'addchecklist'
            ));
        }
        $item = $this->getCheckListTable()->getItem($id);
        $class = new CheckList();
        $form = new CheckListForm();
        $form->bind($item);

        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();

        if ($request->isPost()) {
            
            $form->setInputFilter($class->getInputFilter());

            $data = $request->getPost();
            
            $form->setData($data);

            if ($form->isValid()) {

                   $class->exchangeArray($data);
                   $this->getCheckListTable()->save($class);                    
                
                return $this->redirect()->toRoute('admin/pre-planning', array('action' => 'checklist', 'category' => $category, 'id' => $item->preplanning_id));
            }

        }

        return array(
            'item' => $item,
            'form' => $form, 'category' => $category
        );
    }

    public function deletechecklistAction() {
        
        $this->layout()->setTemplate('layout/admin');
        $id = (int) $this->params()->fromRoute('id', 0);
        $category = (int) $this->params()->fromRoute('category', 0);
        if (!$id) {
            return $this->redirect()->toRoute('admin/pre-planning');
        }

        $item = $this->getCheckListTable()->getItem($id);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getCheckListTable()->delete($id);
            }

            // Redirect to list of find
            return $this->redirect()->toRoute('admin/pre-planning', array('action' => 'checklist', 'category' => $category, 'id' => $item->preplanning_id));
        }

        return array(
            'id' => $id,
            'find' => $item, 'category' => $category
        );
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
            $this->formsTable = $sm->get('\Model\FormsTable');
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

}