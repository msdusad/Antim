<?php

namespace CremationPlan\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use CremationPlan\Model\Garland;
use CremationPlan\Form\GarlandForm;
use Zend\Validator\File\Size;


class GarlandController extends AbstractActionController {

    protected $garlandTable;

    public function indexAction() {

        $this->layout()->setTemplate('layout/admin');
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            
            $action = $request->getPost('action');
         
            $ids = $request->getPost('ids');

            switch ($action) {

                case 'multidelete':
                    $paginator = $this->getGarlandTable()->multiDelete($ids);
                    return $this->redirect()->toRoute('admin/garlands');
                    break;
                default :
                    break;
            }
            //
        }

        //$this->layout('layout/admin');
        // grab the paginator from the AlbumTable
        $paginator = $this->getGarlandTable()->fetchAll(true);
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        // set the number of items per page to 10
        $paginator->setItemCountPerPage();

        return new ViewModel(array(
            'paginator' => $paginator
        ));
    }
   

    public function addAction() {

        $this->layout()->setTemplate('layout/admin');
        
        $form = new GarlandForm();
        
        $form->get('submit')->setValue('Add');
        
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $class = new Garland();
            
            $form->setInputFilter($class->getInputFilter());

            $nonFile = $request->getPost()->toArray();
            
            $File = $this->params()->fromFiles('garland_image');
            $data = array_merge(
                    $nonFile, //POST 
                    array('garland_image' => $File['name']) //FILE...
            );

            $form->setData($data);

            if ($form->isValid()) {

                $size = new Size(array('min' => 20000)); //minimum bytes filesize

                $adapter = new \Zend\File\Transfer\Adapter\Http();
                $adapter->setValidators(array($size), $File['name']);
                if (!$adapter->isValid()) {
                    $dataError = $adapter->getMessages();
                    $error = array();
                    foreach ($dataError as $key => $row) {
                        $error[] = $row;
                    }

                    $form->setMessages(array('fileupload' => $error));

                    $class->exchangeArray($form->getData());

                    $this->getGarlandTable()->save($class);
                } else {
                    $dirName = dirname(__DIR__) . '/../../assets/garland';
                    $adapter->setDestination($dirName);
                    if ($adapter->receive($File['name'])) {

                        $class->exchangeArray($form->getData());

                        $id = $this->getGarlandTable()->save($class);

                        $thumbnailer = $this->getServiceLocator()->get('WebinoImageThumb');
                        $thumb = $thumbnailer->create($dirName . '/' . $data['garland_image'], $options = array());

                        $thumb->resize(72, 72);

                        //$thumb->show();
                        // or/and
                        $thumb->save($dirName . '/thumb/' . $id . '_' . $data['garland_image']);
                    }
                }
                return $this->redirect()->toRoute('admin/garlands');
            }
        }
        return array('form' => $form);
    }

//    public function editAction() {
//        
//        $this->layout()->setTemplate('layout/admin');
//        
//        $id = (int) $this->params()->fromRoute('id', 0);
//        if (!$id) {
//            return $this->redirect()->toRoute('admin/garlands', array(
//                        'action' => 'add'
//            ));
//        }
//        $garland = $this->getGarlandTable()->getProduct($id);
//        $class = new Garland();
//        $form = new GarlandForm();
//        $form->bind($garland);
//        $form->get('submit')->setAttribute('value', 'Edit');
//       
//        $request = $this->getRequest();
//        
//        if ($request->isPost()) {
//
//            $form->setInputFilter($class->getInputFilter());
//
//            $nonFile = $request->getPost()->toArray();
//            $File = $this->params()->fromFiles('garland_image');
//            $data = array_merge(
//                    $nonFile, //POST 
//                    array('garland_image' => $File['name']) //FILE...
//            );
//
//            $form->setData($data);
//
//            if ($form->isValid()) {
//
//                $size = new Size(array('min' => 20000)); //minimum bytes filesize
//
//                $adapter = new \Zend\File\Transfer\Adapter\Http();
//                $adapter->setValidators(array($size), $File['name']);
//                if (!$adapter->isValid()) {
//                    $dataError = $adapter->getMessages();
//                    $error = array();
//                    foreach ($dataError as $key => $row) {
//                        $error[] = $row;
//                    }
//                    unset($data['garland_image']);
//
//                    $class->exchangeArray($data);
//
//                    $this->getGarlandTable()->save($class);
//
//                    $form->setMessages(array('fileupload' => $error));
//                } else {
//                    $dirName = dirname(__DIR__) . '/../../assets/garland';
//                    $adapter->setDestination($dirName);
//                    if ($adapter->receive($File['name'])) {
//
//                        $class->exchangeArray($data);
//
//                        $this->getGarlandTable()->saveProduct($class);
//
//                        $thumbnailer = $this->getServiceLocator()->get('WebinoImageThumb');
//                        $thumb = $thumbnailer->create($dirName . '/' . $data['garland_image'], $options = array());
//
//                        $thumb->resize(72, 72);
//
//                        //$thumb->show();
//                        // or/and
//                        $thumb->save($dirName . '/thumb/' . $data['id'] . '_' . $data['garland_image']);
//                    }
//                }
//                return $this->redirect()->toRoute('admin/garlands');
//            }
//        }
//
//        return array(
//            'garland' => $garland,
//            'form' => $form,
//        );
//    }

    public function deleteAction() {
       
        $this->layout()->setTemplate('layout/admin');
        
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('admin/garlands');
        }

        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getGarlandTable()->delete($id);
            }

            // Redirect to list of find
            return $this->redirect()->toRoute('admin/garlands');
        }

        return array(
            'id' => $id,
            'garland' => $this->getGarlandTable()->getItem($id)
        );
    }

    public function getGarlandTable() {
        if (!$this->garlandTable) {
            $sm = $this->getServiceLocator();
            $this->garlandTable = $sm->get('CremationPlan\Model\GarlandTable');
        }
        return $this->garlandTable;
    }

}