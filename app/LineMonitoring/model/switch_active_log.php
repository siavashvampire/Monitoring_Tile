<?php


namespace App\LineMonitoring\model;


use paymentCms\component\model;
use paymentCms\model\modelInterFace ;

class Switch_active_log extends model implements modelInterFace {

	private $primaryKey = null;
	private $primaryKeyShouldNotInsertOrUpdate = null;
	private $ActivityId ;
	private $Switch_id ;
	private $Start_time;
	private $JStart_time ;
	private $End_Time ;
	private $JEnd_Time ;
	private $Start_shift_id ;
	private $Start_Shift_group_id ;
	private $Start_employers_id ;
	private $End_Shift_id ;
	private $End_Shift_group_id ;
	private $End_employers_id ;
	private $phase ;
	private $unit ;

	public function setFromArray($result) {
		$this->ActivityId = $result['ActivityId'] ;
		$this->Switch_id = $result['Switch_id'] ;
		$this->Start_time = $result['Start_time'] ;
		$this->JStart_time = $result['JStart_time'] ;
		$this->End_Time = $result['End_Time'] ;
		$this->JEnd_Time = $result['JEnd_Time'] ;
		$this->Start_shift_id = $result['Start_shift_id'] ;
		$this->Start_Shift_group_id = $result['Start_Shift_group_id'] ;
		$this->Start_employers_id = $result['Start_employers_id'] ;
		$this->End_Shift_id = $result['End_Shift_id'] ;
		$this->End_Shift_group_id = $result['End_Shift_group_id'] ;
		$this->End_employers_id = $result['End_employers_id'] ;
		$this->phase = $result['phase'] ;
		$this->unit = $result['unit'] ;
	}

	public function returnAsArray( ) {
		$array['Switch_id'] = $this->Switch_id ;
		$array['ActivityId'] = $this->ActivityId ;
		$array['Start_time'] = $this->Start_time ;
		$array['JStart_time'] = $this->JStart_time ;
		$array['End_Time'] = $this->End_Time ;
		$array['JEnd_Time'] = $this->JEnd_Time ;
		$array['Start_shift_id'] = $this->Start_shift_id ;
		$array['Start_Shift_group_id'] = $this->Start_Shift_group_id ;
		$array['Start_employers_id'] = $this->Start_employers_id ;
		$array['End_Shift_id'] = $this->End_Shift_id ;
		$array['End_Shift_group_id'] = $this->End_Shift_group_id ;
		$array['End_employers_id'] = $this->End_employers_id ;
		$array['phase'] = $this->phase ;
		$array['unit'] = $this->unit ;
		return $array ;
	}
    
    public function getPrimaryKey(){
		return $this->primaryKey;
	}

	public function getPrimaryKeyShouldNotInsertOrUpdate(){
		return $this->primaryKeyShouldNotInsertOrUpdate;
	}

    /**
     * @return mixed
     */
    public function getActivityId()
    {
        return $this->ActivityId;
    }

    /**
     * @param mixed $ActivityId
     */
    public function setActivityId($ActivityId): void
    {
        $this->ActivityId = $ActivityId;
    }

    /**
     * @return mixed
     */
    public function getSwitchId()
    {
        return $this->Switch_id;
    }

    /**
     * @param mixed $Switch_id
     */
    public function setSwitchId($Switch_id): void
    {
        $this->Switch_id = $Switch_id;
    }

    /**
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->Start_time;
    }

    /**
     * @param mixed $Start_time
     */
    public function setStartTime($Start_time): void
    {
        $this->Start_time = $Start_time;
    }

    /**
     * @return mixed
     */
    public function getJStartTime()
    {
        return $this->JStart_time;
    }

    /**
     * @param mixed $JStart_time
     */
    public function setJStartTime($JStart_time): void
    {
        $this->JStart_time = $JStart_time;
    }

    /**
     * @return mixed
     */
    public function getEndTime()
    {
        return $this->End_Time;
    }

    /**
     * @param mixed $End_Time
     */
    public function setEndTime($End_Time): void
    {
        $this->End_Time = $End_Time;
    }

    /**
     * @return mixed
     */
    public function getJEndTime()
    {
        return $this->JEnd_Time;
    }

    /**
     * @param mixed $JEnd_Time
     */
    public function setJEndTime($JEnd_Time): void
    {
        $this->JEnd_Time = $JEnd_Time;
    }

    /**
     * @return mixed
     */
    public function getStartShiftId()
    {
        return $this->Start_shift_id;
    }

    /**
     * @param mixed $Start_shift_id
     */
    public function setStartShiftId($Start_shift_id): void
    {
        $this->Start_shift_id = $Start_shift_id;
    }

    /**
     * @return mixed
     */
    public function getStartShiftGroupId()
    {
        return $this->Start_Shift_group_id;
    }

    /**
     * @param mixed $Start_Shift_group_id
     */
    public function setStartShiftGroupId($Start_Shift_group_id): void
    {
        $this->Start_Shift_group_id = $Start_Shift_group_id;
    }

    /**
     * @return mixed
     */
    public function getStartEmployersId()
    {
        return $this->Start_employers_id;
    }

    /**
     * @param mixed $Start_employers_id
     */
    public function setStartEmployersId($Start_employers_id): void
    {
        $this->Start_employers_id = $Start_employers_id;
    }

    /**
     * @return mixed
     */
    public function getEndShiftId()
    {
        return $this->End_Shift_id;
    }

    /**
     * @param mixed $End_Shift_id
     */
    public function setEndShiftId($End_Shift_id): void
    {
        $this->End_Shift_id = $End_Shift_id;
    }

    /**
     * @return mixed
     */
    public function getEndShiftGroupId()
    {
        return $this->End_Shift_group_id;
    }

    /**
     * @param mixed $End_Shift_group_id
     */
    public function setEndShiftGroupId($End_Shift_group_id): void
    {
        $this->End_Shift_group_id = $End_Shift_group_id;
    }

    /**
     * @return mixed
     */
    public function getEndEmployersId()
    {
        return $this->End_employers_id;
    }

    /**
     * @param mixed $End_employers_id
     */
    public function setEndEmployersId($End_employers_id): void
    {
        $this->End_employers_id = $End_employers_id;
    }

    /**
     * @return mixed
     */
    public function getPhase()
    {
        return $this->phase;
    }

    /**
     * @param mixed $phase
     */
    public function setPhase($phase): void
    {
        $this->phase = $phase;
    }

    /**
     * @return mixed
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param mixed $unit
     */
    public function setUnit($unit): void
    {
        $this->unit = $unit;
    }

    public function clear($Shift_id,$Shift_group_id) {
//		parent::deleteOnFullQuery([ date('Y-m-d 00:00:00') ] , ' DATE(Start_time) < ? ');
        parent::deleteOnFullQuery([ $Shift_id,$Shift_group_id ] , ' ( End_Shift_id != ? and End_Shift_id is not null )  or  ( End_Shift_group_id != ? and End_Shift_group_id is not null )');
    }

    public function updateOneRow() {
        parent::updateOnFullQuery($this->returnAsArray() ,[$this->getActivityId()], ' ActivityId = ?');
    }
}
