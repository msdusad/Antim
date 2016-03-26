<?php

namespace Donation\Form;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Hostname as HostnameValidator;

class CharityFilter extends InputFilter
{   
    public function __construct()
    {
        $this->add(array(
            'name' => 'cause_id',
            'required' => true, 
        ));
       $this->add(array(
            'name' => 'name',
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
            'name' => 'address',
            'required' => true,
            'filters' => array(array('name' => 'StringTrim')),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 3,                        
                    ),
                ),
            ),
        ));
      
        
       
    }

  
}