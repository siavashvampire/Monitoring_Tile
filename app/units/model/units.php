<?php


namespace App\units\model;


use paymentCms\component\model;
use paymentCms\model\modelInterFace ;

class units extends model implements modelInterFace {

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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getCount($value = array(),$variable = array()) {
        return (parent::search( (array) $value  , ( count($variable) == 0 ) ? null : implode(' and ' , $variable) , 'units', 'COUNT(id) as co' )) [0]['co'];
    }
    public function getItems($value = array(),$variable = array() , $sortWith = ['column' => 'item.label' , 'type' =>'asc']) {
        return parent::search( (array) $value  , ( ( count($variable) == 0 ) ? null : implode(' and ' , $variable) )  , 'units item', 'item.id ,item.label '  , $sortWith );
    }

    public function getById($id){
        $value = array();
        $value[] = $id;
        $variable = array();
        $variable[] = 'item.id = ?';
        return parent::search(  $value  ,  implode(' and ' , $variable)  , 'units item', 'item.id as unitId,item.label as Name ' );
    }
}
