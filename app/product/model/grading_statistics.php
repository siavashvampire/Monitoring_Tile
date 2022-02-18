<?php


namespace App\product\model;


use paymentCms\component\JDate;
use paymentCms\component\model;
use paymentCms\model\modelInterFace ;

class grading_statistics extends model implements modelInterFace {
    private $tableName = "grading_statistics";

	private $primaryKey = ['id'];
	private $primaryKeyShouldNotInsertOrUpdate = 'id';
	private $id ;
	private $product_id ;
	private $novanc_id ;
	private $insert_date ;
	private $routine_date ;
	public function setFromArray($result) {
		$this->id = $result['id'] ;
		$this->product_id = $result['product_id'] ;
		$this->novanc_id = $result['novanc_id'] ;
		$this->insert_date = $result['insert_date'] ;
		$this->routine_date = $result['routine_date'] ;
	}

	public function returnAsArray( ) {
		$array['id'] = $this->id ;
		$array['product_id'] = $this->product_id ;
		$array['novanc_id'] = $this->novanc_id ;
		$array['insert_date'] = $this->insert_date ;
		$array['routine_date'] = $this->routine_date ;
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

    public function getCount($value = array(), $variable = array())
    {
        return (parent::search((array)$value, (count($variable) == 0) ? null : implode(' and ', $variable), $this->tableName . ' item', 'COUNT(item.id) as co')) [0]['co'];
    }
    public function getItems($kind_degree = [] , $value = array(), $variable = array(), $sortWith = ['column' => 'id', 'type' => 'ASC'], $pagination = [0, 9999])
    {
        if ( count($kind_degree) == 0  )
            $kind_degree = (new product_degree())->getItems();
        $select = ['item.id' ,
            'item.routine_date' ,
            'item.product_id' ,
            'item.novanc_id' ,
            'novanc.label as novanc' ,
            'product.label as product',
            'product.size as size_id',
            'product_size.label as size',
            'product.body as body_id',
            'product_body.label as body',
        ];
        parent::join('grading_statistics_space as space' ,  'space.grading_statistic_id = item.id');
        parent::join('product_novanc as novanc' ,  'novanc.id = item.novanc_id');
        parent::join('product as product' ,  'product.id = item.product_id');
        parent::join('product_size as product_size' ,  'product_size.id = product.size');
        parent::join('product_body as product_body' ,  'product_body.id = product.body');

        foreach ($kind_degree as  $degree){
            $select[] = 'MAX(CASE WHEN space.degree_id = \''.$degree['id'].'\' 
                THEN space.space END) as `'.$degree['label'].'`';
        }
        $select[] = 'SUM(space.space) as `sum`';
        $data = parent::search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), $this->tableName . ' item', implode(' , ' , $select), $sortWith, $pagination ,'item.id');
        return $data;
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
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * @param mixed $product_id
     */
    public function setProductId($product_id): void
    {
        $this->product_id = $product_id;
    }

    /**
     * @return mixed
     */
    public function getNovancId()
    {
        return $this->novanc_id;
    }

    /**
     * @param mixed $novanc_id
     */
    public function setNovancId($novanc_id): void
    {
        $this->novanc_id = $novanc_id;
    }

    /**
     * @return mixed
     */
    public function getInsertDate()
    {
        return $this->insert_date;
    }

    /**
     * @param mixed $insert_date
     */
    public function setInsertDate($insert_date): void
    {
        $this->insert_date = $insert_date;
    }

    /**
     * @return mixed
     */
    public function getRoutineDate()
    {
        return $this->routine_date;
    }

    /**
     * @return mixed
     */
    public function getJDate()
    {
        return $this->routine_date != null ? JDate::jdate('Y/m/d' , strtotime($this->routine_date)) : null ;
    }

    /**
     * @param mixed $routine_date
     */
    public function setRoutineDate($routine_date): void
    {
        $this->routine_date = $routine_date;
    }
}
