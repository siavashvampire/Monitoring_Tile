<?php


namespace App\product\model;


use paymentCms\component\JDate;
use paymentCms\component\model;
use paymentCms\model\modelInterFace ;

class disadvantages extends model implements modelInterFace {
    private $tableName = "disadvantages";

	private $primaryKey = ['id'];
	private $primaryKeyShouldNotInsertOrUpdate = 'id';
	private $id ;
	private $product_id ;
	private $phases_id ;
	private $shift_id ;
	private $insert_date ;
	private $insert_id ;
	private $routine_date ;
	public function setFromArray($result) {
		$this->id = $result['id'] ;
		$this->product_id = $result['product_id'] ;
		$this->phases_id = $result['phases_id'] ;
		$this->shift_id = $result['shift_id'] ;
		$this->insert_date = $result['insert_date'] ;
		$this->insert_id = $result['insert_id'] ;
		$this->routine_date = $result['routine_date'] ;
	}

	public function returnAsArray( ) {
		$array['id'] = $this->id ;
		$array['product_id'] = $this->product_id ;
		$array['phases_id'] = $this->phases_id ;
		$array['shift_id'] = $this->shift_id ;
		$array['insert_date'] = $this->insert_date ;
		$array['insert_id'] = $this->insert_id ;
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
    public function getItems($disadvantages = [] , $value = array(), $variable = array(), $sortWith = ['column' => 'id', 'type' => 'ASC'], $pagination = [0, 9999])
    {
        if ( count($disadvantages) == 0  )
            $disadvantages = (new disadvantages())->getItems();
        $select = ['item.id' ,
            'item.routine_date' ,
            'item.product_id' ,
            'item.phases_id' ,
            'item.shift_id' ,
            'degree.id as degree_id' ,
            'novanc.label as novanc' ,
            'product.label as product',
            'product.size as size_id',
            'product_size.label as size',
            'product.body as body_id',
            'product_body.label as body',
            'CONCAT(user.fname , \' \',user.lname) as user',
            'user.userId as user_id',
        ];
        parent::join('disadvantages_count' ,  'disadvantages_count.disadvantages_id = item.id');
        parent::join('phases as phases' ,  'phases.id = item.phases_id');
        parent::join('shift_work as shift' ,  'shift.shift_id = item.shift_id');
        parent::join('user as user' ,  'user.userId = item.insert_id');
        parent::join('product_degree as degree' ,  'degree.id = disadvantages_count.degree_id');

        foreach ($disadvantages as  $disadvantage){
            $select[] = 'MAX(CASE WHEN space.degree_id = \''.$disadvantage['id'].'\' 
                THEN space.space END) as `'.$disadvantage['label'].'`';
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

    /**
     * @return mixed
     */
    public function getInsertId()
    {
        return $this->insert_id;
    }

    /**
     * @param mixed $insert_id
     */
    public function setInsertId($insert_id): void
    {
        $this->insert_id = $insert_id;
    }

    /**
     * @return mixed
     */
    public function getPhasesId()
    {
        return $this->phases_id;
    }

    /**
     * @param mixed $phases_id
     */
    public function setPhasesId($phases_id): void
    {
        $this->phases_id = $phases_id;
    }

    /**
     * @return mixed
     */
    public function getShiftId()
    {
        return $this->shift_id;
    }

    /**
     * @param mixed $shift_id
     */
    public function setShiftId($shift_id): void
    {
        $this->shift_id = $shift_id;
    }
}
