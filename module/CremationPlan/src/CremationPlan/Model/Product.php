<?php

namespace CremationPlan\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Product implements InputFilterAwareInterface {

    public $id;
    public $category_id;
    public $title;
    public $description;
    public $sku;
    public $price;
    public $fax;
    public $quantity;
    public $product_image;
    public $total_amount;
    public $total_quantity;
    public $status;
    public $created_at;
    public $user;
    public $category;
    public $productid;
    public $email;
    protected $inputFilter;

    public function exchangeArray($data) {

        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->category_id = (isset($data['category_id'])) ? $data['category_id'] : null;
        $this->title = (isset($data['title'])) ? $data['title'] : null;
        $this->description = (isset($data['description'])) ? $data['description'] : null;
        $this->sku = (isset($data['sku'])) ? $data['sku'] : null;
        $this->price = (isset($data['price'])) ? $data['price'] : null;
        $this->quantity = (isset($data['quantity'])) ? $data['quantity'] : null;
        $this->product_image = (isset($data['product_image'])) ? $data['product_image'] : null;
        $this->total_amount = (isset($data['total_amount'])) ? $data['total_amount'] : null;
        $this->total_quantity = (isset($data['total_quantity'])) ? $data['total_quantity'] : null;
        $this->status = (isset($data['status'])) ? $data['status'] : null;
        $this->created_at = (isset($data['created_at'])) ? $data['created_at'] : null;
        $this->user = (isset($data['user'])) ? $data['user'] : null;
        $this->category = (isset($data['category'])) ? $data['category'] : null;
        $this->productid = (isset($data['productid'])) ? $data['productid'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
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
                        'name' => 'category_id',
                        'filters' => array(
                            array('name' => 'Null'),
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


            $inputFilter->add($factory->createInput(array(
                        'name' => 'description',
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
                                ),
                            ),
                        ),
            )));


//            $this->setInputFilter($factory->createInputFilter(array(
//                        'price' => array(
//                            'name' => 'price',
//                            'required' => true,
//                            'validators' => array(
//                                array(
//                                    'name' => 'Float',
//                                ),
//                            ),
//                        ),
//            )));
//            $inputFilter->add($factory->createInput(array(
//                        'name' => 'quantity',
//                        'required' => true,
//                        'filters' => array(
//                            array('name' => 'Int'),
//                        ),
//            )));


            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}