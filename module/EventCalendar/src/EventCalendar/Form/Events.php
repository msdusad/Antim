<?php

namespace EventCalendar\Form;


use Zend\Form\Form;

class Events extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('event_list');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        
               
        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type'  => 'text',
                 'class' => 'form-control',
                 'id' =>'title'
            ),
            'options' => array(
                'label' => 'Title',
            ),
        ));
        $this->add(array(
            'name' => 'edate',
            'attributes' => array(
                'type'  => 'text',
                 'class' => 'form-control dp ',
                 'id' =>'dp1',
                'placeholder' => 'dd/mm/yyyy'
            ),
            'options' => array(
                'label' => 'Date',
            ),
            
        ));
		 
        $this->add(array(
            'name' => 'start_time',
            'attributes' => array(
                'type'  => 'text',
                 'class' => 'form-control timepicker-default',
                 'id' =>'start_time'
            ),
            'options' => array(
                'label' => 'Start Time',
				'class' => 'start-date-cls'
            ),           
        ));
		
		$this->add(array(
            'name' => 'end_time',
            'attributes' => array(
                'type'  => 'text',
                 'class' => 'form-control timepicker-default ',
                 'id' =>'end_time'
            ),
            'options' => array(
                'label' => 'End Time',
                'class' => 'start-date-cls'
            ),           
        ));
			$this->add(array(
            'name' => 'location',
            'attributes' => array(
                'type'  => 'text',
                 'class' => 'form-control',
                 'id' =>'location'
            ),
            'options' => array(
                'label' => 'Location',
            ),           
        ));
			$this->add(array(
            'name' => 'contact',
            'attributes' => array(
                'type'  => 'text',
                 'class' => 'form-control',
                 'id' =>'contact'
            ),
            'options' => array(
                'label' => 'Contact',
            ),           
        ));
       
          $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'content',
            'options' => array(
                'label' => 'Content',
            ),
            'attributes' => array(                
                'class' => 'form-control',
                'id' =>'nicedit'
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