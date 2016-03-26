<?php

namespace Obituary\Form;

use Zend\Form\Form;

class Media extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct();
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'obituary_id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'action',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
       
        $this->add(array(
            'type' => 'Zend\Form\Element\File',
            'name' => 'media_url',
            'options' => array(
                'label' => 'Video',
            ),
            'attributes' => array(
                'id' => 'media_url',
                'class' => '',
            ),
        ));


        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Upload',
                'id' => 'submitbutton',
                'class' => 'btn btn-lg btn-default btn-sm',
            ),
        ));
    }

}