<?php

namespace Obituary\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Stdlib\Hydrator\ClassMethods;
use Obituary\Mapper\InfosInterface;
use Obituary\Options\ModuleOptions;
use Zend\Form\Form;

class InfosController extends AbstractActionController {

    /**
     * @var ModuleOptions
     */
    protected $options;

    /**
     * @var UserProviderInterface
     */
    protected $mapper;

    /**
     * @var Form
     */
    protected $infosForm;

    public function indexAction() {

        $id = (int) $this->params()->fromRoute('id', 0);        
        $type = $this->params()->fromRoute('type');
                       
        $flashMessenger = $this->flashMessenger();

        if ($flashMessenger->hasMessages()) {

            $message = $flashMessenger->getMessages();
        } else {

            $message = '';
        }
        $form = $this->getInfosForm();
          
        if($id!=0){           
             $editDatas = $this->getMapper()->findInfoById($id);              
             $form->get('obituary_id')->setAttributes(array('value' => $editDatas->obituary_id));
             $form->get('id')->setAttributes(array('value' => $id));
             $form->get('first_name')->setAttributes(array('value' => $editDatas->first_name));
             $form->get('middle_name')->setAttributes(array('value' => $editDatas->middle_name));
             $form->get('last_name')->setAttributes(array('value' => $editDatas->last_name));
             $form->get('dob')->setAttributes(array('value' => $editDatas->dob));
             $form->get('dod')->setAttributes(array('value' => $editDatas->dod));
             $form->get('age')->setAttributes(array('value' => $editDatas->age));
             $form->get('death_place')->setAttributes(array('value' => $editDatas->death_place));
             $form->get('school')->setAttributes(array('value' => $editDatas->school));  
             $form->get('ug')->setAttributes(array('value' => $editDatas->ug));  
             $form->get('ug_specialization')->setAttributes(array('value' => $editDatas->ug_specialization));  
             $form->get('pg')->setAttributes(array('value' => $editDatas->pg));  
             $form->get('pg_specialization')->setAttributes(array('value' => $editDatas->pg_specialization));  
             $form->get('family')->setAttributes(array('value' => $editDatas->family));                     
             $form->get('submit')->setAttributes(array('value' => 'Save')); 
        }

        $request = $this->getRequest();

        if ($request->isPost()) {

            $data = $request->getPost();
            
            $form->setData($data);

            if ($form->isValid()) {                               
                $sm = $this->getServiceLocator();
                $service = $sm->get('zfcuser_user_service');
                $userId = $service->getAuthService()->getIdentity()->getId();
                $data['user_id'] = $userId;
                $data['created_by'] = $service->getAuthService()->getIdentity()->getUsername().' '.$service->getAuthService()->getIdentity()->getDisplayname();
             
                if(!isset($data['description'])){
                   
                    $data['description'] = '';
                }
               
                $mId = $this->getMapper()->save($data);
                $this->flashMessenger()->addMessage('Infos added successfully');
                
                
                // Redirect to list of connections
                return $this->redirect()->toRoute('obituary-create-media',array('id'=>$mId,'step'=>1));
               
            }
        }

        return new ViewModel(array('form' => $form));
    }
    
    public function popupAction() {

        $id = (int) $this->params()->fromRoute('id', 0);
                       
        $flashMessenger = $this->flashMessenger();

        if ($flashMessenger->hasMessages()) {

            $message = $flashMessenger->getMessages();
        } else {

            $message = '';
        }
        $form = $this->getInfosForm();
          //echo '<pre>'; print_r($form);
        if($id!=0){           
             $editDatas = $this->getMapper()->findInfoByObituary($id);         
             $form->get('obituary_id')->setAttributes(array('value' => $editDatas->obituary_id));
             $form->get('id')->setAttributes(array('value' => $id));
             $form->get('first_name')->setAttributes(array('value' => $editDatas->first_name));
             $form->get('middle_name')->setAttributes(array('value' => $editDatas->middle_name));
             $form->get('last_name')->setAttributes(array('value' => $editDatas->last_name));
             $form->get('dob')->setAttributes(array('value' => $editDatas->dob));
             $form->get('dod')->setAttributes(array('value' => $editDatas->dod));
             $form->get('age')->setAttributes(array('value' => $editDatas->age));
             $form->get('death_place')->setAttributes(array('value' => $editDatas->death_place));
             $form->get('school')->setAttributes(array('value' => $editDatas->school));  
             $form->get('ug')->setAttributes(array('value' => $editDatas->ug));  
             $form->get('ug_specialization')->setAttributes(array('value' => $editDatas->ug_specialization));  
             $form->get('pg')->setAttributes(array('value' => $editDatas->pg));  
             $form->get('pg_specialization')->setAttributes(array('value' => $editDatas->pg_specialization));
             $form->get('family')->setAttributes(array('value' => $editDatas->family));                  
             $form->get('description')->setAttributes(array('value' => $editDatas->description)); 
             $form->get('submit')->setAttributes(array('value' => 'Save')); 
        }

        $request = $this->getRequest();

        if ($request->isPost()) {

            $data = $request->getPost();
            $form->setData($data);

            if ($form->isValid()) {
                               
                $sm = $this->getServiceLocator();
                $service = $sm->get('zfcuser_user_service');
                $userId = $service->getAuthService()->getIdentity()->getId();
                $data['user_id'] = $userId;
                $data['created_by'] = $service->getAuthService()->getIdentity()->getUsername().' '.$service->getAuthService()->getIdentity()->getDisplayname();
             
                if(!isset($data['description'])){
                   
                    $data['description'] = '';
                }
                $this->getMapper()->save($data);
                $this->flashMessenger()->addMessage('Infos added successfully');
                return $this->redirect()->toRoute('obituary',array('id'=>$data['id']));                 
            }
        }

        return new ViewModel(array('form' => $form,'id'=>$id));
    }

    /**
     * set mapper
     *
     * @param  InfosInterface $mapper
     * @return dbmapper
     */
    public function setMapper(InfosInterface $mapper) {
        $this->mapper = $mapper;

        return $this;
    }

    /**
     * get mapper
     *
     * @return InfosMapper
     */
    public function getMapper() {
        if (!$this->mapper instanceof InfosInterface) {

            $this->setMapper($this->getServiceLocator()->get('InfosMapper'));
        }
        return $this->mapper;
    }
    
     /**
     * set options
     *
     * @param  ModuleOptions $options
     * @return HybridAuth
     */
    public function setOptions(ModuleOptions $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * get options
     *
     * @return ModuleOptions
     */
    public function getOptions()
    {
        if (!$this->options instanceof ModuleOptions) {
            $this->setOptions($this->getServiceLocator()->get('Obituary-ModuleOptions'));
        }

        return $this->options;
    }

    public function getInfosForm() {
        if (!$this->infosForm) {
            $this->setInfosForm($this->getServiceLocator()->get('infos-form'));
        }
        return $this->infosForm;
    }

    public function setInfosForm(Form $infosForm) {
        $this->infosForm = $infosForm;
        $this->flashMessenger()->setNamespace('infos-form')->getMessages();
        return $this;
    }

}
