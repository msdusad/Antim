<?php

namespace SharedTasks\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class SharedTask implements InputFilterAwareInterface {

    public $id;
    
    public $due_date;
    public $due_time;
    public $fre;
    public $priority;
    public $status;
    public $notes;
    public $task_id;
    public $user_id;
    public $obituary_id;
    public $memoralize_id;
    public $userName;
    public $task;
    public $category;
    public $assigned_to;
 
    
    protected $inputFilter;

    public function exchangeArray($data) {

        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->task_id = (isset($data['task_id'])) ? $data['task_id'] : null;
        $this->task = (isset($data['task'])) ? $data['task'] : null;
        $this->due_date = (isset($data['due_date'])) ? $data['due_date'] : null;
        $this->due_time = (isset($data['due_time'])) ? $data['due_time'] : null;
        $this->fre = (isset($data['fre'])) ? $data['fre'] : null;
        $this->priority = (isset($data['priority'])) ? $data['priority'] : null;
        $this->status = (isset($data['status'])) ? $data['status'] : null;
        $this->fre = (isset($data['fre'])) ? $data['fre'] : null;
        $this->notes = (isset($data['notes'])) ? $data['notes'] : null;
        $this->obituary_id = (isset($data['obituary_id'])) ? $data['obituary_id'] : null;
        $this->user_id = (isset($data['user_id'])) ? $data['user_id'] : null;
        $this->memoralize_id = (isset($data['memoralize_id'])) ? $data['memoralize_id'] : null;
        $this->userName = (isset($data['userName'])) ? $data['userName'] : null;
        $this->category = (isset($data['category'])) ? $data['category'] : null;
        $this->assigned_to = (isset($data['assigned_to'])) ? $data['assigned_to'] : null;
        
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
                        'name' => 'artist',
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

            $inputFilter->add($factory->createInput(array(
                        'name' => 'title',
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