<?php


namespace App\product\model;


use paymentCms\component\model;
use paymentCms\model\modelInterFace ;

class product_packing extends model implements modelInterFace {
    private $tableName = "product_packing";

	private $primaryKey = ['id'];
	private $primaryKeyShouldNotInsertOrUpdate = 'id';
	private $id ;
	private $label ;
	private $carton_packing_carton ;
	private $carton_packing_carton_size ;
	private $carton_packing_carton_theme ;
	private $carton_packing_carton_thickness ;
	private $carton_packing_carton_weight ;
	private $carton_packing_glue ;
	private $carton_packing_strap ;
	private $carton_packing_strap_weight ;
	private $carton_packing_glue_amount ;
	private $carton_packing_plastic ;
	private $carton_packing_plastic_weight ;
	private $carton_packing_number_of_tiles ;
	private $pallet_packing_pallet ;
	private $pallet_packing_pallet_size ;
	private $pallet_packing_pallet_weight ;
	private $pallet_packing_strap ;
	private $pallet_packing_strap_weight ;
	private $pallet_packing_plastic ;
	private $pallet_packing_plastic_weight ;
	private $pallet_packing_carton_on_pallet ;
	private $pallet_packing_carton ;
	public function setFromArray($result) {
		$this->id = $result['id'] ;
		$this->label = $result['label'] ;
		$this->carton_packing_carton = $result['carton_packing_carton'] ;
		$this->carton_packing_carton_size = $result['carton_packing_carton_size'] ;
		$this->carton_packing_carton_theme = $result['carton_packing_carton_theme'] ;
		$this->carton_packing_carton_thickness = $result['carton_packing_carton_thickness'] ;
		$this->carton_packing_carton_weight = $result['carton_packing_carton_weight'] ;
		$this->carton_packing_glue = $result['carton_packing_glue'] ;
		$this->carton_packing_strap = $result['carton_packing_strap'] ;
		$this->carton_packing_strap_weight = $result['carton_packing_strap_weight'] ;
		$this->carton_packing_glue_amount = $result['carton_packing_glue_amount'] ;
		$this->carton_packing_plastic = $result['carton_packing_plastic'] ;
		$this->carton_packing_plastic_weight = $result['carton_packing_plastic_weight'] ;
		$this->carton_packing_number_of_tiles = $result['carton_packing_number_of_tiles'] ;
		$this->pallet_packing_pallet = $result['pallet_packing_pallet'] ;
		$this->pallet_packing_pallet_size = $result['pallet_packing_pallet_size'] ;
		$this->pallet_packing_pallet_weight = $result['pallet_packing_pallet_weight'] ;
		$this->pallet_packing_strap = $result['pallet_packing_strap'] ;
		$this->pallet_packing_strap_weight = $result['pallet_packing_strap_weight'] ;
		$this->pallet_packing_plastic = $result['pallet_packing_plastic'] ;
		$this->pallet_packing_plastic_weight = $result['pallet_packing_plastic_weight'] ;
		$this->pallet_packing_carton_on_pallet = $result['pallet_packing_carton_on_pallet'] ;
		$this->pallet_packing_carton = $result['pallet_packing_carton'] ;
	}

	public function returnAsArray( ) {
		$array['id'] = $this->id ;
		$array['label'] = $this->label ;
		$array['carton_packing_carton'] = $this->carton_packing_carton ;
		$array['carton_packing_carton_size'] = $this->carton_packing_carton_size ;
		$array['carton_packing_carton_theme'] = $this->carton_packing_carton_theme ;
		$array['carton_packing_carton_thickness'] = $this->carton_packing_carton_thickness ;
		$array['carton_packing_carton_weight'] = $this->carton_packing_carton_weight ;
		$array['carton_packing_glue'] = $this->carton_packing_glue ;
		$array['carton_packing_strap'] = $this->carton_packing_strap ;
		$array['carton_packing_strap_weight'] = $this->carton_packing_strap_weight ;
		$array['carton_packing_glue_amount'] = $this->carton_packing_glue_amount ;
		$array['carton_packing_plastic'] = $this->carton_packing_plastic ;
		$array['carton_packing_plastic_weight'] = $this->carton_packing_plastic_weight ;
		$array['carton_packing_number_of_tiles'] = $this->carton_packing_number_of_tiles ;
		$array['pallet_packing_pallet'] = $this->pallet_packing_pallet ;
		$array['pallet_packing_pallet_size'] = $this->pallet_packing_pallet_size ;
		$array['pallet_packing_pallet_weight'] = $this->pallet_packing_pallet_weight ;
		$array['pallet_packing_strap'] = $this->pallet_packing_strap ;
		$array['pallet_packing_strap_weight'] = $this->pallet_packing_strap_weight ;
		$array['pallet_packing_plastic'] = $this->pallet_packing_plastic ;
		$array['pallet_packing_plastic_weight'] = $this->pallet_packing_plastic_weight ;
		$array['pallet_packing_carton_on_pallet'] = $this->pallet_packing_carton_on_pallet ;
		$array['pallet_packing_carton'] = $this->pallet_packing_carton ;
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
    public function getCartonPackingCarton()
    {
        return $this->carton_packing_carton;
    }

    /**
     * @param mixed $carton_packing_carton
     */
    public function setCartonPackingCarton($carton_packing_carton): void
    {
        $this->carton_packing_carton = $carton_packing_carton;
    }

    /**
     * @return mixed
     */
    public function getCartonPackingCartonSize()
    {
        return $this->carton_packing_carton_size;
    }

    /**
     * @param mixed $carton_packing_carton_size
     */
    public function setCartonPackingCartonSize($carton_packing_carton_size): void
    {
        $this->carton_packing_carton_size = $carton_packing_carton_size;
    }

    /**
     * @return mixed
     */
    public function getCartonPackingCartonTheme()
    {
        return $this->carton_packing_carton_theme;
    }

    /**
     * @param mixed $carton_packing_carton_theme
     */
    public function setCartonPackingCartonTheme($carton_packing_carton_theme): void
    {
        $this->carton_packing_carton_theme = $carton_packing_carton_theme;
    }

    /**
     * @return mixed
     */
    public function getCartonPackingCartonThickness()
    {
        return $this->carton_packing_carton_thickness;
    }

    /**
     * @param mixed $carton_packing_carton_thickness
     */
    public function setCartonPackingCartonThickness($carton_packing_carton_thickness): void
    {
        $this->carton_packing_carton_thickness = $carton_packing_carton_thickness;
    }

    /**
     * @return mixed
     */
    public function getCartonPackingCartonWeight()
    {
        return $this->carton_packing_carton_weight;
    }

    /**
     * @param mixed $carton_packing_carton_weight
     */
    public function setCartonPackingCartonWeight($carton_packing_carton_weight): void
    {
        $this->carton_packing_carton_weight = $carton_packing_carton_weight;
    }

    /**
     * @return mixed
     */
    public function getCartonPackingGlue()
    {
        return $this->carton_packing_glue;
    }

    /**
     * @param mixed $carton_packing_glue
     */
    public function setCartonPackingGlue($carton_packing_glue): void
    {
        $this->carton_packing_glue = $carton_packing_glue;
    }

    /**
     * @return mixed
     */
    public function getCartonPackingStrap()
    {
        return $this->carton_packing_strap;
    }

    /**
     * @param mixed $carton_packing_strap
     */
    public function setCartonPackingStrap($carton_packing_strap): void
    {
        $this->carton_packing_strap = $carton_packing_strap;
    }

    /**
     * @return mixed
     */
    public function getCartonPackingStrapWeight()
    {
        return $this->carton_packing_strap_weight;
    }

    /**
     * @param mixed $carton_packing_strap_weight
     */
    public function setCartonPackingStrapWeight($carton_packing_strap_weight): void
    {
        $this->carton_packing_strap_weight = $carton_packing_strap_weight;
    }

    /**
     * @return mixed
     */
    public function getCartonPackingGlueAmount()
    {
        return $this->carton_packing_glue_amount;
    }

    /**
     * @param mixed $carton_packing_glue_amount
     */
    public function setCartonPackingGlueAmount($carton_packing_glue_amount): void
    {
        $this->carton_packing_glue_amount = $carton_packing_glue_amount;
    }

    /**
     * @return mixed
     */
    public function getCartonPackingPlastic()
    {
        return $this->carton_packing_plastic;
    }

    /**
     * @param mixed $carton_packing_plastic
     */
    public function setCartonPackingPlastic($carton_packing_plastic): void
    {
        $this->carton_packing_plastic = $carton_packing_plastic;
    }

    /**
     * @return mixed
     */
    public function getCartonPackingPlasticWeight()
    {
        return $this->carton_packing_plastic_weight;
    }

    /**
     * @param mixed $carton_packing_plastic_weight
     */
    public function setCartonPackingPlasticWeight($carton_packing_plastic_weight): void
    {
        $this->carton_packing_plastic_weight = $carton_packing_plastic_weight;
    }

    /**
     * @return mixed
     */
    public function getCartonPackingNumberOfTiles()
    {
        return $this->carton_packing_number_of_tiles;
    }

    /**
     * @param mixed $carton_packing_number_of_tiles
     */
    public function setCartonPackingNumberOfTiles($carton_packing_number_of_tiles): void
    {
        $this->carton_packing_number_of_tiles = $carton_packing_number_of_tiles;
    }

    /**
     * @return mixed
     */
    public function getPalletPackingPallet()
    {
        return $this->pallet_packing_pallet;
    }

    /**
     * @param mixed $pallet_packing_pallet
     */
    public function setPalletPackingPallet($pallet_packing_pallet): void
    {
        $this->pallet_packing_pallet = $pallet_packing_pallet;
    }

    /**
     * @return mixed
     */
    public function getPalletPackingPalletSize()
    {
        return $this->pallet_packing_pallet_size;
    }

    /**
     * @param mixed $pallet_packing_pallet_size
     */
    public function setPalletPackingPalletSize($pallet_packing_pallet_size): void
    {
        $this->pallet_packing_pallet_size = $pallet_packing_pallet_size;
    }

    /**
     * @return mixed
     */
    public function getPalletPackingPalletWeight()
    {
        return $this->pallet_packing_pallet_weight;
    }

    /**
     * @param mixed $pallet_packing_pallet_weight
     */
    public function setPalletPackingPalletWeight($pallet_packing_pallet_weight): void
    {
        $this->pallet_packing_pallet_weight = $pallet_packing_pallet_weight;
    }

    /**
     * @return mixed
     */
    public function getPalletPackingStrap()
    {
        return $this->pallet_packing_strap;
    }

    /**
     * @param mixed $pallet_packing_strap
     */
    public function setPalletPackingStrap($pallet_packing_strap): void
    {
        $this->pallet_packing_strap = $pallet_packing_strap;
    }

    /**
     * @return mixed
     */
    public function getPalletPackingStrapWeight()
    {
        return $this->pallet_packing_strap_weight;
    }

    /**
     * @param mixed $pallet_packing_strap_weight
     */
    public function setPalletPackingStrapWeight($pallet_packing_strap_weight): void
    {
        $this->pallet_packing_strap_weight = $pallet_packing_strap_weight;
    }

    /**
     * @return mixed
     */
    public function getPalletPackingPlastic()
    {
        return $this->pallet_packing_plastic;
    }

    /**
     * @param mixed $pallet_packing_plastic
     */
    public function setPalletPackingPlastic($pallet_packing_plastic): void
    {
        $this->pallet_packing_plastic = $pallet_packing_plastic;
    }

    /**
     * @return mixed
     */
    public function getPalletPackingPlasticWeight()
    {
        return $this->pallet_packing_plastic_weight;
    }

    /**
     * @param mixed $pallet_packing_plastic_weight
     */
    public function setPalletPackingPlasticWeight($pallet_packing_plastic_weight): void
    {
        $this->pallet_packing_plastic_weight = $pallet_packing_plastic_weight;
    }

    /**
     * @return mixed
     */
    public function getPalletPackingCartonOnPallet()
    {
        return $this->pallet_packing_carton_on_pallet;
    }

    /**
     * @param mixed $pallet_packing_carton_on_pallet
     */
    public function setPalletPackingCartonOnPallet($pallet_packing_carton_on_pallet): void
    {
        $this->pallet_packing_carton_on_pallet = $pallet_packing_carton_on_pallet;
    }

    /**
     * @return mixed
     */
    public function getPalletPackingCarton()
    {
        return $this->pallet_packing_carton;
    }

    /**
     * @param mixed $pallet_packing_carton
     */
    public function setPalletPackingCarton($pallet_packing_carton): void
    {
        $this->pallet_packing_carton = $pallet_packing_carton;
    }

    public function getCount($value = array(), $variable = array())
    {
        return (parent::search((array)$value, (count($variable) == 0) ? null : implode(' and ', $variable), $this->tableName . ' item', 'COUNT(item.id) as co')) [0]['co'];
    }
    public function getItems($value = array(), $variable = array(), $sortWith = ['column' => 'id', 'type' => 'ASC'], $pagination = [0, 9999])
    {
        return parent::search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), $this->tableName . ' item', 'item.*', $sortWith, $pagination);
    }
}
