<?php

namespace Mailbox\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class AdminMail implements InputFilterAwareInterface
{
    public $admin_email_id;
    public $parent_id;
    public $sender;
	public $reciever;
    public $subject;
    public $body;
    public $view;
    public $status;
    public $deleted;
    public $created;

    protected $inputFilter;

    /**
     * Used by ResultSet to pass each database row to the entity
     */
    public function exchangeArray($data)
    {
        $this->admin_email_id      = (isset($data['admin_email_id'])) ? $data['admin_email_id'] : null;
        $this->parent_id           = (isset($data['parent_id'])) ? $data['parent_id'] : null;
        $this->sender              = (isset($data['sender'])) ? $data['sender'] : null;
        $this->reciever            = (isset($data['reciever'])) ? $data['reciever'] : null;
        $this->subject             = (isset($data['subject'])) ? $data['subject'] : null;
        $this->body                = (isset($data['body'])) ? $data['body'] : null;
		$this->view                = (isset($data['view'])) ? $data['view'] : null;
		$this->status              = (isset($data['status'])) ? $data['status'] : null;
        $this->deleted             = (isset($data['deleted'])) ? $data['deleted'] : null;
        $this->created             = (isset($data['created'])) ? $data['created'] : null;
        
        
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $factory = new InputFactory();

           

            $inputFilter->add($factory->createInput(array(
                'name'     => 'reciver',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                   
                ),
            )));
            $inputFilter->add($factory->createInput(array(
                'name'     => 'subject',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                   
                ),
            )));
            $inputFilter->add($factory->createInput(array(
                'name'     => 'body',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                   
                ),
            )));
            
            
            $this->inputFilter = $inputFilter;        
        }

        return $this->inputFilter;
    }
    
    
}
