<?php

namespace Obituary\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;

class Media extends AbstractDbMapper implements MediaInterface {

    protected $imageTable = 'obituary_image';
    protected $avTable = 'obituary_av';
    protected $infoTable = 'obituary_infos';
    protected $themesTable = 'cremation_templates';
    protected $languageTable = 'languages';

    public function getMimages($id) {

        $sql = $this->getSql();
        $select = $sql->select();
        $select->from($this->imageTable)
                ->where(array(
                    'obituary_id' => $id,
        ));
        //echo  $select->getSqlString();die;
        $entity = $this->select($select)->toArray();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }
    public function getMainImage($id) {

        $sql = $this->getSql();
        $select = $sql->select();
        $select->from($this->imageTable)
                ->where(array('obituary_id' => $id,'main_image'=>1));
        //echo  $select->getSqlString();die;
        $entity = $this->select($select)->current();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }

    public function getThemes($templateId) {

        $sql = $this->getSql();
        
        $select = $sql->select();
        
        $select->from($this->themesTable);
        
        if($templateId!=0){
        $select->where(array(
                    'language_id' => $templateId,
        ));
        }
         //echo  $select->getSqlString();die;
        $entity = $this->select($select)->toArray();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }
    
     public function getLanguages(){
         $sql = $this->getSql();
        
        $select = $sql->select();
        
        $select->from($this->languageTable);
         //echo  $select->getSqlString();die;
        $entity = $this->select($select)->toArray();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
     }
    public function getTheme($id) {

        $sql = $this->getSql();
        $select = $sql->select();

        $select->from($this->themesTable)
                ->where(array('id'=>$id));
        // echo  $select->getSqlString();die;
        $entity = $this->select($select)->current();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }

    public function getMedia($id) {

        $sql = $this->getSql();
        $select = $sql->select();
        $select->from($this->avTable)
                ->where(array(
                    'obituary_id' => $id,
        ));

        $entity = $this->select($select)->current();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }

    public function saveImages($data) {

      
        $orgData = array('obituary_id' => $data['obituary_id'],
            'image_url' => $data['image_url'],
            'main_image' => $data['main_image']);
        
       $images = $this->getMimages($data['obituary_id']);
        
        if(count($images)<9){
        
        $this->insert($orgData, $this->imageTable);
        }
         $mData = array('steps' => 2,'status'=>0);

        $where = 'id=' . $data['obituary_id'].' AND steps!=3';

        $this->update($mData, $where, 'obituary');
        
        return true;
    }

    public function saveThemes($data) {

        $orgData = array('user_id' => $data['user_id'],
            'image_url' => $data['image_url']);

        $this->insert($orgData, $this->themesTable);
        

        return true;
    }

    public function saveMedia($data) {

        $orgData = array('obituary_id' => $data['obituary_id'],
            'media_url' => $data['media_url']);

        $media = $this->getMedia($data['obituary_id']);

        if ($media->media_url == '') {

            $this->insert($orgData, $this->avTable);
        } else {

            $where = 'obituary_id=' . $data['obituary_id'];

            $this->update($orgData, $where, $this->avTable);
        }
        $this->insert($orgData, $this->avTable);

        $mData = array('steps' => 2,'status'=>0);

        $where = 'id=' . $data['obituary_id'].' AND steps!=3';

        $this->update($mData, $where, 'obituary');

        return true;
    }

    public function updateCover($obituaryid,$id) {

          $data = array('main_image' => 0);

        $where = 'obituary_id=' . $obituaryid;

        $this->update($data, $where, $this->imageTable);
        
        $orgData = array('main_image' => 1);

        $where = 'id=' . $id;

        $this->update($orgData, $where, $this->imageTable);

        return true;
    }
    public function updateGarland($garlandid,$id) {

        $orgData = array('garland_id' => $garlandid);

        $where = 'obituary_id=' . $id;

        $this->update($orgData, $where, $this->infoTable);

        return true;
    }

    public function updateTheme($data) {

        $orgData = array('description'=> $data['theme_content']);

        $where = 'obituary_id=' . $data['id'];

        $this->update($orgData, $where, 'obituary_infos');
        
        $obData = array('status'=> 0,'steps'=>3);

        $where1 = 'id=' . $data['id'].' AND steps!=3';

        $this->update($obData, $where1, 'obituary');

        return true;
    }

    public function deleteImages($ids) {

        $id = implode(",", $ids);
        $sql = $this->getSql();
        $select = $sql->select();
        $select->from($this->imageTable)
                ->where(
                    'id IN('.$id.')'
        );

        $entity = $this->select($select)->toArray();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));
        
      
        foreach($entity as $val){
         $finalDir = dirname(__DIR__) . '/../../assets/images/'.$val['obituary_id'].'/'.$val['image_url'];
         $thumbDir = dirname(__DIR__) . '/../../assets/images/'.$val['obituary_id'] . '/thumb/'.$val['image_url'];
         if(file_exists($finalDir))
         {
             unlink($finalDir);
         }
          if(file_exists($thumbDir))
         {
             unlink($thumbDir);
         }
        }
    
        $where = "id IN (" . $id . ")";
        $this->delete($where, $this->imageTable);

        return true;
    }

    public function deleteThemes($ids) {

        $id = implode(",", $ids);
        $where = "id IN (" . $id . ")";
        $this->delete($where, $this->themesTable);

        return true;
    }
        
    public function getGarlands(){
        
        $sql = $this->getSql();
        $select = $sql->select();
        $select->from('garland');

        $entity = $this->select($select)->toArray();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }

}