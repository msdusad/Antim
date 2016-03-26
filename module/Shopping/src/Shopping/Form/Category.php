<?php

namespace Shopping\Form;

use Zend\Form\Form;

class Category extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('shopping_category');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'parent_id',
            'attributes' => array(
                'id' => 'parent_id',
                 'class' => 'form-control',
            ),
           'options' => array(
                'label' => 'Category',                
            ),
            
        ));
        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Title','label_attributes' => array(
            'class'  => 'required'
        ),
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Add Details',
                'id' => 'submitbutton',
                'class' => 'btn btn-lg btn-primary btn-block',
            ),
        ));
    }

}