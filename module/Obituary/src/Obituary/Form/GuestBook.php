<?php

namespace Obituary\Form;


use Zend\Form\Form;

class GuestBook extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('obituary_infos');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'user_id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
         $this->add(array(
            'name' => 'obituary_id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
          $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'description',
            'options' => array(
                'label' => 'Your Message',
            ),
            'attributes' => array(                
                'class' => 'form-control',
                'id' =>'description'
            ),
        ));     
               
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Add Details',
                'id' => 'submitbutton',
                'class'=>'btn btn-lg  btn-block',
            ),
        ));
    }
}