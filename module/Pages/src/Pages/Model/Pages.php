<?php

namespace Pages\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Pages implements InputFilterAwareInterface
{
    public $id;
    public $title;
    public $alias;
    public $user_id;
	public $content;
    public $state;
    public $meta_title;
    public $meta_description;
	public $meta_keywords;	
    public $robots;
    public $deleted;
    public $updated;
    public $created;

	
    protected $inputFilter;

    /**
     * Used by ResultSet to pass each database row to the entity
     */
    public function exchangeArray($data)
    {
        $this->id               = (isset($data['id'])) ? $data['id'] : null;
        $this->user_id          = (isset($data['user_id'])) ? $data['user_id'] : null;
		$this->title            = (isset($data['title'])) ? $data['title'] : null;
		$this->alias            = (isset($data['alias'])) ? $data['alias'] : null;
		$this->content          = (isset($data['content'])) ? $data['content'] : null;	
        $this->status           = (isset($data['status'])) ? $data['status'] : null;
        $this->meta_title       = (isset($data['meta_title'])) ? $data['meta_title'] : null;
		$this->meta_description = (isset($data['meta_description'])) ? $data['meta_description'] : null;
		$this->meta_keywords    = (isset($data['meta_keywords'])) ? $data['meta_keywords'] : null;		
        $this->robots           = (isset($data['robots'])) ? $data['robots'] : null;
        $this->deleted          = (isset($data['deleted'])) ? $data['deleted'] : null;
        $this->updated          = (isset($data['updated'])) ? $data['updated'] : null;
		$this->created          = (isset($data['created'])) ? $data['created'] : null;
		
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
                    'name'     => 'title',
                    'required' => true,
                ))
            );
			
						
			

            $this->inputFilter = $inputFilter;        
        }

        return $this->inputFilter;
    }
}
