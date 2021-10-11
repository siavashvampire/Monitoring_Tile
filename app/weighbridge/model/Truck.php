<?php
namespace App\weighbridge\model;

use paymentCms\component\browser;
use paymentCms\component\model;
use paymentCms\component\security;
use paymentCms\model\modelInterFace ;

class Truck extends model implements modelInterFace {
	private $primaryKey = ['id'];
	private $primaryKeyShouldNotInsertOrUpdate = 'id';
	private $id ;
	private $registrar ;
	private $registerTime ;
	private $mainNumberPlate ;
	private $Number1Plate ;
	private $CharNumberPlate ;
	private $Number2Plate ;
	private $Weight ;
	private $Driver1 ;
	private $Driver1Number ;
	private $Driver2 ;
	private $Driver2Number ;
	private $Driver3 ;
	private $Driver3Number ;
	private $Truck_Kind ;
	private $Work_Title ;
	private $Description ;

	public function setFromArray($result) {
		$this->id                   = $result['id'] ;
		$this->registrar            = $result['registrar'] ;
		$this->registerTime         = $result['registerTime'] ;
		$this->mainNumberPlate      = $result['mainNumberPlate'] ;
		$this->Number1Plate         = $result['Number1Plate'] ;
		$this->CharNumberPlate      = $result['CharNumberPlate'] ;
		$this->Number2Plate         = $result['Number2Plate'] ;
		$this->Weight               = $result['Weight'] ;
		$this->Driver1              = $result['Driver1'] ;
		$this->Driver1Number        = $result['Driver1Number'] ;
		$this->Driver2              = $result['Driver2'] ;
		$this->Driver2Number        = $result['Driver2Number'] ;
		$this->Driver3              = $result['Driver3'] ;
		$this->Driver3Number        = $result['Driver3Number'] ;
		$this->Truck_Kind           = $result['Truck_Kind'] ;
		$this->Work_Title           = $result['Work_Title'] ;
		$this->Description          = $result['Description'] ;
	}

	public function returnAsArray( ) {
		$array['id']                = $this->id ;
		$array['registrar']         = $this->registrar ;
		$array['registerTime']      = $this->registerTime ;
		$array['mainNumberPlate']   = $this->mainNumberPlate ;
		$array['Number1Plate']      = $this->Number1Plate ;
		$array['CharNumberPlate']   = $this->CharNumberPlate ;
		$array['Number2Plate']      = $this->Number2Plate ;
		$array['Weight']            = $this->Weight ;
		$array['Driver1']           = $this->Driver1 ;
		$array['Driver1Number']     = $this->Driver1Number ;
		$array['Driver2']           = $this->Driver2 ;
		$array['Driver2Number']     = $this->Driver2Number ;
		$array['Driver3']           = $this->Driver3 ;
		$array['Driver3Number']     = $this->Driver3Number ;
		$array['Truck_Kind']        = $this->Truck_Kind ;
		$array['Work_Title']        = $this->Work_Title ;
		$array['Description']       = $this->Description ;
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

    public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getRegistrar(){
		return $this->registrar;
	}

	public function setRegistrar($registrar){
		$this->registrar = $registrar;
	}

	public function getRegisterTime(){
		return $this->registerTime;
	}

	public function setRegisterTime($registerTime){
		$this->registerTime = $registerTime;
	}

	public function getMainNumberPlate(){
		return $this->mainNumberPlate;
	}

	public function setMainNumberPlate($MainNumberPlate){
		$this->mainNumberPlate = $MainNumberPlate;
	}

	public function getNumber1Plate(){
		return $this->Number1Plate;
	}

	public function setNumber1Plate($Number1Plate){
		$this->Number1Plate = $Number1Plate;
	}

	public function getCharNumberPlate(){
		return $this->CharNumberPlate;
	}

	public function setCharNumberPlate($CharNumberPlate){
		$this->CharNumberPlate = $CharNumberPlate;
	}

	public function getNumber2Plate(){
		return $this->Number2Plate;
	}

	public function setNumber2Plate($Number2Plate){
		$this->Number2Plate = $Number2Plate;
	}

	public function getWeight(){
		return $this->Weight;
	}

	public function setWeight($Weight){
		$this->Weight = $Weight;
	}

	public function getDriver1(){
		return $this->Driver1;
	}

	public function setDriver1($Driver1){
		$this->Driver1 = $Driver1;
	}

	public function getDriver1Number(){
		return $this->Driver1Number;
	}

	public function setDriver1Number($Driver1Number){
		$this->Driver1Number = $Driver1Number;
	}

	public function getDriver2(){
		return $this->Driver2;
	}

	public function setDriver2($Driver2){
		$this->Driver2 = $Driver2;
	}

	public function getDriver2Number(){
		return $this->Driver2Number;
	}

	public function setDriver2Number($Driver2Number){
		$this->Driver2Number = $Driver2Number;
	}

	public function getDriver3(){
		return $this->Driver3;
	}

	public function setDriver3($Driver3){
		$this->Driver3 = $Driver3;
	}

	public function getDriver3Number(){
		return $this->Driver3Number;
	}

	public function setDriver3Number($Driver3Number){
		$this->Driver3Number = $Driver3Number;
	}

	public function getTruck_Kind(){
		return $this->Truck_Kind;
	}

	public function setTruck_Kind($Truck_Kind){
		$this->Truck_Kind = $Truck_Kind;
	}

	public function getWork_Title(){
		return $this->Work_Title;
	}

	public function setWork_Title($Work_Title){
		$this->Work_Title = $Work_Title;
	}

	public function getDescription(){
		return $this->Description;
	}

	public function setDescription($Description){
		$this->Description = $Description;
	}
    
    public function getItemCount($value = array(),$variable = array()) {
        return (parent::search( (array) $value  , ( count($variable) == 0 ) ? null : implode(' and ' , $variable) , 'Truck item', 'COUNT(item.id) as co' )) [0]['co'];
    }
    public function getItems($value = array(),$variable = array() , $sortWith = ['column' => 'id' , 'type' =>'asc'],$pagination = ['start' => 0 , 'limit' =>"25"]) {
        parent::join('truck_work_title title', 'title.id = item.Work_Title' );
        parent::join('Truck_Kind Type', 'Type.id = item.Truck_Kind' );
	    return parent::search( (array) $value  , ( ( count($variable) == 0 ) ? null : implode(' and ' , $variable) )  , 'Truck item' , 'item.*,title.label as titleLabel,Type.label as TypeLabel'  , $sortWith , [$pagination['start'] , $pagination['limit'] ] );
	}
}
