<?php


namespace App\product\model;


use paymentCms\component\model;
use paymentCms\model\modelInterFace ;

class grading_statistics_space extends model implements modelInterFace {
    private $tableName = "grading_statistics_space";

	private $primaryKey = [];
	private $primaryKeyShouldNotInsertOrUpdate = null;
	private $grading_statistic_id ;
	private $degree_id ;
	private $space ;
	public function setFromArray($result) {
		$this->grading_statistic_id = $result['grading_statistic_id'] ;
		$this->degree_id = $result['degree_id'] ;
		$this->space = $result['space'] ;
	}

	public function returnAsArray( ) {
		$array['grading_statistic_id'] = $this->grading_statistic_id ;
		$array['degree_id'] = $this->degree_id ;
		$array['space'] = $this->space ;
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
    public function getGradingStatisticId()
    {
        return $this->grading_statistic_id;
    }

    /**
     * @param mixed $grading_statistic_id
     */
    public function setGradingStatisticId($grading_statistic_id): void
    {
        $this->grading_statistic_id = $grading_statistic_id;
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

    /**
     * @return mixed
     */
    public function getSpace()
    {
        return $this->space;
    }

    /**
     * @param mixed $space
     */
    public function setSpace($space): void
    {
        $this->space = $space;
    }

}
