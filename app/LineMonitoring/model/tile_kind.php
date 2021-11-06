<?php


namespace App\LineMonitoring\model;


use paymentCms\component\browser;
use paymentCms\component\model;
use paymentCms\component\security;
use paymentCms\model\modelInterFace ;

class tile_kind extends model implements modelInterFace {

	private $primaryKey = ['tile_id'];
	private $primaryKeyShouldNotInsertOrUpdate = 'tile_id';
	private $id ;
	private $label ;
	private $tile_width ;
	private $tile_length ;

	public function setFromArray($result) {
		$this->id = $result['id'] ;
		$this->label = $result['label'] ;
		$this->tile_width = $result['tile_width'] ;
		$this->tile_length = $result['tile_length'] ;
	}

	public function returnAsArray( ) {
		$array['id'] = $this->id ;
		$array['label'] = $this->label ;
		$array['tile_width'] = $this->tile_width ;
		$array['tile_length'] = $this->tile_length ;
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
	public function getTileLength() {
		return $this->tile_length;
	}

	/**
	 * @param mixed $tile_length
	 */
	public function setTileLength($tile_length) {
		$this->tile_length = $tile_length;
	}

	/**
	 * @return mixed
	 */
	public function getTileWidth() {
		return $this->tile_width;
	}

	/**
	 * @param mixed $tile_width
	 */
	public function setTileWidth($tile_width) {
		$this->tile_width = $tile_width;
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


    public function getItems() {
		return parent::search( array()  ,  null  , 'tile_kind', '*'  , ['column' => 'id' , 'type' =>'asc'] );
	}
}
