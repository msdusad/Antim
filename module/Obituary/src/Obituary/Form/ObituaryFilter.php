<?php

namespace Obituary\Form;
use Zend\InputFilter\InputFilter;

class ObituaryFilter extends InputFilter
{
   
    public function __construct()
    {
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
            'name' => 'relation',
            'required' => true            
        ));
    }

  
}