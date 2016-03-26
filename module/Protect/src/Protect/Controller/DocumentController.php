<?php

namespace Protect\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Protect\Model\Document;
use Protect\Form\DocumentForm;

class DocumentController extends AbstractActionController {

    protected $documentsTable;

    public function indexAction() {
        // grab the paginator from the AlbumTable
        $paginator = $this->getDocumentsTable()->fetchAll(true);
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        // set the number of items per page to 10
        $paginator->setItemCountPerPage(5);

        return new ViewModel(array(
            'paginator' => $paginator
        ));
    }

    public function addAction() {
        $form = new DocumentForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $class = new Document();
            $form->setInputFilter($class->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $class->exchangeArray($form->getData());
                $this->getAlbumTable()->save($class);

                // Redirect to list page
                return $this->redirect()->toRoute('documents');
            }
        }
        return array('form' => $form);
    }

    public function editAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('documents', array(
                        'action' => 'add'
            ));
        }
        $data= $this->getDocumentsTable()->getDocument($id);

        $form = new DocumentForm();
        $form->bind($data);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($data->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getDocumentsTable()->save($form->getData());

                // Redirect to list of albums
                return $this->redirect()->toRoute('documents');
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
            return $this->redirect()->toRoute('documents');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getDocumentsTable()->delete($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('documents');
        }

        return array(
            'id' => $id,
            'document' => $this->getDocumentsTable()->getDocument($id)
        );
    }

    public function getDocumentsTable() {
        if (!$this->documentsTable) {
            $sm = $this->getServiceLocator();
            $this->documentsTable = $sm->get('Protect\Model\DocumentsTable');
        }
        return $this->documentsTable;
    }

}