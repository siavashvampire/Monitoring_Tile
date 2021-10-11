<?php
namespace App\LineMonitoring\model;

use App\shiftWork\app_provider\api\Day;
use paymentCms\component\model;
use paymentCms\model\modelInterFace ;

class phases_budget extends model implements modelInterFace {
	private $primaryKey = ['phase_id'];
	private $primaryKeyShouldNotInsertOrUpdate = null;
	private $phase_id ;
	private $startTime ;
	private $JStartTime ;
	private $endTime ;
	private $JEndTime ;
	private $budget ;
	private $budgetDiff ;
	private $firstDegree ;
	private $secondDegree ;
	private $thirdDegree ;
	private $fourthDegree ;
	private $fifthDegree ;
	private $firstDegreePer ;
	private $secondDegreePer ;
	private $thirdDegreePer ;
	private $fourthDegreePer ;
	private $fifthDegreePer ;

	public function setFromArray($result) {
		$this->phase_id           = $result['phase_id'] ;
		$this->startTime          = $result['startTime'] ;
		$this->JStartTime         = $result['JStartTime'] ;
		$this->endTime            = $result['endTime'] ;
		$this->JEndTime           = $result['JEndTime'] ;
		$this->budget             = $result['budget'] ;
		$this->budgetDiff         = $result['budgetDiff'] ;
		$this->firstDegree        = $result['firstDegree'] ;
		$this->secondDegree       = $result['secondDegree'] ;
		$this->thirdDegree        = $result['thirdDegree'] ;
		$this->fourthDegree       = $result['fourthDegree'] ;
		$this->fifthDegree        = $result['fifthDegree'] ;
		$this->firstDegreePer     = $result['firstDegreePer'] ;
		$this->secondDegreePer    = $result['secondDegreePer'] ;
		$this->thirdDegreePer     = $result['thirdDegreePer'] ;
		$this->fourthDegreePer    = $result['fourthDegreePer'] ;
		$this->fifthDegreePer     = $result['fifthDegreePer'] ;
	}

	public function returnAsArray( ) {
		$array['phase_id']        = $this->phase_id ;
		$array['startTime']       = $this->startTime ;
		$array['JStartTime']      = $this->JStartTime ;
		$array['endTime']         = $this->endTime ;
		$array['JEndTime']        = $this->JEndTime ;
		$array['budget']          = $this->budget ;
		$array['budgetDiff']      = $this->budgetDiff ;
		$array['firstDegree']     = $this->firstDegree ;
		$array['secondDegree']    = $this->secondDegree ;
		$array['thirdDegree']     = $this->thirdDegree ;
		$array['fourthDegree']    = $this->fourthDegree ;
		$array['fifthDegree']     = $this->fifthDegree ;
		$array['firstDegreePer']  = $this->firstDegreePer ;
		$array['secondDegreePer'] = $this->secondDegreePer ;
		$array['thirdDegreePer']  = $this->thirdDegreePer ;
		$array['fourthDegreePer'] = $this->fourthDegreePer ;
		$array['fifthDegreePer']  = $this->fifthDegreePer ;
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
	public function getPhase_id() {
		return $this->phase_id;
	}

	/**
	 * @param mixed $tile_id
	 */
	public function setPhase_id($Phase_id) {
		$this->phase_id = $Phase_id;
	}

    
    
	/**
	 * @return mixed
	 */
	public function getStartTime() {
		return $this->startTime;
	}

	/**
	 * @param mixed $tile_name
	 */
	public function setStartTime($startTime) {
		$this->startTime = $startTime;
	}
    

    
    
	/**
	 * @return mixed
	 */
	public function getJStartTime() {
		return $this->JStartTime;
	}

	/**
	 * @param mixed $tile_name
	 */
	public function setJStartTime($JStartTime) {
		$this->JStartTime = $JStartTime;
	}
    
    
	/**
	 * @return mixed
	 */
	public function getEndTime() {
		return $this->endTime;
	}

	/**
	 * @param mixed $tile_name
	 */
	public function setEndTime($endTime) {
		$this->endTime = $endTime;
	}
    
	/**
	 * @return mixed
	 */
	public function getJEndTime() {
		return $this->JEndTime;
	}

	/**
	 * @param mixed $tile_name
	 */
	public function setJEndTime($JEndTime) {
		$this->JEndTime = $JEndTime;
	}
        
	/**
	 * @return mixed
	 */
	public function getBudget() {
		return $this->budget;
	}

	/**
	 * @param mixed $tile_id
	 */
	public function setBudget($budget) {
		$this->budget = $budget;
	}
    
	/**
	 * @return mixed
	 */
	public function getBudgetDiff() {
		return $this->budgetDiff;
	}

	/**
	 * @param mixed $tile_id
	 */
	public function setBudgetDiff($budgetDiff) {
		$this->budgetDiff = $budgetDiff;
	}
    
    public function getFirstDegree(){
		return $this->firstDegree;
	}

	public function setFirstDegree($firstDegree){
		$this->firstDegree = $firstDegree;
	}

	public function getSecondDegree(){
		return $this->secondDegree;
	}

	public function setSecondDegree($secondDegree){
		$this->secondDegree = $secondDegree;
	}

	public function getThirdDegree(){
		return $this->thirdDegree;
	}

	public function setThirdDegree($thirdDegree){
		$this->thirdDegree = $thirdDegree;
	}

	public function getFourthDegree(){
		return $this->fourthDegree;
	}

	public function setFourthDegree($fourthDegree){
		$this->fourthDegree = $fourthDegree;
	}

	public function getFifthDegree(){
		return $this->fifthDegree;
	}

	public function setFifthDegree($fifthDegree){
		$this->fifthDegree = $fifthDegree;
	}

	public function getFirstDegreePer(){
		return $this->firstDegreePer;
	}

	public function setFirstDegreePer($firstDegreePer){
		$this->firstDegreePer = $firstDegreePer;
	}

	public function getSecondDegreePer(){
		return $this->secondDegreePer;
	}

	public function setSecondDegreePer($secondDegreePer){
		$this->secondDegreePer = $secondDegreePer;
	}

	public function getThirdDegreePer(){
		return $this->thirdDegreePer;
	}

	public function setThirdDegreePer($thirdDegreePer){
		$this->thirdDegreePer = $thirdDegreePer;
	}

	public function getFourthDegreePer(){
		return $this->fourthDegreePer;
	}

	public function setFourthDegreePer($fourthDegreePer){
		$this->fourthDegreePer = $fourthDegreePer;
	}

	public function getFifthDegreePer(){
		return $this->fifthDegreePer;
	}

	public function setFifthDegreePer($fifthDegreePer){
		$this->fifthDegreePer = $fifthDegreePer;
	}
    
    public function getPhasesBudget($Phase_id = null , $startTime = null , $endTime = null) {
        if ( $Phase_id == null) $Phase_id = $this->getPhase_id();
        
        $value = array();
		$variable = array();
        
        $value[] = $Phase_id;
        $variable[] = 'phase_id = ?';
        
        if ( $startTime != null and $endTime == null){
            $value[] = $startTime;
            $variable[] = '!(endTime < ?)';
        }
        if ( $startTime == null and $endTime != null){
            $value[] = $endTime;
            $variable[] = '!(startTime > ? )';
        }
        if ( $startTime != null and $endTime != null){
            $value[] = $endTime;
            $value[] = $startTime;
            $variable[] = '!(startTime > ? or endTime < ?)'; 
        }
        
		return parent::search($value ,  implode(' and ', $variable) , 'phases_budget', '*'  , ['column' => 'startTime' , 'type' =>'asc'] );
	}
    
    public function deleteAllRow($id = null , $startTime = null , $endTime = null){
		if ( $id == null) $id = $this->getPhase_id();
        
        $value = array();
		$variable = array();
        
        $value[] = $id;
        $variable[] = 'phase_id = ?';
        
       if ( $startTime != null and $endTime == null){
            $value[] = $startTime;
            $variable[] = '!(endTime < ?)';
        }
        if ( $startTime == null and $endTime != null){
            $value[] = $endTime;
            $variable[] = '!(startTime > ? )';
        }
        if ( $startTime != null and $endTime != null){
            $value[] = $endTime;
            $value[] = $startTime;
            $variable[] = '!(startTime > ? or endTime < ?)'; 
        }
		parent::deleteOnFullQuery($value,implode(' and ', $variable));
	}
    
    public function getBudgetWithTime($id = null , $Time = null){
		if ( $id == null)     $id = $this->getPhase_id();
        if ( $Time == null )  $Time = time();
        
        $_SERVER['JsonOff'] = true;
        $Time = date('Y-m-d' , strtotime(Day::index(0,$Time)['result']["dayStart"]));
        unset($_SERVER['JsonOff']);
        
        $value = array();
		$variable = array();
        
        $value[] = $id;
        $variable[] = 'phase_id = ?';
        $value[] = $Time;
        $variable[] = '(? BETWEEN startTime AND endTime)';
        
		return parent::search($value ,  implode(' and ', $variable) , 'phases_budget', '*'  , ['column' => 'startTime' , 'type' =>'asc'] )[0]["budget"];
	}
}
