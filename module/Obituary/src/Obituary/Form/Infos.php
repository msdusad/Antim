<?php

namespace Obituary\Form;

use Zend\Form\Form;

class Infos extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('obituary_infos');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'obituary_id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'description',
            'options' => array(
                'label' => 'Template Description',
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'description'
            ),
        ));
        $this->add(array(
            'name' => 'first_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'first_name'
            ),
            'options' => array(
                'label' => 'First Name', 'label_attributes' => array(
                    'class' => 'required'
                ),
            ),
        ));
        $this->add(array(
            'name' => 'middle_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'middle_name'
            ),
            'options' => array(
                'label' => 'Middle Name',
            ),
        ));
        $this->add(array(
            'name' => 'last_name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'last_name'
            ),
            'options' => array(
                'label' => 'Last Name',
            ),
        ));
        $this->add(array(
            'name' => 'dob',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'dob',
                'placeholder' => ''
            ), 'options' => array(
                'label' => 'Date of Birth', 'label_attributes' => array(
                    'class' => 'required'
                ),
            ),
        ));
        $this->add(array(
            'name' => 'dod',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'dod',
                'placeholder' => ''
            ), 'options' => array(
                'label' => 'Date of death', 'label_attributes' => array(
                    'class' => 'required'
                ),
            ),
        ));
        $this->add(array(
            'name' => 'age',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control timepicker-default',
                'id' => 'age',
                'placeholder' => ''
            ), 'options' => array(
                'label' => 'Age', 'label_attributes' => array(
                    'class' => 'required'
                ),
            ),
        ));
        $this->add(array(
            'name' => 'death_place',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'death_place'
            ),
            'options' => array(
                'label' => 'Death Place', 'label_attributes' => array(
                    'class' => 'required'
                ),
            ),
        ));
        $this->add(array(
            'name' => 'school',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'school'
            ),
            'options' => array(
                'label' => 'School'
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'ug',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'ug',
                'options' => array(
                    'Not Pursuing Graduation' => 'Not Pursuing Graduation',
                    'B.A' => 'B.A',
                    'B.Arch' => 'B.Arch',
                    'BCA' => 'BCA',
                    'B.B.A' => 'B.B.A',
                    'B.Com' => 'B.Com',
                    'B.Ed' => 'B.Ed',
                    'BDS' => 'BDS',
                    'BHM' => 'BHM',
                    'B.Pharma' => 'B.Pharma',
                    'B.Sc' => 'B.Sc',
                    'B.Tech/B.E' => 'B.Tech/B.E',
                    'LLB' => 'LLB',
                    'MBBS' => 'MBBS',
                    'Diploma' => 'Diploma',
                    'BVSC' => 'BVSC',
                    'Other' => 'Other',
                ),
            ), 'options' => array(
                'label' => 'Basic / Graduation',
            ),
        ));
         $this->add(array(
            'name' => 'ug_specialization',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'ug_specialization'
            ),
            'options' => array(
                'label' => 'Grauation Specialization'
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'pg',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'pg',
                'options' => array(
                     'N/A' => 'Select',
                    'CA' => 'CA',
                    'CS' => 'CS',
                    'ICWA' => 'ICWA',
                    'Integrated PG' => 'Integrated PG',
                    'LLM' => 'LLM',
                    'M.A' => 'M.A',
                    'M.Arch' => 'M.Arch',
                    'M.Com' => 'M.Com',
                    'M.Ed' => 'M.Ed',
                    'M.Pharma' => 'M.Pharma',
                    'M.Sc' => 'M.Sc',
                    'M.Tech/M.E' => 'M.Tech/M.E',
                    'MBA/PGDM' => 'MBA/PGDM',
                    'MCA' => 'MCA',
                    'MS' => 'MS',
                    'PG Diploma' => 'PG Diploma',
                    'MVSC' => 'MVSC',
                    'MCM' => 'MCM',
                    'Other' => 'Other',
                ),
            ), 'options' => array(
                'label' => 'Post Graduation',
            ),
        ));
         $this->add(array(
            'name' => 'pg_specialization',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'pg_specialization'
            ),
            'options' => array(
                'label' => 'Post Graduation Specialization'
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'family',
            'options' => array(
                'label' => 'Family',
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'family'
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'tributes',
            'options' => array(
                'label' => 'Tributes',
            ),
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'tributes'
            ),
        ));


        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Add Details',
                'id' => 'submitbutton',
                'class' => 'btn btn-lg  btn-block',
            ),
        ));
    }

}