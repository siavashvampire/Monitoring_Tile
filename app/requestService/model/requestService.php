<?php


namespace App\requestService\model;


use paymentCms\component\browser;
use paymentCms\component\model;
use paymentCms\component\security;
use paymentCms\model\modelInterFace ;

class requestService extends model implements modelInterFace {

	private $primaryKey = ['requestId'];
	private $primaryKeyShouldNotInsertOrUpdate = 'requestId';
	private $requestId ;
	private $requestCode ;
	private $Time_Send ;
	private $JTime_Send ;
	private $Time_Start ;
	private $Time_End ;
	private $System_Name ;
	private $phase ;
	private $section ;
	private $Line ;
	private $Cost ;
	private $WorkerSection ;
	private $offTime ;
	private $System_Status ;
	private $WorkTitle ;
	private $BugInfluence ;
	private $latency ;
	private $latencyTime ;
	private $failure ;
	private $failureDes ;
	private $donework ;
	private $doneworkDes ;
	private $unitPerson_id ;
	private $workerPerson_id ;
	private $Sender_note ;
	private $HumanNumber ;
	private $Consumable_Parts ;
	private $Consumable_Parts_Qty ;

	public function setFromArray($result) {
		$this->requestId        =  $result['requestId'] ;
		$this->requestCode        =  $result['requestCode'] ;
		$this->Time_Send        =  $result['Time_Send'] ;
		$this->JTime_Send        =  $result['JTime_Send'] ;
		$this->Time_Start        =  $result['Time_Start'] ;
		$this->Time_End        =  $result['Time_End'] ;
		$this->System_Name        =  $result['System_Name'] ;
		$this->phase         =  $result['phase'] ;
		$this->section         =  $result['section'] ;
		$this->Line          =  $result['Line'] ;
		$this->Cost          =  $result['Cost'] ;
		$this->WorkerSection    =  $result['WorkerSection'] ;
		$this->offTime    =  $result['offTime'] ;
		$this->System_Status =  $result['System_Status'] ;
		$this->WorkTitle     =  $result['WorkTitle'] ;
		$this->BugInfluence  =  $result['BugInfluence'] ;
		$this->latency  =  $result['latency'] ;
		$this->latencyTime  =  $result['latencyTime'] ;
		$this->failure  =  $result['failure'] ;
		$this->failureDes  =  $result['failureDes'] ;
		$this->donework  =  $result['donework'] ;
		$this->doneworkDes  =  $result['doneworkDes'] ;
		$this->unitPerson_id  =  $result['unitPerson_id'] ;
		$this->workerPerson_id  =  $result['workerPerson_id'] ;
		$this->Sender_note  =  $result['Sender_note'] ;
		$this->HumanNumber  =  $result['HumanNumber'] ;
		$this->Consumable_Parts  =  $result['Consumable_Parts'] ;
		$this->Consumable_Parts_Qty  =  $result['Consumable_Parts_Qty'] ;
	}

	public function returnAsArray( ) {
		$array['requestId']          = $this->requestId ;
		$array['requestCode']          = $this->requestCode ;
		$array['Time_Send']          = $this->Time_Send ;
		$array['JTime_Send']          = $this->JTime_Send ;
		$array['Time_Start']          = $this->Time_Start ;
		$array['Time_End']          = $this->Time_End ;
		$array['System_Name']          = $this->System_Name ;
		$array['phase']           = $this->phase ;
		$array['section']           = $this->section ;
		$array['Line']            = $this->Line ;
		$array['Cost']            = $this->Cost ;
		$array['WorkerSection']      = $this->WorkerSection ;
		$array['offTime']      = $this->offTime ;
		$array['System_Status']   = $this->System_Status ;
		$array['WorkTitle']       = $this->WorkTitle ;
		$array['BugInfluence']    = $this->BugInfluence ;
		$array['latency']    = $this->latency ;
		$array['latencyTime']    = $this->latencyTime ;
		$array['failure']    = $this->failure ;
		$array['failureDes']    = $this->failureDes ;
		$array['donework']    = $this->donework ;
		$array['doneworkDes']    = $this->doneworkDes ;
		$array['unitPerson_id']    = $this->unitPerson_id ;
		$array['workerPerson_id']    = $this->workerPerson_id ;
		$array['Sender_note']    = $this->Sender_note ;
		$array['HumanNumber']    = $this->HumanNumber ;
		$array['Consumable_Parts']    = $this->Consumable_Parts ;
		$array['Consumable_Parts_Qty']    = $this->Consumable_Parts_Qty ;
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
    
    
    public function getRequestId() {
		return $this->requestId;
	}

	public function setRequestId($requestId) {
		$this->requestId = $requestId;
	}
        
    public function getRequestCode() {
		return $this->requestCode;
	}

	public function setRequestCode($requestCode) {
		$this->requestCode = $requestCode;
	}
    
    public function getTime_Send(){
		return $this->Time_Send;
	}

	public function setTime_Send($Time_Send){
		$this->Time_Send = $Time_Send;
	} 
            
    public function getJTime_Send(){
		return $this->JTime_Send;
	}

	public function setJTime_Send($JTime_Send){
		$this->JTime_Send = $JTime_Send;
	} 
        
    public function getTime_Start(){
		return $this->Time_Start;
	}

	public function setTime_Start($Time_Start){
		$this->Time_Start = $Time_Start;
	}     
    public function getTime_End(){
		return $this->Time_End;
	}

	public function setTime_End($Time_End){
		$this->Time_End = $Time_End;
	} 
    
    public function getSystem_Name(){
		return $this->System_Name;
	}

	public function setSystem_Name($System_Name){
		$this->System_Name = $System_Name;
	}

	public function getPhase(){
		return $this->phase;
	}

	public function setPhase($phase){
		$this->phase = $phase;
	}

	public function getLine(){
		return $this->Line;
	}

	public function setLine($Line){
		$this->Line = $Line;
	}

	public function getCost(){
		return $this->Cost;
	}

	public function setCost($Cost){
		$this->Cost = $Cost;
	}

	public function getWorkerSection(){
		return $this->WorkerSection;
	}

	public function setWorkerSection($WorkerSection){
		$this->WorkerSection = $WorkerSection;
	}
    

	public function getOffTime(){
		return $this->offTime;
	}

	public function setOffTime($offTime){
		$this->offTime = $offTime;
	}

	public function getSystem_Status(){
		return $this->System_Status;
	}

	public function setSystem_Status($System_Status){
		$this->System_Status = $System_Status;
	}

	public function getWorkTitle(){
		return $this->WorkTitle;
	}

	public function setWorkTitle($WorkTitle){
		$this->WorkTitle = $WorkTitle;
	}

	public function getBugInfluence(){
		return $this->BugInfluence;
	}

	public function setBugInfluence($BugInfluence){
		$this->BugInfluence = $BugInfluence;
	}
    
	public function getLatency(){
		return $this->latency;
	}

	public function setLatency($latency){
		$this->latency = $latency;
	}
    
	public function getLatencyTime(){
		return $this->latencyTime;
	}

	public function setLatencyTime($latencyTime){
		$this->latencyTime = $latencyTime;
	}
    
	public function getFailure(){
		return $this->failure;
	}

	public function setFailure($failure){
		$this->failure = $failure;
	}
    
	public function getFailureDes(){
		return $this->failureDes;
	}

	public function setFailureDes($failureDes){
		$this->failureDes = $failureDes;
	}
    
	public function getDonework(){
		return $this->donework;
	}

	public function setDonework($donework){
		$this->donework = $donework;
	}
    
    
	public function getDoneworkDes(){
		return $this->doneworkDes;
	}

	public function setDoneworkDes($doneworkDes){
		$this->doneworkDes = $doneworkDes;
	}
    
    public function getUnitPerson_id(){
		return $this->unitPerson_id;
	}

	public function setUnitPerson_id($unitPerson_id){
		$this->unitPerson_id = $unitPerson_id;
	}
    
    public function getworkerPerson_id(){
		return $this->workerPerson_id;
	}

	public function setworkerPerson_id($workerPerson_id){
		$this->workerPerson_id = $workerPerson_id;
	}

	/**
	 * @return mixed
	 */
	public function getSection() {
		return $this->section;
	}

	/**
	 * @param mixed $section
	 */
	public function setSection($section) {
		$this->section = $section;
	}

    	/**
	 * @return mixed
	 */
	public function getSender_note() {
		return $this->Sender_note;
	}

	/**
	 * @param mixed $section
	 */
	public function setSender_note($Sender_note) {
		$this->Sender_note = $Sender_note;
	}
    
        	/**
	 * @return mixed
	 */
	public function getHumanNumber() {
		return $this->HumanNumber;
	}

	/**
	 * @param mixed $section
	 */
	public function setHumanNumber($HumanNumber) {
		$this->HumanNumber = $HumanNumber;
	}
        
        	/**
	 * @return mixed
	 */
	public function getConsumable_Parts() {
		return $this->Consumable_Parts;
	}

	/**
	 * @param mixed $section
	 */
	public function setConsumable_Parts($Consumable_Parts) {
		$this->Consumable_Parts = $Consumable_Parts;
	}
            
        	/**
	 * @return mixed
	 */
	public function getConsumable_Parts_Qty() {
		return $this->Consumable_Parts_Qty;
	}

	/**
	 * @param mixed $section
	 */
	public function setConsumable_Parts_Qty($Consumable_Parts_Qty) {
		$this->Consumable_Parts_Qty = $Consumable_Parts_Qty;
	}
}
