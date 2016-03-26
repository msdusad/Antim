<?php

namespace Memoralize\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Memoralize\Mapper\MemoralizeInterface;
use Memoralize\Mapper\InfosInterface;
use Memoralize\Mapper\MediaInterface;
use EventCalendar\Mapper\EventsInterface;
use Zend\Form\Form;


class IndexController extends AbstractActionController {

    /**
     * @var infoMapper
     */
    protected $infosMapper;

    /**
     * @var mediaMapper
     */
    protected $mediaMapper;

    /**
     * @var memoralizeMapper
     */
    protected $memoralizeMapper;
    /**
     * @var memoralizeMapper
     */
    protected $eventMapper;

    /**
     * @var Form
     */
    protected $memoralizeForm;

    /**
     * display page
     */
    public function indexAction() {

        $id = (int) $this->params()->fromRoute('id', 0);
        $flashMessenger = $this->flashMessenger();

        if ($flashMessenger->hasMessages()) {

            $message = $flashMessenger->getMessages();
        } else {

            $message = '';
        }

        $images = $this->getMediaMapper()->getMimages($id);
        $media = $this->getMediaMapper()->getMedia($id);
        $memoralize = $this->getMemoralizeMapper()->getMemoralize($id);
        $info = $this->getInfoseMapper()->findInfos($id);
        $theme = $this->getMediaMapper()->getTheme($memoralize->theme_id);
        $events = $this->getEventMapper()->findEvents($id);
        $recentOffers = $this->getMemoralizeMapper()->getRecentOffers($id);
        
        $sm = $this->getServiceLocator();
        $service = $sm->get('zfcuser_user_service');
        $userId = $service->getAuthService()->getIdentity()->getId();
        
        return new ViewModel(array('userid'=>$userId,'message' => $message,'media'=>$media, 'info' => $info, 'images' => $images, 
            'memoralize' => $memoralize,'theme'=>$theme,'events'=>$events,'id'=>$id,'offers'=>$recentOffers));
    }
    
    public function offerAction(){
        
         $request = $this->getRequest();

        if ($request->isPost()) {

            $data = $request->getPost();
            
             $recentOffers = $this->getMemoralizeMapper()->updateOffer($data);
             $string = 'sucess';
             
             echo json_encode($string);exit;
        }
    }

    /**
     * display page
     */
    public function createAction() {

        $step = $this->params()->fromRoute('step', 0);
        $id = (int) $this->params()->fromRoute('id', 0);

        $flashMessenger = $this->flashMessenger();

        if ($flashMessenger->hasMessages()) {

            $message = $flashMessenger->getMessages();
        } else {

            $message = '';
        }

        return new ViewModel(array('message' => $message, 'step' => $step, 'id' => $id));
    }
    /**
     * display page
     */
    public function eventAction() {

         $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('home');
        }

        $event = $this->getEventMapper()->findEventById($id);
       
        return array('id' => $id, 'event' => $event);
    }
    /**
     * set mapper
     *
     * @param  MemoralizeInterface $mapper
     * @return dbmapper
     */
    public function setMemoralizeMapper(MemoralizeInterface $mapper) {

        $this->memoralizeMapper = $mapper;

        return $this;
    }
    /**
     * get mapper
     *
     * @return MemoralizeInterface
     */
    public function getMemoralizeMapper() {
        if (!$this->memoralizeMapper instanceof MemoralizeInterface) {

            $this->setMemoralizeMapper($this->getServiceLocator()->get('MemoralizeMapper'));
        }
        return $this->memoralizeMapper;
    }
    /**
     * set mapper
     *
     * @param  InfosInterface $mapper
     * @return dbmapper
     */
    public function setInfoseMapper(InfosInterface $mapper) {
        $this->infosMapper = $mapper;

        return $this;
    }
    /**
     * get mapper
     *
     * @return InfosInterface
     */
    public function getInfoseMapper() {
        if (!$this->infosMapper instanceof InfosInterface) {

            $this->setInfoseMapper($this->getServiceLocator()->get('InfosMapper'));
        }
        return $this->infosMapper;
    }
    /**
     * set mapper
     *
     * @param  MediaInterface $mapper
     * @return dbmapper
     */
    public function setMediaMapper(MediaInterface $mapper) {

        $this->mediaMapper = $mapper;

        return $this;
    }
    /**
     * get mapper
     *
     * @return MediaInterface
     */
    public function getMediaMapper() {
        if (!$this->mediaMapper instanceof MediaInterface) {

            $this->setMediaMapper($this->getServiceLocator()->get('MediaMapper'));
        }
        return $this->mediaMapper;
    }
    /**
     * set mapper
     *
     * @param  UserProviderInterface $mapper
     * @return HybridAuth
     */
    public function setEventMapper(EventsInterface $mapper) {
        $this->eventMapper = $mapper;

        return $this;
    }

    /**
     * get mapper
     *
     * @return UserProviderInterface
     */
    public function getEventMapper() {
        if (!$this->eventMapper instanceof EventsInterface) {

            $this->setEventMapper($this->getServiceLocator()->get('EventsMapper'));
        }

        return $this->eventMapper;
    }

    public function getForm() {
        if (!$this->memoralizeForm) {
            $this->setForm($this->getServiceLocator()->get('main-form'));
        }
        return $this->memoralizeForm;
    }

    public function setForm(Form $memoralizeForm) {
        $this->memoralizeForm = $memoralizeForm;
        $this->flashMessenger()->setNamespace('main-form')->getMessages();
        return $this;
    }
}
