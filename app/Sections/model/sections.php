<?php

namespace App\Sections\model;

use paymentCms\component\model;
use paymentCms\model\modelInterFace;

class sections extends model implements modelInterFace
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

    public function returnAsArray(): array
    {
        $array['id'] = $this->id;
        $array['label'] = $this->label;
        return $array;
    }

    /**
     * @return array
     */
    public function getPrimaryKey(): array
    {
        return $this->primaryKey;
    }

    /**
     * @return string
     */
    public function getPrimaryKeyShouldNotInsertOrUpdate(): string
    {
        return $this->primaryKeyShouldNotInsertOrUpdate;
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
    public function setId($id): void
    {
        $this->id = $id;
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
    public function setLabel($label): void
    {
        $this->label = $label;
    }


    public function getCount($value = array(), $variable = array())
    {
        return (parent::search((array)$value, (count($variable) == 0) ? null : implode(' and ', $variable), 'sections', 'COUNT(id) as co')) [0]['co'];
    }

    public function getItems($value = array(), $variable = array(), $sortWith = ['column' => 'item.id', 'type' => 'asc'], $pagination = [0, 1000])
    {
        $tableName = 'sections item';
        $fields = array();
        $fields[] = 'item.id';
        $fields[] = 'item.label';
        $fields = implode(' , ',$fields);
        return parent::search($value, (count($variable) == 0) ? null : implode(' and ', $variable), $tableName, $fields, $sortWith, $pagination);
    }


}
