<?php

namespace PrePlanning\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use PrePlanning\Form\LinksForm;
use PrePlanning\Model\Links;

class LinksController extends AbstractActionController {

     /**
     * @var preplanningTable
     */
    protected $table;

    
    public function indexAction() {
        
        $this->layout()->setTemplate('layout/admin');
        
        $id = (int) $this->params()->fromRoute('id', 0);
        $category = (int) $this->params()->fromRoute('category', 0);
        $request = $this->getRequest();
        if ($request->isPost()) {
             $action = $request->getPost('action');
           
             $ids = $request->getPost('ids');

            switch($action){
                
                case 'multidelete':
                     $paginator = $this->getPrePlanningTable()->multiDelete($ids);
                    break;
                default :
                    break;
                
                
                
            }
             return $this->redirect()->toRoute('admin/preplanning-links');
           
        }
        //$this->layout('layout/admin');
        // grab the paginator from the AlbumTable
        $paginator = $this->getPrePlanningTable()->fetchAll(true,$id,null);
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        // set the number of items per page to 10
        $paginator->setItemCountPerPage();

        return new ViewModel(array(
            'paginator' => $paginator,'category'=>$category,'id'=>$id
        ));
    }

    public function addAction() {
       
        $this->layout()->setTemplate('layout/admin');
        
        $form = new LinksForm();
       
        $id = (int) $this->params()->fromRoute('id', 0);
        $category = (int) $this->params()->fromRoute('category', 0);
        
        $form->get('submit')->setValue('Add');
        $form->get('preplanning_id')->setValue($id);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $links = new Links();
            $form->setInputFilter($links->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) { 
                $links->exchangeArray($form->getData());
                $this->getPrePlanningTable()->saveList($links);

                // Redirect to list of categories
                return $this->redirect()->toRoute('admin/preplanning-links',array('category'=>$category,'id'=>$id));
            }
        }
        return array('form' => $form,'category'=>$category,'id'=>$id);
    }

    public function editAction() {
        $this->layout()->setTemplate('layout/admin');
        $id = (int) $this->params()->fromRoute('id', 0);
        $category = (int) $this->params()->fromRoute('category', 0);
        if (!$id) {
            return $this->redirect()->toRoute('admin/preplanning-links', array(
                        'action' => 'add'
            ));
        }
        $link = $this->getPrePlanningTable()->getListById($id);

        $form = new LinksForm();
        $form->bind($link);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
           
            $form->setInputFilter($link->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) { 
                $this->getPrePlanningTable()->saveList($form->getData());
               
                // Redirect to list of categories
                return $this->redirect()->toRoute('admin/preplanning-links',array('category'=>$category,'id'=>$link->preplanning_id));
            }
        }

        return array(
            'id' => $id,
            'category'=>$category,
            'form' => $form,
        );
    }

    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('admin/preplanning-links');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getCategoryTable()->deleteList($id);
            }

            // Redirect to list of categories
            return $this->redirect()->toRoute('admin/preplanning-links');
        }

        return array(
            'id' => $id,
            'list' => $this->getPrePlanningTable()->getListById($id)
        );
    }

    public function getPrePlanningTable() {
        if (!$this->table) {
            $sm = $this->getServiceLocator();
            $this->table = $sm->get('PrePlanning\Model\LinksTable');
        }
        return $this->table;
    }

    

}
