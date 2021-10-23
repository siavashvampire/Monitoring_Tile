<?php

namespace App\DAUnits\model;

use paymentCms\component\browser;
use paymentCms\component\model;
use paymentCms\component\security;
use paymentCms\model\modelInterFace;

class DAUnits extends model implements modelInterFace
{
    private $primaryKey = ['id'];
    private $primaryKeyShouldNotInsertOrUpdate = 'id';
    private $id;
    private $IP;
    private $label;
    private $status;
    private $type;


    public function setFromArray($result)
    {
        $this->id = $result['id'];
        $this->IP = $result['IP'];
        $this->label = $result['label'];
        $this->status = $result['status'];
        $this->status = $result['status'];
        $this->type = $result['type'];

    }

    public function returnAsArray()
    {
        $array['id'] = $this->id;
        $array['IP'] = $this->IP;
        $array['label'] = $this->label;
        $array['status'] = $this->status;
        $array['type'] = $this->type;
        return $array;
    }

    /**
     * @return string[]
     */
    public function getPrimaryKey(): array
    {
        return $this->primaryKey;
    }

    /**
     * @param string[] $primaryKey
     */
    public function setPrimaryKey(array $primaryKey)
    {
        $this->primaryKey = $primaryKey;
    }

    /**
     * @return string
     */
    public function getPrimaryKeyShouldNotInsertOrUpdate(): string
    {
        return $this->primaryKeyShouldNotInsertOrUpdate;
    }

    /**
     * @param string $primaryKeyShouldNotInsertOrUpdate
     */
    public function setPrimaryKeyShouldNotInsertOrUpdate(string $primaryKeyShouldNotInsertOrUpdate)
    {
        $this->primaryKeyShouldNotInsertOrUpdate = $primaryKeyShouldNotInsertOrUpdate;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIP()
    {
        return $this->IP;
    }

    /**
     * @param mixed $IP
     */
    public function setIP($IP)
    {
        $this->IP = $IP;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    public function getCount($value = array(), $variable = array())
    {
        return (parent::search((array)$value, (count($variable) == 0) ? null : implode(' and ', $variable), 'DAUnits', 'COUNT(id) as co')) [0]['co'];
    }

    public function getItems($value = array(), $variable = array(), $sortWith = ['column' => 'item.id', 'type' => 'asc'], $pagination = [0,25], $getApp = false)
    {
        $tableName = 'DAUnits item';
        $fields = array();
        $fields[] = 'item.id';
        $fields[] = 'item.label';
        $fields[] = 'item.IP';
        $fields[] = 'type.label as type';
        $fields[] = ' type.testPort as testPort';
        if ($getApp) {
            parent::join('daunits_app apps', 'item.id = apps.DAUnits_id');
            $fields[] = "apps.label  as app";
        }
        $fields = implode(',', $fields);

        parent::join('DAUnits_Type type', 'item.type = type.id');
        return parent::search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), $tableName, $fields, $sortWith, $pagination);
    }


}
