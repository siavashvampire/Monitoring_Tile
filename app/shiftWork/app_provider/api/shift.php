<?php
namespace App\shiftWork\app_provider\api;

use App\api\controller\innerController;
use paymentCms\component\JDate;
use paymentCms\component\model;


if ( !defined( 'paymentCMS' ) ) die( '<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>' );

class shift extends innerController {
	public  static function index ($date = null ){
		if ( $date == null )  $date = time() ;
		$day = JDate::jdate('l' , $date);
		$dayNum = JDate::jdate('w' , $date);
		$timeSTR = date("H:i:30" , $date);

		$shift = parent::model(['shiftWork', 'shift_time']);
		model::join('shift_time shift_time2', 'shift_time.shift_id = shift_time2.shift_id and shift_time.shift_time_group = shift_time2.shift_time_group ' , 'right');
		model::join('shift_work shift_work', 'shift_time.shift_id = shift_work.shift_id');
		$shifts = $shift->search([$day, $timeSTR , -1], ' (shift_time.onDay = ? and ? BETWEEN  shift_time.startTime and shift_time.endTime) AND shift_time.shift_id <> ?', 'shift_time shift_time', 'shift_work.taskmaster_id,shift_time.shift_id,shift_time.shift_time_group , shift_time2.startTime , shift_time2.endTime , shift_time2.onDay as day , CASE WHEN shift_time2.onDay = "شنبه" then 0 WHEN shift_time2.onDay = "یک شنبه" then 1 WHEN shift_time2.onDay = "دو شنبه" then 2 WHEN shift_time2.onDay = "سه شنبه" then 3 WHEN shift_time2.onDay = "چهار شنبه" then 4 WHEN shift_time2.onDay = "پنج شنبه" then 5 ELSE 6 END AS daynum');
		if ( $shifts !== true and count($shifts) > 0 ){
			usort($shifts, function($a, $b) {
				if ( $a['daynum'] - $b['daynum']  == 6 ){
					return  -6 ;
				} elseif ( $a['daynum'] - $b['daynum'] == -6 ){
					return  6 ;
				} else
					return $a['daynum'] - $b['daynum'];
			});
			foreach ( $shifts as $index => $shift){
				if ( $shift['daynum'] == $dayNum ){
					$startDateTime = date('Y-m-d '.$shifts[0]['startTime'] ,  $date -24*60*60 * $index ) ;
					$endDateTime = date('Y-m-d '.$shifts[ count($shifts) -1 ]['endTime'] ,  $date+24*60*60 * ( count($shifts) - $index -1 )  ) ;
					break;
				}
			}
		}


		return self::json([
			'taskmaster_id' => $shifts[0]['taskmaster_id'],
			'shift_id' => $shifts[0]['shift_id'],
			'shift_time_group' => $shifts[0]['shift_time_group'],
			'startTime' => $startDateTime,
			'endTime' => $endDateTime,
			'startTimeStamp' => strtotime($startDateTime),
			'endTimeStamp' => strtotime($endDateTime),
			'startTimeStampX1000' => strtotime($startDateTime) * 1000 ,
			'endTimeStampX1000' => strtotime($endDateTime)* 1000,
		]);
	}
}