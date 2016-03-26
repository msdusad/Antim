<?php

namespace PrePlanning\Form;

use Zend\Form\Form;


class LinksForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct($name);
        $this->setAttribute('method', 'post');
         $this->setAttribute('enctype', 'multipart/form-data');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
         $this->add(array(
            'name' => 'preplanning_id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
         $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'category',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'category',
                'options' => array(  
                    'resource' => 'Resource',
                    'article' => 'Article', 
                    'tools' => 'Tools',                    
                ),
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
            'name' => 'url',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'URL','label_attributes' => array(
            'class'  => 'required'
        ),
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