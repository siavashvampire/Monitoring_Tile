<?php


namespace App\product\model;


use paymentCms\component\model;
use paymentCms\model\modelInterFace ;

class product_carton_packing extends model implements modelInterFace {
    private $tableName = "product_carton_packing";

	private $primaryKey = ['id'];
	private $primaryKeyShouldNotInsertOrUpdate = 'id';
	private $id ;
	private $label ;
	private $carton ;
	private $glue ;
	private $number_of_tiles ;
	private $plastic ;
	private $strap ;
	private $plastic_weight ;
	private $strap_weight ;
	private $glue_weight ;
	public function setFromArray($result) {
		$this->id = $result['id'] ;
		$this->label = $result['label'] ;
		$this->carton = $result['carton'] ;
		$this->glue = $result['glue'] ;
		$this->number_of_tiles = $result['number_of_tiles'] ;
		$this->plastic = $result['plastic'] ;
		$this->strap = $result['strap'] ;
		$this->plastic_weight = $result['plastic_weight'] ;
		$this->strap_weight = $result['strap_weight'] ;
		$this->glue_weight = $result['glue_weight'] ;
	}

	public function returnAsArray( ) {
		$array['id'] = $this->id ;
		$array['label'] = $this->label ;
		$array['carton'] = $this->carton ;
		$array['glue'] = $this->glue ;
		$array['number_of_tiles'] = $this->number_of_tiles ;
		$array['plastic'] = $this->plastic ;
		$array['strap'] = $this->strap ;
		$array['plastic_weight'] = $this->plastic_weight ;
		$array['strap_weight'] = $this->strap_weight ;
		$array['glue_weight'] = $this->glue_weight ;
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
    public function getGlue()
    {
        return $this->glue;
    }

    /**
     * @param mixed $glue
     */
    public function setGlue($glue): void
    {
        $this->glue = $glue;
    }

    /**
     * @return mixed
     */
    public function getNumberOfTiles()
    {
        return $this->number_of_tiles;
    }

    /**
     * @param mixed $number_of_tiles
     */
    public function setNumberOfTiles($number_of_tiles): void
    {
        $this->number_of_tiles = $number_of_tiles;
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

    /**
     * @return mixed
     */
    public function getGlueWeight()
    {
        return $this->glue_weight;
    }

    /**
     * @param mixed $glue_weight
     */
    public function setGlueWeight($glue_weight): void
    {
        $this->glue_weight = $glue_weight;
    }


    public function getCount($value = array(), $variable = array())
    {
        return (parent::search((array)$value, (count($variable) == 0) ? null : implode(' and ', $variable), $this->tableName . ' item', 'COUNT(item.id) as co')) [0]['co'];
    }
    public function getItems($value = array(), $variable = array(), $sortWith = ['column' => 'id', 'type' => 'ASC'], $pagination = [0, 9999])
    {
        parent::join('product_carton carton', 'carton.id =  item.carton');
        parent::join('product_glue glue', 'glue.id =  item.glue');
        parent::join('product_strap strap', 'strap.id =  item.strap');
        parent::join('product_plastic plastic', 'plastic.id =  item.plastic');
        return parent::search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), $this->tableName . ' item', 'item.*,carton.label as carton_label,glue.label as glue_label,strap.label as strap_label,plastic.label as plastic_label', $sortWith, $pagination);
    }
}
