<?php


namespace App\product\model;


use paymentCms\component\model;
use paymentCms\model\modelInterFace ;

class product_pallet extends model implements modelInterFace {
    private $tableName = 'product_pallet';


    private $primaryKey = ['id'];
	private $primaryKeyShouldNotInsertOrUpdate = 'id';
	private $id ;
	private $label ;
	private $pallet_size ;
	private $pallet_weight ;
	public function setFromArray($result) {
		$this->id = $result['id'] ;
		$this->label = $result['label'] ;
		$this->pallet_size = $result['pallet_size'] ;
		$this->pallet_weight = $result['pallet_weight'] ;
	}

	public function returnAsArray( ) {
		$array['id'] = $this->id ;
		$array['label'] = $this->label ;
		$array['pallet_size'] = $this->pallet_size ;
		$array['pallet_weight'] = $this->pallet_weight ;
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

    /**
     * @return mixed
     */
    public function getPalletSize()
    {
        return $this->pallet_size;
    }

    /**
     * @param mixed $pallet_size
     */
    public function setPalletSize($pallet_size): void
    {
        $this->pallet_size = $pallet_size;
    }

    /**
     * @return mixed
     */
    public function getPalletWeight()
    {
        return $this->pallet_weight;
    }

    /**
     * @param mixed $pallet_weight
     */
    public function setPalletWeight($pallet_weight): void
    {
        $this->pallet_weight = $pallet_weight;
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
