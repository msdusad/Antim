<?php

namespace PrePlanning\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class PrePlanning implements InputFilterAwareInterface {

    public $id;
    public $category_id;
    public $preplanning_id;
    public $title;
    public $description;
    public $url;
     
   
    protected $inputFilter;

    public function exchangeArray($data) {

        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->category_id = (isset($data['category_id'])) ? $data['category_id'] : null;
         $this->preplanning_id = (isset($data['preplanning_id'])) ? $data['preplanning_id'] : null;
        $this->title = (isset($data['title'])) ? $data['title'] : null;
        $this->description = (isset($data['description'])) ? $data['description'] : null;
        $this->url = (isset($data['url'])) ? $data['url'] : null;
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
                'name'     => 'category_id',
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
                        'name' => 'description',
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
                                ),
                            ),
                        ),
            )));
            
            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}