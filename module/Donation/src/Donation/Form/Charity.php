<?php

namespace Donation\Form;

use Zend\Form\Form;

class Charity extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('donation_charity');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
       $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'cause_id',
            'attributes' => array(
                'id' => 'cause_id',
                 'class' => 'form-control',
            ),
           'options' => array(
                'label' => 'Cause',                
            ),
            
        ));
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Charity Name','label_attributes' => array(
            'class'  => 'required'
        ),
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'description',
            'options' => array(
                'label' => 'About Charity',
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
                'label' => 'Charity Address',
            ),
            'attributes' => array(                
                'class' => 'form-control',
                'id' =>'address'
            ),
        ));  
         $this->add(array(
            'name' => 'contact_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Contact Name'
            ),
        ));
         $this->add(array(
            'name' => 'url',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Website Url'
            ),
        ));
       $this->add(array(
            'type' => 'Zend\Form\Element\File',
            'name' => 'photo_url',
            'options' => array(
                'label' => 'Charity Image',
            ),
            'attributes' => array(
                'id' => 'photo_url',
                'class' => '',
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