<?php

namespace Obituary\Form;

use Zend\InputFilter\InputFilter;

class GuestBookFilter extends InputFilter {

    protected $emailValidator;
    protected $usernameValidator;

    /**
     * @var RegistrationOptionsInterface
     */
    protected $options;

    public function __construct() {

        $this->add(array(
            'name' => 'description',
            'required' => true,
            'filters' => array(array('name' => 'StringTrim')),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 10,
                        'max' => 1000,
                    ),
                ),
            ),
        ));
          
    }

}