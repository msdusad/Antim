<?php

namespace Emails\Controller;

use ScnSocialAuth\Controller\ContactsController;
use Zend\View\Model\ViewModel;
use Emails\Model\Groups;
use Emails\Form\GroupsForm;
use Emails\Form\UsersForm;

class GroupsController extends ContactsController {

    protected $groupTable;

    public function indexAction() {

        $request = $this->getRequest();

        $flashMessenger = $this->flashMessenger();

        if ($flashMessenger->hasMessages()) {

            $message = $flashMessenger->getMessages();
        } else {

            $message = '';
        }

        if ($request->isPost()) {
            $action = $request->getPost('action');

            $ids = $request->getPost('ids');

            switch ($action) {

                case 'multidelete':
                    $paginator = $this->getGroupsTable()->multiGroupDelete($ids);
                    $this->flashMessenger()->addMessage('Groups deleted successfully');
                    break;
                default :
                    break;
            }
            return $this->redirect()->toRoute('contact-groups');
        }
        $sm = $this->getServiceLocator();
        $service = $sm->get('zfcuser_user_service');
        $id = $service->getAuthService()->getIdentity()->getId();
        // grab the paginator from the GroupsTable
        $paginator = $this->getGroupsTable()->fetchAll(true, $id);
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        // set the number of items per page to 10
        $paginator->setItemCountPerPage();

        return new ViewModel(array(
            'paginator' => $paginator, 'message' => $message
        ));
    }

    public function usersAction() {

        $id = (int) $this->params()->fromRoute('id', 0);

        $flashMessenger = $this->flashMessenger();

        if ($flashMessenger->hasMessages()) {

            $message = $flashMessenger->getMessages();
        } else {

            $message = '';
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $action = $request->getPost('action');

            $ids = $request->getPost('ids');

            switch ($action) {

                case 'multidelete':
                    $paginator = $this->getGroupsTable()->multiUserDelete($ids);
                    $this->flashMessenger()->addMessage('Contacts deleted successfully');
                    break;
                default :
                    break;
            }
            return $this->redirect()->toRoute('contact-group-users', array('id' => $id));
        }

        // grab the paginator from the AlbumTable
        $paginator = $this->getGroupsTable()->groupUsers(true, $id);
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        // set the number of items per page to 10
        $paginator->setItemCountPerPage();

        return new ViewModel(array(
            'paginator' => $paginator, 'message' => $message, 'id' => $id
        ));
    }

    public function addAction() {

        $sm = $this->getServiceLocator();
        $service = $sm->get('zfcuser_user_service');
        $id = $service->getAuthService()->getIdentity()->getId();

        $form = new GroupsForm();

        $form->get('submit')->setValue('Add');
        $form->get('user_id')->setValue($id);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $groups = new Groups();
            $form->setInputFilter($groups->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $groups->exchangeArray($form->getData());
                $this->getGroupsTable()->saveGroup($groups);

                $this->flashMessenger()->addMessage('Group added successfully');
                // Redirect to list of albums
                return $this->redirect()->toRoute('contact-groups');
            }
        }
        return array('form' => $form);
    }

    public function editAction() {
//        $sm = $this->getServiceLocator();
//        $service = $sm->get('zfcuser_user_service');
//        $userId = $service->getAuthService()->getIdentity()->getId();

        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('contact-group');
        }

        $group = $this->getGroupsTable()->getGroup($id);

        $form = new GroupsForm();

        //$form->bind($group);

        $form->get('submit')->setValue('Save');
        $form->get('title')->setValue($group->title);
        $form->get('id')->setValue($group->id);
        $form->get('user_id')->setValue($group->user_id);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $groups = new Groups();
            $form->setInputFilter($groups->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $groups->exchangeArray($form->getData());
                $this->getGroupsTable()->saveGroup($groups);

                $this->flashMessenger()->addMessage('Group added successfully');
                // Redirect to list of albums
                return $this->redirect()->toRoute('contact-groups');
            }
        }
        return array('id' => $id, 'form' => $form);
    }

    public function addusersAction() {

        $hybridAuth = $this->getHybridAuth();
        $userProfile = array();
        $providers = $hybridAuth->getConnectedProviders();
        foreach ($providers as $provider) {
          if($provider!='LinkedIn'){
            if ($hybridAuth->isConnectedWith($provider)) {

                $adapter = $hybridAuth->authenticate($provider);
                
                $userProfile[] = $adapter->getUserContacts();
                
            }
          }
        }
        if(count($userProfile)<=0){
            $userProfile[0] = '';
        }
        //$userProfile['identifier'].'@facebook.com';;
        $rows = count($userProfile);
        switch ($rows) {

            case 2:
                $result = array_merge((array) $userProfile[0], (array) $userProfile[1]);
                break;
            case 3:
                $result = array_merge((array) $userProfile[0], (array) $userProfile[1], (array) $userProfile[2]);
                break;
            case 4:
                $result = array_merge((array) $userProfile[0], (array) $userProfile[1], (array) $userProfile[2], (array) $userProfile[3]);
                break;
            default:
                $result = $userProfile[0];
                break;
        }

  
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('contact-group-users');
        }

        $form = new UsersForm();

        $form->get('submit')->setAttribute('value', 'Add');
        $form->get('group_id')->setAttribute('value', $id);

        $request = $this->getRequest();

        if ($request->isPost()) {

            $data = $request->getPost();

            $this->getGroupsTable()->saveUser($data);
            $this->flashMessenger()->addMessage('Contacts added successfully');
            // Redirect to list of albums
            return $this->redirect()->toRoute('contact-group-users', array('id' => $id));
        }

        return array(
            'id' => $id,
            'form' => $form,
            'contacts' => $result,
            'providers' => $providers,
        );
    }

    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('contact-groups');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');

                $this->getGroupsTable()->delete($id);
                $this->flashMessenger()->addMessage('Group deleted successfully');
            }

            
            // Redirect to list of albums
            return $this->redirect()->toRoute('contact-groups');
        }

        return array(
            'id' => $id,
            'group' => $this->getGroupsTable()->getGroup($id)
        );
    }

    public function getGroupsTable() {
        if (!$this->groupTable) {
            $sm = $this->getServiceLocator();
            $this->groupTable = $sm->get('Emails\Model\GroupsTable');
        }
        return $this->groupTable;
    }

}