<?php

namespace Donation\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\View\Model\ViewModel;
use Zend\Form\Form;
use Donation\Mapper\CharityInterface;
use Zend\Validator\File\Size;


class CharityController extends AbstractActionController {

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
        
        $categoryId = (int) $this->params()->fromRoute('id', 0);

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
       
        
        $categories = $this->getMapper()->fetchCategories($id);
        
        foreach ($categories as $row) {
            $options[$row['id']] = array(
                'value' => $row['id'],
                'label' => $row['name'],
            );
        }
       
        $form->get('cause_id')->setAttributes(array('options' => $options));
        $form->get('cause_id')->setValue($id);

        $request = $this->getRequest();

        if ($request->isPost()) {

                $nonFile = $request->getPost()->toArray();
                $File = $this->params()->fromFiles('photo_url');
                if($File==''){
                    
                     return $this->redirect()->toRoute('admin/donation-charity', array('id' => $id));
                }
                $data = array_merge(
                        $nonFile, //POST 
                        array('photo_url' => $File['name']) //FILE...
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
                        $charityid =  $this->getMapper()->save($form->getData());
                      
                    } else {
                        
                        $charityid =  $this->getMapper()->save($form->getData());
                     
                          $dirName = dirname(__DIR__) . '/../../assets/charity/'.$charityid;
                        if (!is_dir($dirName)) {
                                     mkdir($dirName,0777);         
                                  }
                                
//                        $media = $this->getMapper()->getItem($charityid);
//print_r($media);die;
//                        if (isset($media->photo_url) && $media->photo_url != '') {
//                            unlink($dirName . $media->photo_url);
//                        }
                        $adapter->setDestination($dirName);
                        $imgData = array();
                        if ($adapter->receive($File['name'])) {

                            $imgData['id'] = $charityid;
                            $imgData['photo_url'] = $File['name'];
                           
                            $this->getMapper()->updatePhoto($imgData);
                        }
                    }
                    return $this->redirect()->toRoute('admin/donation-charity', array('id' => $id));
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
        
        foreach ($categories as $row) {
            $options[$row['id']] = array(
                'value' => $row['id'],
                'label' => $row['name'],
            );
        }

        $form->get('cause_id')->setAttributes(array('options' => $options));
        
        $form->get('cause_id')->setValue($item->getCauseId());
        $form->get('id')->setValue($item->getId());
        $form->get('name')->setValue($item->getName());
        $form->get('description')->setValue($item->getDescription());
        $form->get('address')->setValue($item->getAddress());
        $form->get('contact_name')->setValue($item->getContactName());
        $form->get('url')->setValue($item->getUrl());
        $form->get('submit')->setValue('Save');
        
        $request = $this->getRequest();

        if ($request->isPost()) {

                $nonFile = $request->getPost()->toArray();
                $File = $this->params()->fromFiles('photo_url');
                if($File==''){
                    
                     return $this->redirect()->toRoute('admin/donation-charity', array('id' => $id));
                }
                $data = array_merge(
                        $nonFile, //POST 
                        array('photo_url' => $File['name']) //FILE...
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
                        $charityid =  $this->getMapper()->save($form->getData());
                      
                    } else {
                        
                        $charityid =  $this->getMapper()->save($form->getData());
                     
                          $dirName = dirname(__DIR__) . '/../../assets/charity/'.$charityid;
                        if (!is_dir($dirName)) {
                                     mkdir($dirName,0777);         
                                  }
                                
                     // echo $item->getPhotoUrl();die;

                        if ($item->getPhotoUrl() != '') { 
                            unlink($dirName .'/'. $item->getPhotoUrl());
                        }
                        $adapter->setDestination($dirName);
                        $imgData = array();
                        if ($adapter->receive($File['name'])) {

                            $imgData['id'] = $charityid;
                            $imgData['photo_url'] = $File['name'];
                           
                            $this->getMapper()->updatePhoto($imgData);
                        }
                    }
                    return $this->redirect()->toRoute('admin/donation-charity', array('id' => $id));
                }
        }

        return new ViewModel(array('form' => $form, 'id' => $id));
    }
     public function deleteAction() {
        
        $this->layout()->setTemplate('layout/admin');
       
        $id = (int) $this->params()->fromRoute('id', 0);
        
        if (!$id) {
            return $this->redirect()->toRoute('admin/donation-charity');
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
            return $this->redirect()->toRoute('admin/donation-charity');
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
    public function setMapper(CharityInterface $mapper) {

        $this->mapper = $mapper;

        return $this;
    }

    /**
     * get mapper
     *
     * @return ShoppingInterface
     */
    public function getMapper() {
        if (!$this->mapper instanceof CharityInterface) {

            $this->setMapper($this->getServiceLocator()->get('CharityMapper'));
        }
        return $this->mapper;
    }

    public function getForm() {
        if (!$this->form) {
            $this->setForm($this->getServiceLocator()->get('charity-form'));
        }
        return $this->form;
    }

    public function setForm(Form $form) {
        $this->form = $form;
        $this->flashMessenger()->setNamespace('charity-form')->getMessages();
        return $this;
    }
    
    

}
