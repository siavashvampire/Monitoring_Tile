<?php


namespace App\product\model;


use paymentCms\component\model;
use paymentCms\model\modelInterFace ;

class product_glaze extends model implements modelInterFace {

	private $primaryKey = ['id'];
	private $primaryKeyShouldNotInsertOrUpdate = 'id';
	private $id ;
	private $label ;
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
		return parent::search( array()  ,  null  , 'product_glaze', '*'  , ['column' => 'id' , 'type' =>'asc'] );
	}
}
