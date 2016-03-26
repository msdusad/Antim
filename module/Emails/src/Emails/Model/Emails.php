<?php

namespace Emails\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


class Emails implements InputFilterAwareInterface {

    public $id;
    public $to_id;
    public $from_id;
    public $subject;
    public $message;
    public $sent_item;
    public $inbox_item;
    public $email;
    public $user;
    public $created_date;
    protected $inputFilter;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->to_id = (isset($data['to_id'])) ? $data['to_id'] : null;
        $this->from_id = (isset($data['from_id'])) ? $data['from_id'] : null;
        $this->subject = (isset($data['subject'])) ? $data['subject'] : null;
        $this->message = (isset($data['message'])) ? $data['message'] : null;
        $this->sent_item = (isset($data['sent_item'])) ? $data['sent_item'] : null;
        $this->inbox_item = (isset($data['inbox_item'])) ? $data['inbox_item'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->user = (isset($data['user'])) ? $data['user'] : null;
       $this->created_date = (isset($data['created_date'])) ? $data['created_date'] : null;
    }

    // Add the following method:
    public function getArrayCopy() {
        return get_object_vars($this);
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                        'name' => 'id',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'Int'),
                        ),
            )));
            $inputFilter->add($factory->createInput(array(
                        'name' => 'from_id',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'Int'),
                        ),
            )));
            $inputFilter->add($factory->createInput(array(
                        'name' => 'to_id',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        )
            )));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'subject',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min' => 1,
                                    'max' => 100,
                                ),
                            ),
                        ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}