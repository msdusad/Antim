<?php

namespace EventCalendar\Entity;


class Events implements EventsInterface
{
    public $id;   
    
    public $obituary_id;
   
    public $memoralize_id;

    public $title;

    public $eventId;
   
    public $start;   
	 public $end;  
   
    public $edate;
	 public $profile_type;
    public $location;
    
    public $content;
    public $contact;

    public function setId($id) {
        
        $this->id = $id;

        return $this;
    }
    /**
     * @return the $userId
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function setObituaryId($id) {

        $this->obituary_id = $id;
        return $this;
    }

    /**
     * @return the $memoralize_id
     */
    public function getObituaryId() {
        return $this->obituary_id;
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

    public function setProfileType($profile_type) {

        $this->profile_type = $profile_type;
        return $this;
    }

    public function getProfileType() {
        return $this->profile_type;
    }
    /**
     * @param  integer      $userId
     * @return UserProvider
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return the $providerId
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param  integer $id
     * @return Events
     */
    public function setEventId($id)
    {
        $this->eventId = $id;

        return $this;
    }

    /**
     * @return the $eventId
     */
    public function getEventId()
    {
        return $this->eventId;
    }

    /**
     * @param  string       $provider
     * @return Events
     */
    public function setCreatedAt($edate)
    {
        $this->edate = $edate;

        return $this;
    }

    public function getCreatedAt() {
        
        return $this->edate;
    }
public function setEdate($edate)
    {
        $this->edate = $edate;

        return $this;
    }

    public function getEdate() {
        
        return $this->edate;
    }
    public function setStart($start) {
        
        $this->start = $start;

        return $this;
    }
    /**
     * @return the $starttime
     */
    public function getStart()
    {
        return $this->start;
    }
   public function setEnd($end) {
        
        $this->end = $end;

        return $this;
    }
    /**
     * @return the $starttime
     */
    public function getEnd()
    {
        return $this->end;
    }
   public function setLocation($location) {
        
        $this->location = $location;

        return $this;
    }
    /**
     * @return the $starttime
     */
    public function getLocation()
    {
        return $this->location;
    }
    public function setContact($contact) {
        
        $this->contact = $contact;

        return $this;
    }
    /**
     * @return the $starttime
     */
    public function getContact()
    {
        return $this->contact;
    }
     public function setContent($content) {
        
        $this->content = $content;

        return $this;
    }
    /**
     * @return the $content
     */
    public function getContent()
    {
        return $this->content;
    }
 
    
}
