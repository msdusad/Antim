<?php



namespace EventCalendar\Controller;



use Zend\Mvc\Controller\AbstractActionController;

use Zend\Authentication\AuthenticationService;

use Zend\View\Model\ViewModel;

use EventCalendar\Mapper\EventsInterface;

use Zend\Form\Form;



class EventsController extends AbstractActionController {



    /**

     * @var UserProviderInterface

     */

    protected $mapper;



    /**

     * @var Form

     */

    protected $eventsForm;



    /**

     * Calendar page

     */

    public function indexAction() {



       $authService = new AuthenticationService();



        if ($authService->hasIdentity()) {



            $userId = $authService->getIdentity();

        } else {



            $userId = 0;

            return $this->redirect()->toRoute('zfcuser/login');

        }

        

        $id = (int) $this->params()->fromRoute('id', 0);

        $type = $this->params()->fromRoute('type');
        $evtdate=$this->params()->fromQuery('edate');
        if($evtdate!="") {
 		  		$edate = date("Y-m-d",strtotime($evtdate));
     	  }else {
				$edate = date("Y-m-d");    	  
     	  }

        $flashMessenger = $this->flashMessenger();



        if ($flashMessenger->hasMessages()) {



            $message = $flashMessenger->getMessages();

        } else {



            $message = '';

        }

//print_r($message);exit;

        return new ViewModel(array('message' => $message,'edate'=>$edate,'id'=>$id,'type'=>$type,'userid'=>$userId,'mapper'=>$this->getMapper()));
       // return new ViewModel(array('message' => $message,'id'=>$id,'type'=>$type,'mapper'=>$this->getMapper()));

    }

    /**

     * indian Holidays page

     */

    public function inAction() {



        $authService = $this->zfcUserAuthentication()->getAuthService();



        // If user is not logged in, redirect to login page

        if (!$authService->hasIdentity()) {

            return $this->redirect()->toRoute('zfcuser/login');

        }

        $id = (int) $this->params()->fromRoute('id', 0);

          

        $flashMessenger = $this->flashMessenger();



        if ($flashMessenger->hasMessages()) {



            $message = $flashMessenger->getMessages();

        } else {



            $message = '';

        }

        

        return new ViewModel(array('message' => $message,'id'=>$id));

    }

    /**

     * us Holidays page

     */

    public function usAction() {



        $authService = $this->zfcUserAuthentication()->getAuthService();



        // If user is not logged in, redirect to login page

        if (!$authService->hasIdentity()) {

            return $this->redirect()->toRoute('zfcuser/login');

        }

        $id = (int) $this->params()->fromRoute('id', 0);

         

        $flashMessenger = $this->flashMessenger();



        if ($flashMessenger->hasMessages()) {



            $message = $flashMessenger->getMessages();

        } else {



            $message = '';

        }

        

        return new ViewModel(array('message' => $message,'id'=>$id));

    }



    /**

     * set mapper

     *

     * @param  UserProviderInterface $mapper

     * @return HybridAuth

     */

    public function setMapper(EventsInterface $mapper) {

        $this->mapper = $mapper;



        return $this;

    }



    /**

     * get mapper

     *

     * @return UserProviderInterface

     */

    public function getMapper() {

        if (!$this->mapper instanceof EventsInterface) {



            $this->setMapper($this->getServiceLocator()->get('EventsMapper'));

        }



        return $this->mapper;

    }



    public function eventsAction() {



        $id = (int) $this->params()->fromRoute('id', 0);



        $events = $this->getMapper()->findEvents($id);



        $jsonEvent = array();



        foreach ($events as $key => $event) {



            $jsonEvent[$key] = $event;

            $jsonEvent[$key]['start'] = date('Y-m-d', strtotime($event['start'])) . 'T' . date('h:i:s', strtotime($event['start'])) . '+04:00';

            $jsonEvent[$key]['end'] = date('Y-m-d', strtotime($event['end'])) . 'T' . date('h:i:s', strtotime($event['end'])) . '+04:00';

            $jsonEvent[$key]['url'] = $this->request->getBasePath() . '/events/edit/' . $event['id'];

            $jsonEvent[$key]['allDay'] = false;

        }



        echo json_encode($jsonEvent);





        exit;

    }
/*
    public function eventsviewAction() {



        $id = (int) $this->params()->fromRoute('id', 0);



        $events = $this->getMapper()->findEvents($id);



        $jsonEvent = array();



        foreach ($events as $key => $event) {



            $jsonEvent[$key] = $event;

            $jsonEvent[$key]['start'] = date('Y-m-d', strtotime($event['start'])) . 'T' . date('h:i:s', strtotime($event['start'])) . '+04:00';

            $jsonEvent[$key]['end'] = date('Y-m-d', strtotime($event['end'])) . 'T' . date('h:i:s', strtotime($event['end'])) . '+04:00';

            $jsonEvent[$key]['url'] = $this->request->getBasePath() . '/memoralize/event/' . $event['id'];

            $jsonEvent[$key]['allDay'] = false;

        }



        echo json_encode($jsonEvent);





        exit;

    }*/
public function eventsviewAction() {

        $id = (int) $this->params()->fromQuery('id');
        $events = $this->getMapper()->getEvents($id);
        return new ViewModel(array('id'=>$id,'event'=>$events));


    }


    public function addAction() {
        $form = $this->getEventsForm();
        $id = (int) $this->params()->fromRoute('id', 0);
        $type = $this->params()->fromRoute('type');
        $request = $this->getRequest();
        if ($request->isPost()) {
        		$authService = new AuthenticationService();
        		if ($authService->hasIdentity()) {
           		$userId = $authService->getIdentity();
        		} else {
         		 $userId = 0;
         		 return $this->redirect()->toRoute('zfcuser/login');
        		}
            $data = $request->getPost();
				//print_r($data);exit;
				$data['user_id']=$userId;
            $data['start'] = $data['start_time'];
            $data['end'] = $data['end_time'];
           	$eDate = date('Y-m-d', strtotime($data['edate']));
            $data['edate'] = $eDate;
	         // $data['edate'] = $eDate;
	         $id = $data['profile_id'];
            $type = $data['profile_type'];
            if($data['profile_type']=='obituary'){
                $data['obituary_id'] = $data['profile_id'];
                $data['name']="";
                $data['memoralize_id'] = 0;
            }else if($data['profile_type']=='memoralize'){
                $data['memoralize_id'] = $data['profile_id'];
                $data['name']="";
                $data['obituary_id'] = 0;
            }else{
            	 $data['name'] = $data['profile_id'];
					 $data['memoralize_id'] = 0;
					 $data['obituary_id'] = 0;
				}
            unset($data['profile_id']);
            //unset($data['profile_type']);
				//print_r($data);exit;
            $this->getMapper()->save($data);
            $this->flashMessenger()->addMessage('Events added successfully');
            // Redirect to list of connections
            return $this->redirect()->toRoute('event-calendar-events');
        }
      //return new ViewModel(array('form' => $form,'type'=> $type, 'id'=> $id,'userid'=>$userId));
		return new ViewModel(array('form' => $form,'type'=> $type, 'id'=> $id));
    }



    public function editAction() {





        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {

            return $this->redirect()->toRoute('event-calendar-events');

        }



        $event = $this->getMapper()->findEventById($id);



        $form = $this->getEventsForm();



        $form->get('title')->setAttribute('value', $event->title);

        $form->get('start')->setAttribute('value', $event->start);

        $form->get('start_time')->setAttribute('value', $event->start_time);

     

        $form->get('content')->setAttribute('value', $event->content);

        $form->get('user_id')->setAttribute('value', $event->user_id);

        $form->get('id')->setAttribute('value', $event->id);

        $form->get('submit')->setAttribute('value', 'Save');

        

        $request = $this->getRequest();

        if ($request->isPost()) {

            $data = $request->getPost();

            $combined_start = $data['start'] . ' ' . $data['start_time'];

            $startDate = date('Y-m-d h:i:s', strtotime($combined_start));

            $orgData['start'] = $startDate;

            $orgData['title'] = $data['title'];

            $orgData['content'] = $data['content'];

            $orgData['user_id'] = $data['user_id'];

             $orgData['id'] = $data['id'];

           



            $form->setData($orgData);



            if ($form->isValid()) {  

                $this->getMapper()->save($form->getData());



                $this->flashMessenger()->addMessage('Event updated successfully');

                // Redirect to list of albums

                return $this->redirect()->toRoute('event-calendar-events');

            }

        }

        return array('id' => $id, 'form' => $form);

    }

  



    public function getEventsForm() {

        if (!$this->eventsForm) {

            $this->setEventsForm($this->getServiceLocator()->get('events-form'));

        }

        return $this->eventsForm;

    }



    public function setEventsForm(Form $eventsForm) {

        $this->eventsForm = $eventsForm;

        $this->flashMessenger()->setNamespace('events-form')->getMessages();

        return $this;

    }



}

