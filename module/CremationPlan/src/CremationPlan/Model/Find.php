<?php

namespace CremationPlan\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Find implements InputFilterAwareInterface {

    public $id;
    public $category_id;
    public $name;
    public $address;
    public $phone;
    public $mobile;
    public $email;
    public $skype;
    public $languages;
    public $photo;
    protected $inputFilter;

    public function exchangeArray($data) {

        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->category_id = (isset($data['category_id'])) ? $data['category_id'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->address = (isset($data['address'])) ? $data['address'] : null;
        $this->phone = (isset($data['phone'])) ? $data['phone'] : null;
        $this->mobile = (isset($data['mobile'])) ? $data['mobile'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->skype = (isset($data['skype'])) ? $data['skype'] : null;
        $this->languages = (isset($data['languages'])) ? $data['languages'] : null;
        $this->photo = (isset($data['photo'])) ? $data['photo'] : null;
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
                        'name' => 'name',
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
                        'name' => 'email',
                        'required' => true,                        
                        'validators' => array(
                            array(
                                'name' => 'EmailAddress',                                
                            ),
                        ),
            )));
            
                        
            $inputFilter->add($factory->createInput(array(
                        'name' => 'address',
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