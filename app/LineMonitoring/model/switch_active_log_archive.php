<?php


namespace App\LineMonitoring\model;



use paymentCms\component\model;
use paymentCms\model\modelInterFace ;

class switch_active_log_archive extends model implements modelInterFace {

	private $primaryKey = ['ActivityId'];
	private $primaryKeyShouldNotInsertOrUpdate = 'ActivityId';
	private $ActivityId ;
	private $id ;
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
	private $unitId ;
	private $reason ;
	private $description ;
	private $infoInsert ;

	public function setFromArray($result) {
		$this->ActivityId = $result['ActivityId'] ;
		$this->id = $result['id'] ;
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
		$this->unitId = $result['unitId'] ;
		$this->description = $result['description'] ;
		$this->reason = $result['reason'] ;
		$this->infoInsert = $result['infoInsert'] ;
	}

	public function returnAsArray( ) {
		$array['id'] = $this->id ;
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
		$array['unitId'] = $this->unitId ;
		$array['description'] = $this->description ;
		$array['reason'] = $this->reason ;
		$array['infoInsert'] = $this->infoInsert ;
		return $array ;
	}
    
    public function getPrimaryKey(){
		return $this->primaryKey;
	}

	public function getPrimaryKeyShouldNotInsertOrUpdate(){
		return $this->primaryKeyShouldNotInsertOrUpdate;
	}

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
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

	public function getActivityId(){
		return $this->ActivityId;
	}

	public function setActivityId($End_Tile_Kind){
		$this->ActivityId = $End_Tile_Kind;
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
	public function getUnitId() {
		return $this->unitId;
	}

	/**
	 * @param mixed $unitId
	 */
	public function setUnit($unitId) {
		$this->unitId = $unitId;
	}

	/**
	 * @return mixed
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param mixed $description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * @return mixed
	 */
	public function getReason() {
		return $this->reason;
	}

	/**
	 * @param mixed $reason
	 */
	public function setReason($reason) {
		$this->reason = $reason;
	}

	/**
	 * @return mixed
	 */
	public function getInfoInsert() {
		return $this->infoInsert;
	}

	/**
	 * @param mixed $infoInsert
	 */
	public function setInfoInsert($infoInsert) {
		$this->infoInsert = $infoInsert;
	}

}
