<?php

namespace Obituary\Form;

use Zend\Form\Form;

class Obituary extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('obituary');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'user_id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'status',
            'attributes' => array(
                'type' => 'hidden',
            )
        ));
        $this->add(array(
            'name' => 'created_by',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'created_by'
            ),
            'options' => array(
                'label' => 'Name',
            ),
        ));
        
          $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'relation',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'sorting',
                'options' => array(                    
                    'husband' => 'Husband',
                    'wife' => 'Wife',
                    'son' => 'Son',                    
                    'daughter' => 'Daughter',
                    'brother' => 'Brother',
                    'sister' =>'Sister',
                    'cousinbrother' =>'Cousin Brother',
                    'cousinsister' =>'Cousin Sister'                    
                ),
            ),'options' => array(
                'label' => 'Relation',
            ),
            
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Add Details',
                'id' => 'submitbutton',
                'class' => 'btn btn-lg  btn-block',
            ),
        ));
    }

}