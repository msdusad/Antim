<?php

namespace Donation\Form;
use Zend\InputFilter\InputFilter;

class CauseFilter extends InputFilter
{   
    public function __construct()
    {
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
       
    }

  
}