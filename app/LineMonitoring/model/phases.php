<?php
namespace App\LineMonitoring\model;

use paymentCms\component\model;
use paymentCms\model\modelInterFace ;

class phases extends model implements modelInterFace {
	private $primaryKey = ['id'];
	private $primaryKeyShouldNotInsertOrUpdate = 'id';
	private $id ;
	private $label ;

    /**
     * @param $result
     */
    public function setFromArray($result) {
		$this->id            = $result['id'] ;
		$this->label         = $result['label'] ;
	}

    /**
     * @return array
     */
    public function returnAsArray( ): array
    {
		$array['id']         = $this->id ;
		$array['label']      = $this->label ;
		return $array ;
	}

	/**
	 * @return array
	 */
	public function getPrimaryKey() {
		return $this->primaryKey;
	}

	/**
	 * @return string
	 */
	public function getPrimaryKeyShouldNotInsertOrUpdate() {
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
	public function getId() {
		return $this->id;
	}

    /**
     * @param $id
     */
	public function setId($id) {
		$this->id = $id;
	}

    public function getItems($value = array(),$variable = array() , $sortWith = ['column' => 'item.id' , 'type' =>'asc'],$pagination = ['start' => 0 , 'limit' =>"25"]) {
        return parent::search( (array) $value  , ( ( count($variable) == 0 ) ? null : implode(' and ' , $variable) )  , 'phases item' , '*', $sortWith , [$pagination['start'] , $pagination['limit'] ] );
    }
    public function getById($id){
        $value = array();
        $value[] = $id;
        $variable = array();
        $variable[] = 'item.id = ?';
        return parent::search(  $value  ,  implode(' and ' , $variable)  , 'phases item', 'item.*' );
    }
}
