<?php
namespace App\LineMonitoring\app_provider\api;

use App\api\controller\innerController;
use App\shiftWork\app_provider\api\shift;
use app\LineMonitoring\model\data;
use paymentCms\component\cache;
use paymentCms\component\JDate;
use paymentCms\component\model;


if ( !defined( 'paymentCMS' ) ) die( '<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>' );

class diagram extends innerController {
    /**
    * @return array
    *              [global-access]
    */
    public static function index($diagramID , $sensor) {
	    $sensors = explode('-',$sensor);
		if ( is_array($sensors) ){
			$value = $sensors ;
			$value2 = $sensors ;
			$variable[] = ' data.Sensor_id IN ( '. substr(str_repeat('? ,', count($sensors)), 0, -1) .')  ';
			$variable2[]= ' id IN ( '. substr(str_repeat('? ,', count($sensors)), 0, -1) .')  ';
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
            $shifts = shift::index()['result'];
            unset($_SERVER['JsonOff']);
		}
        
        $value[] = $shifts['shift_id'] ;
        $value[] = $shifts['shift_time_group'] ; 
        $value[] = -1 ;
		$variable[] = ' ((data.Shift_id = ? and data.Shift_group_id = ? ) or (data.Shift_id = ?))';

	    /* @var data $model */
	    $model = parent::model('data');

	    model::join('sensors sensors','data.Sensor_id = sensors.id');
	    $search = $model->search( (array) $value  , ( ( count($variable) == 0 ) ? null : implode(' and ' , $variable) )  , 'data data', 'SUM(data.counter) as counter,sensors.Active , data.Sensor_id as id'  , null , null , 'data.Sensor_id' );
        $Sensors = $model->search( (array) $value2  ,  ( ( count($variable2) == 0 ) ? null : implode(' and ' , $variable2) )  , 'sensors', '*'  , ['column' => 'showSort' , 'type' =>'asc'] );
		$sensorHasCount = (array) array_column($search, 'id');
		if ( $search === true ) {
			$search = array();
		}
		foreach ( $Sensors as $sensor ){
			if ( ! in_array($sensor['id'] , $sensorHasCount ) ) {
					$search[] = [
						'counter' => 0 ,
						'Active' => $sensor['Active'] ,
						'id' => $sensor['id'] ,
					];
			}
		}
	    return self::json(['data' => $search , 'jtime' => JDate::jdate("l - H:i:s") ] );

    }
}