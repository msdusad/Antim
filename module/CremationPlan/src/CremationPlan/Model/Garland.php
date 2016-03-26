<?php

namespace CremationPlan\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Garland implements InputFilterAwareInterface {

    public $id;
    public $garland_image;    
    protected $inputFilter;

    public function exchangeArray($data) {

        $this->id = (isset($data['id'])) ? $data['id'] : null;        
        $this->garland_image = (isset($data['garland_image'])) ? $data['garland_image'] : null;
        
    }

    // Add the following method:
    public function getArrayCopy() {
        return get_object_vars($this);
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                        'name' => 'id',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'Int'),
                        ),
            )));            


            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}