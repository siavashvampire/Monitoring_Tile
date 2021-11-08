<?php


namespace App\product\model;


use paymentCms\component\model;
use paymentCms\model\modelInterFace;

class product_size extends model implements modelInterFace
{

    private $primaryKey = ['id'];
    private $primaryKeyShouldNotInsertOrUpdate = 'id';
    private $id;
    private $label;
    private $width;
    private $length;
    private $thickness;

    public function setFromArray($result)
    {
        $this->id = $result['id'];
        $this->label = $result['label'];
        $this->width = $result['width'];
        $this->length = $result['length'];
        $this->thickness = $result['thickness'];
    }

    public function returnAsArray()
    {
        $array['id'] = $this->id;
        $array['label'] = $this->label;
        $array['width'] = $this->width;
        $array['length'] = $this->length;
        $array['thickness'] = $this->thickness;
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

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param mixed $width
     */
    public function setWidth($width): void
    {
        $this->width = $width;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param mixed $length
     */
    public function setLength($length): void
    {
        $this->length = $length;
    }

    /**
     * @return mixed
     */
    public function getThickness()
    {
        return $this->thickness;
    }

    /**
     * @param mixed $thickness
     */
    public function setThickness($thickness): void
    {
        $this->thickness = $thickness;
    }


    public function getItems()
    {
        return parent::search(array(), null, 'product_size', '*', ['column' => 'id', 'type' => 'asc']);
    }
}
