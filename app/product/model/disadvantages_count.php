<?php


namespace App\product\model;


use paymentCms\component\model;
use paymentCms\model\modelInterFace ;

class disadvantages_count extends model implements modelInterFace {
    private $tableName = "disadvantages_count";

	private $primaryKey = [];
	private $primaryKeyShouldNotInsertOrUpdate = null;
	private $disadvantages_id ;
	private $product_disadvantage_id ;
	private $degree_id ;
	private $count ;
	public function setFromArray($result) {
		$this->disadvantages_id = $result['disadvantages_id'] ;
		$this->product_disadvantage_id = $result['product_disadvantage_id'] ;
		$this->degree_id = $result['degree_id'] ;
		$this->count = $result['count'] ;
	}

	public function returnAsArray( ) {
		$array['disadvantages_id'] = $this->disadvantages_id ;
		$array['product_disadvantage_id'] = $this->product_disadvantage_id ;
		$array['degree_id'] = $this->degree_id ;
		$array['count'] = $this->count ;
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

    public function getItems($value = array(), $variable = array())
    {
        return parent::search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), $this->tableName . ' item', 'item.*');
    }

    /**
     * @return mixed
     */
    public function getDisadvantagesId()
    {
        return $this->disadvantages_id;
    }

    /**
     * @param mixed $disadvantages_id
     */
    public function setDisadvantagesId($disadvantages_id): void
    {
        $this->disadvantages_id = $disadvantages_id;
    }

    /**
     * @return mixed
     */
    public function getProductDisadvantageId()
    {
        return $this->product_disadvantage_id;
    }

    /**
     * @param mixed $product_disadvantage_id
     */
    public function setProductDisadvantageId($product_disadvantage_id): void
    {
        $this->product_disadvantage_id = $product_disadvantage_id;
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param mixed $count
     */
    public function setCount($count): void
    {
        $this->count = $count;
    }

    /**
     * @return mixed
     */
    public function getDegreeId()
    {
        return $this->degree_id;
    }

    /**
     * @param mixed $degree_id
     */
    public function setDegreeId($degree_id): void
    {
        $this->degree_id = $degree_id;
    }

}
