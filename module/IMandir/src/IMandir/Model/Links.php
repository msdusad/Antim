<?php

namespace IMandir\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Links implements InputFilterAwareInterface {

    public $id;
    public $category;
    public $preplanning_id;
    public $title;  
    public $url;
    public $created_at;
     
   
    protected $inputFilter;

    public function exchangeArray($data) {

        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->category = (isset($data['category'])) ? $data['category'] : null;
         $this->preplanning_id = (isset($data['preplanning_id'])) ? $data['preplanning_id'] : null;
        $this->title = (isset($data['title'])) ? $data['title'] : null;
        $this->url = (isset($data['url'])) ? $data['url'] : null;
        $this->created_at = (isset($data['created_at'])) ? $data['created_at'] : null;
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
                'name'     => 'category',
                'filters' => array(
                            array('name' => 'Null'),
                        ),
                
            )));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'title',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min' => 1,
                                    'max' => 100,
                                ),
                            ),
                        ),
            )));
            
            
                        
            $inputFilter->add($factory->createInput(array(
                        'name' => 'url',
                        'required' => true,
                       
            )));
            
            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}