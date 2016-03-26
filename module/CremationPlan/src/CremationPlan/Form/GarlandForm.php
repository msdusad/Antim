<?php

namespace CremationPlan\Form;

use Zend\Form\Form;


class GarlandForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('garland');
        $this->setAttribute('method', 'post');
         $this->setAttribute('enctype', 'multipart/form-data');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\File',
            'name' => 'garland_image',
            'options' => array(
                'label' => 'Garland Image',
            ),
            'attributes' => array(
                'id' => 'garland_image',
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
                'class' => 'btn btn-lg btn-primary btn-block',
            ),
        ));
    }

}