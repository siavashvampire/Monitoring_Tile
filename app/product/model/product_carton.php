<?php


namespace App\product\model;


use paymentCms\component\model;
use paymentCms\model\modelInterFace ;

class product_carton extends model implements modelInterFace {
    private $tableName = 'product_carton';


    private $primaryKey = ['id'];
	private $primaryKeyShouldNotInsertOrUpdate = 'id';
	private $id ;
	private $label ;
	private $carton_weight ;
	private $carton_theme ;
	private $carton_size ;
	public function setFromArray($result) {
		$this->id = $result['id'] ;
		$this->label = $result['label'] ;
		$this->carton_weight = $result['carton_weight'] ;
		$this->carton_theme = $result['carton_theme'] ;
		$this->carton_size = $result['carton_size'] ;
	}

	public function returnAsArray( ) {
		$array['id'] = $this->id ;
		$array['label'] = $this->label ;
		$array['carton_weight'] = $this->carton_weight ;
		$array['carton_theme'] = $this->carton_theme ;
		$array['carton_size'] = $this->carton_size ;
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
    public function getCartonWeight()
    {
        return $this->carton_weight;
    }

    /**
     * @param mixed $carton_weight
     */
    public function setCartonWeight($carton_weight): void
    {
        $this->carton_weight = $carton_weight;
    }

    /**
     * @return mixed
     */
    public function getCartonTheme()
    {
        return $this->carton_theme;
    }

    /**
     * @param mixed $carton_theme
     */
    public function setCartonTheme($carton_theme): void
    {
        $this->carton_theme = $carton_theme;
    }

    /**
     * @return mixed
     */
    public function getCartonSize()
    {
        return $this->carton_size;
    }

    /**
     * @param mixed $carton_size
     */
    public function setCartonSize($carton_size): void
    {
        $this->carton_size = $carton_size;
    }


    public function getCount($value = array(), $variable = array())
    {
        return (parent::search((array)$value, (count($variable) == 0) ? null : implode(' and ', $variable), $this->tableName . ' item', 'COUNT(item.id) as co')) [0]['co'];
    }
    public function getItems($value = array(), $variable = array(), $sortWith = ['column' => 'id', 'type' => 'asc'], $pagination = [0, 9999])
    {
        parent::join('carton_size c_size', 'c_size.id =  item.carton_size');
        parent::join('carton_theme c_theme', 'c_theme.id =  item.carton_theme');
        return parent::search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), $this->tableName . ' item', 'item.*,c_theme.label as theme_label,c_size.label as size_label', $sortWith, $pagination);
    }
}
