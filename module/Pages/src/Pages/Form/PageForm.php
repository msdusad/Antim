<?php
namespace Pages\Form;

use Zend\Form\Form;

class PageForm extends Form
{
    public function __construct()
    {
        // we want to ignore the name passed
        parent::__construct('page');

        $this->setAttribute('method', 'post');
		$this->setAttribute('enctype','multipart/form-data');
		

       $this->add(array(
       		'name' => 'title',
       		'attributes' => array(
       				'type'  => 'text',
					'class' => 'form-control',
					'value' => '',
       		),
       		'options' => array(
       				'label' => '',
           
       		),
       		
       ));
	   
	   
       $this->add(array(
       		'name' => 'alias',
       		'attributes' => array(
       				'type'  => 'hidden',
					'class' => 'form-control',
					'value' => '',
					'id'  => 'alias',
       		),
       		'options' => array(
       				'label' => '',
       		),     		
       ));	 


		$this->add(array(
					'name' => 'content',
					'attributes' => array(
							'type'  => 'textarea',
							'id' => 'content',
							'class' => 'form-control',
                           
					),
					'options' => array(
							'label' => 'Contents',
					),
		
			));
			
		$this->add(array(			
		'type' => 'Zend\Form\Element\Select',
		'name' => 'status',
		 'attributes' => array(
						'class' => 'form-control',
					),
		'options' => array(
				'value_options' => array(
					'' => 'Please Select',
					'1'    	 => 'Published',
					'0'      => 'Unpublished',
					                     
				),
				'label' => '',
				)
			));			
			
			
       $this->add(array(
       		'name' => 'meta_title',
       		'attributes' => array(
       				'type'  => 'text',
					'class' => 'form-control',
					'id' => 'meta_title',
					'value' => '',
       		),
       		'options' => array(
       				'label' => ' ',
       		),
       		
       ));
	   
	   
		$this->add(array(
					'name' => 'meta_description',
					'attributes' => array(
							'type'  => 'text',
							'id' => 'meta_description',
							'class' => 'form-control',
					),
					'options' => array(
							'label' => '',
					),
		
			));



       $this->add(array(
       		'name' => 'meta_keywords',
       		'attributes' => array(
       				'type'  => 'text',
					'class' => 'form-control',
					'id' => 'meta_keywords',
					'value' => '',
       		),
       		'options' => array(
       				'label' => '',
       		),
       		
       ));	   
	   


		$this->add(array(			
        		'type' => 'Zend\Form\Element\Select',
        		'name' => 'robots',
                'attributes' => array(
						'class' => 'form-control',
					),
        		'options' => array(
        				'value_options' => array(
        					'' => 'please  Select',
        					'index'    	 => 'Index/Follow',
        					'noindex'    => 'Nonindex/Nfollow',                      
        				),
        				'label' => '',
        				)
		));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'   => 'submit',
                'value'  => 'Create',
                'id'     => 'submit',
				'class'  => 'btn btn-primary',
            ),
        ));

    }
}
