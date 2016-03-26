<?php

namespace Obituary\Entity;

class Infos implements InfosInterface {

    public $id;
    public $obituary_id;
    public $description;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $dob;
    public $dod;
    public $age;
    public $death_place;
    public $school;
    public $ug;
    public $ug_specialization;
    public $pg;
    public $pg_specialization;
    public $family;
    public $tributes;   
    public $steps;
    public $garland_id;

    public function setId($id) {

        $this->id = $id;

        return $this;
    }

    /**
     * @return the $id
     */
    public function getId() {
        return $this->id;
    }

    public function setObituaryId($id) {

        $this->obituary_id = $id;
        return $this;
    }

    /**
     * @return the $obituary_id
     */
    public function getObituaryId() {
        return $this->obituary_id;
    }
    
    public function setDescription($desc) {

        $this->description = $desc;
        return $this;
    }

    /**
     * @return the description
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param  string $first_name
     * @return UserProvider
     */
    public function setFirstName($name) {
      
        $this->first_name = $name;
        return $this;
    }

    /**
     * @return the $first_name
     */
    public function getFirstName() {
       
        return $this->first_name;
    }

    /**
     * @param  string $id
     * @return Infos
     */
    public function setMiddleName($name) {
        
        $this->middle_name = $name;
        return $this;
    }

    /**
     * @return the $middle_name
     */
    public function getMiddleName() {
       
        return $this->middle_name;
    }

    /**
     * @param  string $name
     * @return Infos
     */
    public function setLastName($name) {
        
        $this->last_name = $name;
        return $this;
    }

    /**
     * @return the $last_namee
     */
    public function getLastName() {
       
        return $this->last_name;
    }
    
    /**
     * @param  string $dod
     * @return Infos
     */
    public function setDob($dod) {
       
        $this->dob = $dod;
        return $this;
    }

    public function getDob() {

        return $this->dob;
    }

    /**
     * @param  string $dod
     * @return Infos
     */
    public function setDod($dod) {
       
        $this->dod = $dod;
        return $this;
    }

    public function getDod() {

        return $this->dod;
    }

    public function setAge($age) {

        $this->age = $age;
        return $this;
    }

    /**
     * @return the $age
     */
    public function getAge() {
       
        return $this->age;
    }

    public function setDeathPlace($place) {

        $this->death_place = $place;
        return $this;
    }

    /**
     * @return the $starttime
     */
    public function getDeathPlace() {
        
        return $this->death_place;
    }

    public function setSchool($school) {

        $this->school = $school;
        return $this;
    }
    /**
     * @return the $education
     */
    public function getSchool() {
       
        return $this->school;
    }
    
    public function setUg($ug) {

        $this->ug = $ug;
        return $this;
    }
    /**
     * @return the $education
     */
    public function getUg() {
       
        return $this->ug;
    }
    
    public function setUgSpecialization($specilization) {

        $this->ug_specialization = $specilization;
        return $this;
    }

    /**
     * @return the $education
     */
    public function getUgSpecialization() {
       
        return $this->ug_specialization;
    }
    public function setPg($pg) {

        $this->pg = $pg;
        return $this;
    }

    /**
     * @return the $education
     */
    public function getPg() {
       
        return $this->pg;
    }
    public function setPgSpecialization($specilization) {

        $this->pg_specialization = $specilization;
        return $this;
    }

    /**
     * @return the $education
     */
    public function getPgSpecialization() {
       
        return $this->pg_specialization;
    }
     /**
     * @return the $family
     */
    public function setFamily($family) {

        $this->family = $family;
        return $this;
    }

    /**
     * @return the $family
     */
    public function getFamily() {
       
        return $this->family;
    }
    public function setTributes($tributes) {

        $this->tributes = $tributes;
        return $this;
    }

    /**
     * @return the $tributes
     */
    public function getTributes() {
       
        return $this->tributes;
    }
    
    public function setSteps($steps) {

        $this->steps = $steps;

        return $this;
    }
    /**
     * @return the $id
     */
    public function getSteps() {
        return $this->steps;
    }
    /**
     * @param  string $id
     * @return Obituary
     */
    public function setGarlandId($id) {
      
        $this->garland_id = $id;
        return $this;
    }

    /**
     * @return the $garland_id
     */
    public function getGarlandId() {
       
        return $this->garland_id;
    }

    public function getEducation() {
        
    }

    public function setEducation($education) {
        
    }

}
