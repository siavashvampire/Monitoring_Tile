<?php


namespace App\LineMonitoring\model;



use paymentCms\component\model;
use paymentCms\model\modelInterFace ;

class data_archive extends model implements modelInterFace {

	private $primaryKey = null;
	private $primaryKeyShouldNotInsertOrUpdate = null;
	private $Sensor_id ;
	private $Start_time ;
	private $JStart_time ;
	private $AbsTime ;
	private $counter ;
	private $Shift_id ;
	private $employers_id ;
	private $Tile_Kind ;
	private $Motor_Speed ;
	private $Shift_group_id ;
	private $phase ;
	private $unit ;
	private $tileDegree ;

	public static  function  creatExportTable ( $variable ){
		$db = (model::db());
		$perfix = $db::$prefix ;
		model::queryUnprepared('CREATE TEMPORARY TABLE IF NOT EXISTS '.$perfix.'temp_table1 select SUM(arch1.counter) as counterAll ,arch1.Tile_Kind ,arch1.Sensor_id  ,arch1.phase ,arch1.unit from '.$perfix.'data_archive arch1 LEFT JOIN '.$perfix.'sensors sensor on ( arch1.Sensor_id = sensor.id) WHERE sensor.Export = 1 and arch1.tileDegree = \'همه\' and '.$variable.' GROUP by arch1.Sensor_id,arch1.phase ,arch1.unit , arch1.Tile_Kind ORDER BY sensor.showSort ASC');
		model::queryUnprepared('CREATE TEMPORARY TABLE IF NOT EXISTS '.$perfix.'temp_table2 select archAll.counterAll , SUM(arch1.counter) as counterNotAll , arch1.Tile_Kind,arch1.Sensor_id, arch1.phase ,arch1.unit,arch1.tileDegree  ,arch1.Start_time ,arch1.JStart_time FROM '.$perfix.'data_archive arch1 LEFT JOIN '.$perfix.'temp_table1 archAll on ( archAll.unit = arch1.unit and archAll.Tile_Kind = arch1.Tile_Kind and arch1.phase = archAll.phase ) LEFT JOIN '.$perfix.'sensors sensor on ( archAll.Sensor_id = sensor.id) WHERE sensor.Export = 1 and arch1.tileDegree != \'همه\' and '.$variable.' GROUP by arch1.phase ,arch1.unit ,arch1.Sensor_id, arch1.Tile_Kind ORDER BY sensor.showSort ASC;');
		model::queryUnprepared('INSERT INTO '.$perfix.'temp_table2 select archAll.counterAll , SUM(arch1.counter) as counterNotAll , arch1.Tile_Kind,arch1.Sensor_id, arch1.phase ,arch1.unit,arch1.tileDegree  ,arch1.Start_time ,arch1.JStart_time  FROM '.$perfix.'data_archive arch1 LEFT JOIN '.$perfix.'temp_table1 archAll  on ( archAll.Sensor_id = arch1.Sensor_id  ) WHERE archAll.unit not in ( SELECT unit FROM '.$perfix.'temp_table2) and archAll.unit in ( SELECT unit FROM '.$perfix.'temp_table1) and '.$variable.' GROUP by arch1.phase ,arch1.unit ,arch1.Sensor_id, arch1.Tile_Kind ;');
	    model::queryUnprepared('CREATE TEMPORARY TABLE IF NOT EXISTS '.$perfix.'temp_table3 SELECT t.* , ROUND( counterNotAll / counterAll * 100 , 2 ) as percent , tk.label, tk.tile_width , tk.tile_length  from '.$perfix.'temp_table2 t LEFT JOIN '.$perfix.'tile_kind tk on ( t.Tile_Kind = tk.id ) ; ');
		model::queryUnprepared('CREATE TEMPORARY TABLE IF NOT EXISTS '.$perfix.'temp_table4 select
    table3.*,
    case when tileDegree = "درجه 1" then percent end as p1 ,
    case when tileDegree = "درجه 2" then percent end as p2,
    case when tileDegree = "درجه 3" then percent end as p3,
    case when tileDegree = "درجه W" then percent end as p5,
    case when tileDegree = "درجه U" then percent end as p4,
    case when tileDegree = "درجه 1" then counterNotAll end as m1,
    case when tileDegree = "درجه 2" then counterNotAll end as m2,
    case when tileDegree = "درجه 3" then counterNotAll end as m3,
    case when tileDegree = "درجه W" then counterNotAll end as m5,
    case when tileDegree = "درجه U" then counterNotAll end as m4
  from '.$perfix.'temp_table3 table3
;');
		model::queryUnprepared('CREATE TEMPORARY TABLE IF NOT EXISTS  '.$perfix.'temp_table5 select 
    table4.counterAll  ,table4.Start_time,table4.JStart_time,table4.counterNotAll ,table4.Tile_Kind ,table4.Sensor_id ,table4.phase ,table4.unit ,table4.tileDegree,table4.percent , table4.label, table4.tile_width , table4.tile_length ,
    sum(p1) as p1,
    sum(p2) as p2,
    sum(p3) as p3,
    sum(p4) as p4,
    sum(p5) as p5,
    sum(m1) as m1,
    sum(m2) as m2,
    sum(m3) as m3,
    sum(m4) as m4,
    sum(m5) as m5
  from '.$perfix.'temp_table4 table4 
  group by table4.phase ,table4.unit, table4.Tile_Kind
; ');
		model::queryUnprepared('CREATE TEMPORARY TABLE IF NOT EXISTS  '.$perfix.'temp_table6_0  select 
    counterAll    ,Start_time  ,JStart_time,Tile_Kind ,table5.phase ,unit  , label, tile_width , tile_length ,
    coalesce(p1, 0) as p1,
    coalesce(p2, 0) as p2,
    coalesce(p3, 0) as p3,
    coalesce(p4, 0) as p4,
    coalesce(p5, 0) as p5,
    coalesce(m1, 0) as m1,
    coalesce(m2, 0) as m2,
    coalesce(m3, 0) as m3,
    coalesce(m4, 0) as m4,
    coalesce(m5, 0) as m5
  from  '.$perfix.'temp_table5 table5 
;
 ');
	model::queryUnprepared('CREATE TEMPORARY TABLE IF NOT EXISTS  '.$perfix.'temp_table6  select counterAll ,Start_time  ,JStart_time,Tile_Kind ,phase , units.label as unitName , units.id as unit  , label, tile_width , tile_length , p1 , p2 , p3 , p4 , p5 , m1 , m2 , m3 , m4 , m5 from  '.$perfix.'temp_table6_0 t6 LEFT JOIN '.$perfix.'units units on ( t6.unit = units.id );');
		return 'temp_table6';
	}
	public function setFromArray($result) {
		$this->Sensor_id = $result['Sensor_id'] ;
		$this->Start_time = $result['Start_time'] ;
		$this->JStart_time = $result['JStart_time'] ;
		$this->AbsTime = $result['AbsTime'] ;
		$this->Shift_id = $result['Shift_id'] ;
		$this->employers_id = $result['employers_id'] ;
		$this->Tile_Kind = $result['Tile_Kind'] ;
		$this->counter = $result['counter'] ;
		$this->Motor_Speed = $result['Motor_Speed'] ;
		$this->Shift_group_id = $result['Shift_group_id'] ;
		$this->phase = $result['phase'] ;
		$this->unit = $result['unit'] ;
		$this->tileDegree = $result['tileDegree'] ;
	}

	public function returnAsArray( ) {
		$array['Sensor_id'] = $this->Sensor_id ;
		$array['Start_time'] = $this->Start_time ;
		$array['JStart_time'] = $this->JStart_time ;
		$array['AbsTime'] = $this->AbsTime ;
		$array['counter'] = $this->counter ;
		$array['Shift_id'] = $this->Shift_id ;
		$array['employers_id'] = $this->employers_id ;
		$array['Tile_Kind'] = $this->Tile_Kind ;
		$array['Motor_Speed'] = $this->Motor_Speed ;
		$array['Shift_group_id'] = $this->Shift_group_id ;
		$array['phase'] = $this->phase ;
		$array['unit'] = $this->unit ;
		$array['tileDegree'] = $this->tileDegree ;
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
	public function getSensorId() {
		return $this->Sensor_id;
	}

	/**
	 * @param mixed $Sensor_id
	 */
	public function setSensorId($Sensor_id) {
		$this->Sensor_id = $Sensor_id;
	}

	/**
	 * @return mixed
	 */
	public function getStartTime() {
		return $this->Start_time;
	}

	/**
	 * @param mixed $Start_time
	 */
	public function setStartTime($Start_time) {
		$this->Start_time = $Start_time;
	}

	/**
	 * @return mixed
	 */
	public function getAbsTime() {
		return $this->AbsTime;
	}

	/**
	 * @param mixed $Times
	 */
	public function setAbsTime($Times) {
		$this->AbsTime = $Times;
	}

	/**
	 * @return mixed
	 */
	public function getShiftId() {
		return $this->Shift_id;
	}

	/**
	 * @param mixed $Shift_id
	 */
	public function setShiftId($Shift_id) {
		$this->Shift_id = $Shift_id;
	}

	/**
	 * @return mixed
	 */
	public function getEmployersId() {
		return $this->employers_id;
	}

	/**
	 * @param mixed $employers_id
	 */
	public function setEmployersId($employers_id) {
		$this->employers_id = $employers_id;
	}


	/**
	 * @return mixed
	 */
	public function getTileKind() {
		return $this->Tile_Kind;
	}

	/**
	 * @param mixed $employers_id
	 */
	public function setTileKind($employers_id) {
		$this->Tile_Kind = $employers_id;
	}


	/**
	 * @return mixed
	 */
	public function getMotorSpeed() {
		return $this->Motor_Speed;
	}

	/**
	 * @param mixed $employers_id
	 */
	public function setMotorSpeed($employers_id) {
		$this->Motor_Speed = $employers_id;
	}

	/**
	 * @return mixed
	 */
	public function getCounter() {
		return $this->counter;
	}

	/**
	 * @param mixed $counter
	 */
	public function setCounter($counter) {
		$this->counter = $counter;
	}

	/**
	 * @return mixed
	 */
	public function getJStartTime() {
		return $this->JStart_time;
	}

	/**
	 * @param mixed $JStart_time
	 */
	public function setJStartTime($JStart_time) {
		$this->JStart_time = $JStart_time;
	}
    
    
	/**
	 * @return mixed
	 */
	public function getShiftGroupId() {
		return $this->Shift_group_id;
	}

	/**
	 * @param mixed $counter
	 */
	public function setShiftGroupId($counter) {
		$this->Shift_group_id = $counter;
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
	public function getTileDegree() {
		return $this->tileDegree;
	}

	/**
	 * @param mixed $tileDegree
	 */
	public function setTileDegree($tileDegree) {
		$this->tileDegree = $tileDegree;
	}
}
