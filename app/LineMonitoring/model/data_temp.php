<?php

namespace App\LineMonitoring\model;

use App\LineMonitoring\app_provider\api\sensor;
use paymentCms\component\model;
use paymentCms\model\modelInterFace;
use paymentCms\component\JDate;

class data_temp extends model implements modelInterFace
{
    private $primaryKey = null;
    private $primaryKeyShouldNotInsertOrUpdate = null;
    private $Sensor_id;
    private $Start_time;
    private $JStart_time;
    private $AbsTime;
    private $counter;
    private $Shift_id;
    private $employers_id;
    private $Tile_Kind;
    private $Motor_Speed;
    private $Shift_group_id;
    private $phase;
    private $unit;
    private $tileDegree;

    public function setFromArray($result)
    {
        $this->Sensor_id = $result['Sensor_id'];
        $this->Start_time = $result['Start_time'];
        $this->JStart_time = $result['JStart_time'];
        $this->AbsTime = $result['AbsTime'];
        $this->Shift_id = $result['Shift_id'];
        $this->employers_id = $result['employers_id'];
        $this->Tile_Kind = $result['Tile_Kind'];
        $this->counter = $result['counter'];
        $this->Motor_Speed = $result['Motor_Speed'];
        $this->Shift_group_id = $result['Shift_group_id'];
        $this->phase = $result['phase'];
        $this->unit = $result['unit'];
        $this->tileDegree = $result['tileDegree'];
    }

    public function returnAsArray()
    {
        $array['Sensor_id'] = $this->Sensor_id;
        $array['Start_time'] = $this->Start_time;
        $array['JStart_time'] = $this->JStart_time;
        $array['AbsTime'] = $this->AbsTime;
        $array['counter'] = $this->counter;
        $array['Shift_id'] = $this->Shift_id;
        $array['employers_id'] = $this->employers_id;
        $array['Tile_Kind'] = $this->Tile_Kind;
        $array['Motor_Speed'] = $this->Motor_Speed;
        $array['Shift_group_id'] = $this->Shift_group_id;
        $array['phase'] = $this->phase;
        $array['unit'] = $this->unit;
        $array['tileDegree'] = $this->tileDegree;
        return $array;
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
    public function getSensorId()
    {
        return $this->Sensor_id;
    }

    /**
     * @param mixed $Sensor_id
     */
    public function setSensorId($Sensor_id)
    {
        $this->Sensor_id = $Sensor_id;
    }

    /**
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->Start_time;
    }

    /**
     * @param mixed $Start_time
     */
    public function setStartTime($Start_time)
    {
        $this->Start_time = $Start_time;
    }

    /**
     * @return mixed
     */
    public function getAbsTime()
    {
        return $this->AbsTime;
    }

    /**
     * @param mixed $Times
     */
    public function setAbsTime($Times)
    {
        $this->AbsTime = $Times;
    }

    /**
     * @return mixed
     */
    public function getShiftId()
    {
        return $this->Shift_id;
    }

    /**
     * @param mixed $Shift_id
     */
    public function setShiftId($Shift_id)
    {
        $this->Shift_id = $Shift_id;
    }

    /**
     * @return mixed
     */
    public function getEmployersId()
    {
        return $this->employers_id;
    }

    /**
     * @param mixed $employers_id
     */
    public function setEmployersId($employers_id)
    {
        $this->employers_id = $employers_id;
    }


    /**
     * @return mixed
     */
    public function getTileKind()
    {
        return $this->Tile_Kind;
    }

    /**
     * @param mixed $employers_id
     */
    public function setTileKind($employers_id)
    {
        $this->Tile_Kind = $employers_id;
    }


    /**
     * @return mixed
     */
    public function getMotorSpeed()
    {
        return $this->Motor_Speed;
    }

    /**
     * @param mixed $employers_id
     */
    public function setMotorSpeed($employers_id)
    {
        $this->Motor_Speed = $employers_id;
    }

    /**
     * @return mixed
     */
    public function getCounter()
    {
        return $this->counter;
    }

    /**
     * @param mixed $counter
     */
    public function setCounter($counter)
    {
        $this->counter = $counter;
    }

    /**
     * @return mixed
     */
    public function getShiftGroupId()
    {
        return $this->Shift_group_id;
    }

    /**
     * @param mixed $counter
     */
    public function setShiftGroupId($counter)
    {
        $this->Shift_group_id = $counter;
    }

    public function clear($Shift_id, $Shift_group_id)
    {
//		parent::deleteOnFullQuery([ date('Y-m-d 00:00:00') ] , ' DATE(Start_time) < ? ');
        parent::deleteOnFullQuery([$Shift_id, $Shift_group_id], ' Shift_id != ? or Shift_group_id != ? ');
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
    public function getJStartTime()
    {
        return $this->JStart_time;
    }

    /**
     * @param mixed $JStart_time
     */
    public function setJStartTime($JStart_time)
    {
        $this->JStart_time = $JStart_time;
    }

    public function insertZero($Shift_id, $Shift_group_id, $shiftWorker, $Time = null)
    {
        if ($Time == null)
            $Time = date('Y-m-d H:i:s');
        $strTime = strtotime($Time);
        $this->setStartTime($Time);
        $this->setJStartTime(JDate::jdate('Y/n/j', $strTime));
        $this->setMotorSpeed('100');
        $this->setAbsTime(100);
        $this->setShiftId($Shift_id);
        $this->setEmployersId($shiftWorker);
        $this->setShiftGroupId($Shift_group_id);
        $this->setCounter(0);

        $value2 = array();
        $variable2 = array();

        $value2[] = 0;
        $variable2[] = 'item.isVirtual = ? ';
        $value2[] = 0;
        $variable2[] = 'item.Sensor_plc_id <> ? ';

        $sensorList = sensor::index($value2, $variable2)["result"];

        foreach ($sensorList as $id) {
            $sensor = new sensors($id["id"]);
            $this->setSensorId($sensor->getId());
            $this->setTileKind($sensor->getTileId());
            $this->setPhase($sensor->getPhase());
            $this->setUnit($sensor->getUnit());
            $this->setTileDegree($sensor->getTileDegree());
            $this->insertToDataBase();
        }

    }
}
