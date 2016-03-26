<?php

namespace Shopping\Form;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Hostname as HostnameValidator;

class ItemFilter extends InputFilter
{   
    public function __construct()
    {
        $this->add(array(
            'name' => 'category_id',
            'required' => true, 
        ));
       $this->add(array(
            'name' => 'title',
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
       
       $this->add(array(
            'name' => 'price',
            'required' => true,
            'filters' => array(array('name' => 'StringTrim')),
            
        ));
        
       
    }

  
}