<?php

namespace Shopping\Form;

use Zend\Form\Form;

class Item extends Form {

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
            'name' => 'category_id',
            'attributes' => array(
                'id' => 'parent_id',
                 'class' => 'form-control',
            ),
           'options' => array(
                'label' => 'Main Category',                
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
                'label' => 'Product Description',
            ),
            'attributes' => array(                
                'class' => 'form-control',
                'id' =>'description'
            ),
        ));  
        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'address',
            'options' => array(
                'label' => 'Shop Address',
            ),
            'attributes' => array(                
                'class' => 'form-control',
                'id' =>'address'
            ),
        ));  
        
        $this->add(array(
            'name' => 'price',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Price','label_attributes' => array(
            'class'  => 'required'
        ),
            ),
        ));
        $this->add(array(
            'name' => 'url',
            'attributes' => array(
                'type' => 'Url',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Product Url'
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