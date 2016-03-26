<?php

namespace CremationPlan\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use CremationPlan\Model\Product;
use CremationPlan\Form\ProductForm;
use Zend\Validator\File\Size;


class ProductController extends AbstractActionController {

    protected $productTable;

    public function indexAction() {

        $this->layout()->setTemplate('layout/admin');
        $categories = $this->getProductTable()->getCategories();

        $request = $this->getRequest();
        if ($request->isPost()) {
            
            $action = $request->getPost('action');
           
            $categoryId = $request->getPost('category_id');

            if ($categoryId != '') {

                //$this->layout('layout/admin');
                // grab the paginator from the AlbumTable
                $paginator = $this->getProductTable()->fetchAll(true, $categoryId);
                // set the current page to what has been passed in query string, or to 1 if none set
                $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
                // set the number of items per page to 10
                $paginator->setItemCountPerPage();

                return new ViewModel(array(
                    'paginator' => $paginator, 'categories' => $categories,'category'=>$categoryId
                ));
            }

            $ids = $request->getPost('ids');

            switch ($action) {

                case 'multidelete':
                    $paginator = $this->getProductTable()->multiDelete($ids);
                    return $this->redirect()->toRoute('admin/products');
                    break;
                default :
                    break;
            }
            //
        }

        //$this->layout('layout/admin');
        // grab the paginator from the AlbumTable
        $paginator = $this->getProductTable()->fetchAll(true);
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
        // set the number of items per page to 10
        $paginator->setItemCountPerPage();

        return new ViewModel(array(
            'paginator' => $paginator, 'categories' => $categories,'category'=>''
        ));
    }
   

    public function addAction() {

        $this->layout()->setTemplate('layout/admin');
        $form = new ProductForm();
        $form->get('submit')->setValue('Add');
        $categories = $this->getProductTable()->getCategories();

        $form->get('category_id')->setAttributes(array('options' => $categories));

        $request = $this->getRequest();
        if ($request->isPost()) {
            $product = new Product();
            $form->setInputFilter($product->getInputFilter());

            $nonFile = $request->getPost()->toArray();
            $File = $this->params()->fromFiles('product_image');
            $data = array_merge(
                    $nonFile, //POST 
                    array('product_image' => $File['name']) //FILE...
            );

            $form->setData($data);

            if ($form->isValid()) {

                $size = new Size(array('min' => 20000)); //minimum bytes filesize

                $adapter = new \Zend\File\Transfer\Adapter\Http();
                $adapter->setValidators(array($size), $File['name']);
                if (!$adapter->isValid()) {
                    $dataError = $adapter->getMessages();
                    $error = array();
                    foreach ($dataError as $key => $row) {
                        $error[] = $row;
                    }

                    $form->setMessages(array('fileupload' => $error));

                    $product->exchangeArray($form->getData());

                    $this->getProductTable()->saveProduct($product);
                } else {
                    $dirName = dirname(__DIR__) . '/../../assets/product';
                    $adapter->setDestination($dirName);
                    if ($adapter->receive($File['name'])) {

                        $product->exchangeArray($form->getData());

                        $id = $this->getProductTable()->saveProduct($product);

                        $thumbnailer = $this->getServiceLocator()->get('WebinoImageThumb');
                        $thumb = $thumbnailer->create($dirName . '/' . $data['product_image'], $options = array());

                        $thumb->resize(72, 72);

                        //$thumb->show();
                        // or/and
                        $thumb->save($dirName . '/thumb/' . $id . '_' . $data['product_image']);
                    }
                }
                return $this->redirect()->toRoute('admin/products');
            }
        }
        return array('form' => $form);
    }

    public function editAction() {
        $this->layout()->setTemplate('layout/admin');
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('products', array(
                        'action' => 'add'
            ));
        }
        $product = $this->getProductTable()->getProduct($id);
        $productClass = new Product();
        $form = new ProductForm();
        $form->bind($product);
        $form->get('submit')->setAttribute('value', 'Edit');
        $categories = $this->getProductTable()->getCategories();

        $form->get('category_id')->setAttributes(array('options' => $categories));
        $request = $this->getRequest();
        if ($request->isPost()) {

            $form->setInputFilter($productClass->getInputFilter());

            $nonFile = $request->getPost()->toArray();
            $File = $this->params()->fromFiles('product_image');
            $data = array_merge(
                    $nonFile, //POST 
                    array('product_image' => $File['name']) //FILE...
            );

            $form->setData($data);

            if ($form->isValid()) {

                $size = new Size(array('min' => 20000)); //minimum bytes filesize

                $adapter = new \Zend\File\Transfer\Adapter\Http();
                $adapter->setValidators(array($size), $File['name']);
                if (!$adapter->isValid()) {
                    $dataError = $adapter->getMessages();
                    $error = array();
                    foreach ($dataError as $key => $row) {
                        $error[] = $row;
                    }
                    unset($data['product_image']);

                    $productClass->exchangeArray($data);

                    $this->getProductTable()->saveProduct($productClass);

                    $form->setMessages(array('fileupload' => $error));
                } else {
                    $dirName = dirname(__DIR__) . '/../../assets/product';
                    $adapter->setDestination($dirName);
                    if ($adapter->receive($File['name'])) {

                        $productClass->exchangeArray($data);

                        $this->getProductTable()->saveProduct($productClass);

                        $thumbnailer = $this->getServiceLocator()->get('WebinoImageThumb');
                        $thumb = $thumbnailer->create($dirName . '/' . $data['product_image'], $options = array());

                        $thumb->resize(72, 72);

                        //$thumb->show();
                        // or/and
                        $thumb->save($dirName . '/thumb/' . $data['id'] . '_' . $data['product_image']);
                    }
                }
                return $this->redirect()->toRoute('admin/products');
            }
        }

        return array(
            'product' => $product,
            'form' => $form,
        );
    }

    public function deleteAction() {
        $this->layout()->setTemplate('layout/admin');
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('admin/products');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getProductTable()->deleteProduct($id);
            }

            // Redirect to list of find
            return $this->redirect()->toRoute('admin/products');
        }

        return array(
            'id' => $id,
            'product' => $this->getProductTable()->getProduct($id)
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