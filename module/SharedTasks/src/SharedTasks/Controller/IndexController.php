<?php

namespace SharedTasks\Controller;

use Zend\View\Model\ViewModel;
use Admin\Controller\TaskController;
use Zend\Authentication\AuthenticationService;
use Admin\Form\TaskForm;

class IndexController extends TaskController {

    protected $sharedTaskTable;

    public function indexAction() {


        $auth = new AuthenticationService();

        if ($auth->hasIdentity()) {

            $userId = $auth->getIdentity();
        } else {

            $userId = 0;
            return $this->redirect()->toRoute('zfcuser/login');
        }

        $form = new TaskForm();

        $id = (int) $this->params()->fromRoute('id', 0);
        $type = $this->params()->fromRoute('type');


        $categories = $this->getCategoryTable()->getCategoriesByType('task');


        $sharedTasks = $this->getSharedTable()->fetchAll($type, $id, $userId);


        // grab the paginator from the AlbumTable
        $tasks = $this->getTaskTable()->fetchAll(true);
        // set the current page to what has been passed in query string, or to 1 if none set
        $tasks->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        // set the number of items per page to 10
        $tasks->setItemCountPerPage();

        $userList = $this->getSharedTable()->fetchUsers();

        $sharedWithme = $this->getSharedTable()->sharedWithme($userId);
//echo '<pre>';print_r($sharedWithme);die;
        $shareList = $this->getSharedTable()->getShares($userId);

        $loggedList = $this->getSharedTable()->loggedUsers($userId);
		$profiles = $this->getSharedTable()->fetchObituary($userId);

        // grab the paginator from the AlbumTable
        $events = $this->getTaskTable()->fetchAll(true);
        // set the current page to what has been passed in query string, or to 1 if none set
        $events->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        // set the number of items per page to 10
        $events->setItemCountPerPage();

        return new ViewModel(array(
            'tasks' => $tasks, 'profiles'=>$profiles,'form' => $form, 'sharedTasks' => $sharedTasks, 'loggedList' => $loggedList,
            'events' => $events, 'categories' => $categories, 'userid' => $userId, 'userList' => $userList,
            'shareList' => $shareList, 'sharedWithme' => $sharedWithme,'type'=>$type,'id'=>$id
        ));
    }

    public function addtaskAction() {

        $request = $this->getRequest();
        if ($request->isPost()) {

            $this->getSharedTable()->saveTask($request->getPost());
            $data = 'true';
        }
        return $this->getResponse()->setContent(json_encode($data));
    }

    public function obituarytasksAction() {

        $data = array();
        $request = $this->getRequest();
        if ($request->isPost()) {

            $data = $this->getSharedTable()->fetchDeathUser($request->getPost('user_id'));
        }
        
        echo  '<option value="">Select</option>';

        foreach ($data as $option) {

            echo $option = '<option value="' . $option['id'] . '">' . $option['name'] . '</option>';
        }

        exit;
    }

    public function memoralizetasksAction() {

        $data = array();
        $request = $this->getRequest();
        if ($request->isPost()) {

            $data = $this->getSharedTable()->fetchMemoralize($request->getPost('user_id'));
        }

        echo  '<option value="">Select</option>';
        foreach ($data as $option) {

            echo $option = '<option value="' . $option['id'] . '">' . $option['name'] . '</option>';
        }

        exit;
    }

    public function addAction() {
       
        
        $request = $this->getRequest();
        $taskId = $request->getPost('task_id');
        $user_id = $request->getPost('user_id');
        $type = $request->getPost('type');
       $profile = $request->getPost('profile');
        
        $obituaryId =0;
        $memoralizeId = 0;

        if($type=='obituary'){
            $obituaryId = $profile;
        }
        if($type=='memoralize'){
            $memoralizeId = $profile;
        }
        $auth = new AuthenticationService();

        if ($auth->hasIdentity() && $user_id == 0) {

            $userId = $auth->getIdentity();
        } else {

            $userId = $user_id;
        }
        $date = date('Y-m-d');
        $time = date('H:i:s');
        $data = array(
            'id' => 0,
            'task_id' => $taskId,
            'obituary_id' => $obituaryId,
            'memoralize_id' => $memoralizeId,
            'due_date' => $date,
            'due_time' => $time,
            'fre' => 0,
            'priority' => 1,
            'status' => "pending",
            'notes' => "",
            'user_id' => $userId,
            'assigned_to' => $userId,
        );

        
        $this->getSharedTable()->savesharedTask($data);

        return $this->getResponse()->setContent(json_encode($data));
    }

    public function editAction() {

        $request = $this->getRequest();
      
        $data = $request->getPost();
       
        $this->getSharedTable()->updateTask($data);
            
       
        return $this->getResponse()->setContent(json_encode($data));
    }

    public function usersAction() {

        $userList = $this->getSharedTable()->fetchUsers();

        return $this->getResponse()->setContent(json_encode($userList));
    }

    public function getSharedTable() {
        if (!$this->sharedTaskTable) {
            $sm = $this->getServiceLocator();
            $this->sharedTaskTable = $sm->get('SharedTasks\Model\SharedTask');
        }
        return $this->sharedTaskTable;
    }

    public function deleteAction() {


        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('sharedtasks');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getSharedTable()->deleteTask($id, null);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('sharedtasks');
        }

        return array(
            'id' => $id,
            'tasks' => $this->getSharedTable()->getTask($id)
        );
    }

    public function shareAction() {

        $request = $this->getRequest();
        if ($request->isPost()) {
            $userId = $request->getPost('user_id');
            $id = $request->getPost('id');

            $level = $request->getPost('level');

            if ($id == '') {

                $uri = $this->getRequest()->getUri();
                $base = sprintf('%s://%s', $uri->getScheme(), $uri->getHost());
                $basePath = $base . $this->getRequest()->getBasePath();


                $data = array(
                    'owner_id' => $userId,
                    'users' => $request->getPost('users'),
                    'level' => $level,
                    'base' => $basePath
                );
              
            } else {
                parse_str($request->getPost('id'), $id);
                $data = array(
                    'id' => $id
                );
            }
           
            if(isset($data['users']) && is_array($data['users']) && count($data['users'])<=0){
              return $this->redirect()->toRoute('sharedtasks');
            }
            
            $this->getSharedTable()->saveUsers($data);
            $reponse = 'true';
        }
        return $this->getResponse()->setContent(json_encode($reponse));
    }

    public function deletesharesAction() {

        $request = $this->getRequest();
        $id = (int) $request->getPost('id');
        $this->getSharedTable()->deleteShare($id);
        $reponse = 'true';
        return $this->getResponse()->setContent(json_encode($reponse));
    }

    public function deletetaskAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('sharedtasks');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getTaskTable()->deleteTask($id);
                $this->getSharedTable()->deleteTask(null, $id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('sharedtasks');
        }

        return array(
            'id' => $id,
            'tasks' => $this->getTaskTable()->getTask($id)
        );
    }

    public function sharestateAction() {

        $id = $this->params()->fromRoute('id');

        $this->getSharedTable()->shareState($id);

        return $this->redirect()->toRoute('sharedtasks');
    }
    
    public function updatelavelAction() {

        $auth = new AuthenticationService();

        if ($auth->hasIdentity()) {

            $ownerId = $auth->getIdentity();
        } else {

            $ownerId = 0;
           
            }
        $request = $this->getRequest();
        if ($request->isPost()) {
           
            $userId = $request->getPost('userid');
           
            $level = $request->getPost('level');
            
            $reponse = $this->getSharedTable()->shareLevel($level,$ownerId,$userId);
        }
        return $this->getResponse()->setContent(json_encode($reponse));
    }

}