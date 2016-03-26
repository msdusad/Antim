<?php

namespace PrePlanning\Form;

use Zend\Form\Form;


class PrePlanning extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('preplanning');
        $this->setAttribute('method', 'post');
         $this->setAttribute('enctype', 'multipart/form-data');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'category_id',
            'attributes' => array(
                'id' => 'category_id',
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
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'description',
            'options' => array(
                'label' => 'Description','label_attributes' => array(
            'class'  => 'required'
        ),
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' =>'nicedit'
            ),
        ));
        
        

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Add',
                'id' => 'submitbutton',
                'class' => 'btn btn-lg btn-primary btn-block',
            ),
        ));
    }

}