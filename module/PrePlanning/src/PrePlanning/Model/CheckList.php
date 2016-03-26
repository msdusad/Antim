<?php

namespace PrePlanning\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class CheckList implements InputFilterAwareInterface {

    public $id;
    public $title;  
    public $preplanning_id;     
    protected $inputFilter;

    public function exchangeArray($data) {

        $this->id = (isset($data['id'])) ? $data['id'] : null;        
        $this->title = (isset($data['title'])) ? $data['title'] : null;      
        $this->preplanning_id = (isset($data['preplanning_id'])) ? $data['preplanning_id'] : null;
        
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
             $inputFilter->add($factory->createInput(array(
                        'name' => 'title',
                        'required' => true
            )));   


            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}