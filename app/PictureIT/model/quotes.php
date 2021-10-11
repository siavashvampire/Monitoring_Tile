<?php
namespace App\PictureIT\model;

use paymentCms\component\browser;
use paymentCms\component\model;
use paymentCms\component\security;
use paymentCms\model\modelInterFace ;

class quotes extends model implements modelInterFace {
	private $primaryKey = ['id'];
	private $primaryKeyShouldNotInsertOrUpdate = 'id';
	private $id ;
	private $label ;
	private $device_id ;
	private $Send_Time ;

	public function setFromArray($result) {
		$this->id            = $result['id'] ;
		$this->label         = $result['label'] ;
		$this->device_id     = $result['device_id'] ;
		$this->Send_Time     = $result['Send_Time'] ;
	}

	public function returnAsArray( ) {
		$array['id']         = $this->id ;
		$array['label']      = $this->label ;
		$array['device_id']  = $this->device_id ;
		$array['Send_Time']  = $this->Send_Time ;
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
	public function getlabel() {
		return $this->label;
	}

	/**
	 * @param mixed $tile_name
	 */
	public function setlabel($label) {
		$this->label = $label;
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
	public function getDevice_id() {
		return $this->device_id;
	}

	/**
	 * @param mixed $tile_id
	 */
	public function setDevice_id($id) {
		$this->device_id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getSend_Time() {
		return $this->Send_Time;
	}

	/**
	 * @param mixed $tile_id
	 */
	public function setSend_Time($Send_Time) {
		$this->Send_Time = $Send_Time;
	}
    
    public function getQuotes() {
		return parent::search( array()  ,  null  , 'quotes', '*'  , ['column' => 'id' , 'type' =>'asc'] );
	}
}
