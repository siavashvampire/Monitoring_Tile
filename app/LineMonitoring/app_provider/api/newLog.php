<?php
namespace App\LineMonitoring\app_provider\api;

use App\api\controller\innerController;
use App\shiftWork\app_provider\api\shift;
use app\LineMonitoring\model\data;
use app\LineMonitoring\model\sensors;
use paymentCms\component\cache;
use paymentCms\component\JDate;
use paymentCms\component\model;
use paymentCms\component\request;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class newLog extends innerController {
	public  static function index(){
		$port = parent::setting('wsPort' , 'LineMonitoring' , true);
		$ipsInString = parent::setting('WsIP' , 'LineMonitoring', true);
		$ips = preg_split('/\r\n|[\r\n]/', $ipsInString) ;
		require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'web_socket'.DIRECTORY_SEPARATOR.'clientSocket.php';
        $DataArray = json_decode($_POST['DataArray']);
		if ( isset($DataArray) ){
			foreach ($DataArray  as $index => $_dataSTD ){
                $_data = [
                            "Sensor_id" => $_dataSTD->Sensor_id,
                            "AbsTime" => $_dataSTD->AbsTime,
                            "counter" => $_dataSTD->counter,
                            "Tile_Kind" => $_dataSTD->Tile_Kind,
                            "Motor_Speed" => $_dataSTD->Motor_Speed,
                            "start_time" => $_dataSTD->start_time,
                        ];
				$result = self::insertLog($_data , $ips , $port);
				if ( ! $result[0] ){
					return self::jsonError(['indexOfProblem' => $index , 'error' => $result[1]]);
				}
			}
		} else {
			$result = self::insertLog($_POST , $ips , $port);
			if ( ! $result[0] ){
				return self::jsonError(['indexOfProblem' => 0 , 'error' => $result[1]]);
			}
		}


		$data       = cache::get('isTileKindUpdate'   , null ,'LineMonitoring');
		$dataSwitch = cache::get('isSwitchKindUpdate' , null ,'LineMonitoring');
		if ( $data !== 'yes' or $dataSwitch !== 'yes' ) {
			return self::jsonError(null,205);
		}

		return self::jsonError(null,204);
	}
	private static function insertLog($_data , $ips , $port){
		$data = request::getFromArray( $_data,'Sensor_id,AbsTime,counter,Tile_Kind,Motor_Speed,start_time');
		/* @var sensors $sensor */
		$sensor = parent::model(['LineMonitoring','sensors'] , [$data['Sensor_id'] ] , 'Sensor_id = ? ');
		if ( $sensor->getSensorId() != $data['Sensor_id'] ) {
			return [false,'شماره یکتا سنسور یافت نشد!'];
		}

		$Time = $data['start_time'];

		if ( $Time == null )
			$Time = date('Y-m-d H:i:s');
        $strTime = strtotime($Time);

		if ( $shifts = cache::get('lastShiftGet' , null ,'LineMonitoring') ){
			if ( ! ($strTime <= $shifts['endTimeStamp'] and $strTime >= $shifts['startTimeStamp'] ) ) {
				$_SERVER['JsonOff'] = true;
                $shifts = shift::index($strTime)['result'];
                unset($_SERVER['JsonOff']);
			}

		} else {
			$_SERVER['JsonOff'] = true;
            $shifts = shift::index($strTime)['result'];
            unset($_SERVER['JsonOff']);
		}

        $shiftId = $shifts['shift_id'];
        $shiftWorker = $shifts['taskmaster_id'];
        $shift_time_group = $shifts['shift_time_group'];

		/* @var data $log */
		$log = parent::model(['LineMonitoring','data_temp'] );

		$log->setStartTime($Time);
		$log->setAbsTime($data['AbsTime']);
		$log->setSensorId($sensor->getSensorId());
		$log->setShiftId($shiftId);
		$log->setEmployersId($shiftWorker);
		$log->setShiftGroupId($shift_time_group);
		$log->setCounter($data['counter']);
		$log->setTileKind($data['Tile_Kind']);
		$log->setMotorSpeed($data['Motor_Speed']);
		$log->setPhase($sensor->getPhase());
		$log->setUnit($sensor->getUnitId());
		$log->setTileDegree($sensor->getTileDegree());
		$log->setJStartTime(JDate::jdate('Y/n/j',$strTime));
		if ( ! $log->insertToDataBase() ) {
			return [false,model::getLastQuery()];
		}


		for ( $i =  0 ; $i < count($ips) ; $i++ ) {
			$ip = trim($ips[$i]);
			$ip = str_replace(['https://' , 'http://' , '/','https:','http:'] , '' , $ip );
			if ( $ip != '' and $port != '' ){
				$ws = new clientSocket(array('host' => $ip,'port' => $port,'path' => ''));
				$ws->send(json_encode([
					'sensor_id' => $sensor->getSensorId() ,
					'label' => $sensor->getLabel(),
					'tile_id' => $log->getTileKind(),
					'shift_id' => $log->getShiftId(),
					'counter' => $log->getCounter(),
					'absTime' => $log->getAbsTime(),
					'motorSpeed' => $log->getMotorSpeed(),
					'phase' => $sensor->getPhase(),
					'unitId' => $sensor->getUnitId(),
					'tileDegree' => $sensor->getTileDegree(),
				]));$ws->send('disconnect');
				$ws->close();
			}
		}


		return [true];
	}
}


