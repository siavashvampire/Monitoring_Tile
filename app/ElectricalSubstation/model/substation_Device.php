<?php
namespace App\ElectricalSubstation\model;

use paymentCms\component\browser;
use paymentCms\component\model;
use paymentCms\component\security;
use paymentCms\model\modelInterFace ;

class substation_Device  extends model implements modelInterFace {
	private $primaryKey = ['substation_id'];
	private $primaryKeyShouldNotInsertOrUpdate = null;
	private $substation_id ;
	private $deviceType ;
	private $Name ;
	private $unitId ;
	private $refreshTime ;


	public function setFromArray($result) {
		$this->substation_id           = $result['substation_id'] ;
		$this->deviceType         = $result['deviceType'] ;
		$this->Name               = $result['Name'] ;
		$this->unitId             = $result['unitId'] ;
		$this->refreshTime             = $result['refreshTime'] ;
	}

	public function returnAsArray( ) {
		$array['substation_id']        = $this->substation_id ;
		$array['deviceType']       = $this->deviceType ;
		$array['Name']      = $this->Name ;
		$array['unitId']         = $this->unitId ;
		$array['refreshTime']         = $this->refreshTime ;
		return $array ;
	}
    /**
     * @return array
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * @return string
     */
    public function getPrimaryKeyShouldNotInsertOrUpdate()
    {
        return $this->primaryKeyShouldNotInsertOrUpdate;
    }

    /**
     * @return mixed
     */
    public function getRefreshTime()
    {
        return $this->refreshTime;
    }

    /**
     * @param mixed $refreshTime
     */
    public function setRefreshTime($refreshTime)
    {
        $this->refreshTime = $refreshTime;
    }

    /**
     * @return mixed
     */

    public function getSubstationId()
    {
        return $this->substation_id;
    }

    /**
     * @param mixed $substation_id
     */
    public function setSubstationId($substation_id)
    {
        $this->substation_id = $substation_id;
    }

    /**
     * @return mixed
     */
    public function getDeviceType()
    {
        return $this->deviceType;
    }

    /**
     * @param mixed $deviceType
     */
    public function setDeviceType($deviceType)
    {
        $this->deviceType = $deviceType;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * @param mixed $Name
     */
    public function setName($Name)
    {
        $this->Name = $Name;
    }

    /**
     * @return mixed
     */
    public function getUnitId()
    {
        return $this->unitId;
    }

    /**
     * @param mixed $unitId
     */
    public function setUnitId($unitId)
    {
        $this->unitId = $unitId;
    }

    public function getItems($substation_id = null,$type = null) {
        if ( $substation_id == null) $substation_id = $this->getSubstationId();

        $value = array();
		$variable = array();

		if ($substation_id != 0) {
            $value[] = $substation_id;
            $variable[] = 'item.substation_id = ?';
        }
        if ($type != null){
            $value[] = $type;
            $variable[] = 'item.deviceType = ?';
        }
        $field = array();
        $field[]='item.substation_id';
        $field[]='Substation.label as substation_name';
        $field[]='item.unitId';
        $field[]='item.Name';
        $field[]='item.deviceType';
        $field[]='item.refreshTime';
        $field = implode(" , ",$field);

        $order = ['column' => 'item.substation_id', 'type' => 'asc'];

        model::join('Substation  Substation','Substation.id = item.substation_id');

		return parent::search($value ,  implode(' and ', $variable) , 'substation_Device item',  $field ,$order);
	}

    public function deleteAllRow($id = null){
		if ( $id == null) $id = $this->getSubstationId();

        $value = array();
		$variable = array();

        $value[] = $id;
        $variable[] = 'substation_id = ?';

		parent::deleteOnFullQuery($value,implode(' and ', $variable));
	}
}
