<?php

namespace Obituary\Entity;

interface InfosInterface {

    /**
     * @return the $id
     */
    public function getId();

    /**
     * @param  integer  $id
     * @return ConnectionsInterface
     */
    public function setId($id);

    /**
     * @return the $id
     */
    public function getObituaryId();

    /**
     * @param  integer   $id
     * @return InfosInterface
     */
    public function setObituaryId($id);

    /**
     * @return the $desc
     */
    public function getDescription();

    /**
     * @param  string  $desc
     * @return InfosInterface
     */
    public function setDescription($desc);

    /**
     * @return the $name
     */
    public function getFirstName();

    /**
     * @param  string  $name
     * @return InfosInterface
     */
    public function setFirstName($name);

    /**
     * @return the $name
     */
    public function getMiddleName();

    /**
     * @param  string  $name
     * @return InfosInterface
     */
    public function setMiddleName($name);

    /**
     * @return the $name
     */
    public function getLastName();

    /**
     * @param  string   $name
     * @return InfosInterface
     */
    public function setLastName($name);

    /**
     * @return the $dob
     */
    public function getDob();

    /**
     * @param  string   $dod
     * @return InfosInterface
     */
    public function setDob($dob);

    /**
     * @return the $dod
     */
    public function getDod();

    /**
     * @param  string   $dod
     * @return InfosInterface
     */
    public function setDod($dob);

    /**
     * @return the $age
     */
    public function getAge();

    /**
     * @param  string   $age
     * @return InfosInterface
     */
    public function setAge($age);

    /**
     * @return the $place
     */
    public function getDeathPlace();

    /**
     * @param  string   $place
     * @return InfosInterface
     */
    public function setDeathPlace($place);
    /**
     * @param  string   $school
     * @return InfosInterface
     */
    public function setSchool($school);
    /**
     * @return the $education
     */
    public function getSchool();
     /**
     * @param  string   $ug
     * @return InfosInterface
     */
    public function setUg($ug);

    /**
     * @return the $education
     */
    public function getUg();
    
     /**
     * @param  string   $ugspecilization
     * @return InfosInterface
     */
    public function setUgSpecialization($specilization);

    /**
     * @return the $education
     */
    public function getUgSpecialization();
    
     /**
     * @param  string   $pg
     * @return InfosInterface
     */
    public function setPg($pg);

    /**
     * @return the $education
     */
    public function getPg();
    
     /**
     * @param  string   $pgspecilization
     * @return InfosInterface
     */
    public function setPgSpecialization($specilization);

    /**
     * @return the $education
     */
    public function getPgSpecialization();

    /**
     * @return the $family
     */
    public function getFamily();

    /**
     * @param  string   $family
     * @return InfosInterface
     */
    public function setFamily($family);

    /**
     * @return the $tributes
     */
    public function getTributes();

    /**
     * @param  string   $tributes
     * @return InfosInterface
     */
    public function setTributes($tributes);
    
    /**
     * @return the $steps
     */
     public function getSteps();
    /**
     * @param  string   $steps
     * @return InfosInterface
     */
    public function setSteps($steps);
    
     /**
     * @param  string $id
     * @return Obituary
     */
    public function setGarlandId($id);

    /**
     * @return the $garland_id
     */
    public function getGarlandId();
}
