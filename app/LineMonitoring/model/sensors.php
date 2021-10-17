<?php

namespace App\LineMonitoring\model;

use paymentCms\component\model;
use paymentCms\model\modelInterFace;

class sensors extends model implements modelInterFace
{
    private $primaryKey = ['id'];
    private $primaryKeyShouldNotInsertOrUpdate = 'id';
    private $id;
    private $showSort;
    private $label;
    private $Sensor_plc_id;
    private $tile_id;
    private $tile_Count;
    private $plc_read;
    private $phase;
    private $tileDegree;
    private $unit;
    private $OffTime;
    private $OffTime_Bale;
    private $OffTime_SMS;
    private $Active;
    private $SensorChosenId;
    private $SensorSign;
    private $Export;
    private $isVirtual;
    private $isStorage;

    public function setFromArray($result)
    {
        $this->id = $result['id'];
        $this->showSort = $result['showSort'];
        $this->label = $result['label'];
        $this->Sensor_plc_id = $result['Sensor_plc_id'];
        $this->tile_id = $result['tile_id'];
        $this->tile_Count = $result['tile_Count'];
        $this->plc_read = $result['plc_read'];
        $this->phase = $result['phase'];
        $this->tileDegree = $result['tileDegree'];
        $this->unit = $result['unit'];
        $this->OffTime = $result['OffTime'];
        $this->OffTime_Bale = $result['OffTime_Bale'];
        $this->OffTime_SMS = $result['OffTime_SMS'];
        $this->Active = $result['Active'];
        $this->SensorChosenId = $result['SensorChosenId'];
        $this->SensorSign = $result['SensorSign'];
        $this->Export = $result['Export'];
        $this->isVirtual = $result['isVirtual'];
        $this->isStorage = $result['isStorage'];
    }

    public function returnAsArray()
    {
        $array['id'] = $this->id;
        $array['showSort'] = $this->showSort;
        $array['label'] = $this->label;
        $array['Sensor_plc_id'] = $this->Sensor_plc_id;
        $array['tile_id'] = $this->tile_id;
        $array['tile_Count'] = $this->tile_Count;
        $array['plc_read'] = $this->plc_read;
        $array['phase'] = $this->phase;
        $array['tileDegree'] = $this->tileDegree;
        $array['unit'] = $this->unit;
        $array['OffTime'] = $this->OffTime;
        $array['OffTime_Bale'] = $this->OffTime_Bale;
        $array['OffTime_SMS'] = $this->OffTime_SMS;
        $array['Active'] = $this->Active;
        $array['SensorChosenId'] = $this->SensorChosenId;
        $array['SensorSign'] = $this->SensorSign;
        $array['Export'] = $this->Export;
        $array['isVirtual'] = $this->isVirtual;
        $array['isStorage'] = $this->isStorage;
        return $array;
    }

    public function upDateDataBase()
    {
        $result = parent::upDateDataBase();
        if ($result) {
            if ($this->getisVirtual()) {
                if ($this->getisStorage()) {
                    (new data)->UpdateZeroStorage($this->getId(), $this->getTileId(), $this->getPhase(), $this->getUnit(), $this->getTileDegree());
                }

                $db = (model::db());
                $perfix = $db::$prefix;
                model::queryUnprepared('DROP TRIGGER IF EXISTS `' . $perfix . 'execute_virtual_sensor_' . $this->getId() . '`;');
                $listSensors = explode(',', $this->getSensorChosenId());
                $listSensorsSign = explode(',', $this->getSensorSign());
                if (count($listSensors) > 0) {
                    $query = '
					CREATE TRIGGER `' . $perfix . 'execute_virtual_sensor_' . $this->getId() . '` AFTER INSERT ON `' . $perfix . 'data_temp` FOR EACH ROW BEGIN
					    ';
                    for ($i = 0; $i < count($listSensors); $i++) {
                        if ($this->getisStorage()) {
                            $query .= '
                            ' . (($i > 0) ? 'ELSE' : '') . 'IF (NEW.Sensor_id = \'' . $listSensors[$i] . '\') THEN
                                INSERT INTO ' . $perfix . 'data(`Sensor_id`,`Start_time`,`JStart_time`,`AbsTime`,`counter`,`Shift_id`,`Shift_group_id`,`employers_id`,`Tile_Kind`,`Motor_Speed`,`phase`,`unit`,`tileDegree`)
                                VALUES(\'' . $this->getId() . '\',NEW.Start_time,NEW.JStart_time,NEW.AbsTime,( NEW.counter * ' . ((isset($listSensorsSign[$i]) and $listSensorsSign[$i] != null) ? $listSensorsSign[$i] : '1') . '),-1,-1,-1,\'' . $this->getTileId() . '\',NEW.Motor_Speed,\'' . $this->getPhase() . '\',\'' . $this->getUnit() . '\',\'' . $this->getTileDegree() . '\');';
                        } else {
                            $query .= '
					        ' . (($i > 0) ? 'ELSE' : '') . 'IF (NEW.Sensor_id = \'' . $listSensors[$i] . '\') THEN
					        INSERT INTO ' . $perfix . 'data(`Sensor_id`,`Start_time`,`JStart_time`,`AbsTime`,`counter`,`Shift_id`,`Shift_group_id`,`employers_id`,`Tile_Kind`,`Motor_Speed`,`phase`,`unit`,`tileDegree`)
					        VALUES(\'' . $this->getId() . '\',NEW.Start_time,NEW.JStart_time,NEW.AbsTime,( NEW.counter * ' . ((isset($listSensorsSign[$i]) and $listSensorsSign[$i] != null) ? $listSensorsSign[$i] : '1') . '),NEW.Shift_id,NEW.Shift_group_id,NEW.employers_id,\'' . $this->getTileId() . '\',NEW.Motor_Speed,\'' . $this->getPhase() . '\',\'' . $this->getUnit() . '\',\'' . $this->getTileDegree() . '\');';
                        }
                    }
                    $query .= '
					        END IF;
					END;
				';
                    model::queryUnprepared($query);
                }
            }
        }
        return $result;
    }


    public function insertToDataBase()
    {
        $result = parent::insertToDataBase();
        if ($result) {
            if ($this->getisVirtual()) {
                if ($this->getisStorage()) {
                    (new data)->InsertZeroStorage($this->getId(), $this->getTileId(), $this->getPhase(), $this->getUnit(), $this->getTileDegree());
                }

                $db = (model::db());
                $perfix = $db::$prefix;
                model::queryUnprepared('DROP TRIGGER IF EXISTS `' . $perfix . 'execute_virtual_sensor_' . $this->getId() . '`;');
                $listSensors = explode(',', $this->getSensorChosenId());
                $listSensorsSign = explode(',', $this->getSensorSign());
                if (count($listSensors) > 0) {
                    $query = '
					CREATE TRIGGER `' . $perfix . 'execute_virtual_sensor_' . $this->getId() . '` AFTER INSERT ON `' . $perfix . 'data_temp` FOR EACH ROW BEGIN
					    ';
                    for ($i = 0; $i < count($listSensors); $i++) {
                        if ($this->getisStorage()) {
                            $query .= '
                            ' . (($i > 0) ? 'ELSE' : '') . 'IF (NEW.Sensor_id = \'' . $listSensors[$i] . '\') THEN
                                INSERT INTO ' . $perfix . 'data(`Sensor_id`,`Start_time`,`JStart_time`,`AbsTime`,`counter`,`Shift_id`,`Shift_group_id`,`employers_id`,`Tile_Kind`,`Motor_Speed`,`phase`,`unit`,`tileDegree`)
                                VALUES(\'' . $this->getId() . '\',NEW.Start_time,NEW.JStart_time,NEW.AbsTime,( NEW.counter * ' . ((isset($listSensorsSign[$i]) and $listSensorsSign[$i] != null) ? $listSensorsSign[$i] : '1') . '),-1,-1,-1,\'' . $this->getTileId() . '\',NEW.Motor_Speed,\'' . $this->getPhase() . '\',\'' . $this->getUnit() . '\',\'' . $this->getTileDegree() . '\');';
                        } else {
                            $query .= '
					        ' . (($i > 0) ? 'ELSE' : '') . 'IF (NEW.Sensor_id = \'' . $listSensors[$i] . '\') THEN
					        INSERT INTO ' . $perfix . 'data(`Sensor_id`,`Start_time`,`JStart_time`,`AbsTime`,`counter`,`Shift_id`,`Shift_group_id`,`employers_id`,`Tile_Kind`,`Motor_Speed`,`phase`,`unit`,`tileDegree`)
					        VALUES(\'' . $this->getId() . '\',NEW.Start_time,NEW.JStart_time,NEW.AbsTime,( NEW.counter * ' . ((isset($listSensorsSign[$i]) and $listSensorsSign[$i] != null) ? $listSensorsSign[$i] : '1') . '),NEW.Shift_id,NEW.Shift_group_id,NEW.employers_id,\'' . $this->getTileId() . '\',NEW.Motor_Speed,\'' . $this->getPhase() . '\',\'' . $this->getUnit() . '\',\'' . $this->getTileDegree() . '\');';
                        }
                    }
                    $query .= '
					        END IF;
					END;
				';
                    model::queryUnprepared($query);
                }
            }
        }
        return $result;
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
    public function getshowSort()
    {
        return $this->showSort;
    }

    /**
     * @param mixed $Sensor_id
     */
    public function setshowSort($showSort)
    {
        $this->showSort = $showSort;
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
    public function getSensorPlcId()
    {
        return $this->Sensor_plc_id;
    }

    /**
     * @param mixed $Sensor_plc_id
     */
    public function setSensorPlcId($Sensor_plc_id)
    {
        $this->Sensor_plc_id = $Sensor_plc_id;
    }

    /**
     * @return mixed
     */
    public function getTileId()
    {
        return $this->tile_id;
    }

    /**
     * @param mixed $tile_id
     */
    public function setTileId($tile_id)
    {
        $this->tile_id = $tile_id;
    }

    /**
     * @return mixed
     */
    public function getTile_Count()
    {
        return $this->tile_Count;
    }

    /**
     * @param mixed $tile_id
     */
    public function setTile_Count($tile_Count)
    {
        $this->tile_Count = $tile_Count;
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
    public function setPlcRead($plc_read)
    {
        $this->plc_read = $plc_read;
    }

    public function getOffTime()
    {
        return $this->OffTime;
    }


    public function setOffTime($OffTime)
    {
        $this->OffTime = $OffTime;
    }

    public function getOffTime_Bale()
    {
        return $this->OffTime_Bale;
    }


    public function setOffTime_Bale($OffTime_Bale)
    {
        $this->OffTime_Bale = $OffTime_Bale;
    }

    public function getOffTime_SMS()
    {
        return $this->OffTime_SMS;
    }


    public function setOffTime_SMS($OffTime_SMS)
    {
        $this->OffTime_SMS = $OffTime_SMS;
    }

    public function getActive()
    {
        return $this->Active;
    }

    public function setActive($Active)
    {
        $this->Active = $Active;
    }

    public function setUnreadForPlc($tileId = null, $plcId = null)
    {
        if ($tileId == null)
            $tileId = $this->getTileId();
        if ($plcId == null)
            $plcId = $this->getSensorPlcId();

        if ($tileId != null and $plcId != null)
            parent::updateOnFullQuery(['plc_read' => '0'], [$tileId, $plcId], 'tile_id = ? and  Sensor_id = ? ');
        elseif ($tileId == null and $plcId != null)
            parent::updateOnFullQuery(['plc_read' => '0'], [$plcId], ' Sensor_id = ? ');
        elseif ($tileId != null and $plcId == null)
            parent::updateOnFullQuery(['plc_read' => '0'], [$tileId], 'tile_id = ? ');
    }

    public function setReadForPlc()
    {
        parent::updateOnFullQuery(['plc_read' => '1'], [0], 'plc_read = ? ');
    }

    /**
     * @return mixed
     */
    public function getPhase()
    {
        return $this->phase;
    }

    /**
     * @param mixed $phase
     */
    public function setPhase($phase)
    {
        $this->phase = $phase;
    }

    /**
     * @return mixed
     */
    public function getTileDegree()
    {
        return $this->tileDegree;
    }

    /**
     * @param mixed $tileDegree
     */
    public function setTileDegree($tileDegree)
    {
        $this->tileDegree = $tileDegree;
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
    public function setUnit($unit)
    {
        $this->unit = $unit;
    }


    /**
     * @return mixed
     */
    public function getSensorChosenId()
    {
        return $this->SensorChosenId;
    }

    /**
     * @param mixed $tileDegree
     */
    public function setSensorChosenId($SensorChosenId)
    {
        $this->SensorChosenId = $SensorChosenId;
    }

    /**
     * @return mixed
     */
    public function getSensorSign()
    {
        return $this->SensorSign;
    }

    /**
     * @param mixed $unit
     */
    public function setSensorSign($SensorSign)
    {
        $this->SensorSign = $SensorSign;
    }

    /**
     * @return mixed
     */
    public function getExport()
    {
        return $this->Export;
    }

    /**
     * @param mixed $unit
     */
    public function setExport($Export)
    {
        $this->Export = $Export;
    }

    /**
     * @return mixed
     */
    public function getisVirtual()
    {
        return $this->isVirtual;
    }

    /**
     * @param mixed $unit
     */
    public function setisVirtual($isVirtual)
    {
        $this->isVirtual = $isVirtual;
    }

    /**
     * @return mixed
     */
    public function getisStorage()
    {
        return $this->isStorage;
    }

    /**
     * @param mixed $unit
     */
    public function setisStorage($isStorage)
    {
        $this->isStorage = $isStorage;
    }

    public function getCount($value = array(), $variable = array())
    {
        $tableName = 'sensors item';
        return (parent::search((array)$value, (count($variable) == 0) ? null : implode(' and ', $variable), $tableName, 'COUNT(item.id) as co')) [0]['co'];
    }

    public function getItems($value = array(), $variable = array(), $sortWith = ['column' => 'item.id', 'type' => 'asc'], $page = null, $field = null)
    {
        if ($field == null) {
            $field = array();
            $field[] = 'item.id';
            $field[] = 'item.label as Name';
            $field[] = 'item.unit as unitId';
            $field[] = 'units.label as unitName';
            $field[] = 'phases.label as phase';
            $field[] = 'phases.id as Phase';
            $field[] = 'item.Sensor_plc_id as PLC_id';
            $field[] = 'item.Active as Active';
            $field[] = 'item.tile_Count';
            $field[] = 'item.tileDegree';
            $field[] = 'item.OffTime';
            $field[] = 'item.OffTime_Bale';
            $field[] = 'item.OffTime_SMS';
            $field[] = 'tile_kind.tile_width';
            $field[] = 'tile_kind.tile_length';
            $field[] = 'tile_kind.id as tile_id';
            $field[] = 'item.isStorage';
        }

        $field = implode(',', $field);
        $table = 'sensors item';

        parent::join('tile_kind tile_kind', 'tile_kind.id =  item.tile_id');
        parent::join('units units', 'units.id = item.unit ');
        parent::join('phases phases', 'phases.id = item.phase ');
        return parent::search($value, implode(' and ', $variable), $table, $field, $sortWith, $page);
    }
}
