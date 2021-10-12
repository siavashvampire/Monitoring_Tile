<?php
namespace App\LineMonitoring\app_provider\admin;

use App\core\controller\fieldService;
use App\LineMonitoring\app_provider\api\phases;
use App\LineMonitoring\model\sensor_active_log_archive;
use App\LineMonitoring\model\switch_active_log_archive;
use App\units\app_provider\api\units;
use App\user\app_provider\api\user;
use controller;
use paymentCms\component\JDate;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class SwitchOffTimeLog extends controller {
	public function index($insertReason = null){
		$this->lists($insertReason);
	}
	private function lists($insertReason = null) {
		$get = request::post('page=1,perEachPage=25,groupId,StartTime,EndTime,howShow=all,phase,unit,sortWith', null);
		$rules = ["page" => ["required|match:>0", rlang('page')], "perEachPage" => ["required|match:>0|match:<501", rlang('page')],];
		$valid = validate::check($get, $rules);
		$value = array();
		$variable = array();
		$sortWith = ['column' => 'data.Start_time', 'type' => 'desc'];

		$user = user::getUserLogin();
		
		if ($user['user_group_id'] == $this->setting('supervisor')) {
			$fields = fieldService::showFilledOutFormWithAllFields($user['user_group_id'], 'user_register', $user['userId'], 'user_register', true);
			$unit = false;
			$phase = false;
			if (is_array($fields['result'])) {
				foreach ($fields['result'] as $index => $fields) {
					if ($fields['type'] == 'fieldCall_units_units') {
						$unit = $fields['value'];
					} elseif ($fields['type'] == 'fieldCall_LineMonitoring_phase') {
						$phase = $fields['value'];
					}
					if ($unit and $phase) break;
				}
			}
			$this->mold->set('canChange', true);
			if ($unit) {
				$value[] = $unit;
				$variable[] = ' data.unit = ? ';
				$get['unit'] = null;
			}
			if ($phase) {
				$value[] = $phase;
				$variable[] = ' data.phase = ? ';
				$get['phase'] = null;
			}
			if ( $insertReason != null ){
				$value[] = '0' ;
				$variable[] = ' ( data.reason is null or data.description is null or ? ) ';
			}

		} else {
			$this->mold->set('canChange', false);
		}		
        
		if ($user['user_group_id'] == $this->setting('field_OFFAdmin') or $user['user_group_id'] == 1) {
			$this->mold->set('canChange2', true);
			$this->mold->set('canChange', true);

		} else {
			$this->mold->set('canChange2', false);
		}


		if ($valid->isFail()) {
			//TODO:: add error is not valid data

		} else {
			if ($get['groupId'] != null) {
				$value[] = $get['groupId'];
				$variable[] = ' data.Switch_id = ? ';
			}
			if ($get['StartTime'] != null and $get['EndTime'] == null) {
				$value[] = date('Y-m-d H:i:s', $get['StartTime'] / 1000);
				$variable[] = ' data.End_Time > ? ';
			} elseif ($get['StartTime'] == null and $get['EndTime'] != null) {
				$value[] = date('Y-m-d H:i:s', $get['EndTime'] / 1000);
				$variable[] = ' data.Start_time < ? ';
			} elseif ($get['StartTime'] != null and $get['EndTime'] != null) {
				$value[] = date('Y-m-d H:i:s', $get['StartTime'] / 1000);
				$value[] = date('Y-m-d H:i:s', $get['EndTime'] / 1000);
				$value[] = date('Y-m-d H:i:s', $get['StartTime'] / 1000);
				$value[] = date('Y-m-d H:i:s', $get['EndTime'] / 1000);
				$variable[] = ' ( (data.Start_time BETWEEN ? AND ?) or (data.End_Time BETWEEN ? AND ?) )';
			}
			
			if ($get['phase'] != null) {
				$value[] = $get['phase'];
				$variable[] = ' data.phase = ? ';
			}
			if ($get['unit'] != null) {
				$value[] = $get['unit'];
				$variable[] = ' data.unit = ? ';
			}
			if ($get['sortWith'] != null and is_array($get['sortWith'])) {
				unset($sortWith);
				foreach ($get['sortWith'] as $sort) {
					$temp = explode('|', $sort);
					$sortWith[] = ['column' => $temp[0], 'type' => $temp[1]];
				}
			}
		}
		$model = parent::model('Switch_active_log');

		if ($get['howShow'] == 'all') {
            $numberOfAll = ($model->search((array)$value, (count($variable) == 0) ? null : implode(' and ', $variable), 'Switch_active_log_archive data', 'COUNT(data.Switch_id) as co')) [0]['co'];
			$pagination = parent::pagination($numberOfAll, $get['page'], $get['perEachPage']);
            

			model::join('shift_work shift_work', 'data.Start_shift_id = shift_work.shift_id');
			model::join('shift_work eshift_work', 'data.End_Shift_id = eshift_work.shift_id');

			model::join('user user', 'data.Start_employers_id = user.userId');
			model::join('user euser', 'data.End_employers_id = euser.userId');


			model::join('units units', 'data.unit = units.id');
			model::join('phases phases', 'data.phase = phases.id');
			model::join('off_sensor_reasons offsensor', 'data.reason = offsensor.label');
            model::join('CamSwitch CS', 'data.Switch_id = CS.id');


			$search = $model->search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), 'Switch_active_log_archive data', 'data.* , phases.label as phase, CS.label,shift_work.shift_name as Sshift_name,eshift_work.shift_name as Eshift_name,user.fname as Sfname,user.lname as Slname,euser.fname as Efname,euser.lname as Elname , units.label as unitName , offsensor.parentId as parentId , ' . "concat(Floor(HOUR(TIMEDIFF(data.End_Time, data.Start_time) )/24) , ' روز ', MOD(HOUR(TIMEDIFF(data.End_Time, data.Start_time) ),24 ), ' سآعت ' , minute(TIMEDIFF(data.End_Time, data.Start_time) ) , ' دقیقه') as OffTime", $sortWith, [$pagination['start'], $pagination['limit']]);
		} 
        elseif ($get['howShow'] == 'count'){
            $numberOfAll = ($model->search((array)$value, (count($variable) == 0) ? null : implode(' and ', $variable), 'Switch_active_log_archive data', 'COUNT(data.Switch_id) as co')) [0]['co'];
			$pagination = parent::pagination($numberOfAll, $get['page'], $get['perEachPage']);
            
            model::join('shift_work shift_work', 'data.Start_shift_id = shift_work.shift_id');
            model::join('CamSwitch CS', 'data.Switch_id = CS.id');
			model::join('units units', 'data.unit = units.id');
            model::join('phases phases', 'data.phase = phases.id');
			$search = $model->search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), 'Switch_active_log_archive data', ' CS.label,shift_work.shift_name as shift_name, SUM(TIMESTAMPDIFF(SECOND,data.End_Time, data.Start_time) ) as OffTime , phases.label as phase , data.JStart_time as Time , units.label as unitName ', $sortWith, [$pagination['start'], $pagination['limit']], 'data.Switch_id , YEAR(`data.Start_time`), MONTH(`data.Start_time`) , DAY(`data.Start_time`) , `data.Start_shift_id`,`data.Start_Shift_group_id`');
		}

		$this->mold->path('default', 'LineMonitoring');
		$this->mold->view('SwitchOffTimeLogList.mold.html');
		$this->mold->setPageTitle('لاگ خاموشی کلیدها');
		$this->mold->set('activeMenu', 'SwitchOfflog');
		$this->mold->set('logs', $search);
		$this->mold->set('howToShow', $get['howShow']);
		$search = $model->search(array(), null, 'CamSwitch', '*', ['column' => 'label', 'type' => 'asc']);
		$this->mold->set('access', $search);
        $this->mold->set('units', units::index()["result"]);
        $this->mold->set('phases', phases::index()["result"]);



		$search = $model->search([1], 'parentId is null and ? ', 'off_sensor_reasons', '*', ['column' => 'label', 'type' => 'asc']);
		$this->mold->set('offSensorReasons', $search);

		$phasesInOne = $this->setting('offSensorDescription');
		if ($phasesInOne != "") {
			$phases = preg_split('/\r\n|[\r\n]/', $phasesInOne);
			$this->mold->set('offSensorDescriptions', $phases);
		}
	}
	public function getReason(){
        $this->mold->offAutoCompile();
		$get = request::post('value');
		/** @var  \App\LineMonitoring\model\off_sensor_reasons $model */
		$model = $this->model('off_sensor_reasons' , $get['value']);
		if ( $model->getId() == $get['value']){
        
			$search = $model->search([$model->getId()], 'parentId = ?', 'off_sensor_reasons', '*', ['column' => 'label', 'type' => 'asc']);
            Response::json(['status'=> true , 'reason' => $search]);
		}
		Response::json(['status'=> false]);
	}
	public function updateReason(){
        $this->mold->offAutoCompile();
		$get = request::post('logId,type,value');
		/** @var  Switch_active_log_archive $model */
		$model = $this->model('Switch_active_log_archive' , $get['logId']);
		if ( $model->getActivityId() == $get['logId']){
			if ( $get['type'] == 'reason' )  $model->setReason($get['value']);
			if ( $get['type'] == 'description' )  $model->setDescription($get['value']);
			$model->setInfoInsert(user::getUserLogin(true));
			if ( $model->upDateDataBase() ){
                $Switch = $this->model('CamSwitch' , $model->getSwitchId());
                $Dis = 'علت کلید  ';
                $Dis = $Dis . $Switch->getLabel();
                $Dis = $Dis .' به ';
                $Dis = $Dis . $model->getReason();
                $Dis = $Dis . ' تغییر یافت';
                $this->callHooks('addLog', [$Dis , 'updateReason']);
				Response::json(['status'=> true]);
			}
		}
		Response::json(['status'=> false]);
	}

	private static function tr_num($str, $mod = 'en') {
		$num_a = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
		$key_a = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
		return ($mod == 'fa') ? str_replace($num_a, $key_a, $str) : str_replace($key_a, $num_a, $str);
	}
}