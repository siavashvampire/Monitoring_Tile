<?php
namespace App\LineMonitoring\app_provider\api;

use App\api\controller\innerController;
use App\shiftWork\app_provider\api\Day;
use App\shiftWork\app_provider\api\shift;
use paymentCms\component\cache;
use paymentCms\component\JDate;
if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class cronjob extends innerController {
	public static function updateShift(){
		$_SERVER['JsonOff'] = true;
        $shiftData = shift::index();
		unset($_SERVER['JsonOff']);
        
		if ($shiftData['status'] and $shiftData['result']['shift_id'] != null ){
			$shiftId = $shiftData['result']['shift_id'];
			$shiftWorker = $shiftData['result']['taskmaster_id'];
			$shift_time_group = $shiftData['result']['shift_time_group'];
			$End_Time = $shiftData['result']['startTime'];
			$JEnd_Time = JDate::jdate('Y/n/j H:i:s',strtotime($End_Time));
			cache::save( $shiftData['result'] , 'lastShiftGet' , 48*60*60 , 'LineMonitoring');
        
            $SSlogArch = parent::model(['LineMonitoring','sensor_active_log_archive'] );
            $SSlogArch->shiftDivisionCheck($End_Time,$JEnd_Time);

            if ( cache::get('lastDataTableClear' , null ,'LineMonitoring') != $shiftId.'_'.$shift_time_group){
                $log = parent::model(['LineMonitoring','data'] );
                $log->clear($shiftId,$shift_time_group);
                $logTemp = parent::model(['LineMonitoring','data_temp'] );
                $logTemp->insertZero($shiftId,$shift_time_group,$shiftWorker,$End_Time);
                $logTemp->clear($shiftId,$shift_time_group);
                $SSlogArch = parent::model(['LineMonitoring','sensor_active_log_archive'] );
                $SSlogArch->shiftDivision($End_Time,$JEnd_Time,$shiftId,$shift_time_group,$shiftWorker);
                $SSlogOff = parent::model(['LineMonitoring','sensor_active_log'] );
                $SSlogOff->clear($shiftId,$shift_time_group);
                $SWlogOff = parent::model(['LineMonitoring','Switch_active_log'] );
                $SWlogOff->clear($shiftId,$shift_time_group);
                cache::save($shiftId.'_'.$shift_time_group , 'lastDataTableClear' , 48*60*60 , 'LineMonitoring');
                cache::clear('isShiftUpdated' , 'LineMonitoring');
            }
        }
		return self::json( $shiftData );
	}
    public static function updateDay(){
        $_SERVER['JsonOff'] = true;
        $DayData = Day::index();
		unset($_SERVER['JsonOff']);
        
		if ($DayData['status'] and $DayData['result']['dayStart'] != null  and $DayData['result']['dayEnd'] != null ){
			$dayStart = $DayData['result']['dayStart'];
			$dayEnd   = $DayData['result']['dayEnd'];
		}
		if ( cache::get('lastDayGet' , null ,'LineMonitoring') != $DayData['result'] ){
            cache::save( $DayData['result'] , 'lastDayGet' , 48*60*60 , 'LineMonitoring');
			cache::clear('isDayUpdated' , 'LineMonitoring');
		}

		return self::json( $DayData );
	}
	public static function mergeData(){
        $_SERVER['JsonOff'] = true;
        $startTime = Day::index(3)['result']['dayStart'];
        $endTime = Day::index(0)['result']['dayEnd'];
        unset($_SERVER['JsonOff']);
        
		parent::model(['LineMonitoring','data_merge'])           ->mergeDB($startTime , $endTime );
        parent::model(['LineMonitoring','data_merge_Hour'])      ->mergeDB($startTime , $endTime );
		parent::model(['LineMonitoring','sensoractivelogMerge']) ->mergeDB($startTime , $endTime );
        parent::model(['LineMonitoring','data'])->mergeDB();
		return self::json('done.');
	}
    public static function mergeAllData(){
        for ($i = 0; $i <= 200; $i++) {
            $_SERVER['JsonOff'] = true;
            $startTime = Day::index($i*3+ 5)['result']['dayStart'];
            $endTime = Day::index($i*3)['result']['dayEnd'];
            unset($_SERVER['JsonOff']);

            parent::model(['LineMonitoring','data_merge'])           ->mergeDB($startTime , $endTime );
            parent::model(['LineMonitoring','data_merge_Hour'])      ->mergeDB($startTime , $endTime );
            parent::model(['LineMonitoring','sensoractivelogMerge']) ->mergeDB($startTime , $endTime );
        }
        parent::model(['LineMonitoring','data'])->mergeDB();
		return self::json('done.');
	}
}


