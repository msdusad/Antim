<?php

namespace Memoralize\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Memoralize\Mapper\MemoralizeInterface;

class DonationController extends AbstractActionController {

    /**
     * @var MediaInterface
     */
    protected $mapper;

    public function indexAction() {

        $request = $this->getRequest();
        $id = (int) $this->params()->fromRoute('id', 0);
        $name = $request->getPost('name');

        $search = array('id' => $id, 'name' => $name);

        $donationCategory = $this->getMapper()->getDonationCategory();
        $donationList = $this->getMapper()->getDonationList($id, $name);

        return new ViewModel(array(
            'donationCategory' => $donationCategory, 'donationList' => $donationList, 'search' => $search
        ));
    }

    public function donateAction() {

        $request = $this->getRequest();
        $id = (int) $this->params()->fromRoute('id', 0);
        $name = $request->getPost('name');

        $search = array('id' => $id, 'name' => $name);

        $donationCategory = $this->getMapper()->getDonationCategory();


        return new ViewModel(array(
            'donationCategory' => $donationCategory, 'search' => $search
        ));
    }

    public function listAction() {

        $request = $this->getRequest();
        $id = $request->getPost('id');

        $donationCategory = $this->getMapper()->getDonationList($id, '');

        $result = '';
        foreach ($donationCategory as $key => $value) {
            $result .= '<option value="' . $value['id'] . '" data-price="' . $value['amount'] . '">' . $value['name'] . '</option>';
        }

        echo $result;
        exit;
    }

    public function priceAction() {

        $request = $this->getRequest();
        $id = $request->getPost('id');
        $donation = $this->getMapper()->getDonation($id, '');

        $result['price'] = '<option value="' . $donation->amount . '">' . $donation->amount . '</option>';
        $result['image'] = $donation->photo;

        echo json_encode($result);
        exit;
    }

    /**
     * set mapper
     *
     * @param  MemoralizeInterface $mapper
     * @return dbmapper
     */
    public function setMapper(MemoralizeInterface $mapper) {
        $this->mapper = $mapper;

        return $this;
    }

    /**
     * get mapper
     *
     * @return MemoralizeInterface
     */
    public function getMapper() {
        if (!$this->mapper instanceof MemoralizeInterface) {

            $this->setMapper($this->getServiceLocator()->get('MemoralizeMapper'));
        }
        return $this->mapper;
    }

}
