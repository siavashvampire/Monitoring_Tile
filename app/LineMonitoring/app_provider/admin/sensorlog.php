<?php
namespace App\LineMonitoring\app_provider\admin;

use App\LineMonitoring\app_provider\api\phases;
use App\LineMonitoring\app_provider\api\sensor;
use App\LineMonitoring\app_provider\api\tiles;
use App\shiftWork\app_provider\api\Day;
use App\shiftWork\app_provider\api\shift;
use app\LineMonitoring\model\data;
use app\LineMonitoring\model\data_archive;
use App\units\app_provider\api\units;
use controller;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\validate;
use App\user\app_provider\api\user;
use App\core\controller\fieldService;
use paymentCms\component\cache;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class sensorlog extends controller {
	public  function index(){
		$this->lists();
	}
	private function lists() {
		$get = request::post('page=1,perEachPage=25,groupId,StartTime,EndTime,tile_kind,phase,unitId,sortWith' ,null);
		$rules = [
			"page" => ["required|match:>0", rlang('page')],
			"perEachPage" => ["required|match:>0|match:<501", rlang('page')],
		];
		$valid = validate::check($get, $rules);
		$value = array( );
		$variable = array( );
		$sortWith =   ['column' => 'data.Start_time' , 'type' =>'desc'] ;
		if ($valid->isFail()){
			//TODO:: add error is not valid data

		} else {
			if ( $get['groupId'] != null ) {
				$value[] = $get['groupId'] ;
				$variable[] = ' data.Sensor_id = ? ';
			}
			if ( $get['tile_kind'] != null ) {
				$value[] = $get['tile_kind'] ;
				$variable[] = ' data.Tile_Kind = ? ';
			}
			if ( $get['StartTime'] != null and $get['EndTime'] == null) {
				$value[] = date('Y-m-d H:i:s' , $get['StartTime'] / 1000 ) ;
				$variable[] = ' data.Start_time > ? ';
			} elseif ( $get['StartTime'] == null and $get['EndTime'] != null) {
				$value[] = date('Y-m-d H:i:s' , $get['EndTime'] / 1000 ) ;
				$variable[] = ' data.Start_time < ? ';
			} elseif ( $get['StartTime'] != null and $get['EndTime'] != null)  {
				$value[] = date('Y-m-d H:i:s' , $get['StartTime'] / 1000 ) ;
				$value[] = date('Y-m-d H:i:s' , $get['EndTime'] / 1000 ) ;
				$variable[] = ' (data.Start_time BETWEEN ? AND ?) ';
			}

			if ( $get['phase'] != null ) {
				$value[] = $get['phase'] ;
				$variable[] = ' data.phase = ? ';
			}
			if ( $get['unitId'] != null ) {
				$value[] = $get['unitId'] ;
				$variable[] = ' data.unit = ? ';
			}
			if ( $get['sortWith'] != null and is_array($get['sortWith']) ) {
				unset($sortWith);
				foreach ($get['sortWith'] as $sort) {
					$temp = explode('|', $sort);
					$sortWith[] = ['column' => $temp[0], 'type' => $temp[1]];
				}
			}
		}

		$model = parent::model('data_archive');
		$numberOfAll = ($model->search( (array) $value  , ( count($variable) == 0 ) ? null : implode(' and ' , $variable) , 'data_archive data', 'COUNT(data.Start_time) as co' )) [0]['co'];
		$pagination = parent::pagination($numberOfAll,$get['page'],$get['perEachPage']);
        $model->join('sensors sensors','data.Sensor_id = sensors.id');
        $model->join('tile_kind tile_kind','data.Tile_Kind = tile_kind.id');
        $model->join('units units','data.unit = units.id');
		$search = $model->search( (array) $value  , ( ( count($variable) == 0 ) ? null : implode(' and ' , $variable) )  , 'data_archive data', 'data.*, sensors.label,tile_kind.label,units.label as unitName'  , $sortWith , [$pagination['start'] , $pagination['limit'] ] );
        
		$this->mold->path('default', 'LineMonitoring');
		$this->mold->view('logList.mold.html');
		$this->mold->setPageTitle('لاگ سنسور ها');
		$this->mold->set('activeMenu' , 'sensorlog');
		$this->mold->set('logs' , $search);
		$search = $model->search( array()  ,  null  , 'sensors', '*'  , ['column' => 'showSort' , 'type' =>'asc'] );
		$this->mold->set('access' , $search);
		$this->mold->set('tiles'  , tiles::index()["result"]);
        $this->mold->set('units', units::index()["result"]);
        $this->mold->set('phases', phases::index()["result"]);
	}
	public  function counter() {
		$get = request::post('groupId,StartTime,EndTime,tile_kind,phase,unitId,sortWith' ,null);
		$value = array( );
		$value2 = array( );
		$valueForUnit = array( );
		$variable = array( );
		$variable2 = array( );
		$variableForUnit = array( );
        
        $user = user::getUserLogin();
        $fields = fieldService::showFilledOutFormWithAllFields($user['user_group_id'], 'user_register', $user['userId'], 'user_register', true);
        $unitId = false;
        $phase = false;
        if (is_array($fields['result'])) {
            foreach ($fields['result'] as $index => $fields) {
                if ($fields['type'] == 'fieldCall_units_units') {
                    $unitId = $fields['value'];
                } elseif ($fields['type'] == 'fieldCall_LineMonitoring_phase') {
                    $phase = $fields['value'];
                }
                if ($unitId and $phase) break;
            }
        }
        if ($unitId) {
            $value[] = $unitId;
            $value2[] = $unitId;
            $valueForUnit[] = $unitId;
            $variable[] = ' data.unit = ? ';
            $variable2[] = ' unitId = ? ';
            $variableForUnit[] = ' unitId = ? ';
            $get['unitId'] = null;
        }
        if ($phase) {
            $value[] = $phase;
            $value2[] = $phase;
            $variable[] = ' data.phase = ? ';
            $variable2[] = ' phase = ? ';
            $get['phase'] = null;
        }
        if ( $get['groupId'] != null ) {
			$value[] = $get['groupId'] ;
			$value2[] = $get['groupId'] ;
			$variable[] = ' data.Sensor_id = ? ';
			$variable2[] = ' item.id = ? ';
		}
		if ( $get['tile_kind'] != null ) {
			$value[] = $get['tile_kind'] ;
			$variable[] = ' data.Tile_Kind = ? ';
		}
		if ( $get['phase'] != null ) {
			$value[] = $get['phase'] ;
			$value2[] = $get['phase'] ;
			$variable[] = ' data.phase = ? ';
			$variable2[] = ' phase = ? ';
		}
		if ( $get['unitId'] != null ) {
			$value[] = $get['unitId'] ;
			$value2[] = $get['unitId'] ;
			$variable[] = ' data.unit = ? ';
			$variable2[] = ' unitId = ? ';
		}
        
		$sortWith = [['column' => 'sensors.showSort' , 'type' =>'asc']];
		if ( $get['sortWith'] != null and is_array($get['sortWith']) ) {
			unset($sortWith);
			foreach ($get['sortWith'] as $sort) {
				$temp = explode('|', $sort);
				$sortWith[] = ['column' => $temp[0], 'type' => $temp[1]];
			}
		}
 
		if ( $shifts = cache::get('lastShiftGet' , null ,'LineMonitoring') ){
            $strTime = strtotime(date('Y-m-d H:i:s'));
			if ( ! ($strTime <= $shifts['endTimeStamp'] and $strTime >= $shifts['startTimeStamp'] ) ) {
				$_SERVER['JsonOff'] = true;

                $shifts = shift::index()['result'];
                unset($_SERVER['JsonOff']);
			}

		} else {
			$_SERVER['JsonOff'] = true;
            $shifts =  shift::index()['result'];
            unset($_SERVER['JsonOff']);
		}
        
        $this->mold->set('shift' , $shifts);
        $this->mold->set('shiftId' , $shifts['shift_id']);
        $value[] = $shifts['shift_id'] ;
        $value[] = $shifts['shift_time_group'] ; 
        $value[] = -1 ;
		$variable[] = ' ((data.Shift_id = ? and data.Shift_group_id = ? ) or (data.Shift_id = ?))';
        
		$variable2[] = ' Sensor_plc_id <> ? ';
		$value2[] = 0;
		/* @var data $model */
		$model = parent::model('data');

        $model->join('sensors sensors','data.Sensor_id = sensors.id');
        $model->join('tile_kind tile_kind','data.Tile_Kind = tile_kind.id');
        $model->join('units units','data.unit = units.id');
        $field = array();
        $field[] = 'SUM(data.counter) as counter';
        $field[] = 'sensors.label as Name';
        $field[] = 'tile_kind.tile_width * tile_kind.tile_length / 10000 * SUM(data.counter) as MetrCounter';
        $field[] = 'sensors.label';
        $field[] = 'sensors.phase';
        $field[] = 'sensors.tileDegree';
        $field[] = 'sensors.Active';
        $field[] = 'sensors.OffTime';
        $field[] = 'sensors.id';
        $field[] = 'tile_kind.label as tile_label';
        $field[] = 'units.label as unitName';
        $field[] = 'units.id';
        $field[] = 'sensors.isStorage';
        $field = implode(',',$field);
        $table = 'data data';
        $search = $model->search( (array) $value  , ( ( count($variable) == 0 ) ? null : implode(' and ' , $variable) )  ,$table , $field  , $sortWith , null , 'data.Sensor_id , data.Tile_Kind' );

        $Sensors = sensor::index($value2,$variable2)["result"];

        if ( $search === true ) {
			$search = array();
		}
        $sensorHasCount = (array) array_column($search, 'Sensor_id');
		foreach ( $Sensors as $sensor ){
			if ( ! in_array($sensor['id'] , $sensorHasCount ) ) {
                $search[] = [
                    'Sensor_id' => $sensor['id'] ,
                    'counter' => 0 ,
                    'MetrCounter' => 0 ,
                    'label' => $sensor['label'] ,
                    'phase' => $sensor['phase'] ,
                    'tileDegree' => $sensor['tileDegree'] ,
                    'Active' => $sensor['Active'] ,
                    'OffTime' => $sensor['OffTime'] ,
                    'tile_label' => '-' ,
                    'unitName' => '-' ,
                    'unit' => $sensor['unit'] ,
                    'isStorage' => $sensor['isStorage'] ,
                ];
			}
		}

        $this->mold->set('logs' , $search);
		$this->mold->set('access' , $Sensors);
		$this->mold->set('tiles'  , tiles::index()["result"]);
		$units = $model->search((array) $valueForUnit  ,  ( ( count($variableForUnit) == 0 ) ? null : implode(' and ' , $variableForUnit) ), 'units', '*', ['column' => 'label', 'type' => 'asc']);
        $this->mold->set('units', units::index()["result"]);
        $this->mold->set('phases', phases::index()["result"]);

        $value = array( );
        $variable = array( );
        $value[] = $shifts['shift_id'] ;
        $value[] = $shifts['shift_time_group'] ;
		$variable[] = ' (data.Start_shift_id = ? and data.Start_Shift_group_id = ? ) ';
        $model = parent::model('sensor_active_log');
        $OFFlogs = $model->search(  (array) $value  , ( ( count($variable) == 0 ) ? null : implode(' and ' , $variable) ) , 'sensor_active_log data', ' data.Sensor_id, SUM(IF(data.End_Time is not null , TIMESTAMPDIFF(SECOND,data.Start_time, data.End_Time) , TIMESTAMPDIFF(SECOND, data.Start_time , now()) ) )  as OffTime ' , null , null ,'data.Sensor_id');
        $this->mold->set('OFFlogs' , $OFFlogs); 
        
        if ($user['user_group_id'] == 1) {
            $value = array( );
            $variable = array( );
            $DayData = Day::index(0)['result'];
            $value[] = $DayData['dayStart'];
            $value[] = $DayData['dayEnd'];
            $value[] = -1;
            $variable[] = '(data.Start_time BETWEEN ? AND ?)';
            $variable[] = 'data.Shift_id <> ?';
            $model = parent::model('data_merge');
            model::join('tile_kind tile_kind','data.Tile_Kind = tile_kind.id');
            $DayLogs = $model->search( (array) $value  ,  ( ( count($variable) == 0 ) ? null : implode(' and ' , $variable) )  , 'data_merge data', ' data.Sensor_id,SUM(data.counter) as counter ,tile_kind.tile_width * tile_kind.tile_length / 10000 * SUM(data.counter) as MetrCounter' , null , null ,'data.Sensor_id');
            $this->mold->set('DayLogs' , $DayLogs);
            $this->mold->set('DaylogFlag', true);
		} 
        else {
			$this->mold->set('DaylogFlag', false);
		}

        $this->mold->path('default', 'LineMonitoring');
		$this->mold->view('logListCounter.mold.html');
		$this->mold->setPageTitle('تولیدات خطوط');
		$this->mold->set('activeMenu' , 'sensorCount');
		$this->mold->set('socketIP' , $_SERVER['HTTP_HOST']);
		$this->mold->set('socketPORT' , $this->setting('wsPort' , 'LineMonitoring' ));

	}
	public  function export() {
		$get = request::post('groupId,StartTime,EndTime,tile_kind,showField,shifts,expert' ,null);

		$value = array( );
		$variable = array( );
		/* @var data_archive $model */
		$model = parent::model('data_archive');


		if (request::isPost() and is_array($get['showField']) and count($get['showField']) > 0 and is_array($get['expert'])and count($get['expert']) > 0 ) {
			if (is_array($get['groupId'] ) and count($get['groupId'] ) > 0 ) {
				$value = $a1 = array_merge($value,$get['groupId'])  ;
				$variable[] = ' data.Sensor_id IN( '. substr(str_repeat( ' ? ,' , count($get['groupId'])) ,0,-1 ) .' ) ';
			}
            
			if (is_array($get['tile_kind'] ) and count($get['tile_kind'] ) > 0 ) {
				$value = $a1 = array_merge($value,$get['tile_kind'])  ;
				$variable[] = ' data.Tile_Kind IN( '. substr(str_repeat( ' ? ,' , count($get['tile_kind'])) ,0,-1 ) .' ) ';
			}
            
			if (is_array($get['shifts'] ) and count($get['shifts'] ) > 0 ) {
				$value = $a1 = array_merge($value,$get['shifts'])  ;
				$variable[] = ' data.Shift_id IN( '. substr(str_repeat( ' ? ,' , count($get['shifts'])) ,0,-1 ) .' ) ';
			}
			if ($get['StartTime'] != null and $get['EndTime'] == null) {
				$value[] = date('Y-m-d H:i:s', $get['StartTime'] / 1000);
				$variable[] = ' data.Start_time > ? ';
			} elseif ($get['StartTime'] == null and $get['EndTime'] != null) {
				$value[] = date('Y-m-d H:i:s', $get['EndTime'] / 1000);
				$variable[] = ' data.Start_time < ? ';
			} elseif ($get['StartTime'] != null and $get['EndTime'] != null) {
				$value[] = date('Y-m-d H:i:s', $get['StartTime'] / 1000);
				$value[] = date('Y-m-d H:i:s', $get['EndTime'] / 1000);
				$variable[] = ' (data.Start_time BETWEEN ? AND ?) ';
			}
			$header = [];
			for ( $i = 0 ;$i < count($get['showField']) ; $i++ ){
				if ( $get['showField'][$i] == "GROUP_CONCAT(DISTINCT CONCAT(user.fname, ' ', user.lname , ' (#',user.userId,')' ) SEPARATOR ' - ')" )
					$header[] = 'نام سرشیفت';
				elseif ( $get['showField'][$i] == "GROUP_CONCAT(DISTINCT shift_work.shift_name SEPARATOR ' - ')" )
					$header[] = 'عنوان شیفت';
				elseif ( $get['showField'][$i] == "GROUP_CONCAT(DISTINCT tile_kind.label SEPARATOR ' - ')" )
					$header[] = 'عنوان کاشی';
				elseif ( $get['showField'][$i] == "GROUP_CONCAT(DISTINCT sensors.label SEPARATOR ' - ')" )
					$header[] = 'عنوان سنسور';
				elseif ( $get['showField'][$i] == "GROUP_CONCAT(DISTINCT data.Shift_group_id SEPARATOR ' - ')" )
					$header[] = 'کد گروهی شیفت';
				elseif ( $get['showField'][$i] == "data.JStart_time" )
					$header[] = 'تاریخ شمسی';
				elseif ( $get['showField'][$i] == "DATE(data.Start_time)" )
					$header[] = 'تاریخ میلادی';
				elseif ( $get['showField'][$i] == "TIME(data.Start_time)" )
					$header[] = 'ساعت';
				elseif ( $get['showField'][$i] == "SUM(data.counter)" )
					$header[] = 'مجموع تعداد';
			}

			model::join('sensors sensors', 'data.Sensor_id = sensors.id');
			model::join('tile_kind tile_kind', 'data.Tile_Kind = tile_kind.id');
			model::join('user user', 'data.employers_id = user.userId');
			model::join('shift_work shift_work', 'data.Shift_id = shift_work.shift_id');
			$search = $model->search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), 'data_archive data', implode(' , ' , $get['showField']), null, null, implode(' , ', $get['expert']));
            
			if ( is_array($search) and count($search) > 0 ) {
				header('Content-Encoding: UTF-8');
				header('Content-type: text/csv; charset=UTF-8');
				header("Content-Disposition: attachment; filename=" . 'Export Log (' . date('Y-M-d H:i:s') . ').csv');
				header("Pragma: no-cache");
				header("Expires: 0");
				header('Content-Transfer-Encoding: binary');
				$this->mold->offAutoCompile();
				$GLOBALS['timeStart'] = '';
				echo "\xEF\xBB\xBF";
				$fp = fopen('php://output', 'w');
				fputcsv($fp, $header);
				for ($i = 0; $i < count($search); $i++) {
					fputcsv($fp, $search[$i]);
				}
				fclose($fp);
				return true;
			}else{
				$this->alert('danger','','نتیجه ای یافت نشد !');
			}
		}

		$this->mold->path('default', 'LineMonitoring');
		$this->mold->view('export.mold.html');
		$this->mold->setPageTitle('گزارش گیری');
		$this->mold->set('activeMenu' , 'exportExcel');

		$search = $model->search( array()  ,  null  , 'sensors', '*'  , ['column' => 'showSort' , 'type' =>'asc'] );
		$this->mold->set('access' , $search);
		$this->mold->set('tiles'  , tiles::index()["result"]);
        $this->mold->set('shifts' , shift::index()["result"]);

	}

	private static function tr_num($str, $mod = 'en') {
		$num_a = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
		$key_a = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
		return ($mod == 'fa') ? str_replace($num_a, $key_a, $str) : str_replace($key_a, $num_a, $str);
	}
}