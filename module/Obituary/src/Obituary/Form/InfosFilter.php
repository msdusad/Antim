<?php

namespace Obituary\Form;

use Zend\InputFilter\InputFilter;

class InfosFilter extends InputFilter {

    protected $emailValidator;
    protected $usernameValidator;

    /**
     * @var RegistrationOptionsInterface
     */
    protected $options;

    public function __construct() {

        $this->add(array(
            'name' => 'first_name',
            'required' => true,
            'filters' => array(array('name' => 'StringTrim')),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 3,
                        'max' => 128,
                    ),
                ),
            ),
        ));


        $this->add(array(
            'name' => 'dod',
            'required' => true,
            'validators' => array(array('name' => 'date',
                    'options' => array('locale' => 'en', 'format' => 'Y-m-d'),),)
        ));
        
         $this->add(array(
            'name' => 'dob',
            'required' => true,
            'validators' => array(array('name' => 'date',
                    'options' => array('locale' => 'en', 'format' => 'Y-m-d'),),)
        ));
         
        $this->add(array(
            'name' => 'age',
            'required' => true,
            'validators' => array(array('name' => 'digits'), array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 1,
                        'max' => 3,
                    ),
                ),)
        ));
        
        $this->add(array(
            'name' => 'death_place',
            'required' => true,
            'filters' => array(array('name' => 'StringTrim')),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 3,
                        'max' => 128,
                    ),
                ),
            ),
        ));
       
            
    }

}