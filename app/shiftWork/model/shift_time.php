<?php
namespace App\shiftWork\model;
use paymentCms\component\browser;
use paymentCms\component\model;
use paymentCms\component\security;
use paymentCms\model\modelInterFace ;

class shift_time extends model implements modelInterFace {
	private $primaryKey = ['shift_id'];
	private $primaryKeyShouldNotInsertOrUpdate = null;
	private $shift_id ;
	private $onDay ;
	private $startTime ;
	private $endTime ;
	private $shift_time_group ;

	public function setFromArray($result) {
		$this->shift_id = $result['shift_id'] ;
		$this->onDay = $result['onDay'] ;
		$this->startTime = $result['startTime'] ;
		$this->endTime = $result['endTime'] ;
		$this->shift_time_group = $result['shift_time_group'] ;
	}

	public function returnAsArray( ) {
		$array['shift_id'] = $this->shift_id ;
		$array['onDay'] = $this->onDay ;
		$array['startTime'] = $this->startTime ;
		$array['endTime'] = $this->endTime ;
		$array['shift_time_group'] = $this->shift_time_group ;
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
	public function getShiftId() {
		return $this->shift_id;
	}

	/**
	 * @param mixed $shift_id
	 */
	public function setShiftId($shift_id) {
		$this->shift_id = $shift_id;
	}

	/**
	 * @return mixed
	 */
	public function getOnDay() {
		return $this->onDay;
	}

	/**
	 * @param mixed $onDay
	 */
	public function setOnDay($onDay) {
		$this->onDay = $onDay;
	}

	/**
	 * @return mixed
	 */
	public function getStartTime() {
		return $this->startTime;
	}

	/**
	 * @param mixed $startTime
	 */
	public function setStartTime($startTime) {
		$this->startTime = $startTime;
	}

	/**
	 * @return mixed
	 */
	public function getEndTime() {
		return $this->endTime;
	}

	/**
	 * @param mixed $endTime
	 */
	public function setEndTime($endTime) {
		$this->endTime = $endTime;
	}

    
    public function setShiftTimeGroup($t){
        $this->shift_time_group = $t;
    }
    
    public function getShiftTimeGroup(){
        return $this->shift_time_group ;
    }

	public function deleteAllRow($id = null){
		if ( $id == null)
			$id = $this->getShiftId();
		parent::deleteOnFullQuery([$id],'shift_id = ?');
	}
}
