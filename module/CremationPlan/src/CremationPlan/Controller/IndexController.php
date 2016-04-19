<?php

namespace CremationPlan\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;

class IndexController extends AbstractActionController {

    protected $allTable;

    public function indexAction() {

        $auth = new AuthenticationService();

        if ($auth->hasIdentity()) {

            $userId = $auth->getIdentity();
           
        } else {

            $userId = 0;
           
        }
        $findCategory = $this->getAllTable()->getFinds();
        $purchaseCategory = $this->getAllTable()->getPurchase();
        $learnCategory = $this->getAllTable()->getLearns();
        $impactCategory = $this->getAllTable()->getImpacts();
        $protectList = $this->getAllTable()->getProtects();

        return new ViewModel(array(
            'findCategory' => $findCategory, 'purchaseCategory' => $purchaseCategory,
            'learnCategory' => $learnCategory, 'impactCategory' => $impactCategory, 'userId' => $userId,'protectList'=>$protectList
        ));
    }

    public function impactDetailsAction() {

        $request = $this->getRequest();

        $id = (int) $this->params()->fromRoute('id', 0);

        $impactDetails = $this->getAllTable()->getImpactDetails($id);

        $name = $request->getPost('name');

        $impact = array('id' => $id, 'name' => $name);

        $impactList = $this->getAllTable()->getImpactList($impactDetails['category_id'], $name);

        $category = $this->getAllTable()->getCategoryBy($impactDetails['category_id']);

        $photose = $this->getAllTable()->getGallery($id);

        $videos = $this->getAllTable()->getVideos($id);

        return new ViewModel(array(
            'impactDetails' => $impactDetails, 'id' => $id, 'impactList' => $impactList,
            'impact' => $impact, 'category' => $category, 'photose' => $photose, 'videos' => $videos,
        ));
    }

    public function impactsAction() {

        $request = $this->getRequest();
        $id = (int) $this->params()->fromRoute('id', 0);
        $name = $request->getPost('name');

        $impact = array('id' => $id, 'name' => $name);

        $impactList = $this->getAllTable()->getImpactList($id, $name);
        $category = $this->getAllTable()->getCategoryBy($id);

        return new ViewModel(array(
            'impactList' => $impactList, 'impact' => $impact, 'category' => $category, 'id' => $id
        ));
    }

    public function findAction() {

         $auth = new AuthenticationService();

        if ($auth->hasIdentity()) {

            $userId = $auth->getIdentity();
          
        } else {
            $userId = 0;            
        }
        $request = $this->getRequest();
        $id = (int) $this->params()->fromRoute('id', 0);
        $name = $request->getPost('name');
        $city = $request->getPost('city');
        $code = $request->getPost('code');
        
        
        $find = array('id' => $id, 'name' => $name, 'city' => $city,'code'=>$code);

        $findList = $this->getAllTable()->getFindList($id, $name, $city,$code);

        $markers = array();
        foreach ($findList as $key => $val) {
            $markers[$key]['address'] = preg_replace("!\r?\n!", "", $val['address']);
            $markers[$key]['html'] = preg_replace("!\r?\n!", "", $val['address']);
        }

        $category = $this->getAllTable()->getCategoryBy($id);
      

        return new ViewModel(array(
            'findList' => $findList,'markers'=>json_encode($markers),
            'find' => $find, 'category' => $category,'userId'=>$userId
        ));
    }

    public function ritualsAction() {

        $request = $this->getRequest();
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($request->isPost()) {
            $tradtionalId = $request->getPost('tradtional_id');
        } else {
            $tradtionalId = 0;
        }

        $traditionalList = $this->getAllTable()->getTraditionalList();
        $traditionalSelected = $this->getAllTable()->getTraditionalSelected($id);

        if ($tradtionalId != 0) {

            $traditionalSelected = $tradtionalId;
        }

        $ritualList = $this->getAllTable()->getRitualList($traditionalSelected);

        $daysList = $this->getAllTable()->getRitualDays($ritualList['id']);

        return new ViewModel(array(
            'id' => $ritualList['id'], 'daysList' => $daysList, 'ritualList' => $ritualList, 'traditionalList' => $traditionalList, 'selected' => $traditionalSelected
        ));
    }

    public function gotraAction() {

        $gotraList = $this->getAllTable()->getGothras();

        return new ViewModel(array(
            'gotraList' => $gotraList
        ));
    }
    public function protectsAction() {

        $protectList = $this->getAllTable()->getProtects();
        $id = (int) $this->params()->fromRoute('id', 0);

        
        return new ViewModel(array(
            'protectList' => $protectList,'id'=>$id
        ));
    }

    public function hinduismAction() {

        $hindusimsList = $this->getAllTable()->getHindusims();

        return new ViewModel(array(
            'hindusimsList' => $hindusimsList
        ));
    }  
    

    public function protectfilterAction() {

        return new ViewModel();
    } 


//    public function hinduismdetailAction() {
//
//        $hindusimsListdetail = $this->getAllTable()->getHindusimsdetail();
//
//        return new ViewModel(array(
//            'hindusimsListdetail' => $hindusimsListdetail
//        ));
//    }

    public function editRitualsAction() {

        $request = $this->getRequest();
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($request->isPost()) {
            $tradtionalId = $request->getPost('tradtional_id');
        } else {
            $tradtionalId = 0;
        }

        $traditionalList = $this->getAllTable()->getTraditionalList();
        $traditionalSelected = $this->getAllTable()->getTraditionalSelected($id);

        if ($tradtionalId != 0) {

            $traditionalSelected = $tradtionalId;
        }

        $ritualList = $this->getAllTable()->getRitualList($traditionalSelected);

        $daysList = $this->getAllTable()->getRitualDays($ritualList['id']);

        if ($request->isPost() && $tradtionalId == 0) {

            $this->getAllTable()->saveDays($request->getPost());

            // Redirect to list of cms
            return $this->redirect()->toRoute('cremation-plans', array('action' => 'rituals'));
        }

        return new ViewModel(array(
            'daysList' => $daysList, 'ritualList' => $ritualList, 'traditionalList' => $traditionalList, 'selected' => $traditionalSelected
        ));
    }

    public function productsAction() {


        $request = $this->getRequest();
        $id = (int) $this->params()->fromRoute('id', 0);
        $name = $request->getPost('name');

        $find = array('id' => $id, 'name' => $name);

        $productList = $this->getAllTable()->getProductList($id, $name);
        $category = $this->getAllTable()->getCategoryBy($id);
        $productCategory = $this->getAllTable()->getPurchase();

        return new ViewModel(array(
            'productList' => $productList, 'productCategory' => $productCategory, 'find' => $find, 'category' => $category
        ));
    }

    public function paymentAction() {
//       $config = array(
//    'username'      => 'vasanth.ganes.raju-facilitator_api1.gmail.com',
//    'password'      => '1363245173',
//    'signature'     => 'Aj2IZLu5ikwGsrebE8ZLFzFNdMCMApBk005tLgFny.AXzZDb2P.V1.WH',
//    'endpoint'      => 'https://api-3t.sandbox.paypal.com/nvp' //this is sandbox endpoint
//);
        print_r($_REQUEST);
        exit;
    }

    public function getAllTable() {
        if (!$this->allTable) {
            $sm = $this->getServiceLocator();
            $this->allTable = $sm->get('CremationPlan\Model\AllTable');
        }
        return $this->allTable;
    }

      public function reviewAction() {

       $request = $this->getRequest();
        if ($request->isPost()) {

           $response = $this->getAllTable()->saveReview($request->getPost());
            
        }
          echo json_encode($response);exit;
    }
}
