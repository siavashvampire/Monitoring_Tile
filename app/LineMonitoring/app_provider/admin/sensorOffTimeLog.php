<?php

namespace App\LineMonitoring\app_provider\admin;

use App\core\controller\fieldService;
use App\LineMonitoring\app_provider\api\phases;
use App\LineMonitoring\model\sensor_active_log;
use App\shiftWork\app_provider\api\Day;
use App\LineMonitoring\model\sensor_active_log_archive;
use App\units\app_provider\api\units;
use App\user\app_provider\api\user;
use controller;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class sensorOffTimeLog extends controller
{
    public function lists($insertReason = null)
    {
        $get = request::post('page=1,perEachPage=25,groupId,StartTime,EndTime,howShow=count,phase,unitId,reasonType,sortWith', null);
        $rules = ["page" => ["required|match:>0", rlang('page')], "perEachPage" => ["required|match:>0|match:<501", rlang('page')],];
        $valid = validate::check($get, $rules);
        $value = array();
        $variable = array();
        $valueForSensor = array();
        $valueForUnit = array();
        $variableForSensor = array();
        $variableForUnit = array();
        $sortWith = ['column' => 'data.Start_time', 'type' => 'desc'];
        $variableForSensor[] = 'OffTime <> ?';
        $valueForSensor[] = 0;
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
            $valueForSensor[] = $unitId;
            $valueForUnit[] = $unitId;
            $variable[] = ' data.unit = ? ';
            $variableForSensor[] = ' unit = ? ';
            $variableForUnit[] = ' id = ? ';
            $get['unitId'] = null;
        }
        if ($phase) {
            $value[] = $phase;
            $valueForSensor[] = $phase;
            $variable[] = ' data.phase = ? ';
            $variableForSensor[] = ' phase = ? ';
            $get['phase'] = null;
        }
        if ($insertReason != null) {
            $value[] = '0';
            $variable[] = ' ( data.reason is null or data.description is null or ? ) ';
        }

        $this->mold->set('canChange', false);
        $this->mold->set('canChange2', false);

        if ($get['groupId'] != null) {
            $value[] = $get['groupId'];
            $variable[] = ' data.Sensor_id = ? ';
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
            $variable[] = '(data.Start_time BETWEEN ? AND ?)';
        }

        if ($get['phase'] != null) {
            $value[] = $get['phase'];
            $variable[] = ' data.phase = ? ';
        }
        if ($get['unitId'] != null) {
            $value[] = $get['unitId'];
            $variable[] = ' data.unit = ? ';
        }
        if ($get['reasonType'] != null) {
            $value[] = $get['reasonType'];
            $variable[] = ' data.reasonType = ? ';
        }
        if ($get['sortWith'] != null and is_array($get['sortWith'])) {
            unset($sortWith);
            foreach ($get['sortWith'] as $sort) {
                $temp = explode('|', $sort);
                $sortWith[] = ['column' => $temp[0], 'type' => $temp[1]];
            }
        }

        if ($get['howShow'] == 'all') {
            $search = $this->getActive($value, $variable, $sortWith, $get['page'], $get['perEachPage']);
        } elseif ($get['howShow'] == 'count') {
            $search = $this->countTab($value, $variable, $sortWith, $get['page'], $get['perEachPage']);
        } elseif ($get['howShow'] == 'yesterday') {
            $DayData = Day::index(1)['result'];
            $value[] = $DayData['dayStart'];
            $value[] = $DayData['dayEnd'];
            $variable[] = ' (data.Start_time BETWEEN ? AND ?)';
            $search = $this->getActive($value, $variable, $sortWith, $get['page'], $get['perEachPage']);
        } elseif ($get['howShow'] == 'today') {
            $DayData = Day::index(0)['result'];
            $value[] = $DayData['dayStart'];
            $value[] = $DayData['dayEnd'];
            $variable[] = '(data.Start_time BETWEEN ? AND ?)';
            $search = $this->getActive($value, $variable, $sortWith, $get['page'], $get['perEachPage']);
        }

        /** @var sensor_active_log $model */
        $model = parent::model('sensor_active_log');
        $Sensors = $model->search((array)$valueForSensor, ((count($variableForSensor) == 0) ? null : implode(' and ', $variableForSensor)), 'sensors', '*', ['column' => 'showSort', 'type' => 'asc']);
        $this->mold->set('access', $Sensors);
        $this->mold->set('units', units::index($valueForUnit , $variableForUnit)['result']);

        $this->mold->set('phases', phases::index()["result"]);

        $offReasons = $model->search([1], 'parentId is null and ? ', 'off_sensor_reasons', '*', ['column' => 'id', 'type' => 'asc']);
        $this->mold->set('offSensorReasons', $offReasons);

        $reasonType = $model->search([1], null, 'reasonType', '*', ['column' => 'id', 'type' => 'asc']);
        $this->mold->set('reasonTypes', $reasonType);

        $phasesInOne = $this->setting('offSensorDescription');
        if ($phasesInOne != "") {
            $phases = preg_split('/\r\n|[\r\n]/', $phasesInOne);
            $this->mold->set('offSensorDescriptions', $phases);
        }

        $this->mold->path('default', 'LineMonitoring');
        $this->mold->view('OffTimeLogList.mold.html');
        $this->mold->setPageTitle('لاگ توقفات واحدها');
        $this->mold->set('activeMenu', 'sensorOfflog');
        $this->mold->set('logs', $search);
        $this->mold->set('howToShow', $get['howShow']);

    }

    public function index($insertReason = null)
    {
        $this->InsertReason($insertReason);
    }

    private function InsertReason($insertReason = null)
    {
        $get = request::post('page=1,perEachPage=10,groupId,StartTime,EndTime,howShow=yesterday,phase,unitId,reasonType,sortWith', null);
        $rules = ["page" => ["required|match:>0", rlang('page')], "perEachPage" => ["required|match:>0|match:<501", rlang('page')],];
        $valid = validate::check($get, $rules);
        $value = array();
        $variable = array();
        $valueForSensor = array();
        $valueForUnit = array();
        $variableForSensor = array();
        $variableForUnit = array();
        $sortWith = ['column' => 'data.Start_time', 'type' => 'desc'];

        $variableForSensor[] = 'OffTime <> ?';
        $valueForSensor[] = 0;
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
            $valueForSensor[] = $unitId;
            $valueForUnit[] = $unitId;
            $variable[] = ' data.unit = ? ';
            $variableForSensor[] = ' unit = ? ';
            $variableForUnit[] = ' id = ? ';
            $get['unitId'] = null;
        }
        if ($phase) {
            $value[] = $phase;
            $valueForSensor[] = $phase;
            $variable[] = ' data.phase = ? ';
            $variableForSensor[] = ' phase = ? ';
            $get['phase'] = null;
        }
        if ($insertReason != null) {
            $value[] = '0';
            $variable[] = ' ( data.reason is null or data.description is null or ? ) ';
        }

        if ($user['user_group_id'] == $this->setting('supervisor')) {
            $this->mold->set('canChange', true);
        } else {
            $this->mold->set('canChange', false);
        }

        if ($user['user_group_id'] == $this->setting('OFFAdmin') or $user['user_group_id'] == 1) {
            $this->mold->set('canChange2', true);
            $this->mold->set('canChange', true);

        } else {
            $this->mold->set('canChange2', false);
        }


        if ($get['groupId'] != null) {
            $value[] = $get['groupId'];
            $variable[] = ' data.Sensor_id = ? ';
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
            $variable[] = '(data.Start_time BETWEEN ? AND ?)';
        }

        if ($get['phase'] != null) {
            $value[] = $get['phase'];
            $variable[] = ' data.phase = ? ';
        }
        if ($get['unitId'] != null) {
            $value[] = $get['unitId'];
            $variable[] = ' data.unit = ? ';
        }
        if ($get['reasonType'] != null) {
            $value[] = $get['reasonType'];
            $variable[] = ' data.reasonType = ? ';
        }
        if ($get['sortWith'] != null and is_array($get['sortWith'])) {
            unset($sortWith);
            foreach ($get['sortWith'] as $sort) {
                $temp = explode('|', $sort);
                $sortWith[] = ['column' => $temp[0], 'type' => $temp[1]];
            }
        }

        if ($get['howShow'] == 'all') {
            $search = $this->getActive($value, $variable, $sortWith, $get['page'], $get['perEachPage']);
        } elseif ($get['howShow'] == 'count') {
            $search = $this->countTab($value, $variable, $sortWith, $get['page'], $get['perEachPage']);
        } elseif ($get['howShow'] == 'yesterday') {
            $DayData = Day::index(1)['result'];
            $value[] = $DayData['dayStart'];
            $value[] = $DayData['dayEnd'];
            $variable[] = ' (data.Start_time BETWEEN ? AND ?)';
            $search = $this->getActive($value, $variable, $sortWith, $get['page'], $get['perEachPage']);
        } elseif ($get['howShow'] == 'today') {
            $DayData = Day::index(0)['result'];
            $value[] = $DayData['dayStart'];
            $value[] = $DayData['dayEnd'];
            $variable[] = '(data.Start_time BETWEEN ? AND ?)';
            $search = $this->getActive($value, $variable, $sortWith, $get['page'], $get['perEachPage']);
        }

        $model = parent::model('sensor_active_log');
        $Sensors = $model->search((array)$valueForSensor, ((count($variableForSensor) == 0) ? null : implode(' and ', $variableForSensor)), 'sensors', '*', ['column' => 'showSort', 'type' => 'asc']);
        $this->mold->set('access', $Sensors);
        $units = $model->search((array)$valueForUnit, ((count($variableForUnit) == 0) ? null : implode(' and ', $variableForUnit)), 'units', '*', ['column' => 'label', 'type' => 'asc']);
        $this->mold->set('units', $units);

        $this->mold->set('phases', phases::index()["result"]);

        $offReasons = $model->search([1], 'parentId is null and ? ', 'off_sensor_reasons', '*', ['column' => 'id', 'type' => 'asc']);
        $this->mold->set('offSensorReasons', $offReasons);

        $reasonType = $model->search([1], null, 'reasonType', '*', ['column' => 'id', 'type' => 'asc']);
        $this->mold->set('reasonTypes', $reasonType);

        $phasesInOne = $this->setting('offSensorDescription');
        if ($phasesInOne != "") {
            $phases = preg_split('/\r\n|[\r\n]/', $phasesInOne);
            $this->mold->set('offSensorDescriptions', $phases);
        }

        $this->mold->path('default', 'LineMonitoring');
        $this->mold->view('OffTimeLogList.mold.html');
        $this->mold->setPageTitle('ثبت توقفات');
        $this->mold->set('activeMenu', 'InsertsensorOfflog');
        $this->mold->set('logs', $search);
        $this->mold->set('howToShow', $get['howShow']);
    }

    public function getReason()
    {
        $this->mold->offAutoCompile();
        $get = request::post('value');
        /** @var  \App\LineMonitoring\model\off_sensor_reasons $model */
        $model = $this->model('off_sensor_reasons', $get['value']);
        if ($model->getId() == $get['value']) {

            $search = $model->search([$model->getId()], 'parentId = ?', 'off_sensor_reasons', '*', ['column' => 'id', 'type' => 'asc']);
            Response::json(['status' => true, 'reason' => $search]);
        }
        Response::json(['status' => false]);
    }

    public function updateReason()
    {
        $this->mold->offAutoCompile();
        $get = request::post('logId,type,value');
        /** @var  sensor_active_log_archive $model */
        $model = $this->model('sensor_active_log_archive', $get['logId']);
        if ($model->getActivityId() == $get['logId']) {
            if ($get['type'] == 'reason') $model->setReason($get['value']);
            if ($get['type'] == 'description') $model->setDescription($get['value']);
            if ($get['type'] == 'reasonType') $model->setReasonType($get['value']);
            $model->setInfoInsert(user::getUserLogin(true));
            if ($model->upDateDataBase()) {
                $sensor = $this->model('sensors', $model->getSensor_id());
                if ($get['type'] == 'reason') $Dis = 'علت توقف سنسور  ';
                if ($get['type'] == 'description') $Dis = 'توضیحات توقف سنسور  ';
                if ($get['type'] == 'reasonType') $Dis = 'نوع توقف سنسور  ';

                $Dis = $Dis . $sensor->getLabel();
                $Dis = $Dis . ' به ';

                if ($get['type'] == 'reason') $Dis = $Dis . $model->getReason();
                if ($get['type'] == 'description') $Dis = $Dis . $model->getDescription();
                if ($get['type'] == 'reasonType') {
                    $reasontype = $this->model('reasontype', $model->getReasonType());
                    $Dis = $Dis . $reasontype->getTitle();
                }
                $Dis = $Dis . ' تغییر یافت';
                $this->callHooks('addLog', [$Dis, 'updateReason']);
                Response::json(['status' => true]);
            }
        }
        Response::json(['status' => false]);
    }

    private function getActive($value, $variable, $sortWith, $page, $perEachPage)
    {
        $model = parent::model('sensor_active_log');
        $numberOfAll = ($model->search((array)$value, (count($variable) == 0) ? null : implode(' and ', $variable), 'sensor_active_log_archive data', 'COUNT(data.Sensor_id) as co')) [0]['co'];
        $pagination = parent::pagination($numberOfAll, $page, $perEachPage);

        model::join('tile_kind tile_kind', 'data.Start_Tile_Kind = tile_kind.id');
        model::join('tile_kind etile_kind', 'data.End_Tile_Kind = etile_kind.id');

        model::join('shift_work shift_work', 'data.Start_shift_id = shift_work.shift_id');
        model::join('shift_work eshift_work', 'data.End_Shift_id = eshift_work.shift_id');

        model::join('user user', 'data.Start_employers_id = user.userId');
        model::join('user euser', 'data.End_employers_id = euser.userId');


        model::join('units units', 'data.unit = units.id');
        model::join('off_sensor_reasons offsensor', 'data.reason = offsensor.label');
        model::join('sensors sensors', 'data.Sensor_id = sensors.id');
        model::join('phases phase', 'data.phase = phase.id');

        $search = $model->search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), 'sensor_active_log_archive data', 'data.* ,phase.label as phase, sensors.label,tile_kind.label as Stile_name,etile_kind.label as Etile_name,shift_work.shift_name as Sshift_name,eshift_work.shift_name as Eshift_name,user.fname as Sfname,user.lname as Slname,euser.fname as Efname,euser.lname as Elname , units.label as unitName , offsensor.parentId as parentId , ' . "concat(IF(MOD(HOUR(TIMEDIFF(data.End_Time, data.Start_time) ),24 ) !=0 , concat(MOD(HOUR(TIMEDIFF(data.End_Time, data.Start_time) ),24 ), ' ساعت و ') , '' ) , minute(TIMEDIFF(data.End_Time, data.Start_time) ) , ' دقیقه') as OffTime", $sortWith, [$pagination['start'], $pagination['limit']]);
        return $search;
    }

    private function countTab($value, $variable, $sortWith, $page, $perEachPage)
    {
        $value[] = 1;
        $variable[] = '(End_Shift_id is not null or End_Shift_group_id is not null) AND ?';
        $model = parent::model('sensor_active_log_archive');

        $db = (model::db());
        $perfix = $db::$prefix;
        $tempDBName1 = 'temp_Count';
        $tempDBName = $perfix . $tempDBName1;
        $numberOfAll = model::queryUnprepared('CREATE TEMPORARY TABLE IF NOT EXISTS ' . $tempDBName . ' SELECT COUNT(co1) as co FROM (SELECT COUNT(data.Sensor_id) as co1 FROM per_sensor_active_log_archive data WHERE ( End_Shift_id is not null or End_Shift_group_id is not null )GROUP BY data.Sensor_id , YEAR(data.Start_time), MONTH(data.Start_time) , DAY(data.Start_time) , data.Start_shift_id,data.Start_Shift_group_id) as co1;');
        $numberOfAll = $model->search([1], '?', $tempDBName1, '*')[0]['co'];
        $pagination = parent::pagination($numberOfAll, $page, $perEachPage);
        $model -> join('shift_work shift_work', 'data.Start_shift_id = shift_work.shift_id');
        $model ->join('shift_time shift_time', '(data.Start_Shift_group_id = shift_time.shift_time_group AND data.Start_shift_id = shift_time.shift_id AND TIME(data.Start_time) between shift_time.startTime AND shift_time.endTime)');
        $model ->join('sensors sensors', 'data.Sensor_id = sensors.id');
        $model ->join('units units', 'data.unit = units.id');
        model::join('phases phase', 'data.phase = phase.id');
        $OFFCount = $model->search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), 'sensor_active_log_merge data', 'sensors.label,shift_work.shift_name as shift_name,shift_time.onDay as Day_Name, SUM(TIMESTAMPDIFF(SECOND,data.Start_time,data.End_Time) ) as OffTime , DATE(data.JStart_time) as Time ,phase.label as phase , units.label as unitName ', $sortWith, [$pagination['start'], $pagination['limit']], 'data.Sensor_id , YEAR(`data.Start_time`), MONTH(`data.Start_time`) , DAY(`data.Start_time`) , `data.Start_shift_id` , `data.Start_Shift_group_id`');
        return $OFFCount;
    }

    private static function tr_num($str, $mod = 'en')
    {
        $num_a = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $key_a = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        return ($mod == 'fa') ? str_replace($num_a, $key_a, $str) : str_replace($key_a, $num_a, $str);
    }
}