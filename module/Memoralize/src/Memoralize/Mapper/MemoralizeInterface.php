<?php

namespace Memoralize\Mapper;

interface MemoralizeInterface {

    /**
     * @param  array $data
     * @return MemoralizeInterface
     */
    public function saveMemoralize($data);

    /**
     * @param  array $id
     * @return MemoralizeInterface
     */
    public function getMemoralize($id);
    /**
     * @param  array $id
     * @return MemoralizeInterface
     */
    public function getRecentOffers($id);
     /**
     * @param  array $id
     * @param  array $userId
     * @return MemoralizeInterface
     */
     public function getOffers($id,$userId);
     
    /**
     * @param  array $data
     * @return MemoralizeInterface
     */
    public function updateOffer($data);
    /**
     * @param  array $data
     * @return MemoralizeInterface
     */
    public function getDonationCategory();
        
     /**
     * @param  array $data
     * @return MemoralizeInterface
     */
    public function getDonationList($id,$name);
    
     public function getDonation($id);
}

