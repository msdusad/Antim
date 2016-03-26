<?php

namespace Memoralize\Form;


use Zend\Form\Form;

class Infos extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('memoralize_infos');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
         $this->add(array(
            'name' => 'memoralize_id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
          $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'description',
            'options' => array(
                'label' => 'Profile Description',
            ),
            'attributes' => array(                
                'class' => 'form-control',
                'id' =>'description'
            ),
        ));     
        $this->add(array(
            'name' => 'first_name',
            'attributes' => array(
                'type'  => 'text',
                 'class' => 'form-control',
                 'id' =>'first_name'
            ),
            'options' => array(
                'label' => 'First Name',
            ),
        ));
        $this->add(array(
            'name' => 'middle_name',
            'attributes' => array(
                'type'  => 'text',
                 'class' => 'form-control',
                 'id' =>'middle_name'                
            ),
            'options' => array(
                'label' => 'Middle Name',
            ),           
        ));
        $this->add(array(
            'name' => 'last_name',
            'attributes' => array(
                'type'  => 'text',
                 'class' => 'form-control',
                 'id' =>'last_name'                
            ),
            'options' => array(
                'label' => 'Last Name',
            ),           
        ));
        $this->add(array(
            'name' => 'dob',
            'attributes' => array(
                'type'  => 'text',
                 'class' => 'form-control dp',
                 'id' =>'dob',
                 'placeholder' => 'Date of Birth'
            ),           
        ));
        $this->add(array(
            'name' => 'age',
            'attributes' => array(
                'type'  => 'text',
                 'class' => 'form-control timepicker-default clear',
                 'id' =>'age',
                 'placeholder' => 'Age'
            ),
                      
        ));
        $this->add(array(
            'name' => 'death_place',
            'attributes' => array(
                'type'  => 'text',
                 'class' => 'form-control',
                 'id' =>'death_place'
            ),
            'options' => array(
                'label' => 'Death Place',
            ),             
        ));
        
          $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'education',
            'options' => array(
                'label' => 'Education',
            ),
            'attributes' => array(                
                'class' => 'form-control',
                'id' =>'education'
            ),
        ));
          $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'family',
            'options' => array(
                'label' => 'Family',
            ),
            'attributes' => array(                
                'class' => 'form-control',
                'id' =>'family'
            ),
        ));
           $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'tributes',
            'options' => array(
                'label' => 'Tributes',
            ),
            'attributes' => array(                
                'class' => 'form-control',
                'id' =>'tributes'
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'privacy',
            'options' => array(
                'label' => 'Privacy',
            ),
            'attributes' => array(                
                'class' => 'form-control',
                'id' =>'privacy'
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'guest_book',
            'options' => array(
                'label' => 'Guest Book',
            ),
            'attributes' => array(                
                'class' => 'form-control',
                'id' =>'guest_book'
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Add',
                'id' => 'submitbutton',
                'class'=>'btn btn-lg btn-primary btn-block',
            ),
        ));
    }
}