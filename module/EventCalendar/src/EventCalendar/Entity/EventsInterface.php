<?php

namespace EventCalendar\Entity;

interface EventsInterface 
{
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
     * @return MediaInterface
     */
    public function setObituaryId($id);
    /**
     * @return the $id
     */
    public function getMemoralizeId();

    /**
     * @param  integer   $id
     * @return MediaInterface
     */
    public function setMemoralizeId($id);
    /**
     * @return the $name
     */
    public function getTitle();

    /**
     * @param  string  $title
     * @return EventsInterface
     */
    public function setTitle($title);

    /**
     * @return the $id
     */
    public function getEventId();

    /**
     * @param  integer  $id
     * @return EventsInterface
     */
    public function setEventId($id);
    
    /**
     * @return the $date
     */
    public function getCreatedAt();

    /**
     * @param  string   $date
     * @return EventsInterface
     */
    public function setCreatedAt($date);
    
    /**
     * @return the $date
     */
     public function getStart();
    /**
     * @param  string   $date
     * @return EventsInterface
     */
     public function setStart($start);     
             
   /**
     * @return the $content
     */
     public function getContent();
    /**
     * @param  string   $content
     * @return EventsInterface
     */
     public function setContent($content);
             
    
}
