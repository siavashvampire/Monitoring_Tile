<?php
namespace App\LineMonitoring\model;

use app;
use paymentCms\component\browser;
use paymentCms\component\model;
use paymentCms\component\security;
use paymentCms\model\modelInterFace ;

class diagrams extends model implements modelInterFace {
	private $primaryKey = ['diagramId'];
	private $primaryKeyShouldNotInsertOrUpdate = 'diagramId';
	private $diagramId ;
	private $name ;
	private $pictureName ;
	private $diagram ;

	public function setFromArray($result) {
		$this->diagramId = $result['diagramId'] ;
		$this->name = $result['name'] ;
		$this->pictureName = $result['pictureName'] ;
		$this->diagram = $result['diagram'] ;
	}

	public function returnAsArray( ) {
		$array['diagramId'] = $this->diagramId ;
		$array['name'] = $this->name ;
		$array['pictureName'] = $this->pictureName ;
		$array['diagram'] = $this->diagram ;
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
	public function getDiagramId() {
		return $this->diagramId;
	}

	/**
	 * @param mixed $diagramId
	 */
	public function setDiagramId($diagramId) {
		$this->diagramId = $diagramId;
	}

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getDiagram($serialize = false) {
		if ( $serialize )
			return $this->diagram;
		return unserialize($this->diagram);
	}

	/**
	 * @return array
	 */
	public function getSensors() {
		return array_keys(unserialize($this->diagram));
	}

	/**
	 * @param mixed $diagram
	 */
	public function setDiagram($diagram) {
		if ( is_array($diagram) )
			$diagram = serialize($diagram);
		$this->diagram = $diagram;
	}

	/**
	 * @return mixed
	 */
	public function getPictureName($link = true) {
		if ( $link )
			return app::getAppLink('storage/diagrams/' ,'LineMonitoring').$this->pictureName;
		return $this->pictureName;
	}

	/**
	 * @param mixed $pictureName
	 */
	public function setPictureName($pictureName) {
		$this->pictureName = $pictureName;
	}

}
