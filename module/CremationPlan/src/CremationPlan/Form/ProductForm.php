<?php

namespace CremationPlan\Form;

use Zend\Form\Form;


class ProductForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('product');
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
                'label' => 'Product Title',
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
            ),
        ));
        
        $this->add(array(
            'name' => 'sku',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Sku',
            ),
        ));
        $this->add(array(
            'name' => 'price',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Price',
            ),
        ));
        $this->add(array(
            'name' => 'quantity',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Available Quantity',
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\File',
            'name' => 'product_image',
            'options' => array(
                'label' => 'Product Image',
            ),
            'attributes' => array(
                'id' => 'product_image',
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