<?php

namespace Donation\Mapper;

interface DonationsInterface {

    /**
     * @param  array $id
     * @return DonationsInterface
     */
    public function fetchAll($ids);  
        
    /**
     * @param  array $data
     * @return DonationsInterface
     */
    public function save($data);

    
}

