<?php
namespace App\weighbridge\model;

use paymentCms\component\browser;
use paymentCms\component\model;
use paymentCms\component\security;
use paymentCms\model\modelInterFace ;

class customer extends model implements modelInterFace {
	private $primaryKey = ['id'];
	private $primaryKeyShouldNotInsertOrUpdate = 'id';
	private $id ;
	private $registrar ;
	private $registerTime ;
	private $name ;
	private $idNumber ;
	private $Credit ;
	private $address ;
	private $phone ;
	private $cellPhone ;
	private $accountNumber ;
	private $active ;
	private $settlementType ;
	private $Carrier ;
	private $creditCheck ;
	private $deleteOnExport ;
	private $truckId ;

	public function setFromArray($result) {
		$this->id                   = $result['id'] ;
		$this->registrar            = $result['registrar'] ;
		$this->registerTime         = $result['registerTime'] ;
		$this->name                 = $result['name'] ;
		$this->idNumber             = $result['idNumber'] ;
		$this->Credit               = $result['Credit'] ;
		$this->address              = $result['address'] ;
		$this->phone                = $result['phone'] ;
		$this->cellPhone            = $result['cellPhone'] ;
		$this->accountNumber        = $result['accountNumber'] ;
		$this->active               = $result['active'] ;
		$this->settlementType       = $result['settlementType'] ;
		$this->Carrier              = $result['Carrier'] ;
		$this->creditCheck          = $result['creditCheck'] ;
		$this->deleteOnExport       = $result['deleteOnExport'] ;
		$this->truckId       = $result['truckId'] ;
	}

	public function returnAsArray( ) {
		$array['id']                = $this->id ;
		$array['registrar']         = $this->registrar ;
		$array['registerTime']      = $this->registerTime ;
		$array['name']              = $this->name ;
		$array['idNumber']          = $this->idNumber ;
		$array['Credit']            = $this->Credit ;
		$array['address']           = $this->address ;
		$array['phone']             = $this->phone ;
		$array['cellPhone']         = $this->cellPhone ;
		$array['accountNumber']     = $this->accountNumber ;
		$array['active']            = $this->active ;
		$array['settlementType']    = $this->settlementType ;
		$array['Carrier']           = $this->Carrier ;
		$array['creditCheck']       = $this->creditCheck ;
		$array['deleteOnExport']    = $this->deleteOnExport ;
		$array['truckId']    = $this->truckId ;
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

	public function getName(){
		return $this->name;
	}

	public function setName($name){
		$this->name = $name;
	}

	public function getIdNumber(){
		return $this->idNumber;
	}

	public function setIdNumber($idNumber){
		$this->idNumber = $idNumber;
	}

	public function getCredit(){
		return $this->Credit;
	}

	public function setCredit($Credit){
		$this->Credit = $Credit;
	}

	public function getAddress(){
		return $this->address;
	}

	public function setAddress($address){
		$this->address = $address;
	}

	public function getPhone(){
		return $this->phone;
	}

	public function setPhone($phone){
		$this->phone = $phone;
	}

	public function getCellPhone(){
		return $this->cellPhone;
	}

	public function setCellPhone($cellPhone){
		$this->cellPhone = $cellPhone;
	}

	public function getAccountNumber(){
		return $this->accountNumber;
	}

	public function setAccountNumber($accountNumber){
		$this->accountNumber = $accountNumber;
	}

	public function getActive(){
		return $this->active;
	}

	public function setActive($active){
		$this->active = $active;
	}

	public function getSettlementType(){
		return $this->settlementType;
	}

	public function setSettlementType($settlementType){
		$this->settlementType = $settlementType;
	}

	public function getCarrier(){
		return $this->Carrier;
	}

	public function setCarrier($Carrier){
		$this->Carrier = $Carrier;
	}

	public function getCreditCheck(){
		return $this->creditCheck;
	}

	public function setCreditCheck($creditCheck){
		$this->creditCheck = $creditCheck;
	}

	public function getDeleteOnExport(){
		return $this->deleteOnExport;
	}

	public function setDeleteOnExport($deleteOnExport){
		$this->deleteOnExport = $deleteOnExport;
	}

    /**
     * @return mixed
     */
    public function getTruckId()
    {
        return $this->truckId;
    }

    /**
     * @param mixed $truckId
     */
    public function setTruckId($truckId)
    {
        $this->truckId = $truckId;
    }
    
    public function getItemCount($value = array(),$variable = array()) {
        return (parent::search( (array) $value  , ( count($variable) == 0 ) ? null : implode(' and ' , $variable) , 'customer item', 'COUNT(item.id) as co' )) [0]['co'];
    }
    public function getItems($value = array(),$variable = array() , $sortWith = ['column' => 'id' , 'type' =>'asc'],$pagination = ['start' => 0 , 'limit' =>"25"]) {
        parent::join('customer_status status', 'status.id = item.active' );
        parent::join('customer_settlementType Type', 'Type.id = item.settlementType' );
        parent::join('customer_carrier carrier', 'carrier.id = item.carrier' );
	    return parent::search( (array) $value  , ( ( count($variable) == 0 ) ? null : implode(' and ' , $variable) )  , 'customer item' , 'item.*,status.label as statusLabel,Type.label as TypeLabel,carrier.label as carrierLabel'  , $sortWith , [$pagination['start'] , $pagination['limit'] ] );
	}
}
