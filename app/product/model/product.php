<?php


namespace App\product\model;


use paymentCms\component\model;
use paymentCms\model\modelInterFace;

class product extends model implements modelInterFace
{
    private $tableName = 'product';

    private $primaryKey = ['id'];
    private $primaryKeyShouldNotInsertOrUpdate = 'id';
    private $id;
    private $label;
    private $kind;
    private $size;
    private $phase;
    private $color;
    private $glaze;
    private $punch;
    private $degree;
    private $weight;
    private $pallet;
    private $technique;
    private $effect;
    private $decor;

    public function setFromArray($result)
    {
        $this->id = $result['id'];
        $this->label = $result['label'];
        $this->kind = $result['kind'];
        $this->size = $result['size'];
        $this->phase = $result['phase'];
        $this->color = $result['color'];
        $this->glaze = $result['glaze'];
        $this->punch = $result['punch'];
        $this->degree = $result['degree'];
        $this->weight = $result['weight'];
        $this->pallet = $result['pallet'];
        $this->technique = $result['technique'];
        $this->effect = $result['effect'];
        $this->decor = $result['decor'];
    }

    public function returnAsArray()
    {
        $array['id'] = $this->id;
        $array['label'] = $this->label;
        $array['kind'] = $this->kind;
        $array['size'] = $this->size;
        $array['phase'] = $this->phase;
        $array['color'] = $this->color;
        $array['glaze'] = $this->glaze;
        $array['punch'] = $this->punch;
        $array['degree'] = $this->degree;
        $array['weight'] = $this->weight;
        $array['pallet'] = $this->pallet;
        $array['technique'] = $this->technique;
        $array['effect'] = $this->effect;
        $array['decor'] = $this->decor;
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
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size): void
    {
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getPhase()
    {
        return $this->phase;
    }

    /**
     * @param mixed $phase
     */
    public function setPhase($phase): void
    {
        $this->phase = $phase;
    }

    /**
     * @return mixed
     */
    public function getGlaze()
    {
        return $this->glaze;
    }

    /**
     * @param mixed $glaze
     */
    public function setGlaze($glaze): void
    {
        $this->glaze = $glaze;
    }

    /**
     * @return mixed
     */
    public function getPunch()
    {
        return $this->punch;
    }

    /**
     * @param mixed $punch
     */
    public function setPunch($punch): void
    {
        $this->punch = $punch;
    }

    /**
     * @return mixed
     */
    public function getDegree()
    {
        return $this->degree;
    }

    /**
     * @param mixed $degree
     */
    public function setDegree($degree): void
    {
        $this->degree = $degree;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     */
    public function setWeight($weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return mixed
     */
    public function getPallet()
    {
        return $this->pallet;
    }

    /**
     * @param mixed $pallet
     */
    public function setPallet($pallet): void
    {
        $this->pallet = $pallet;
    }

    /**
     * @return mixed
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     * @param mixed $kind
     */
    public function setKind($kind): void
    {
        $this->kind = $kind;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color): void
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getTechnique()
    {
        return $this->technique;
    }

    /**
     * @param mixed $technique
     */
    public function setTechnique($technique): void
    {
        $this->technique = $technique;
    }

    /**
     * @return mixed
     */
    public function getEffect()
    {
        return $this->effect;
    }

    /**
     * @param mixed $effect
     */
    public function setEffect($effect): void
    {
        $this->effect = $effect;
    }

    /**
     * @return mixed
     */
    public function getDecor()
    {
        return $this->decor;
    }

    /**
     * @param mixed $decor
     */
    public function setDecor($decor): void
    {
        $this->decor = $decor;
    }

    public function getCount($value = array(), $variable = array())
    {
        return (parent::search((array)$value, (count($variable) == 0) ? null : implode(' and ', $variable), $this->tableName . ' item', 'COUNT(item.id) as co')) [0]['co'];
    }

    public function getItems($value = array(), $variable = array(), $sortWith = ['column' => 'id', 'type' => 'asc'], $pagination = [0, 9999])
    {
        return parent::search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), $this->tableName . ' item', 'item.*', $sortWith, $pagination);
    }
}
