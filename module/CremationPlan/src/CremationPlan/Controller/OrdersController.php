<?php

namespace CremationPlan\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class OrdersController extends AbstractActionController {

    protected $productTable;

    public function indexAction() {

        $categories = $this->getProductTable()->getCategories();

        $request = $this->getRequest();
        if ($request->isPost()) {

            $action = $request->getPost('action');

            $categoryId = $request->getPost('category_id');

            if ($categoryId != '') {

                //$this->layout('layout/admin');
                // grab the paginator from the AlbumTable
                $paginator = $this->getProductTable()->fetchOrders(true, $categoryId);
                // set the current page to what has been passed in query string, or to 1 if none set
                $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
                // set the number of items per page to 10
                $paginator->setItemCountPerPage();

                return new ViewModel(array(
                    'paginator' => $paginator, 'categories' => $categories, 'category' => $categoryId
                ));
            }

            $ids = $request->getPost('ids');

            switch ($action) {

                case 'multidelete':
                    $paginator = $this->getProductTable()->multiDeleteOrders($ids);
                    return $this->redirect()->toRoute('admin/orders');
                    break;
                default :
                    break;
            }
            //
        }

        //$this->layout('layout/admin');
        // grab the paginator from the AlbumTable
        $paginator = $this->getProductTable()->fetchOrders(true);
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        // set the number of items per page to 10
        $paginator->setItemCountPerPage();

        return new ViewModel(array(
            'paginator' => $paginator, 'categories' => $categories, 'category' => ''
        ));
    }

    public function viewAction() {

        $id = (int) $this->params()->fromRoute('id', 0);

        return array(
            'id' => $id,
            'product' => $this->getProductTable()->getOrder($id)
        );
    }

    public function orderAction() {

$config = array(
    'username'      => 'vasanth.ganes.raju-facilitator_api1.gmail.com',
    'password'      => '1363245173',
    'signature'     => 'Aj2IZLu5ikwGsrebE8ZLFzFNdMCMApBk005tLgFny.AXzZDb2P.V1.WH',
    'endpoint'      => 'https://api-3t.sandbox.paypal.com/nvp' //this is sandbox endpoint
);
                
        $paypalConfig = new \SpeckPaypal\Element\Config($config);

//set up http client
        $client = new \Zend\Http\Client;
        $client->setMethod('POST');
        $client->setAdapter(new \Zend\Http\Client\Adapter\Curl);
        $paypalRequest = new \SpeckPaypal\Service\Request;
        $paypalRequest->setClient($client);
        $paypalRequest->setConfig($paypalConfig);
        $paymentDetails = new \SpeckPaypal\Element\PaymentDetails(array(
    'amt' => '10.00'
));

$payment = new \SpeckPaypal\Request\DoDirectPayment(array('paymentDetails' => $paymentDetails));
$payment->setCardNumber('4111111111111111');
$payment->setExpirationDate('112017');
$payment->setFirstName('John');
$payment->setLastName('Canyon');
$payment->setIpAddress('255.255.255.255');
$payment->setCreditCardType('Visa');
$payment->setCvv2('123');

$address = new \SpeckPaypal\Element\Address;
$address->setStreet('27 Your Street');
$address->setStreet2('Apt 23');
$address->setCity('Some City');
$address->setState('California');
$address->setZip('92677');
$address->setCountryCode('US');
$payment->setAddress($address);

 $response = $paypalRequest->send($payment);
 echo '<pre>';print_r($response);
        exit;
    }

    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('admin/orders');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getProductTable()->deleteOrder($id);
            }

            // Redirect to list of find
            return $this->redirect()->toRoute('admin/orders');
        }

        return array(
            'id' => $id,
            'order' => $this->getProductTable()->getOrder($id)
        );
    }

    public function getProductTable() {
        if (!$this->productTable) {
            $sm = $this->getServiceLocator();
            $this->productTable = $sm->get('CremationPlan\Model\ProductTable');
        }
        return $this->productTable;
    }

}