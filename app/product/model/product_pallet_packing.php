<?php


namespace App\product\model;


use paymentCms\component\model;
use paymentCms\model\modelInterFace ;

class product_pallet_packing extends model implements modelInterFace {
    private $tableName = "product_pallet_packing";

	private $primaryKey = ['id'];
	private $primaryKeyShouldNotInsertOrUpdate = 'id';
	private $id ;
	private $label ;
	private $carton ;
	private $pallet ;
	private $carton_on_pallet ;
	private $plastic ;
	private $strap ;
	private $plastic_weight ;
	private $strap_weight ;
	public function setFromArray($result) {
		$this->id = $result['id'] ;
		$this->label = $result['label'] ;
		$this->carton = $result['carton'] ;
		$this->pallet = $result['pallet'] ;
		$this->carton_on_pallet = $result['carton_on_pallet'] ;
		$this->plastic = $result['plastic'] ;
		$this->strap = $result['strap'] ;
		$this->plastic_weight = $result['plastic_weight'] ;
		$this->strap_weight = $result['strap_weight'] ;
	}

	public function returnAsArray( ) {
		$array['id'] = $this->id ;
		$array['label'] = $this->label ;
		$array['carton'] = $this->carton ;
		$array['pallet'] = $this->pallet ;
		$array['carton_on_pallet'] = $this->carton_on_pallet ;
		$array['plastic'] = $this->plastic ;
		$array['strap'] = $this->strap ;
		$array['plastic_weight'] = $this->plastic_weight ;
		$array['strap_weight'] = $this->strap_weight ;
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
    public function getCarton()
    {
        return $this->carton;
    }

    /**
     * @param mixed $carton
     */
    public function setCarton($carton): void
    {
        $this->carton = $carton;
    }

    /**
     * @return mixed
     */
    public function getPallet()
    {
        return $this->pallet;
    }

    /**
     * @param mixed $pallet
     */
    public function setPallet($pallet): void
    {
        $this->pallet = $pallet;
    }

    /**
     * @return mixed
     */
    public function getCartonOnPallet()
    {
        return $this->carton_on_pallet;
    }

    /**
     * @param mixed $carton_on_pallet
     */
    public function setCartonOnPallet($carton_on_pallet): void
    {
        $this->carton_on_pallet = $carton_on_pallet;
    }

    /**
     * @return mixed
     */
    public function getPlastic()
    {
        return $this->plastic;
    }

    /**
     * @param mixed $plastic
     */
    public function setPlastic($plastic): void
    {
        $this->plastic = $plastic;
    }

    /**
     * @return mixed
     */
    public function getStrap()
    {
        return $this->strap;
    }

    /**
     * @param mixed $strap
     */
    public function setStrap($strap): void
    {
        $this->strap = $strap;
    }

    /**
     * @return mixed
     */
    public function getPlasticWeight()
    {
        return $this->plastic_weight;
    }

    /**
     * @param mixed $plastic_weight
     */
    public function setPlasticWeight($plastic_weight): void
    {
        $this->plastic_weight = $plastic_weight;
    }

    /**
     * @return mixed
     */
    public function getStrapWeight()
    {
        return $this->strap_weight;
    }

    /**
     * @param mixed $strap_weight
     */
    public function setStrapWeight($strap_weight): void
    {
        $this->strap_weight = $strap_weight;
    }


    public function getCount($value = array(), $variable = array())
    {
        return (parent::search((array)$value, (count($variable) == 0) ? null : implode(' and ', $variable), $this->tableName . ' item', 'COUNT(item.id) as co')) [0]['co'];
    }
    public function getItems($value = array(), $variable = array(), $sortWith = ['column' => 'id', 'type' => 'ASC'], $pagination = [0, 9999])
    {
        parent::join('product_carton carton', 'carton.id =  item.carton');
        parent::join('product_pallet pallet', 'pallet.id =  item.pallet');
        parent::join('product_strap strap', 'strap.id =  item.strap');
        parent::join('product_plastic plastic', 'plastic.id =  item.plastic');
        return parent::search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), $this->tableName . ' item', 'item.*,carton.label as carton_label,pallet.label as pallet_label,strap.label as strap_label,plastic.label as plastic_label', $sortWith, $pagination);
    }
}
