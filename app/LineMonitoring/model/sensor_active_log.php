<?php


namespace App\LineMonitoring\model;

use paymentCms\component\browser;
use paymentCms\component\model;
use paymentCms\component\security;
use paymentCms\model\modelInterFace ;

class sensor_active_log extends model implements modelInterFace {

	private $primaryKey = null;
	private $primaryKeyShouldNotInsertOrUpdate = null;
	private $ActivityId ;
	private $Sensor_id ;
	private $Start_time;
	private $JStart_time ;
	private $End_Time ;
	private $JEnd_Time ;
	private $Start_shift_id ;
	private $Start_Shift_group_id ;
	private $Start_employers_id ;
	private $Start_Tile_Kind ;
	private $End_Shift_id ;
	private $End_Shift_group_id ;
	private $End_employers_id ;
	private $End_Tile_Kind ;
	private $phase ;
	private $unit ;
	private $tileDegree ;

	public function setFromArray($result) {
		$this->ActivityId = $result['ActivityId'] ;
		$this->Sensor_id = $result['Sensor_id'] ;
		$this->Start_time = $result['Start_time'] ;
		$this->JStart_time = $result['JStart_time'] ;
		$this->End_Time = $result['End_Time'] ;
		$this->JEnd_Time = $result['JEnd_Time'] ;
		$this->Start_shift_id = $result['Start_shift_id'] ;
		$this->Start_Shift_group_id = $result['Start_Shift_group_id'] ;
		$this->Start_employers_id = $result['Start_employers_id'] ;
		$this->Start_Tile_Kind = $result['Start_Tile_Kind'] ;
		$this->End_Shift_id = $result['End_Shift_id'] ;
		$this->End_Shift_group_id = $result['End_Shift_group_id'] ;
		$this->End_employers_id = $result['End_employers_id'] ;
		$this->End_Tile_Kind = $result['End_Tile_Kind'] ;
		$this->phase = $result['phase'] ;
		$this->unit = $result['unit'] ;
		$this->tileDegree = $result['tileDegree'] ;
	}

	public function returnAsArray( ) {
		$array['Sensor_id'] = $this->Sensor_id ;
		$array['ActivityId'] = $this->ActivityId ;
		$array['Start_time'] = $this->Start_time ;
		$array['JStart_time'] = $this->JStart_time ;
		$array['End_Time'] = $this->End_Time ;
		$array['JEnd_Time'] = $this->JEnd_Time ;
		$array['Start_shift_id'] = $this->Start_shift_id ;
		$array['Start_Shift_group_id'] = $this->Start_Shift_group_id ;
		$array['Start_employers_id'] = $this->Start_employers_id ;
		$array['Start_Tile_Kind'] = $this->Start_Tile_Kind ;
		$array['End_Shift_id'] = $this->End_Shift_id ;
		$array['End_Shift_group_id'] = $this->End_Shift_group_id ;
		$array['End_employers_id'] = $this->End_employers_id ;
		$array['End_Tile_Kind'] = $this->End_Tile_Kind ;
		$array['phase'] = $this->phase ;
		$array['unit'] = $this->unit ;
		$array['tileDegree'] = $this->tileDegree ;
		return $array ;
	}
    
    public function getPrimaryKey(){
		return $this->primaryKey;
	}

	public function getPrimaryKeyShouldNotInsertOrUpdate(){
		return $this->primaryKeyShouldNotInsertOrUpdate;
	}

	public function getSensor_id(){
		return $this->Sensor_id;
	}

	public function setSensor_id($Sensor_id){
		$this->Sensor_id = $Sensor_id;
	}

	public function getStart_time(){
		return $this->Start_time;
	}

	public function setStart_time($Start_time){
		$this->Start_time = $Start_time;
	}

	public function getJStart_time(){
		return $this->JStart_time;
	}

	public function setJStart_time($JStart_time){
		$this->JStart_time = $JStart_time;
	}

	public function getEnd_Time(){
		return $this->End_Time;
	}

	public function setEnd_Time($End_Time){
		$this->End_Time = $End_Time;
	}

	public function getJEnd_Time(){
		return $this->JEnd_Time;
	}

	public function setJEnd_Time($JEnd_Time){
		$this->JEnd_Time = $JEnd_Time;
	}

	public function getStart_shift_id(){
		return $this->Start_shift_id;
	}

	public function setStart_shift_id($Start_shift_id){
		$this->Start_shift_id = $Start_shift_id;
	}

	public function getStart_Shift_group_id(){
		return $this->Start_Shift_group_id;
	}

	public function setStart_Shift_group_id($Start_Shift_group_id){
		$this->Start_Shift_group_id = $Start_Shift_group_id;
	}

	public function getStart_employers_id(){
		return $this->Start_employers_id;
	}

	public function setStart_employers_id($Start_employers_id){
		$this->Start_employers_id = $Start_employers_id;
	}

	public function getStart_Tile_Kind(){
		return $this->Start_Tile_Kind;
	}

	public function setStart_Tile_Kind($Start_Tile_Kind){
		$this->Start_Tile_Kind = $Start_Tile_Kind;
	}

	public function getEnd_Shift_id(){
		return $this->End_Shift_id;
	}

	public function setEnd_Shift_id($End_Shift_id){
		$this->End_Shift_id = $End_Shift_id;
	}

	public function getEnd_Shift_group_id(){
		return $this->End_Shift_group_id;
	}

	public function setEnd_Shift_group_id($End_Shift_group_id){
		$this->End_Shift_group_id = $End_Shift_group_id;
	}

	public function getEnd_employers_id(){
		return $this->End_employers_id;
	}

	public function setEnd_employers_id($End_employers_id){
		$this->End_employers_id = $End_employers_id;
	}

	public function getEnd_Tile_Kind(){
		return $this->End_Tile_Kind;
	}

	public function setEnd_Tile_Kind($End_Tile_Kind){
		$this->End_Tile_Kind = $End_Tile_Kind;
	}

	public function getActivityId(){
		return $this->ActivityId;
	}

	public function setActivityId($End_Tile_Kind){
		$this->ActivityId = $End_Tile_Kind;
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
	public function getTileDegree() {
		return $this->tileDegree;
	}

	/**
	 * @param mixed $tileDegree
	 */
	public function setTileDegree($tileDegree) {
		$this->tileDegree = $tileDegree;
	}

    public function clear($Shift_id,$Shift_group_id) {
        parent::deleteOnFullQuery([ $Shift_id,$Shift_group_id ] , ' ( End_Shift_id != ? and End_Shift_id is not null )  or  ( End_Shift_group_id != ? and End_Shift_group_id is not null )');
    }

    public function updateOneRow() {
        parent::updateOnFullQuery($this->returnAsArray() ,[$this->getActivityId()], ' ActivityId = ?');
    }
}
