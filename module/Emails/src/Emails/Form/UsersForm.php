<?php
namespace Emails\Form;

use Zend\Form\Form;

class UsersForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('email_group_users');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
     
         $this->add(array(
            'name' => 'group_id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'identity',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control',
                'id' => 'identity'
            ),
            'options' => array(
                'label' => 'Email Id',
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