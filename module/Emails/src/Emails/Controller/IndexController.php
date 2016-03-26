<?php

namespace Emails\Controller;

use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail as SendmailTransport;
use ScnSocialAuth\Controller\ContactsController;
use Zend\View\Model\ViewModel;
use Emails\Model\Emails;
use Emails\Form\EmailsForm;
use Zend\Session\Container;
use Zend\Validator\EmailAddress;

class IndexController extends ContactsController {

    protected $emailsTable;

    /**
     * @var Email_Message
     */
    protected $emailMessage;

    /**
     * @var Email_Message
     */
    protected $templateTable;

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
                    $paginator = $this->getEmailsTable()->multiInboxDelete($ids);
                    $this->flashMessenger()->addMessage('Email deleted successfully');
                    break;
                default :
                    break;
            }
            return $this->redirect()->toRoute('inbox');
        }
        $sm = $this->getServiceLocator();
        $service = $sm->get('zfcuser_user_service');
        $email = $service->getAuthService()->getIdentity()->getEmail();
        // grab the paginator from the AlbumTable
        $paginator = $this->getEmailsTable()->fetchAll(true, $email);
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        // set the number of items per page to 10
        $paginator->setItemCountPerPage();

        return new ViewModel(array(
            'paginator' => $paginator, 'message' => $message
        ));
    }

    public function sentitemsAction() {

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
                    $paginator = $this->getEmailsTable()->multiSentDelete($ids);
                    $this->flashMessenger()->addMessage('Email deleted successfully');
                    break;
                default :
                    break;
            }
            return $this->redirect()->toRoute('sent-items');
        }
        $sm = $this->getServiceLocator();
        $service = $sm->get('zfcuser_user_service');
        $id = $service->getAuthService()->getIdentity()->getId();
        // grab the paginator from the AlbumTable
        $paginator = $this->getEmailsTable()->sentItems(true, $id);
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        // set the number of items per page to 10
        $paginator->setItemCountPerPage();

        return new ViewModel(array(
            'paginator' => $paginator, 'message' => $message
        ));
    }

    public function composeAction() {


        $groupId = (int) $this->params()->fromRoute('id', 0);
        $share = $this->params()->fromRoute('share', '');
        $request = $this->getRequest();

        $templates = $this->getTemplatesTable()->getTemplates();

        if ($request->isPost() && $share != '') {

            $subject = $request->getPost('subject');
            $message = $request->getPost('msg');
            $url = $request->getPost('url');
            
            $fullUrl = "http://".$_SERVER['HTTP_HOST'].$url;
            
            $email_session = new Container('email');
            if ($subject != '') {
                $email_session->subject = $subject;
            }
             $message = '<p>'.$message.'</p>';
            if($url!=''){
               
                $message .= '<a href='.$fullUrl.'>please click this url</a>';
            }
           
            if ($message != '') {
                $email_session->message = $message;
            }
        }
        $emailList = $this->getEmailsTable()->getEmails($groupId);

        $contacts = $this->getContacts();
        
        //print_r($contacts);die;

        $sm = $this->getServiceLocator();
        $service = $sm->get('zfcuser_user_service');
        $id = $service->getAuthService()->getIdentity()->getId();

        $form = new EmailsForm();

        if (isset($email_session->subject) && $email_session->subject != '') {

            $form->get('subject')->setValue($email_session->subject);
        }
        if (isset($email_session->message) && $email_session->message != '') {

            $form->get('message')->setValue($email_session->message);
        }

        if (count($emailList) > 0) {

            $emails = implode(',', $emailList);

            $form->get('to_id')->setAttribute('value', $emails);

            //$this->flashMessenger()->addMessage('Group contacts added');
        }

        $form->get('submit')->setValue('Send');
        $form->get('to_id')->setAttribute('class', 'form-control contactimport');
        $form->get('from_id')->setAttribute('value', $id);

        if ($request->isPost() && $share == '') {

            $emails = new Emails();
            $form->setInputFilter($emails->getInputFilter());
            $form->setData($request->getPost());

            $validator = new EmailAddress();

            $emailValues = explode(',', $request->getPost('to_id'));
            foreach ($emailValues as $email) {
                if ($validator->isValid(trim($email))) {
                    
                } else {

                    foreach ($validator->getMessages() as $error) {
                       $message[] = $email . ' ' . $error ;
                    }
                    return array('form' => $form, 'templates' => $templates, 'contacts' => $contacts['contacts'], 'providers' => $contacts['providers'], 'message' => $message);
                }
            }
            if ($form->isValid()) {
                $emails->exchangeArray($form->getData()); 
                
                $this->getEmailsTable()->saveEmail($emails);
                $from = $service->getAuthService()->getIdentity()->getEmail();                
              
                $this->sendMail($emails->message, $emails->subject, $from, $emails->to_id);

                $this->flashMessenger()->addMessage('Email sent successfully');

                // Redirect to list of albums
                return $this->redirect()->toRoute('inbox');
            }
        }
         
        $flashMessenger = $this->flashMessenger();

        if ($flashMessenger->hasMessages()) {

            $message = $flashMessenger->getMessages();
        } else {

            $message = '';
        }
        return array('form' => $form, 'templates' => $templates, 'contacts' => $contacts['contacts'], 'providers' => $contacts['providers'], 'message' => $message);
    }

    public function replyAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('compose-mail');
        }
        $email = $this->getEmailsTable()->getEmail($id);

        $sm = $this->getServiceLocator();
        $service = $sm->get('zfcuser_user_service');
        $fromId = $service->getAuthService()->getIdentity()->getId();

        $replyedEmail = $this->getEmailsTable()->getReplies($fromId);

        $form = new EmailsForm();

        $form->get('submit')->setAttribute('value', 'Reply');
        $form->get('to_id')->setAttribute('value', $email['from_id']);
         $form->get('to_id')->setAttribute('readonly', 'readonly');
        $form->get('subject')->setAttribute('value', $email['subject']);
        $form->get('from_id')->setAttribute('value', $fromId);
        $form->get('id')->setAttribute('value', $id);

        $request = $this->getRequest();
        $emails = new Emails();
        if ($request->isPost()) {
            
            $form->setInputFilter($emails->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $emails->exchangeArray($form->getData());
                $this->getEmailsTable()->saveEmail($emails);

                $from = $service->getAuthService()->getIdentity()->getEmail();
                $this->sendMail($emails['message'], $emails['subject'], $from, $emails['from_id']);

                $this->flashMessenger()->addMessage('Reply mail sent successfully');
                // Redirect to list of albums
                return $this->redirect()->toRoute('inbox');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
            'replyedEmails' => $replyedEmail
        );
    }

    public function maildetailAction() {


        $id = (int) $this->params()->fromRoute('id', 0);
        $title = $this->params()->fromRoute('title', '');

        if (!$id) {
            return $this->redirect()->toRoute('inbox');
        }
        $emailDetails = $this->getEmailsTable()->getEmail($id);

        $title = $emailDetails['subject'];
        return array('id' => $id, 'emailDetails' => $emailDetails, 'title' => $title);
    }

    public function forwardAction() {

        $contacts = $this->getContacts();

        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('compose-mail');
        }
        $email = $this->getEmailsTable()->getEmail($id);

        $sm = $this->getServiceLocator();
        $service = $sm->get('zfcuser_user_service');
        $fromId = $service->getAuthService()->getIdentity()->getId();

        $form = new EmailsForm();

        $form->get('submit')->setAttribute('value', 'Forward');
        $form->get('to_id')->setAttribute('value', $email['to_id']);
        $form->get('subject')->setAttribute('value', $email['subject']);
        $form->get('message')->setAttribute('value', $email['message']);
        $form->get('from_id')->setAttribute('value', $fromId);
        $form->get('id')->setAttribute('value', $id);

        $request = $this->getRequest();
        $emails = new Emails();
        if ($request->isPost()) {
            $form->setInputFilter($emails->getInputFilter());
            $form->setData($request->getPost());
            
             $validator = new EmailAddress();

            $emailValues = explode(',', $request->getPost('to_id'));
            foreach ($emailValues as $email) {
                if ($validator->isValid(trim($email))) {
                    
                } else {

                    foreach ($validator->getMessages() as $error) {
                       $message[] = $email . ' ' . $error ;
                    }
                     return array('id' => $id, 'form' => $form, 'contacts' => $contacts['contacts'], 'providers' => $contacts['providers'],'message'=>$message);
                }
            }

            if ($form->isValid()) {
                $emails->exchangeArray($form->getData());
                $this->getEmailsTable()->saveEmail($emails);

                $from = $service->getAuthService()->getIdentity()->getEmail();
                $this->sendMail($email['message'], $email['subject'], $from, $email['to_id']);

                $this->flashMessenger()->addMessage('Mail forwarded successfully');
                // Redirect to list of albums
                return $this->redirect()->toRoute('inbox');
            }
        }

        return array('id' => $id, 'form' => $form, 'contacts' => $contacts['contacts'], 'providers' => $contacts['providers']);
    }

    public function getEmailsTable() {
        if (!$this->emailsTable) {
            $sm = $this->getServiceLocator();
            $this->emailsTable = $sm->get('Emails\Model\EmailsTable');
        }
        return $this->emailsTable;
    }

    public function getContacts() {

        $hybridAuth = $this->getHybridAuth();
       
        $providers = $hybridAuth->getConnectedProviders();
        $userProfile = array();
        foreach ($providers as $provider) {
            if ($provider != 'LinkedIn') {
                if ($hybridAuth->isConnectedWith($provider)) {

                    $adapter = $hybridAuth->authenticate($provider); 

                   
                    $userProfile[] = $adapter->getUserContacts();
                }
            }
        }
     
        //$userProfile['identifier'].'@facebook.com';;
        $result = array();
        $rows = count($userProfile);
        if ($rows > 0) {
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
        }
        return array('contacts' => $result, 'providers' => $providers);
    }

    function sendMail($textBody, $subject, $from, $to) {

        $toMails = explode(',', $to);


        foreach ($toMails as $subscriber) {

            $emailMessage = new Message();             
            $html = new \Zend\Mime\Part($textBody);
            $html->type = 'text/html';
            $body = new \Zend\Mime\Message;
            $body->setParts(array($html));
            
            $emailMessage->setEncoding('utf-8')->addFrom($from, '')
                    ->addTo($subscriber)
                    ->setSubject($subject)
                    ->setBody($body);
            
            $transport = new SendmailTransport();
            $transport->send($emailMessage);
        }
        return true;
    }

    public function getTemplatesTable() {
        if (!$this->templateTable) {
            $sm = $this->getServiceLocator();
            $this->templateTable = $sm->get('Admin\Model\EmailTable');
        }
        return $this->templateTable;
    }

}