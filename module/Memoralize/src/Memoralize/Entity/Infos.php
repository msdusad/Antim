<?php

namespace Memoralize\Entity;

class Infos implements InfosInterface {

    public $id;
    public $memoralize_id;
    public $description;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $dob;
    public $age;
    public $death_place;
    public $education;
    public $family;
    public $tributes;
    public $privacy;
    public $guest_book;

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

    public function setMemoralizeId($id) {

        $this->memoralize_id = $id;
        return $this;
    }

    /**
     * @return the $memoralize_id
     */
    public function getMemoralizeId() {
        return $this->memoralize_id;
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
     * @param  string $dob
     * @return Infos
     */
    public function setDob($dob) {
       
        $this->dob = $dob;
        return $this;
    }

    public function getDob() {

        return $this->dob;
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

    public function setEducation($education) {

        $this->education = $education;
        return $this;
    }

    /**
     * @return the $education
     */
    public function getEducation() {
       
        return $this->education;
    }
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
    public function setPrivacy($privacy) {

        $this->privacy = $privacy;
        return $this;
    }

    /**
     * @return the $privacy
     */
    public function getPrivacy() {
       
        return $this->privacy;
    }
    public function setGuestBook($guestbook) {

        $this->guest_book = $guestbook;
        return $this;
    }

    /**
     * @return the $tributes
     */
    public function getGuestBook() {
       
        return $this->guest_book;
    }

}
