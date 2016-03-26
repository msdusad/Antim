<?php

namespace CremationPlan\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use CremationPlan\Model\Find;
use CremationPlan\Form\FindForm;
use Zend\Validator\File\Size;


class FindController extends AbstractActionController {

    protected $findTable;
    
    
    public function indexAction() {
        
        $this->layout()->setTemplate('layout/admin');

        $categories = $this->getFindTable()->getCategories();

        $request = $this->getRequest();
        if ($request->isPost()) {
            
            $action = $request->getPost('action');
           
            $categoryId = $request->getPost('category_id');

            if ($categoryId != '') {

                //$this->layout('layout/admin');
                // grab the paginator from the AlbumTable
                $paginator = $this->getFindTable()->fetchAll(true, $categoryId);
                // set the current page to what has been passed in query string, or to 1 if none set
                $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
                // set the number of items per page to 10
                $paginator->setItemCountPerPage();

                return new ViewModel(array(
                    'paginator' => $paginator, 'categories' => $categories,'category'=>$categoryId
                ));
            }

            $ids = $request->getPost('ids');

            switch ($action) {

                case 'multidelete':
                    $paginator = $this->getFindTable()->multiDelete($ids);
                    return $this->redirect()->toRoute('admin/find');
                    break;
                default :
                    break;
            }
            //
        }

        //$this->layout('layout/admin');
        // grab the paginator from the AlbumTable
        $paginator = $this->getFindTable()->fetchAll(true);
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        // set the number of items per page to 10
        $paginator->setItemCountPerPage();

        return new ViewModel(array(
            'paginator' => $paginator, 'categories' => $categories,'category'=>''
        ));
    }

    public function addAction() {

         $this->layout()->setTemplate('layout/admin');
        $form = new FindForm();
        $form->get('submit')->setValue('Add');
        
        $categories = $this->getFindTable()->getCategories();
        $languages = $this->getFindTable()->getLanguages();

        $form->get('category_id')->setAttributes(array('options' => $categories));
        $form->get('languages')->setAttributes(array('options' => $languages));

        $request = $this->getRequest();
        if ($request->isPost()) {
            $find = new Find();
            $form->setInputFilter($find->getInputFilter());

            $nonFile = $request->getPost()->toArray();
            $File = $this->params()->fromFiles('photo');
            $data = array_merge(
                    $nonFile, //POST 
                    array('photo' => $File['name']) //FILE...
            );

            $form->setData($data);

            if ($form->isValid()) {

                $size = new Size(array('min' => 200)); //minimum bytes filesize

                $adapter = new \Zend\File\Transfer\Adapter\Http();
                $adapter->setValidators(array($size), $File['name']);
                if (!$adapter->isValid()) {
                    $dataError = $adapter->getMessages();
                    $error = array();
                    foreach ($dataError as $key => $row) {
                        $error[] = $row;
                    }

                    $form->setMessages(array('fileupload' => $error));

                    $find->exchangeArray($form->getData());

                    $this->getFindTable()->saveList($find);
                } else {
                    $dirName = dirname(__DIR__) . '/../../assets';
                    $adapter->setDestination($dirName);
                    if ($adapter->receive($File['name'])) {

                        $find->exchangeArray($form->getData());

                        $id = $this->getFindTable()->saveList($find);

                        $thumbnailer = $this->getServiceLocator()->get('WebinoImageThumb');
                        $thumb = $thumbnailer->create($dirName . '/' . $data['photo'], $options = array());

                        $thumb->resize(72, 72);

                        //$thumb->show();
                        // or/and
                        $thumb->save($dirName . '/thumb/' . $id . '_' . $data['photo']);
                    }
                }
                return $this->redirect()->toRoute('admin/find');
            }
        }
        return array('form' => $form);
    }

    public function editAction() {
         $this->layout()->setTemplate('layout/admin');
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('find', array(
                        'action' => 'add'
            ));
        }
        $find = $this->getFindTable()->getListById($id);
        $findClass = new Find();
        $form = new FindForm();
        $form->bind($find);
        $form->get('submit')->setAttribute('value', 'Edit');
        $categories = $this->getFindTable()->getCategories();
        $languages = $this->getFindTable()->getLanguages();

        $form->get('category_id')->setAttributes(array('options' => $categories));
        $form->get('languages')->setAttributes(array('options' => $languages));
        $request = $this->getRequest();
        if ($request->isPost()) {

            $form->setInputFilter($findClass->getInputFilter());

            $nonFile = $request->getPost()->toArray();
            $File = $this->params()->fromFiles('photo');
            $data = array_merge(
                    $nonFile, //POST 
                    array('photo' => $File['name']) //FILE...
            );

            $form->setData($data);

            if ($form->isValid()) {

                $size = new Size(array('min' => 200)); //minimum bytes filesize

                $adapter = new \Zend\File\Transfer\Adapter\Http();
                $adapter->setValidators(array($size), $File['name']);
                if (!$adapter->isValid()) {
                    $dataError = $adapter->getMessages();
                    $error = array();
                    foreach ($dataError as $key => $row) {
                        $error[] = $row;
                    }
                    unset($data['photo']);

                    $findClass->exchangeArray($data);

                    $this->getFindTable()->saveList($findClass);

                    $form->setMessages(array('fileupload' => $error));
                } else {
                    $dirName = dirname(__DIR__) . '/../../assets';
                    $adapter->setDestination($dirName);
                    if ($adapter->receive($File['name'])) {

                        $findClass->exchangeArray($data);

                        $this->getFindTable()->saveList($findClass);

                        $thumbnailer = $this->getServiceLocator()->get('WebinoImageThumb');
                        $thumb = $thumbnailer->create($dirName . '/' . $data['photo'], $options = array());

                        $thumb->resize(72, 72);

                        //$thumb->show();
                        // or/and
                        $thumb->save($dirName . '/thumb/' . $data['id'] . '_' . $data['photo']);
                    }
                }
                return $this->redirect()->toRoute('admin/find');
            }
        }

        return array(
            'find' => $find,
            'form' => $form,
        );
    }

    public function deleteAction() {
         $this->layout()->setTemplate('layout/admin');
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('admin/find');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getFindTable()->deleteList($id);
            }

            // Redirect to list of find
            return $this->redirect()->toRoute('admin/find');
        }

        return array(
            'id' => $id,
            'find' => $this->getFindTable()->getListById($id)
        );
    }

    public function getFindTable() {
        if (!$this->findTable) {
            $sm = $this->getServiceLocator();
            $this->findTable = $sm->get('CremationPlan\Model\FindTable');
        }
        return $this->findTable;
    }

}