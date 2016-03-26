<?php

namespace EventCalendar\Mapper;

interface EventsInterface {

    /**
     * @param  int $id
     * @param  string $type
     * @return EventsInterface
     */
    public function fetchAll($id, $type,$date,$userid);

    /**
     * @param  int $userId
     * @return EventsInterface
     */
    public function findEvents($id, $type);

    /**
     * @param  array $data
     * @return EventsInterface
     */
    public function save($data);

    /**
     * @param  integer $id
     * @return EventsInterface
     */
    public function findEventById($id);
}

