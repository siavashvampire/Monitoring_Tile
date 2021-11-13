<?php

namespace App\LineMonitoring\app_provider\api;

use App\api\controller\innerController;
use App\LineMonitoring\model\data;
use App\LineMonitoring\model\data_merge;
use App\LineMonitoring\model\data_merge_Hour;
use App\LineMonitoring\model\data_temp;
use App\LineMonitoring\model\sensor_active_log;
use App\LineMonitoring\model\sensor_active_log_archive;
use App\LineMonitoring\model\sensor_active_log_merge;
use App\LineMonitoring\model\Switch_active_log;
use App\shiftWork\app_provider\api\totalDate;
use App\shiftWork\app_provider\api\shift;
use paymentCms\component\cache;
use paymentCms\component\JDate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class cronjob extends innerController
{
    public static function updateShift()
    {
        $_SERVER['JsonOff'] = true;
        $shiftData = shift::index();


        /** @var sensor_active_log_archive $SSlogArch */
        $SSlogArch = parent::model(['LineMonitoring', 'sensor_active_log_archive']);

        /** @var data $log */
        $log = parent::model(['LineMonitoring', 'data']);

        /** @var data_temp $logTemp */
        $logTemp = parent::model(['LineMonitoring', 'data_temp']);

        /** @var sensor_active_log $SSlogOff */
        $SSlogOff = parent::model(['LineMonitoring', 'sensor_active_log']);

        /** @var Switch_active_log $SWlogOff */
        $SWlogOff = parent::model(['LineMonitoring', 'Switch_active_log']);

        if ($shiftData['status'] and $shiftData['result']['shift_id'] != null) {
            $shiftId = $shiftData['result']['shift_id'];
            $shiftWorker = $shiftData['result']['taskmaster_id'];
            $shift_time_group = $shiftData['result']['shift_time_group'];
            $End_Time = $shiftData['result']['startTime'];
            $JEnd_Time = JDate::jdate('Y/n/j H:i:s', strtotime($End_Time));
            cache::save($shiftData['result'], 'lastShiftGet', 48 * 60 * 60, 'LineMonitoring');

            $SSlogArch->shiftDivisionCheck($End_Time, $JEnd_Time);

            if (cache::get('lastDataTableClear', null, 'LineMonitoring') != $shiftId . '_' . $shift_time_group) {

                $log->clear($shiftId, $shift_time_group);

                $logTemp->insertZero($shiftId, $shift_time_group, $shiftWorker, $End_Time);
                $logTemp->clear($shiftId, $shift_time_group);

                $SSlogArch->shiftDivision($End_Time, $JEnd_Time, $shiftId, $shift_time_group, $shiftWorker);

                $SSlogOff->clear($shiftId, $shift_time_group);

                $SWlogOff->clear($shiftId, $shift_time_group);

                cache::save($shiftId . '_' . $shift_time_group, 'lastDataTableClear', 48 * 60 * 60, 'LineMonitoring');
                cache::clear('isShiftUpdated', 'LineMonitoring');
            }
        }
        unset($_SERVER['JsonOff']);
        return self::json($shiftData);
    }

    public static function updateDay()
    {
        $_SERVER['JsonOff'] = true;
        $DayData = totalDate::Day();
        unset($_SERVER['JsonOff']);

        if ($DayData['status'] and $DayData['result']['dayStart'] != null and $DayData['result']['dayEnd'] != null) {
            $dayStart = $DayData['result']['dayStart'];
            $dayEnd = $DayData['result']['dayEnd'];
        }

        if (cache::get('lastDayGet', null, 'LineMonitoring') != $DayData['result']) {
            cache::save($DayData['result'], 'lastDayGet', 48 * 60 * 60, 'LineMonitoring');
            cache::clear('isDayUpdated', 'LineMonitoring');
        }

        return self::json($DayData);
    }

    public static function mergeData()
    {
        $_SERVER['JsonOff'] = true;
        $startTime = totalDate::Day(3)['result']['dayStart'];
        $endTime = totalDate::Day(0)['result']['dayEnd'];
        unset($_SERVER['JsonOff']);

        /** @var data_merge $data_merge */
        $data_merge = parent::model(['LineMonitoring', 'data_merge']);

        /** @var data_merge_Hour $data_merge_hour */
        $data_merge_hour = parent::model(['LineMonitoring', 'data_merge_Hour']);

        /** @var sensor_active_log_merge $sensor_active_log_merge */
        $sensor_active_log_merge = parent::model(['LineMonitoring', 'sensor_active_log_merge']);

        /** @var data $data */
        $data = parent::model(['LineMonitoring', 'data']);

        $data_merge->mergeDB($startTime, $endTime);
        $data_merge_hour->mergeDB($startTime, $endTime);
        $sensor_active_log_merge->mergeDB($startTime, $endTime);
        $data->mergeDB();

        return self::json('done.');
    }

    public static function mergeAllData()
    {
        /** @var data_merge $data_merge */
        $data_merge = parent::model(['LineMonitoring', 'data_merge']);

        /** @var data_merge_Hour $data_merge_hour */
        $data_merge_hour = parent::model(['LineMonitoring', 'data_merge_Hour']);

        /** @var sensor_active_log_merge $sensor_active_log_merge */
        $sensor_active_log_merge = parent::model(['LineMonitoring', 'sensor_active_log_merge']);

        /** @var data $data */
        $data = parent::model(['LineMonitoring', 'data']);

        for ($i = 0; $i <= 200; $i++) {
            $_SERVER['JsonOff'] = true;
            $startTime = totalDate::Day($i * 3 + 5)['result']['dayStart'];
            $endTime = totalDate::Day($i * 3)['result']['dayEnd'];
            unset($_SERVER['JsonOff']);

            $data_merge->mergeDB($startTime, $endTime);
            $data_merge_hour->mergeDB($startTime, $endTime);
            $sensor_active_log_merge->mergeDB($startTime, $endTime);
        }

        $data->mergeDB();
        return self::json('done.');
    }
}


