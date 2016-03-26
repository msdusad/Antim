<?php

namespace Memoralize\Entity;

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
    public function getMemoralizeId();

    /**
     * @param  integer   $id
     * @return InfosInterface
     */
    public function setMemoralizeId($id);

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
     * @param  string   $dob
     * @return InfosInterface
     */
    public function setDob($dob);

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
     * @return the $education
     */
    public function getEducation();

    /**
     * @param  string   $education
     * @return InfosInterface
     */
    public function setEducation($education);

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
     * @return the $privacy
     */
    public function getPrivacy();

    /**
     * @param  string   $privacy
     * @return InfosInterface
     */
    public function setPrivacy($privacy);
    /**
     * @return the $guestbook
     */
    public function getGuestBook();

    /**
     * @param  string   $guestbook
     * @return InfosInterface
     */
    public function setGuestBook($guestbook);
}
