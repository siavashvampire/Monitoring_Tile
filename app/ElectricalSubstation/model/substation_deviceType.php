<?php

namespace App\ElectricalSubstation\model;

use paymentCms\component\browser;
use paymentCms\component\model;
use paymentCms\component\security;
use paymentCms\model\modelInterFace;

class substation_deviceType extends model implements modelInterFace
{
    private $primaryKey = ['id'];
    private $primaryKeyShouldNotInsertOrUpdate = 'id';
    private $id;
    private $label;


    public function setFromArray($result)
    {
        $this->id = $result['id'];
        $this->label = $result['label'];
    }

    public function returnAsArray()
    {
        $array['id'] = $this->id;
        $array['label'] = $this->label;
        return $array;
    }

    /**
     * @return array
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * @return string
     */
    public function getPrimaryKeyShouldNotInsertOrUpdate()
    {
        return $this->primaryKeyShouldNotInsertOrUpdate;
    }


    /**
     * @return mixed
     */
    public function getlabel()
    {
        return $this->label;
    }

    /**
     */
    public function setlabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $tile_id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCount($value = array(), $variable = array())
    {
        return (parent::search((array)$value, (count($variable) == 0) ? null : implode(' and ', $variable), 'substation_deviceType', 'COUNT(id) as co')) [0]['co'];
    }

    public function getItems($value = array(), $variable = array(), $sortWith = ['column' => 'id', 'type' => 'asc'], $pagination = ['start' => 0, 'limit' => "25"])
    {
        return parent::search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), 'substation_deviceType', '*', $sortWith, [$pagination['start'], $pagination['limit']]);
    }

}
