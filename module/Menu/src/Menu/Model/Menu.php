<?php

namespace Menu\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Menu implements InputFilterAwareInterface
{
    public $menu_id;
    public $label;
    public $name;
	public $route;
    public $action;
    public $alias;
    public $order;
    public $status;
    public $type;
	public $deleted;	
    public $created;

	
    protected $inputFilter;

    /**
     * Used by ResultSet to pass each database row to the entity
     */
    public function exchangeArray($data)
    {
        $this->menu_id        = (isset($data['menu_id'])) ? $data['menu_id'] : null;
		$this->label          = (isset($data['label'])) ? $data['label'] : null;
		$this->name           = (isset($data['name'])) ? $data['name'] : null;
		$this->route          = (isset($data['route'])) ? $data['route'] : null;	
        $this->action         = (isset($data['action'])) ? $data['action'] : null;
        $this->alias          = (isset($data['alias'])) ? $data['alias'] : null;
        $this->order          = (isset($data['order'])) ? $data['order'] : null;
        $this->type           = (isset($data['type'])) ? $data['type'] : null;
		$this->status         = (isset($data['status'])) ? $data['status'] : null;
		$this->deleted        = (isset($data['deleted'])) ? $data['deleted'] : null;		
		$this->created        = (isset($data['created'])) ? $data['created'] : null;
		
    }

    public function getArrayCopy($data)
    {
        return get_object_vars($data);
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

				
          $inputFilter->add(
                $factory->createInput(array(
                    'name'     => 'label',
                    'required' => true,
                ))
            );
            $inputFilter->add(
                $factory->createInput(array(
                    'name'     => 'name',
                    'required' => true,
                ))
            );

            $this->inputFilter = $inputFilter;        
        }

        return $this->inputFilter;
    }
}
