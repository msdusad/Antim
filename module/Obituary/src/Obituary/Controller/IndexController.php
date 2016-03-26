<?php



namespace Obituary\Controller;



use Zend\Mvc\Controller\AbstractActionController;

use Zend\Authentication\AuthenticationService;

use Zend\View\Model\ViewModel;

use Obituary\Mapper\ObituaryInterface;

use Obituary\Mapper\InfosInterface;

use Obituary\Mapper\MediaInterface;

use EventCalendar\Mapper\EventsInterface;

use Zend\Form\Form;

use Obituary\Form\Infos;



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

     * @var obituaryMapper

     */

    protected $obituaryMapper;



    /**

     * @var obituaryMapper

     */

    protected $eventMapper;



    /**

     * @var sharedTaskMapper

     */

    protected $sharedTaskMapper;



    /**

     * @var Form

     */

    protected $obituaryForm;

    

    /**

     * @var Form

     */

    protected $guestbookForm;



    /**

     * display page

     */

    public function indexAction() {



        $auth = new AuthenticationService();

        if ($auth->hasIdentity()) {



            $userId = $auth->getIdentity();

        } else {

		
      //print_r($oblist);exit;
            $userId = 0;

            return $this->redirect()->toRoute('viewobituary');
			//return $this->redirect()->toRoute('zfcuser/login');

        }

        $id = (int) $this->params()->fromRoute('id', 0);

       

        $flashMessenger = $this->flashMessenger();



        if ($flashMessenger->hasMessages()) {



            $message = $flashMessenger->getMessages();

        } else {



            $message = '';

        }

        if($id==0 ){

            

            $obituary = $this->getObituaryMapper()->getObituaries($userId);

           

            if($obituary){

            $id = $obituary->id;

            }           

        }



        $images = $this->getMediaMapper()->getMimages($id);

        $media = $this->getMediaMapper()->getMedia($id);

        $obituary = $this->getObituaryMapper()->getObituary($id);

        

        $garlands = $this->getMediaMapper()->getGarlands();

         

        $info = $this->getInfoseMapper()->findInfos($id); 

       

        $events = $this->getEventMapper()->findEvents($id, 'obituary');



        $profileList = $this->getSharedMapper()->fetchObituary($userId);

        

        $updates = $this->getSharedMapper()->fetchUpdates($userId);

        

        $guestBooks = $this->getObituaryMapper()->fetchGuestBooks($id);

        

        $tributes = $this->getObituaryMapper()->fetchTributes($id);
        
        $privacy = $this->getObituaryMapper()->fetchPrivacy($id);
		//print_r($privacy);exit;
      

        $dates = array();

      

        foreach ($events as $event) {           

            $date = date('Y ,n ,j', strtotime($event['start']));            

            $dates[$date] = $event['title'];

        }

      

        $alerts = array();

        foreach ($events as $event) {

            $date = strtotime($event['start']);

          if($date > time() + 86400) {$alerts[$event['start']] = $event['title'];}

            

        }



        $sharedTasks = $this->getSharedMapper()->getSharedDocument('obituary', $id, $userId);



        $sm = $this->getServiceLocator();

        $service = $sm->get('zfcuser_user_service');

        $userId = $service->getAuthService()->getIdentity()->getId();

        

        $infoform = new Infos();

        

        

        if($id!=0){           

             $editDatas = $this->getInfoseMapper()->findInfoByObituary($id);  

            

             $infoform->get('obituary_id')->setAttributes(array('value' => $editDatas->obituary_id));

             $infoform->get('id')->setAttributes(array('value' => $id));

             $infoform->get('first_name')->setAttributes(array('value' => $editDatas->first_name));

             $infoform->get('middle_name')->setAttributes(array('value' => $editDatas->middle_name));

             $infoform->get('last_name')->setAttributes(array('value' => $editDatas->last_name));

             $infoform->get('dob')->setAttributes(array('value' => $editDatas->dob));

             $infoform->get('dod')->setAttributes(array('value' => $editDatas->dod));

             $infoform->get('age')->setAttributes(array('value' => $editDatas->age));

             $infoform->get('death_place')->setAttributes(array('value' => $editDatas->death_place)); 

             $infoform->get('school')->setAttributes(array('value' => $editDatas->school));  

             $infoform->get('ug')->setAttributes(array('value' => $editDatas->ug));  

             $infoform->get('ug_specialization')->setAttributes(array('value' => $editDatas->ug_specialization));  

             $infoform->get('pg')->setAttributes(array('value' => $editDatas->pg));  

             $infoform->get('pg_specialization')->setAttributes(array('value' => $editDatas->pg_specialization));

             $infoform->get('family')->setAttributes(array('value' => $editDatas->family));

             $infoform->get('tributes')->setAttributes(array('value' => $editDatas->tributes));            

             $infoform->get('description')->setAttributes(array('value' => $editDatas->description)); 

             $infoform->get('submit')->setAttributes(array('value' => 'Save')); 

        }

         $request = $this->getRequest();

        if ($request->isPost()) {



            $name = $request->getPost('name');

            $obituary = $this->getSharedMapper()->searchObituary($name);

            if (count($obituary) > 0) {

                return $this->redirect()->toRoute('obituary', array('id' => $obituary['id']));

            } else {

                

                $this->flashMessenger()->addMessage('Obituaries not available in the name of '.$name);

                return $this->redirect()->toRoute('search');

            }

        }



        return new ViewModel(array('userid' => $userId, 'message' => $message, 'media' => $media, 'info' => $info, 'images' => $images,

            'obituary' => $obituary,  'events' => $events, 'id' => $id,'sharedTasks' => $sharedTasks, 'dates' => json_encode($dates), 'profileList' => $profileList,'updates'=>$updates,'alerts'=>$alerts,'infoform'=>$infoform,'garlands'=>$garlands,'guestBooks'=>$guestBooks,'tributes'=>$tributes,'privacy'=>$privacy));

    }


public function viewobituaryAction(){
	
        $auth = new AuthenticationService();

        if ($auth->hasIdentity()) {



            $userId = 20;

        } else {

		
      //print_r($oblist);exit;
            $userId = 20;

           // return $this->redirect()->toRoute('viewobituary');
			//return $this->redirect()->toRoute('zfcuser/login');

        }

        $id = (int) $this->params()->fromRoute('id', 0);

       

        $flashMessenger = $this->flashMessenger();



        if ($flashMessenger->hasMessages()) {



            $message = $flashMessenger->getMessages();

        } else {



            $message = '';

        }

        if($id==0 ){

            

            $obituary = $this->getObituaryMapper()->fetchObituaries();

           

            if($obituary){

            $id = $obituary->id;

            }           

        }



        $images = $this->getMediaMapper()->getMimages($id);

        $media = $this->getMediaMapper()->getMedia($id);

        $obituary = $this->getObituaryMapper()->getObituary($id);

        

        $garlands = $this->getMediaMapper()->getGarlands();

         

        $info = $this->getInfoseMapper()->findInfos($id); 

       

        $events = $this->getEventMapper()->findEvents($id, 'obituary');



        $profileList = $this->getSharedMapper()->getObituary();

        

        $updates = $this->getSharedMapper()->getUpdates();

        

        $guestBooks = $this->getObituaryMapper()->fetchGuestBooks($id);

        

        $tributes = $this->getObituaryMapper()->fetchTributes($id);
        
        $privacy = $this->getObituaryMapper()->fetchPrivacy($id);
		//print_r($privacy);exit;
      

        $dates = array();

      

        foreach ($events as $event) {           

            $date = date('Y ,n ,j', strtotime($event['start']));            

            $dates[$date] = $event['title'];

        }

      

        $alerts = array();

        foreach ($events as $event) {

            $date = strtotime($event['start']);

          if($date > time() + 86400) {$alerts[$event['start']] = $event['title'];}

            

        }



        $sharedTasks = $this->getSharedMapper()->fetchSharedDocument('obituary', $id);



        $sm = $this->getServiceLocator();

        $service = $sm->get('zfcuser_user_service');

        //$userId = $service->getAuthService()->getIdentity()->getId();

        

        $infoform = new Infos();

        

        

        if($id!=0){           

             $editDatas = $this->getInfoseMapper()->findInfoByObituary($id);  

            

             $infoform->get('obituary_id')->setAttributes(array('value' => $editDatas->obituary_id));

             $infoform->get('id')->setAttributes(array('value' => $id));

             $infoform->get('first_name')->setAttributes(array('value' => $editDatas->first_name));

             $infoform->get('middle_name')->setAttributes(array('value' => $editDatas->middle_name));

             $infoform->get('last_name')->setAttributes(array('value' => $editDatas->last_name));

             $infoform->get('dob')->setAttributes(array('value' => $editDatas->dob));

             $infoform->get('dod')->setAttributes(array('value' => $editDatas->dod));

             $infoform->get('age')->setAttributes(array('value' => $editDatas->age));

             $infoform->get('death_place')->setAttributes(array('value' => $editDatas->death_place)); 

             $infoform->get('school')->setAttributes(array('value' => $editDatas->school));  

             $infoform->get('ug')->setAttributes(array('value' => $editDatas->ug));  

             $infoform->get('ug_specialization')->setAttributes(array('value' => $editDatas->ug_specialization));  

             $infoform->get('pg')->setAttributes(array('value' => $editDatas->pg));  

             $infoform->get('pg_specialization')->setAttributes(array('value' => $editDatas->pg_specialization));

             $infoform->get('family')->setAttributes(array('value' => $editDatas->family));

             $infoform->get('tributes')->setAttributes(array('value' => $editDatas->tributes));            

             $infoform->get('description')->setAttributes(array('value' => $editDatas->description)); 

             $infoform->get('submit')->setAttributes(array('value' => 'Save')); 

        }

         $request = $this->getRequest();

        if ($request->isPost()) {



            $name = $request->getPost('name');

            $obituary = $this->getSharedMapper()->searchObituary($name);

            if (count($obituary) > 0) {

                return $this->redirect()->toRoute('obituary', array('id' => $obituary['id']));

            } else {

                

                $this->flashMessenger()->addMessage('Obituaries not available in the name of '.$name);

                return $this->redirect()->toRoute('search');

            }

        }

	 
	 return new ViewModel(array( 'message' => $message, 'media' => $media, 'info' => $info, 'images' => $images,

            'obituary' => $obituary,  'events' => $events, 'id' => $id,'sharedTasks' => $sharedTasks, 'dates' => json_encode($dates)

            , 'profileList' => $profileList,'updates'=>$updates,'alerts'=>$alerts,'infoform'=>$infoform,'garlands'=>$garlands,'guestBooks'=>$guestBooks,'tributes'=>$tributes,'privacy'=>$privacy));
}
   

    /**

     * display page

     */

    public function createAction() {



        $step = $this->params()->fromRoute('step', 0);

        $id = (int) $this->params()->fromRoute('id', 0);



        $auth = new AuthenticationService();



        if ($auth->hasIdentity()) {



            $userId = $auth->getIdentity();

        } else {



            $userId = 0;

        }

        $request = $this->getRequest();

        $profile = '';



        $profileList = $this->getSharedMapper()->fetchObituary($userId);

        $drafts = $this->getInfoseMapper()->getdrafts($userId);

        $obituary = $this->getObituaryMapper()->getObituary($id);

       

        if(count($obituary)>0 && isset($obituary->status) && $obituary->status==2){

           

            $draftSteps = $obituary->status;

        

            

        }else{

              $draftSteps = 0;

        }

     

        $flashMessenger = $this->flashMessenger();



        if ($flashMessenger->hasMessages()) {



            $message = $flashMessenger->getMessages();

        } else {



            $message = '';

        }

        if ($request->isPost()) {



            $profile = $request->getPost('profile');

            $obituary = $this->getSharedMapper()->searchObituary($profile);

            if (count($obituary) > 0) {

                return $this->redirect()->toRoute('obituary', array('id' => $obituary['id']));

            } else {

                $message[0] = 'Recent documents not available';

                return array('draftSteps'=>$draftSteps,'message' => $message, 'profile' => $profile, 'step' => $step, 'id' => $id, 'profileList' => $profileList,'drafts'=>$drafts);

            }

        }

        return new ViewModel(array('draftSteps'=>$draftSteps,'message' => $message, 'profile' => $profile, 'step' => $step, 'id' => $id, 'profileList' => $profileList,'drafts'=>$drafts));

    }



      public function draftAction() {

           

          $id = (int) $this->params()->fromRoute('id', 0);

         

          $this->getObituaryMapper()->updateDraft($id);

          

          $response['message'] = 'sucess';

          echo json_encode($response);exit;


      }

      public function publishAction() {

           

          $id = (int) $this->params()->fromRoute('id', 0);

         

          $this->getObituaryMapper()->publish($id);

        

          return $this->redirect()->toRoute('obituary', array('id' => $id));



      }

       public function publishShareAction() {

           

          $id = (int) $this->params()->fromRoute('id', 0);

         

          $this->getObituaryMapper()->publish($id);

          

           $info = $this->getInfoseMapper()->findInfos($id);       

          

          $response['message'] = strip_tags($info->description);

          $response['subject'] = 'Obituary - '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;

          echo json_encode($response);exit;



      }

       public function createdbyAction(){

    

           $request = $this->getRequest();

           if ($request->isPost()) {



                $data = $request->getPost();



                $this->getObituaryMapper()->saveCreatedBy($data);

                $string = 'sucess';



                echo json_encode($string);

                exit;

            }

      }

    /**

     * delete profile

     */

    public function deleteAction() {



        $auth = new AuthenticationService();



        if ($auth->hasIdentity()) {



            $userId = $auth->getIdentity();

        } else {



            $userId = 0;

        }

        $id = (int) $this->params()->fromRoute('id', 0);



        $this->getObituaryMapper()->delete($id);



        $data = $this->getSharedMapper()->fetchObituary($userId);



        $rows = array();



        if (count($data) > 0) {



            foreach ($data as $val) {

                $rows['id'] = $val['id'];

            }

        }

        $this->flashMessenger()->addMessage('Profile deleted successfully');

                  

        return $this->redirect()->toRoute('obituary');

        

    }

        

    /**

     * display page

     */

    public function guestbookAction() {



         $request = $this->getRequest();

           if ($request->isPost()) {



                $data = $request->getPost();

               

                $this->getObituaryMapper()->saveGuestBook($data);

                $string = 'sucess';



                echo json_encode($string);

                exit;

            }       

    }

    /**

     * display page

     */

    public function guestbookdeleteAction() {



         $request = $this->getRequest();

           if ($request->isPost()) {



                $data = $request->getPost();

               

                $this->getObituaryMapper()->deleteGuestBook($data);

                $string = 'sucess';



                echo json_encode($string);

                exit;

            }       

    }

        

    /**

     * display page

     */

    public function tributesAction() {



         $request = $this->getRequest();

           if ($request->isPost()) {



                $data = $request->getPost();

               

                $this->getObituaryMapper()->saveTributes($data);

                $string = 'sucess';



                echo json_encode($string);

                exit;

            }       

    }
 /**

     * display page

     */

    public function privacyAction() {



         $request = $this->getRequest();

           if ($request->isPost()) {



                $data = $request->getPost();

               

                $this->getObituaryMapper()->savePrivacy($data);

                $string = 'sucess';



                echo json_encode($string);

                exit;

            }       

    }
     /**

     * display page

     */

    public function tributesdeleteAction() {



         $request = $this->getRequest();

           if ($request->isPost()) {



                $data = $request->getPost();

               

                $this->getObituaryMapper()->deleteTributes($data);

                $string = 'sucess';



                echo json_encode($string);

                exit;

            }       

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

     * @param  ObituaryInterface $mapper

     * @return dbmapper

     */

    public function setObituaryMapper(ObituaryInterface $mapper) {



        $this->obituaryMapper = $mapper;



        return $this;

    }



    /**

     * get mapper

     *

     * @return ObituaryInterface

     */

    public function getObituaryMapper() {

        if (!$this->obituaryMapper instanceof ObituaryInterface) {



            $this->setObituaryMapper($this->getServiceLocator()->get('ObituaryMapper'));

        }

        return $this->obituaryMapper;

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



    public function getSharedMapper() {

        if (!$this->sharedTaskMapper) {

            $sm = $this->getServiceLocator();

            $this->sharedTaskMapper = $sm->get('SharedTasks\Model\SharedTask');

        }

        return $this->sharedTaskMapper;

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

        if (!$this->obituaryForm) {

            $this->setForm($this->getServiceLocator()->get('main-form'));

        }

        return $this->obituaryForm;

    }



    public function setForm(Form $obituaryForm) {

        $this->obituaryForm = $obituaryForm;

        $this->flashMessenger()->setNamespace('main-form')->getMessages();

        return $this;

    }

}

