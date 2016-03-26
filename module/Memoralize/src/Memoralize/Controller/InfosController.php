<?php

namespace Memoralize\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Memoralize\Mapper\InfosInterface;
use Zend\Form\Form;

class InfosController extends AbstractActionController {

    /**
     * @var UserProviderInterface
     */
    protected $mapper;

    /**
     * @var Form
     */
    protected $infosForm;

    public function indexAction() {

        $flashMessenger = $this->flashMessenger();

        if ($flashMessenger->hasMessages()) {

            $message = $flashMessenger->getMessages();
        } else {

            $message = '';
        }
        $form = $this->getInfosForm();

        $request = $this->getRequest();

        if ($request->isPost()) {

            $data = $request->getPost();
            $form->setData($data);

            if ($form->isValid()) {
                $sm = $this->getServiceLocator();
                $service = $sm->get('zfcuser_user_service');
                $userId = $service->getAuthService()->getIdentity()->getId();
                $data['user_id'] = $userId;
                $mId = $this->getMapper()->save($data);
                $this->flashMessenger()->addMessage('Events added successfully');
                // Redirect to list of connections
                return $this->redirect()->toRoute('memoralize-create',array('step'=>'1','id'=>$mId));
            }
        }

        return new ViewModel(array('form' => $form));
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
