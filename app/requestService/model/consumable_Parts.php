<?php
namespace App\requestService\model;

use paymentCms\component\browser;
use paymentCms\component\model;
use paymentCms\component\security;
use paymentCms\model\modelInterFace ;

class consumable_Parts extends model implements modelInterFace {
	private $primaryKey = ['id'];
	private $primaryKeyShouldNotInsertOrUpdate = 'id';
	private $id ;
	private $Name ;
	private $Unit ;

	public function setFromArray($result) {
		$this->id = $result['id'] ;
		$this->Name = $result['Name'] ;
		$this->Unit = $result['Unit'] ;
	}

	public function returnAsArray( ) {
		$array['id'] = $this->id ;
		$array['Name'] = $this->Name ;
		$array['Unit'] = $this->Unit ;
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
	public function getName() {
		return $this->Name;
	}

	/**
	 * @param mixed $tile_name
	 */
	public function setName($name) {
		$this->Name = $name;
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
	public function getUnit() {
		return $this->Unit;
	}

	/**
	 * @param mixed $tile_id
	 */
	public function setUnit($Unit) {
		$this->Unit = $Unit;
	}

    public function getItems() {
		return parent::search( array()  ,  null  , 'consumable_Parts', '*'  , ['column' => 'id' , 'type' =>'asc'] );
	}
}
