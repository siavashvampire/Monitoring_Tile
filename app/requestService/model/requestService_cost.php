<?php
namespace App\requestService\model;

use paymentCms\component\browser;
use paymentCms\component\model;
use paymentCms\component\security;
use paymentCms\model\modelInterFace ;

class requestService_cost extends model implements modelInterFace {
	private $primaryKey = ['id'];
	private $primaryKeyShouldNotInsertOrUpdate = 'id';
	private $id ;
	private $label;

	public function setFromArray($result) {
		$this->id = $result['id'] ;
		$this->label = $result['label'] ;
	}

	public function returnAsArray( ) {
		$array['id'] = $this->id ;
		$array['label'] = $this->label ;
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
	public function getId() {
		return $this->id;
	}

	/**
	 * @param mixed $tile_id
	 */
	public function setId($id) {
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
    
    public function getItems($value,$variable) {
		return parent::search( $value, (count($variable) == 0) ? null : implode(' and ', $variable)  , 'requestService_cost item', 'item.id , item.label'  , ['column' => 'item.id' , 'type' =>'asc'] );
	}

}
