<?php

namespace App\LineMonitoring\app_provider\api;

use App\api\controller\innerController;
use app\LineMonitoring\model\data;
use App\LineMonitoring\model\phases_budget;
use app\LineMonitoring\model\sensors;
use App\shiftWork\app_provider\api\Day;
use App\shiftWork\app_provider\api\shift;
use paymentCms\component\cache;
use paymentCms\component\JDate;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class get extends innerController
{
    public static function sensorActivity()
    {
        $get = request::post('unitId , phase', null);
        $value = array();
        $variable = array();
        $value[] = 1;
        if ($_POST['unitId'] != null) {
            $variable[] = ' sensors.unitId IN ' . $_POST['unitId'];
        }
        if ($_POST['phase'] != null) {
            $value[] = $_POST['phase'];
            $variable[] = ' sensors.phase = ? ';
        }
        $sensors = parent::model(['LineMonitoring', 'sensors']);
        model::join('units units', 'units.id =  sensors.unitId');
        $sensorsActivity = $sensors->search(( array )$value, ((count($variable) == 0) ? null : '? and ' . implode(' and ', $variable) . ' and ') . 'sensors.Sensor_plc_id <> 0 and sensors.isVirtual = 0 and sensors.OffTime <> 0', 'sensors sensors', 'sensors.label as Name , units.label as unit , sensors.phase as Phase  , sensors.Active as Active', ['column' => 'sensors.showSort', 'type' => 'asc']);
        return self::json($sensorsActivity);
    }

    public static function Counter()
    {
        $get = request::post('unitId, phase, groupId,StartTime,EndTime,tile_kind', null);
        $value = array();
        $value2 = array();
        $variable = array();
        $variable2 = array();
        if ($_POST['unitId'] != null) {
            $variable[] = ' data.unit IN ' . $_POST['unitId'];
            $variable2[] = ' unitId IN ' . $_POST['unitId'];
            $value2[] = '1';
        }

        if ($_POST['phase'] != null) {
            $value[] = $_POST['phase'];
            $value2[] = $_POST['phase'];
            $variable[] = ' data.phase = ? ';
            $variable2[] = ' phase = ? ';
        }
        if ($get['groupId'] != null) {
            $value[] = $_POST['groupId'];
            $value2[] = $_POST['groupId'];
            $variable[] = ' data.Sensor_id = ? ';
            $variable2[] = ' Sensor_id = ? ';
        }
        if ($get['tile_kind'] != null) {
            $value[] = $_POST['tile_kind'];
            $variable[] = ' data.Tile_Kind = ? ';
        }
        if ($get['StartTime'] != null and $get['EndTime'] == null) {
            $value[] = date('Y-m-d ') . substr(self::tr_num($get['StartTime']), 0, 5) . ':00';
            $variable[] = ' data.Start_time > ? ';
        } elseif ($get['StartTime'] == null and $get['EndTime'] != null) {
            $value[] = date('Y-m-d ') . substr(self::tr_num($get['EndTime']), 0, 5) . ':59';
            $variable[] = ' data.Start_time < ? ';
        } elseif ($get['StartTime'] != null and $get['EndTime'] != null) {
            $value[] = date('Y-m-d ') . substr(self::tr_num($get['StartTime']), 0, 5) . ':00';
            $value[] = date('Y-m-d ') . substr(self::tr_num($get['EndTime']), 0, 5) . ':59';
            $variable[] = ' (data.Start_time BETWEEN ? AND ?) ';
        }

        $day = JDate::jdate('l');
        $timeSTR = date("H:i:30");
        if (isset($_SERVER['JsonOff']))
            $isSet = false;
        else
            $isSet = true;
        $_SERVER['JsonOff'] = true;
        $shiftData = self::shift()['result'];
        if ($isSet)
            unset($_SERVER['JsonOff']);

        $value[] = $shiftData['shift_id'];
        $value[] = $shiftData['shift_time_group'];
        $variable[] = ' (data.Shift_id = ? and data.Shift_group_id = ? ) ';

        /* @var data $model */
        $model = parent::model('data');
        $sortWith = [['column' => 'sensors.showSort', 'type' => 'asc']];
        model::join('sensors sensors', 'data.Sensor_id = sensors.id');
        model::join('tile_kind tile_kind', 'data.Tile_Kind = tile_kind.id');
        $Counter = $model->search(( array )$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), 'data data', 'SUM(data.counter) as counter,sensors.id, sensors.label,tile_kind.label as tile_label , sensors.phase', $sortWith, null, 'data.Sensor_id , data.Tile_Kind');

        $Sensors = sensor::index($value2, $variable2)["result"];
        $sensorHasCount = (array)array_column($Counter, 'Sensor_id');
        if ($Counter === true) {
            $Counter = array();
        }
        foreach ($Sensors as $sensor) {
            if (!in_array($sensor['Sensor_id'], $sensorHasCount)) {
                $Counter[] = [
                    'counter' => 0,
                    'Sensor_id' => $sensor['Sensor_id'],
                    'label' => $sensor['label'],
                    'tile_label' => $sensor['label'],
                    'phase' => $sensor['phase'],
                ];
            }
        }
        return self::json($Counter);
    }

    public static function DayCounter($diffDay = 0, $unitId = null)
    {
        $get = request::post('unitId, phase, groupId,StartTime,EndTime,tile_kind,diffDay=0', null);
        if ($diffDay)
            $get['diffDay'] = $diffDay;
        if ($unitId != null)
            $_POST['unitId'] = $unitId;
        $value = array();
        $value2 = array();
        $variable = array();
        $variable2 = array();

        if ($_POST['unitId'] != null) {
            $value[] = $_POST['unitId'];
            $value2[] = $_POST['unitId'];
            $variable[] = ' data.unit = ?';
            $variable2[] = ' unitId = ?';
        }
        if ($_POST['phase'] != null) {
            $value[] = $_POST['phase'];
            $value2[] = $_POST['phase'];
            $variable[] = ' data.phase = ? ';
            $variable2[] = ' phase = ? ';
        }
        if ($get['groupId'] != null) {
            $value[] = $_POST['groupId'];
            $value2[] = $_POST['groupId'];
            $variable[] = ' data.Sensor_id = ? ';
            $variable2[] = ' Sensor_id = ? ';
        }
        if ($get['tile_kind'] != null) {
            $value[] = $_POST['tile_kind'];
            $variable[] = ' data.Tile_Kind = ? ';
        }
        if ($get['StartTime'] != null and $get['EndTime'] == null) {
            $value[] = date('Y-m-d ') . substr(self::tr_num($get['StartTime']), 0, 5) . ':00';
            $variable[] = ' data.Start_time > ? ';
        } elseif ($get['StartTime'] == null and $get['EndTime'] != null) {
            $value[] = date('Y-m-d ') . substr(self::tr_num($get['EndTime']), 0, 5) . ':59';
            $variable[] = ' data.Start_time < ? ';
        } elseif ($get['StartTime'] != null and $get['EndTime'] != null) {
            $value[] = date('Y-m-d ') . substr(self::tr_num($get['StartTime']), 0, 5) . ':00';
            $value[] = date('Y-m-d ') . substr(self::tr_num($get['EndTime']), 0, 5) . ':59';
            $variable[] = ' (data.Start_time BETWEEN ? AND ?) ';
        }

        $day = JDate::jdate('l');
        $timeSTR = date("H:i:30");

        if (isset($_SERVER['JsonOff']))
            $isSet = false;
        else
            $isSet = true;
        $_SERVER['JsonOff'] = true;
        $DayData = self::Day($get['diffDay'])['result'];
        if ($isSet)
            unset($_SERVER['JsonOff']);
        $value[] = $DayData['dayStart'];
        $value[] = $DayData['dayEnd'];
        $variable[] = '(data.Start_time BETWEEN ? AND ?)';

        $model = parent::model('data_merge');
        model::join('tile_kind tile_kind', 'data.Tile_Kind = tile_kind.id');
        model::join('sensors sensors', 'data.Sensor_id = sensors.id');
        $DayLogs = $model->search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), 'data_merge data', 'SUM(data.counter) as counter,sensors.id, sensors.label,tile_kind.label , sensors.phase, sensors.tileDegree', ['column' => 'sensors.showSort', 'type' => 'asc'], null, 'data.Sensor_id');
        model::join('tile_kind tile_kind', 'sensor.tile_id = tile_kind.id');
        $Sensors = $model->search((array)$value2, ((count($variable2) == 0) ? null : implode(' and ', $variable2)), 'sensors sensor', 'sensor.* ,tile_kind.label as label', ['column' => 'showSort', 'type' => 'asc']);
        $sensorHasCount = (array)array_column($DayLogs, 'Sensor_id');
        if ($DayLogs === true)
            $DayLogs = array();

        foreach ($Sensors as $sensor) {
            if (!in_array($sensor['Sensor_id'], $sensorHasCount)) {
                $DayLogs[] = [
                    'counter' => 0,
                    'label' => $sensor['label'],
                    'tile_name' => $sensor['tile_name'],
                    'tileDegree' => $sensor['tileDegree'],
                    'phase' => $sensor['phase'],
                ];
            }
        }
        return self::json($DayLogs);
    }

    public static function Check()
    {
        return self::json(1);
    }

    private static function tr_num($str, $mod = 'en')
    {
        $num_a = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $key_a = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        return ($mod == 'fa') ? str_replace($num_a, $key_a, $str) : str_replace($key_a, $num_a, $str);
    }

    public static function getLogs($data = null)
    {
        return self::json("Busy Server");
        if ($data == null) {
            $data = $_GET;
        }

        $get = request::getFromArray($data, 'page=1,perEachPage=5000,groupId,StartTime,EndTime,tile_kind,phase,unitId,sortWith', null);
        $rules = [
            "page" => ["required|match:>0", rlang('page')],
            "perEachPage" => ["required|match:>=-1|match:<501", rlang('page')],
        ];
        $valid = validate::check($get, $rules);
        $value = array();
        $variable = array();
        $sortWith = ['column' => 'data.Start_time', 'type' => 'desc'];
        if ($valid->isFail()) {
            //TODO:: add error is not valid data
            $get['page'] = 1;
            $get['perEachPage'] = 5000;

        }
        if ($get['groupId'] != null) {
            $value[] = $get['groupId'];
            $variable[] = ' data.Sensor_id = ? ';
        }
        if ($get['tile_kind'] != null) {
            $value[] = $get['tile_kind'];
            $variable[] = ' data.Tile_Kind = ? ';
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

        if ($get['phase'] != null) {
            $value[] = $get['phase'];
            $variable[] = ' data.phase = ? ';
        }
        if ($get['unitId'] != null) {
            $value[] = $get['unitId'];
            $variable[] = ' data.unit = ? ';
        }
        if ($get['sortWith'] != null and is_array($get['sortWith'])) {
            unset($sortWith);
            foreach ($get['sortWith'] as $sort) {
                $temp = explode('|', $sort);
                $sortWith[] = ['column' => $temp[0], 'type' => $temp[1]];
            }
        }


        $model = parent::model(['LineMonitoring', 'data_archive']);
        if ($get['perEachPage'] != -1) {
            $numberOfAll = ($model->search((array)$value, (count($variable) == 0) ? null : implode(' and ', $variable), 'data_archive data', 'COUNT(data.Start_time) as co')) [0]['co'];
            $pagination = parent::pagination($numberOfAll, $get['page'], $get['perEachPage']);
        }
        model::join('sensors sensors', 'data.Sensor_id = sensors.id');
        model::join('tile_kind tile_kind', 'data.Tile_Kind = tile_kind.id');
        model::join('units units', 'data.unit = units.id');
        if ($get['perEachPage'] != -1) {
            $search = $model->search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), 'data_archive data', 'data.*, sensors.label,tile_kind.label,units.label as unitName', $sortWith, [$pagination['start'], $pagination['limit']]);
        } else {
            $search = $model->search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), 'data_archive data', 'data.*, sensors.label,tile_kind.label,units.label as unitName', $sortWith);
        }
        return self::json($search);
    }

    public static function getDayLogs($data = null)
    {
        if ($data == null) {
            $data = $_GET;
        }

        $get = request::getFromArray($data, 'page=1,perEachPage=200,groupId,StartTime,EndTime,tile_kind,phase,unitId,sortWith', null);
        $rules = [
            "page" => ["required|match:>0", rlang('page')],
            "perEachPage" => ["required|match:>=-1|match:<501", rlang('page')],
        ];
        $valid = validate::check($get, $rules);
        $value = array();
        $variable = array();
        $sortWith = ['column' => 'data.Start_time', 'type' => 'desc'];
        if ($valid->isFail()) {
            //TODO:: add error is not valid data
            $get['page'] = 1;
            $get['perEachPage'] = 200;

        }
        $table = 'data data';
        $EndTimeTemp = time();
        $StartTimeTemp = time();
        if ($get['groupId'] != null) {
            $value[] = $get['groupId'];
            $variable[] = ' data.Sensor_id = ? ';
        }
        if ($get['tile_kind'] != null) {
            $value[] = $get['tile_kind'];
            $variable[] = ' data.Tile_Kind = ? ';
        }
        if ($get['StartTime'] != null and $get['EndTime'] == null) {
            $value[] = date('Y-m-d H:i:s', $get['StartTime'] / 1000);
            $StartTimeTemp = $get['StartTime'] / 1000;
            $variable[] = ' data.Start_time > ? ';
        } elseif ($get['StartTime'] == null and $get['EndTime'] != null) {
            $value[] = date('Y-m-d H:i:s', $get['EndTime'] / 1000);
            $EndTimeTemp = $get['EndTime'] / 1000;
            $variable[] = ' data.Start_time < ? ';
        } elseif ($get['StartTime'] != null and $get['EndTime'] != null) {
            $EndTimeTemp = $get['EndTime'] / 1000;
            $StartTimeTemp = $get['StartTime'] / 1000;
            $value[] = date('Y-m-d H:i:s', $get['StartTime'] / 1000);
            $value[] = date('Y-m-d H:i:s', $get['EndTime'] / 1000);
            $variable[] = ' (data.Start_time BETWEEN ? AND ?) ';
        }
        if ($StartTimeTemp > $EndTimeTemp) {
            $a = $StartTimeTemp;
            $StartTimeTemp = $EndTimeTemp;
            $EndTimeTemp = $a;
        }
        if ($shifts = cache::get('shiftOfNowForGetDayLogsApi', null, 'LineMonitoring')) {
            if ($shifts['endTimeStamp'] < time()) {
                $_SERVER['JsonOff'] = true;
                $shiftData = self::shift()['result'];
                unset($_SERVER['JsonOff']);
                cache::save($shiftData, 'shiftOfNowForGetDayLogsApi', 20 * 60 * 60, 'LineMonitoring');
            }
        } else {
            $_SERVER['JsonOff'] = true;
            $shifts = self::shift()['result'];
            unset($_SERVER['JsonOff']);
            cache::save($shifts, 'shiftOfNowForGetDayLogsApi', 20 * 60 * 60, 'LineMonitoring');
        }
        if (!($shifts['endTimeStamp'] >= $EndTimeTemp and $shifts['startTimeStamp'] <= $StartTimeTemp)) {
            $table = 'data_archive data';
        }
        if ($get['phase'] != null) {
            $value[] = $get['phase'];
            $variable[] = ' data.phase = ? ';
        }
        if ($get['unitId'] != null) {
            $value[] = $get['unitId'];
            $variable[] = ' data.unit = ? ';
        }
        if ($get['sortWith'] != null and is_array($get['sortWith'])) {
            unset($sortWith);
            foreach ($get['sortWith'] as $sort) {
                $temp = explode('|', $sort);
                $sortWith[] = ['column' => $temp[0], 'type' => $temp[1]];
            }
        }


        $model = parent::model(['LineMonitoring', 'data']);
        if ($get['perEachPage'] != -1) {
            $numberOfAll = ($model->search((array)$value, (count($variable) == 0) ? null : implode(' and ', $variable), $table, 'COUNT(data.Start_time) as co')) [0]['co'];
            $pagination = parent::pagination($numberOfAll, $get['page'], $get['perEachPage']);
        }
        model::join('sensors sensors', 'data.Sensor_id = sensors.id');
        model::join('tile_kind tile_kind', 'data.Tile_Kind = tile_kind.id');
        model::join('units units', 'data.unit = units.id');
        if ($get['perEachPage'] != -1) {
            $search = $model->search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), $table, 'data.*, sensors.label,tile_kind.label,units.label as unitName', $sortWith, [$pagination['start'], $pagination['limit']]);
        } else {
            $search = $model->search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), $table, 'data.*, sensors.label,tile_kind.label,units.label as unitName', $sortWith);
        }
        return self::json($search);
    }

    public static function getOffLogs($data = null)
    {
        if ($data == null) {
            $data = $_GET;
        }

        $get = request::getFromArray($data, 'page=1,perEachPage=100,StartTime,EndTime,phase,unitId', null);
        $rules = [
            "page" => ["required|match:>0", rlang('page')],
            "perEachPage" => ["required|match:>=-1|match:<501", rlang('page')],
        ];
        $valid = validate::check($get, $rules);
        $value = array();
        $variable = array();
        $sortWith = ['column' => 'data.Start_time', 'type' => 'desc'];
        if ($valid->isFail()) {
            //TODO:: add error is not valid data
            $get['page'] = 1;
            $get['perEachPage'] = 100;

        }
        $table = 'sensor_active_log_archive data';
        $EndTimeTemp = time();
        $StartTimeTemp = time();

        if ($get['StartTime'] != null and $get['EndTime'] == null) {
            $value[] = date('Y-m-d H:i:s', $get['StartTime'] / 1000);
            $StartTimeTemp = $get['StartTime'] / 1000;
            $variable[] = ' data.Start_time > ? ';
        } elseif ($get['StartTime'] == null and $get['EndTime'] != null) {
            $value[] = date('Y-m-d H:i:s', $get['EndTime'] / 1000);
            $EndTimeTemp = $get['EndTime'] / 1000;
            $variable[] = ' data.Start_time < ? ';
        } elseif ($get['StartTime'] != null and $get['EndTime'] != null) {
            $EndTimeTemp = $get['EndTime'] / 1000;
            $StartTimeTemp = $get['StartTime'] / 1000;
            $value[] = date('Y-m-d H:i:s', $get['StartTime'] / 1000);
            $value[] = date('Y-m-d H:i:s', $get['EndTime'] / 1000);
            $variable[] = ' (data.Start_time BETWEEN ? AND ?) ';
        }
        if ($StartTimeTemp > $EndTimeTemp) {
            $a = $StartTimeTemp;
            $StartTimeTemp = $EndTimeTemp;
            $EndTimeTemp = $a;
        }

        if ($get['phase'] != null) {
            $value[] = $get['phase'];
            $variable[] = ' data.phase = ? ';
        }
        if ($get['unitId'] != null) {
            $value[] = $get['unitId'];
            $variable[] = ' data.unit = ? ';
        }


        $model = parent::model(['LineMonitoring', 'data']);
        if ($get['perEachPage'] != -1) {
            $numberOfAll = ($model->search((array)$value, (count($variable) == 0) ? null : implode(' and ', $variable), $table, 'COUNT(data.Start_time) as co')) [0]['co'];
            $pagination = parent::pagination($numberOfAll, $get['page'], $get['perEachPage']);
        }

        model::join('off_sensor_reasons offsensor', 'data.reason = offsensor.label');
        model::join('off_sensor_reasons Parent', 'offsensor.parentId = Parent.id');
        model::join('sensors sensors', 'data.Sensor_id = sensors.id');
        model::join('units units', 'data.unit = units.id');
        if ($get['perEachPage'] != -1) {
            $search = $model->search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), $table, 'data.*, sensors.label,units.label as unitName , Parent.label as SubReason', $sortWith, [$pagination['start'], $pagination['limit']]);
        } else {
            $search = $model->search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), $table, 'data.*, sensors.label,units.label as unitName , Parent.label as SubReason', $sortWith);
        }
        return self::json($search);
    }

    public static function adminDayCounter()
    {
        $variable = array();
        $unitId = array();
        $unitId[] = 13;
        $variable[] = ' arch1.unit IN( ' . implode(' , ', $unitId) . ' ) ';
        $showField = array();
        $showField[] = "data.phase";
        $showField[] = "data.counterAll";
        $showField[] = "data.m1";
        $showField[] = "data.m2";
        $showField[] = "data.m3";
        $showField[] = "data.m4";
        $showField[] = "data.m5";
        $showField[] = "data.p1";
        $showField[] = "data.p2";
        $showField[] = "data.p3";
        $showField[] = "data.p4";
        $showField[] = "data.p5";
        $showField[] = "concat(Floor(SUM(TIMESTAMPDIFF(MINUTE,arch1.Start_time,arch1.End_Time))/60 ), ' ساعت ' , MOD(SUM(TIMESTAMPDIFF(MINUTE,arch1.Start_time,arch1.End_Time)),60) , ' دقیقه') as OFFTime";

        if (isset($_SERVER['JsonOff']))
            $isSet = false;
        else
            $isSet = true;
        $_SERVER['JsonOff'] = true;
        $DayData = Day::index(1)['result'];
        $DayStart = $DayData['dayStart'];
        $DayEnd = $DayData['dayEnd'];
        $variable[] = ' (arch1.Start_time BETWEEN "' . $DayStart . '" AND "' . $DayEnd . '") ';
        $Data = (new export)->index(1, $variable, $showField);
        if ($isSet)
            unset($_SERVER['JsonOff']);


        /** @var phases_budget $modelBudgets */
        $modelBudgets = parent::model('phases_budget');
        $modelBudgets->setPhase_id(2);

        $Budgets = $modelBudgets->getBudgetWithTime(null, strtotime($DayStart));

        cache::save('yes', 'isDayUpdated', 2592000, 'LineMonitoring');

        return self::json([
            'Data' => $Data,
            'Time' => $DayStart,
            'Budget' => $Budgets,
        ]);
    }

    public static function isDayUpdated()
    {
        $data = cache::get('isDayUpdated', null, 'LineMonitoring');
        if ($data !== 'yes')
            return self::jsonError(null, 205);
        return self::jsonError(null, 204);
    }
}