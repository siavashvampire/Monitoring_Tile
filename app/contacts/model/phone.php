<?php
namespace App\contacts\model;

use paymentCms\component\model;
use paymentCms\model\modelInterFace ;

class phone extends model implements modelInterFace {
	private $primaryKey = ['id'];
	private $primaryKeyShouldNotInsertOrUpdate = 'id';
	private $id ;
	private $name ;
	private $phone ;
	private $send_allow ;
	private $access ;
	private $units ;
	private $phase ;
	private $type ;


    /**
     * @param $result
     */
    public function setFromArray($result) {
		$this->id                  = $result['id'] ;
		$this->name                = $result['name'] ;
		$this->phone               = $result['phone'] ;
		$this->send_allow           = $result['send_allow'] ;
		$this->access              = $result['access'] ;
		$this->units               = $result['units'] ;
		$this->phase               = $result['phase'] ;
		$this->type                = $result['type'] ;

	}

    /**
     * @return array
     */
    public function returnAsArray( ) {
		$array['id']             = $this->id ;
		$array['name']           = $this->name ;
		$array['phone']          = $this->phone ;
		$array['send_allow']      = $this->send_allow ;
		$array['access']         = $this->access ;
		$array['units']          = $this->units ;
		$array['phase']          = $this->phase ;
		$array['type']           = $this->type ;
		return $array ;
	}

    /**
     * @return string[]
     */
    public function getPrimaryKey(): array
    {
        return $this->primaryKey;
    }

    /**
     * @param string[] $primaryKey
     */
    public function setPrimaryKey(array $primaryKey): void
    {
        $this->primaryKey = $primaryKey;
    }

    /**
     * @return string
     */
    public function getPrimaryKeyShouldNotInsertOrUpdate(): string
    {
        return $this->primaryKeyShouldNotInsertOrUpdate;
    }

    /**
     * @param string $primaryKeyShouldNotInsertOrUpdate
     */
    public function setPrimaryKeyShouldNotInsertOrUpdate(string $primaryKeyShouldNotInsertOrUpdate): void
    {
        $this->primaryKeyShouldNotInsertOrUpdate = $primaryKeyShouldNotInsertOrUpdate;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }


    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getSendAllow()
    {
        return $this->send_allow;
    }

    /**
     * @param mixed $send_allow
     */
    public function setSendAllow($send_allow): void
    {
        $this->send_allow = $send_allow;
    }



    /**
     * @return mixed
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * @param mixed $access
     */
    public function setAccess($access): void
    {
        $this->access = $access;
    }

    /**
     * @return mixed
     */
    public function getUnits()
    {
        return explode(',',$this->units);
    }

    /**
     * @param mixed $units
     */
    public function setUnits($units): void
    {
        $this->units = implode(",",$units);
    }

    /**
     * @return mixed
     */
    public function getPhase()
    {
        return explode(',',$this->phase);
    }

    /**
     * @param mixed $phase
     */
    public function setPhase($phase): void
    {
        $this->phase =  implode(",",$phase);
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }
    public function getCount($value = array(),$variable = array()) {
        return (parent::search( (array) $value  , ( count($variable) == 0 ) ? null : implode(' and ' , $variable) , 'phone', 'COUNT(id) as co' )) [0]['co'];
    }

    public function getItems($value = array(),$variable = array() , $sortWith = ['column' => 'item.id' , 'type' =>'asc'],$pagination = ['start' => 0 , 'limit' =>"99999"]) {
        parent::join('Phone_type type' , 'item.type = type.id');
        return parent::search( (array) $value  , ( ( count($variable) == 0 ) ? null : implode(' and ' , $variable) )  , 'phone item' , 'item.*,type.label as typeLabel'  , $sortWith , [$pagination['start'] , $pagination['limit'] ] );
    }
    public function getSmsItems($value = array(),$variable = array() , $sortWith = ['column' => 'item.id' , 'type' =>'asc'],$pagination = ['start' => 0 , 'limit' =>"99999"]) {
        $value[]='2';
        $variable[]='item.type = ?';
        return self::getItems($value,$variable,$sortWith,$pagination);
    }
    public function getBaleItems($value = array(),$variable = array() , $sortWith = ['column' => 'item.id' , 'type' =>'asc'],$pagination = ['start' => 0 , 'limit' =>"99999"]) {
        $value[]='1';
        $variable[]='item.type = ?';
        return self::getItems($value,$variable,$sortWith,$pagination);
    }


}
