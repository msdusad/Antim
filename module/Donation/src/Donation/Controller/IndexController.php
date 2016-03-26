<?php

namespace Donation\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\View\Model\ViewModel;
use Donation\Mapper\CauseInterface;
use Donation\Mapper\CharityInterface;
use Donation\Mapper\DonationsInterface;
use Obituary\Mapper\InfosInterface as Obituary;
use Obituary\Mapper\MediaInterface as ObituaryMedia;
use Memoralize\Mapper\InfosInterface as Memoralize;
use Memoralize\Mapper\MediaInterface as MemoralizeMedia;

class IndexController extends AbstractActionController {

    /**
     * @var Mapper
     */
    protected $causeMapper;

    /**
     * @var Mapper
     */
    protected $charityMapper;

    /**
     * @var Mapper
     */
    protected $obituaryMapper;

    /**
     * @var mediaMapper
     */
    protected $obituaryMediaMapper;

    /**
     * @var Mapper
     */
    protected $memoralizeMapper;

    /**
     * @var mediaMapper
     */
    protected $memoralizeMediaMapper;

    /**
     * @var donationsMapper
     */
    protected $donationsMapper;

    /**
     * display page
     */
    public function indexAction() {


        $auth = new AuthenticationService();

        if ($auth->hasIdentity()) {

            $userId = $auth->getIdentity();
        } else {

            $userId = 0;
        }

        $flashMessenger = $this->flashMessenger();

        if ($flashMessenger->hasMessages()) {

            $message = $flashMessenger->getMessages();
        } else {

            $message = '';
        }

        $id = (int) $this->params()->fromRoute('id', 0);
        $type = $this->params()->fromRoute('type', '');

        if ($id == 0) {

            return $this->redirect()->toRoute('cremation-plans');
        }
        if ($type == 'obituary') {
            $info = $this->getObituaryMapper()->findInfos($id);
            $images = $this->getObituaryMediaMapper()->getMainImage($id);
            $garlands = $this->getObituaryMediaMapper()->getGarlands();
        } else if ($type == 'memoralize') {
            $info = $this->getMemoralizeMapper()->findInfos($id);
            $images = $this->getMemoralizeMediaMapper()->getMainImage($id);
            $garlands = $this->getMemoralizeMediaMapper()->getGarlands();
        } else {
            $info = array();
            $images = array();
            $garlands = array();
        }

        $cause = $this->getCauseMapper()->fetchAll(0);
        $charities = $this->getCharityMapper()->fetchAll(0);

        //print_r($charities);die;
        return new ViewModel(array('message' => $message, 'cause' => $cause, 'charities' => $charities,
            'infos' => $info, 'images' => $images, 'garlands' => $garlands, 'id' => $id, 'userid' => $userId, 'type' => $type));
    }

    public function charityAction() {

        $request = $this->getRequest();

        $charities = array();

        if ($request->isPost()) {

            $id = $request->getPost('cause_id');
            $charities = $this->getCharityMapper()->fetchAll($id);
        }
        $html = '<option value="">Please select a Charity</option>';
        foreach ($charities as $key => $charity) {

            $html .= ' <option value="' . $charity['id'] . '" >' . $charity['name'] . '</option>';
        }
        if (count($charities) <= 0) {
            $html = '<option value="">Charities Not avaliable</option>';
        }
        echo $html;
        exit;
    }
    
    public function donateAction() {
       
        $id = (int) $this->params()->fromRoute('id', 0);
        $type = $this->params()->fromRoute('type', '');
        $auth = new AuthenticationService();

        if ($auth->hasIdentity()) {

            $userId = $auth->getIdentity();
        } else {

            $userId = 0;
            return $this->redirect()->toRoute('zfcuser/login');
        }
        $request = $this->getRequest();
        
        if ($request->isPost()) {

             $data = $request->getPost();
             if($type=='obituary'){
                 
                 $data['obituary_id'] = $id;
                 $data['memoralize_id'] = 0;
                 
             }else{
                 $data['obituary_id'] = 0;
                 $data['memoralize_id'] = $id;
             }

                $data['user_id'] = $userId;
                $this->getDonationsMapper()->save($data);

                $this->flashMessenger()->addMessage('Cause added successfully');

                // Redirect to list of connections               
            } 
             return $this->redirect()->toRoute('donation', array('id' => $id,'type'=>$type));
    }
public function paymentAction(){
    
    $config = array(
   
       'username'     			=> 'vasanth.ganes.raju-facilitator_api1.gmail.com',
       'password' 				=> '1363245173',
       'signature'				=> 'Aj2IZLu5ikwGsrebE8ZLFzFNdMCMApBk005tLgFny.AXzZDb2P.V1.WH',
       'endpoint'               => 'https://api-3t.sandbox.paypal.com/nvp' //;Live URL: https://api-3t.paypal.com/nvp
    
);

    }
   
    /**
     * set mapper
     *
     * @param  CauseInterface $mapper
     * @return dbmapper
     */
    public function setCauseMapper(CauseInterface $mapper) {

        $this->causeMapper = $mapper;

        return $this;
    }

    /**
     * get mapper
     *
     * @return CauseInterface
     */
    public function getCauseMapper() {
        if (!$this->causeMapper instanceof CauseInterface) {

            $this->setCauseMapper($this->getServiceLocator()->get('CauseMapper'));
        }
        return $this->causeMapper;
    }

    /**
     * set mapper
     *
     * @param  CharityInterface $mapper
     * @return dbmapper
     */
    public function setCharityMapper(CharityInterface $mapper) {

        $this->charityMapper = $mapper;

        return $this;
    }

    /**
     * get mapper
     *
     * @return ShoppingInterface
     */
    public function getCharityMapper() {
        if (!$this->charityMapper instanceof CharityInterface) {

            $this->setCharityMapper($this->getServiceLocator()->get('CharityMapper'));
        }
        return $this->charityMapper;
    }

    /**
     * set mapper
     *
     * @param  CharityInterface $mapper
     * @return dbmapper
     */
    public function setObituaryMapper(Obituary $mapper) {

        $this->obituaryMapper = $mapper;

        return $this;
    }

    /**
     * get mapper
     *
     * @return ShoppingInterface
     */
    public function getObituaryMapper() {
        if (!$this->obituaryMapper instanceof Obituary) {

            $this->setObituaryMapper($this->getServiceLocator()->get('InfosMapper'));
        }
        return $this->obituaryMapper;
    }

    /**
     * set mapper
     *
     * @param  MediaInterface $mapper
     * @return dbmapper
     */
    public function setObituaryMediaMapper(ObituaryMedia $mapper) {

        $this->obituaryMediaMapper = $mapper;

        return $this;
    }

    /**
     * get mapper
     *
     * @return MediaInterface
     */
    public function getObituaryMediaMapper() {
        if (!$this->obituaryMediaMapper instanceof ObituaryMedia) {

            $this->setObituaryMediaMapper($this->getServiceLocator()->get('MediaMapper'));
        }
        return $this->obituaryMediaMapper;
    }

    /**
     * set mapper
     *
     * @param  CharityInterface $mapper
     * @return dbmapper
     */
    public function setMemoralizeMapper(Memoralize $mapper) {

        $this->memoralizeMapper = $mapper;

        return $this;
    }

    /**
     * get mapper
     *
     * @return ShoppingInterface
     */
    public function getMemoralizeMapper() {
        if (!$this->memoralizeMapper instanceof Memoralize) {

            $this->setMemoralizeMapper($this->getServiceLocator()->get('MemoralizeInfosMapper'));
        }
        return $this->memoralizeMapper;
    }

    /**
     * set mapper
     *
     * @param  MediaInterface $mapper
     * @return dbmapper
     */
    public function setMemoralizeMediaMapper(MemoralizeMedia $mapper) {

        $this->memoralizeMediaMapper = $mapper;

        return $this;
    }

    /**
     * get mapper
     *
     * @return MediaInterface
     */
    public function getMemoralizeMediaMapper() {
        if (!$this->memoralizeMediaMapper instanceof MemoralizeMedia) {

            $this->setMemoralizeMediaMapper($this->getServiceLocator()->get('MemoralizeMediaMapper'));
        }
        return $this->memoralizeMediaMapper;
    }

    /**
     * set mapper
     *
     * @param  MediaInterface $mapper
     * @return dbmapper
     */
    public function setDonationsMapper(DonationsInterface $mapper) {

        $this->donationsMapper = $mapper;

        return $this;
    }

    /**
     * get mapper
     *
     * @return MediaInterface
     */
    public function getDonationsMapper() {
        if (!$this->donationsMapper instanceof DonationsInterface) {

            $this->setDonationsMapper($this->getServiceLocator()->get('DonationsMapper'));
        }
        return $this->donationsMapper;
    }

}
