<?php

namespace Memoralize\Form;


use Zend\Form\Form;

class Memoralize extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('memoralize');
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
            'name' => 'status',
            'attributes' => array(
                'type'  => 'hidden',                
            )
        ));
    }
}