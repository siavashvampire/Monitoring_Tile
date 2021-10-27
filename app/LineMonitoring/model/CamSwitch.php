<?php


namespace App\LineMonitoring\model;
// *************************************************************************
// *                                                                       *
// * TableClass - The Complete Table To Class PHP Function                 *
// * Copyright (c) Erfan Ebrahimi. All Rights Reserved,                    *
// * BuildId: 1                                                            *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * website: https://paymentcms.ir - https://erfanebrahimi.ir             *
// * Email: support@paymentcms.ir                                          *
// * phone: 09361090413                                                    *
// *                                                                       *
// *                                                                       *
// *************************************************************************


use paymentCms\component\browser;
use paymentCms\component\model;
use paymentCms\component\security;
use paymentCms\model\modelInterFace ;

class CamSwitch extends model implements modelInterFace {
	private $primaryKey = ['id'];
	private $primaryKeyShouldNotInsertOrUpdate = 'id';
	private $id;
	private $label;
	private $Switch_plc_id;
	private $plc_read;
	private $phase;
	private $unit;
	private $Active;
	private $IgnoreSensor;
	private $DelayTime;
	private $RenderCheck;

	public function setFromArray($result) {
		$this -> id       = $result['id'];
		$this -> label     = $result['label'];
		$this -> Switch_plc_id   = $result['Switch_plc_id'];
		$this -> plc_read        = $result['plc_read'];
		$this -> phase           = $result['phase'];
		$this -> unit          = $result['unit'];
		$this -> Active          = $result['Active'];
		$this -> IgnoreSensor    = $result['IgnoreSensor'];
		$this -> DelayTime       = $result['DelayTime'];
		$this -> RenderCheck       = $result['RenderCheck'];
	}

	public function returnAsArray( ) {
		$array['id']      = $this -> id;
		$array['label']    = $this -> label;
		$array['Switch_plc_id']  = $this -> Switch_plc_id;
		$array['plc_read']       = $this -> plc_read;
		$array['phase']          = $this -> phase;
		$array['unit']         = $this -> unit;
		$array['Active']         = $this -> Active;
		$array['IgnoreSensor']   = $this -> IgnoreSensor;
		$array['DelayTime']      = $this -> DelayTime;
		$array['RenderCheck']      = $this -> RenderCheck;
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
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label): void
    {
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getSwitchPlcId()
    {
        return $this->Switch_plc_id;
    }

    /**
     * @param mixed $Switch_plc_id
     */
    public function setSwitchPlcId($Switch_plc_id): void
    {
        $this->Switch_plc_id = $Switch_plc_id;
    }

    /**
     * @return mixed
     */
    public function getPlcRead()
    {
        return $this->plc_read;
    }

    /**
     * @param mixed $plc_read
     */
    public function setPlcRead($plc_read): void
    {
        $this->plc_read = $plc_read;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->Active;
    }

    /**
     * @param mixed $Active
     */
    public function setActive($Active): void
    {
        $this->Active = $Active;
    }

	public function setUnreadForPlc($tileId = null , $plcId = null){
		if ( $tileId == null )
			$tileId = $this->getId();
		if ( $plcId == null )
			$plcId = $this->getId();

		if ($tileId != null and $plcId != null )
			parent::updateOnFullQuery(['plc_read'=> '0'] ,[$tileId , $plcId ] , 'id = ? and  Sensor_id = ? ');
		elseif ($tileId == null and $plcId != null )
			parent::updateOnFullQuery(['plc_read'=> '0'] ,[ $plcId ] , ' Sensor_id = ? ');
		elseif ($tileId != null and $plcId == null )
			parent::updateOnFullQuery(['plc_read'=> '0'] ,[$tileId  ] , 'id = ? ');
	}
	public function setReadForPlc(){
		parent::updateOnFullQuery(['plc_read'=> '1'] ,[0  ] , 'plc_read = ? ');
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
	public function getIgnoreSensor() {
		return $this->IgnoreSensor;
	}

	/**
	 * @param mixed $unitId
	 */
	public function setIgnoreSensor($IgnoreSensor) {
		$this->IgnoreSensor = $IgnoreSensor;
	}
    
    /**
	 * @return mixed
	 */
	public function getDelayTime() {
		return $this->DelayTime;
	}

	/**
	 * @param mixed $unitId
	 */
	public function setDelayTime($DelayTime) {
		$this->DelayTime = $DelayTime;
	} 
    
    /**
	 * @return mixed
	 */
	public function getRenderCheck() {
		return $this->RenderCheck;
	}

	/**
	 * @param mixed $unitId
	 */
	public function setRenderCheck($RenderCheck) {
		$this->RenderCheck = $RenderCheck;
	}

    public function getCount($value = array(), $variable = array())
    {
        $tableName = 'CamSwitch item';
        return (parent::search((array)$value, (count($variable) == 0) ? null : implode(' and ', $variable), $tableName, 'COUNT(item.id) as co')) [0]['co'];
    }

    public function getItems($value = array(), $variable = array(), $sortWith = ['column' => 'item.id', 'type' => 'asc'], $page = null, $field = null)
    {
        if ($field == null) {
            $field = array();
            $field[] = 'item.id';
//            $field[] = 'item.label as Name';
//            $field[] = 'item.unit as unitId';
            $field[] = 'item.label';
            $field[] = 'item.unit';
            $field[] = 'units.label as unitName';
            $field[] = 'phases.label as phase';
            $field[] = 'phases.id as phase_id';
            $field[] = 'item.Switch_plc_id as PLC_id';
            $field[] = 'item.Active as Active';
        }

        $field = implode(',', $field);
        $table = 'CamSwitch item';

        parent::join('units units', 'units.id = item.unit ');
        parent::join('phases phases', 'phases.id = item.phase ');
        return parent::search($value, implode(' and ', $variable), $table, $field, $sortWith, $page);
    }
}
