<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Model\Protect;
use Admin\Form\ProtectForm;

class ProtectController extends AbstractActionController {

    protected $table;

    public function indexAction() {

        $request = $this->getRequest();
        if ($request->isPost()) {
            $action = $request->getPost('action');

            $ids = $request->getPost('ids');

            switch ($action) {

                case 'multidelete':
                    $paginator = $this->getTable()->multiDelete($ids);
                    break;
                default :
                    break;
            }
            return $this->redirect()->toRoute('admin/protect');
        }
        //$this->layout('layout/admin');
        // grab the paginator from the AlbumTable
        $paginator = $this->getTable()->fetchAll(true);
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        // set the number of items per page to 10
        $paginator->setItemCountPerPage();

        return new ViewModel(array(
            'paginator' => $paginator
        ));
    }

    public function addAction() {

        $form = new ProtectForm();

        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {

            $class = new Protect();

            $form->setInputFilter($class->getInputFilter());

            $form->setData($request->getPost());

            if ($form->isValid()) {
                $class->exchangeArray($form->getData());

                $this->getTable()->save($class);

                // Redirect to list of protect
                return $this->redirect()->toRoute('admin/protect');
            }
        }
        return array('form' => $form);
    }

    public function editAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('admin/protect', array(
                        'action' => 'add'
            ));
        }
        $data = $this->getTable()->getById($id);

        $form = new ProtectForm();
        $form->bind($data);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($data->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getTable()->save($form->getData());
                // Redirect to list of cms
                return $this->redirect()->toRoute('admin/protect');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('admin/protect');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getTable()->delete($id);
            }

            // Redirect to list of cms
            return $this->redirect()->toRoute('admin/gothra');
        }

        return array(
            'id' => $id,
            'gothra' => $this->getTable()->getById($id)
        );
    }

    public function getTable() {
        if (!$this->table) {
            $sm = $this->getServiceLocator();
            $this->table = $sm->get('Admin\Model\ProtectTable');
        }
        return $this->table;
    }

}