<?php

namespace App\DAUnits\model;

use paymentCms\component\model;
use paymentCms\model\modelInterFace;

class DAUnits_app extends model implements modelInterFace
{
    private $primaryKey = null;
    private $primaryKeyShouldNotInsertOrUpdate = null;
    private $DAUnits_id;
    private $label;


    public function setFromArray($result)
    {
        $this->DAUnits_id = $result['DAUnits_id'];
        $this->label = $result['label'];
    }

    public function returnAsArray()
    {
        $array['DAUnits_id'] = $this->DAUnits_id;
        $array['label'] = $this->label;

        return $array;
    }

    /**
     * @return string[]
     */
    public function getPrimaryKey(): ?array
    {
        return $this->primaryKey;
    }


    /**
     * @return string
     */
    public function getPrimaryKeyShouldNotInsertOrUpdate(): ?string
    {
        return $this->primaryKeyShouldNotInsertOrUpdate;
    }


    /**
     * @return mixed
     */
    public function getDAUnitsId()
    {
        return $this->DAUnits_id;
    }

    /**
     * @param mixed $DAUnits_id
     */
    public function setDAUnitsId($DAUnits_id)
    {
        $this->DAUnits_id = $DAUnits_id;
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

    public function getAppWithId($id)
    {
        return parent::search([$id], 'DAUnits_id = ?', 'DAUnits_app', '*');
    }

    public function deleteAllRow($id = null)
    {
        if ($id == null) $id = $this->getDAUnitsId();

        $value = array();
        $variable = array();

        $value[] = $id;
        $variable[] = 'DAUnits_id = ?';

        parent::deleteOnFullQuery($value, implode(' and ', $variable));
    }
}
