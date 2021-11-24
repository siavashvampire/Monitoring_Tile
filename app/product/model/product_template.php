<?php


namespace App\product\model;


use paymentCms\component\model;
use paymentCms\model\modelInterFace ;

class product_template extends model implements modelInterFace {
    private $tableName = 'product_template';


    private $primaryKey = ['id'];
	private $primaryKeyShouldNotInsertOrUpdate = 'id';
	private $id ;
	private $label ;
	private $bumper_glue ;
	private $selfon ;
	private $weight_after_chamfer ;
	public function setFromArray($result) {
		$this->id = $result['id'] ;
		$this->label = $result['label'] ;
		$this->bumper_glue = $result['bumper_glue'] ;
		$this->selfon = $result['selfon'] ;
		$this->weight_after_chamfer = $result['weight_after_chamfer'] ;
	}

	public function returnAsArray( ) {
		$array['id'] = $this->id ;
		$array['label'] = $this->label ;
		$array['bumper_glue'] = $this->bumper_glue ;
		$array['selfon'] = $this->selfon ;
		$array['weight_after_chamfer'] = $this->weight_after_chamfer ;
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
    public function getBumperGlue()
    {
        return $this->bumper_glue;
    }

    /**
     * @param mixed $bumper_glue
     */
    public function setBumperGlue($bumper_glue): void
    {
        $this->bumper_glue = $bumper_glue;
    }

    /**
     * @return mixed
     */
    public function getSelfon()
    {
        return $this->selfon;
    }

    /**
     * @param mixed $selfon
     */
    public function setSelfon($selfon): void
    {
        $this->selfon = $selfon;
    }

    /**
     * @return mixed
     */
    public function getWeightAfterChamfer()
    {
        return $this->weight_after_chamfer;
    }

    /**
     * @param mixed $weight_after_chamfer
     */
    public function setWeightAfterChamfer($weight_after_chamfer): void
    {
        $this->weight_after_chamfer = $weight_after_chamfer;
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
