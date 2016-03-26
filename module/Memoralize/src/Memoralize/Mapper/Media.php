<?php

namespace Memoralize\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;

class Media extends AbstractDbMapper implements MediaInterface {

    protected $imageTable = 'memoralize_image';
    protected $avTable = 'memoralize_av';
    protected $themesTable = 'memoralize_themes';

    public function getMimages($id) {

        $sql = $this->getSql();
        $select = $sql->select();
        $select->from($this->imageTable)
                ->where(array(
                    'memoralize_id' => $id,
        ));
        //echo  $select->getSqlString();die;
        $entity = $this->select($select)->toArray();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }

    public function getThemes($id) {

        $sql = $this->getSql();
        $select = $sql->select();

        $select->from($this->themesTable)
                ->join('memoralize', $this->themesTable . '.id = memoralize.theme_id', array('theme_id'), 'left')
                ->where($this->themesTable . '.user_id IN (0,' . $id . ')');
        // echo  $select->getSqlString();die;
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
                    'memoralize_id' => $id,
        ));

        $entity = $this->select($select)->current();

        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));

        return $entity;
    }

    public function saveImages($data) {

        $orgData = array('memoralize_id' => $data['memoralize_id'],
            'image_url' => $data['image_url'],
            'main_image' => $data['main_image']);

        return true;
    }

    public function saveThemes($data) {

        $orgData = array('user_id' => $data['user_id'],
            'image_url' => $data['image_url']);

        $this->insert($orgData, $this->themesTable);
        

        return true;
    }

    public function saveMedia($data) {

        $orgData = array('memoralize_id' => $data['memoralize_id'],
            'media_url' => $data['media_url']);

        $media = $this->getMedia($data['memoralize_id']);

        if ($media->media_url == '') {

            $this->insert($orgData, $this->avTable);
        } else {

            $where = 'memoralize_id=' . $data['memoralize_id'];

            $this->update($orgData, $where, $this->avTable);
        }
        $this->insert($orgData, $this->imageTable);

        $mData = array('step' => 2);

        $where = 'id=' . $data['memoralize_id'];

        $this->update($mData, $where, 'memoralize');

        return true;
    }

    public function updateCover($id) {

        $orgData = array('main_image' => 1);

        $where = 'id=' . $id;

        $this->update($orgData, $where, $this->imageTable);

        return true;
    }

    public function updateTheme($id, $theme) {

        $orgData = array('steps'=>3,'theme_id' => $theme);

        $where = 'id=' . $id;

        $this->update($orgData, $where, 'memoralize');

        return true;
    }

    public function deleteImages($ids) {

        $id = implode(",", $ids);
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

}