<?php
namespace Emails\Form;

use Zend\Form\Form;

class GroupsForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('email_group');
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
            'name' => 'title',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Title',
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