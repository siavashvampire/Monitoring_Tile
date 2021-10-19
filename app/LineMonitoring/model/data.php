<?php
namespace App\LineMonitoring\model;

use paymentCms\component\browser;
use paymentCms\component\model;
use paymentCms\component\security;
use paymentCms\model\modelInterFace ;

class data extends model implements modelInterFace {
	private $primaryKey = null;
	private $primaryKeyShouldNotInsertOrUpdate = null;
	private $Sensor_id ;
	private $Start_time ;
	private $JStart_time ;
	private $AbsTime ;
	private $counter ;
	private $Shift_id ;
	private $employers_id ;
	private $Tile_Kind ;
	private $Motor_Speed ;
	private $Shift_group_id ;
	private $phase ;
	private $unit ;
	private $tileDegree ;

	public function setFromArray($result) {
		$this->Sensor_id = $result['Sensor_id'] ;
		$this->Start_time = $result['Start_time'] ;
		$this->JStart_time = $result['JStart_time'] ;
		$this->AbsTime = $result['AbsTime'] ;
		$this->Shift_id = $result['Shift_id'] ;
		$this->employers_id = $result['employers_id'] ;
		$this->Tile_Kind = $result['Tile_Kind'] ;
		$this->counter = $result['counter'] ;
		$this->Motor_Speed = $result['Motor_Speed'] ;
		$this->Shift_group_id = $result['Shift_group_id'] ;
		$this->phase = $result['phase'] ;
		$this->unit = $result['unit'] ;
		$this->tileDegree = $result['tileDegree'] ;
	}

	public function returnAsArray( ) {
		$array['Sensor_id'] = $this->Sensor_id ;
		$array['Start_time'] = $this->Start_time ;
		$array['JStart_time'] = $this->JStart_time ;
		$array['AbsTime'] = $this->AbsTime ;
		$array['counter'] = $this->counter ;
		$array['Shift_id'] = $this->Shift_id ;
		$array['employers_id'] = $this->employers_id ;
		$array['Tile_Kind'] = $this->Tile_Kind ;
		$array['Motor_Speed'] = $this->Motor_Speed ;
		$array['Shift_group_id'] = $this->Shift_group_id ;
		$array['phase'] = $this->phase ;
		$array['unit'] = $this->unit ;
		$array['tileDegree'] = $this->tileDegree ;
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
	public function getSensorId() {
		return $this->Sensor_id;
	}

	/**
	 * @param mixed $Sensor_id
	 */
	public function setSensorId($Sensor_id) {
		$this->Sensor_id = $Sensor_id;
	}

	/**
	 * @return mixed
	 */
	public function getStartTime() {
		return $this->Start_time;
	}

	/**
	 * @param mixed $Start_time
	 */
	public function setStartTime($Start_time) {
		$this->Start_time = $Start_time;
	}

	/**
	 * @return mixed
	 */
	public function getAbsTime() {
		return $this->AbsTime;
	}

	/**
	 * @param mixed $Times
	 */
	public function setAbsTime($Times) {
		$this->AbsTime = $Times;
	}

	/**
	 * @return mixed
	 */
	public function getShiftId() {
		return $this->Shift_id;
	}

	/**
	 * @param mixed $Shift_id
	 */
	public function setShiftId($Shift_id) {
		$this->Shift_id = $Shift_id;
	}

	/**
	 * @return mixed
	 */
	public function getEmployersId() {
		return $this->employers_id;
	}

	/**
	 * @param mixed $employers_id
	 */
	public function setEmployersId($employers_id) {
		$this->employers_id = $employers_id;
	}


	/**
	 * @return mixed
	 */
	public function getTileKind() {
		return $this->Tile_Kind;
	}

	/**
	 * @param mixed $employers_id
	 */
	public function setTileKind($employers_id) {
		$this->Tile_Kind = $employers_id;
	}


	/**
	 * @return mixed
	 */
	public function getMotorSpeed() {
		return $this->Motor_Speed;
	}

	/**
	 * @param mixed $employers_id
	 */
	public function setMotorSpeed($employers_id) {
		$this->Motor_Speed = $employers_id;
	}

	/**
	 * @return mixed
	 */
	public function getCounter() {
		return $this->counter;
	}

	/**
	 * @param mixed $counter
	 */
	public function setCounter($counter) {
		$this->counter = $counter;
	}
	/**
	 * @return mixed
	 */
	public function getShiftGroupId() {
		return $this->Shift_group_id;
	}

	/**
	 * @param mixed $counter
	 */
	public function setShiftGroupId($counter) {
		$this->Shift_group_id = $counter;
	}

	public function clear($Shift_id,$Shift_group_id) {
//		parent::deleteOnFullQuery([ date('Y-m-d 00:00:00') ] , ' DATE(Start_time) < ? ');
		parent::deleteOnFullQuery([ $Shift_id,$Shift_group_id ,-1] , ' (Shift_id != ? or Shift_group_id != ?) AND (Shift_id <> ?)');
	}

	/**
	 * @return mixed
	 */
	public function getPhase() {
		return $this->phase;
	}

	/**
	 * @param mixed $phase
	 */
	public function setPhase($phase) {
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

	/**
	 * @return mixed
	 */
	public function getTileDegree() {
		return $this->tileDegree;
	}

	/**
	 * @param mixed $tileDegree
	 */
	public function setTileDegree($tileDegree) {
		$this->tileDegree = $tileDegree;
	}

	/**
	 * @return mixed
	 */
	public function getJStartTime() {
		return $this->JStart_time;
	}

	/**
	 * @param mixed $JStart_time
	 */
	public function setJStartTime($JStart_time) {
		$this->JStart_time = $JStart_time;
	}
    
    public function mergeDB(){
		$db = (model::db());
		$perfix = $db::$prefix ;
        $tempDBName = $perfix.'temp_merge_data';
        $DBName = $perfix.'data';
        model::queryUnprepared('DROP TABLE IF EXISTS '.$tempDBName.';');
        model::queryUnprepared('CREATE TEMPORARY TABLE IF NOT EXISTS '.$tempDBName.' select `Sensor_id`,`Start_time`,`JStart_time`,`AbsTime`,SUM(`counter`) as `counter` from '.$DBName.' WHERE `Shift_id` = -1 GROUP BY `Sensor_id`;');
		model::queryUnprepared('DELETE FROM '.$perfix.'data WHERE `Shift_id` = -1 AND Shift_group_id = -1;');
        model::queryUnprepared('UPDATE  '.$DBName.' AS data LEFT JOIN '.$tempDBName.' tdata on ( data.Sensor_id = tdata.Sensor_id) SET data.counter = tdata.counter , data.Start_time = NOW() , data.JStart_time = tdata.JStart_time  WHERE  data.Shift_id = -1 AND data.Shift_group_id = 0;');
	}
    public function InsertZeroStorage($SensorID , $Tile_Kind , $phase , $unit , $tileDegree){
		$db = (model::db());
		$perfix = $db::$prefix ;
		model::queryUnprepared('INSERT INTO '.$perfix.'data(`Sensor_id`, `AbsTime`, `counter`, `Shift_id`, `Shift_group_id`, `employers_id`, `Tile_Kind`, `Motor_Speed`, `phase`, `unit`, `tileDegree`) VALUES ('.$SensorID.',100,0,-1,0,-1,'.$Tile_Kind.',100,'.$phase.','.$unit.',"'.$tileDegree.'");');
	}
    public function UpdateZeroStorage($SensorID , $Tile_Kind , $phase , $unitId , $tileDegree){
		$db = (model::db());
		$perfix = $db::$prefix ;
        model::queryUnprepared('UPDATE '.$perfix.'data SET Tile_Kind="' . $Tile_Kind . '",phase="' . $phase . '",unitId="' . $unitId . '",tileDegree="' . $tileDegree . '" WHERE Shift_id = -1 AND Shift_group_id = 0 AND Sensor_id = "' . $SensorID . '";');
	}

}
