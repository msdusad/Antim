<?php

namespace IMandir\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use IMandir\Model\IMandir;
use IMandir\Model\Forms;
use IMandir\Model\CheckList;
use IMandir\Form\Upload;
use IMandir\Form\CheckListForm;
use Zend\Validator\File\Size;
use Zend\Validator\File\Extension;

class IMandirController extends AbstractActionController {

    /**
     * @var IMandirTable
     */
    protected $imandirTable;

    /**
     * @var formsTable
     */
    protected $formsTable;

    /**
     * @var checklistTable
     */
    protected $checklistTable;

    public function indexAction() {

        $this->layout()->setTemplate('layout/admin');

       

        return new ViewModel();
    }

   

}