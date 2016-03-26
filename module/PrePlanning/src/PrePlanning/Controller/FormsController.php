<?php

namespace PrePlanning\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\View\Model\ViewModel;

class FormsController extends AbstractActionController {

    /**
     * @var preplanningTable
     */
    protected $preplanningTable;

    /**
     * @var formsTable
     */
    protected $formsTable;

    /**
     * @var checklistTable
     */
    protected $checklistTable;

    /**
     * @var linksTable
     */
    protected $linksTable;

    public function FormsAction() {
		$viewob=new ViewModel();
		$viewob->forms('view/forms');
		return $viewob;
		
	}

        
}
