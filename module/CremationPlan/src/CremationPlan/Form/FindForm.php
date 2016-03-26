<?php

namespace CremationPlan\Form;

use Zend\Form\Form;


class FindForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('find');
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
            'name' => 'name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Name','label_attributes' => array(
            'class'  => 'required'
        ),
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'address',
            'options' => array(
                'label' => 'Address','label_attributes' => array(
            'class'  => 'required'
        ),
            ),
            'attributes' => array(
                'class' => 'form-control',
            ),
        ));
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Email Address','label_attributes' => array(
            'class'  => 'required'
        ),
            ),
        ));
        $this->add(array(
            'name' => 'phone',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Phone',
            ),
        ));
        
        $this->add(array(
            'name' => 'mobile',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Mobile',
            ),
        ));
         $this->add(array(
            'name' => 'skype',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Skype Id',
            ),
        ));
          $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'languages',
            'attributes' => array(
                'multiple' => 'multiple',
                'id' => 'languages',
                 'class' => 'form-control',
            ),
           'options' => array(
                'label' => 'Languages',                
            ),
            
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\File',
            'name' => 'photo',
            'options' => array(
                'label' => 'Photo',
            ),
            'attributes' => array(
                'id' => 'photo',
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