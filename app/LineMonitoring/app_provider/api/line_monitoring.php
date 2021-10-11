<?php
namespace App\LineMonitoring\app_provider\api;

use App\api\controller\innerController;
use App\LineMonitoring\model\sensor_active_log_archive;
use App\shiftWork\app_provider\api\shift;
use app\LineMonitoring\model\data;
use app\LineMonitoring\model\sensors;
use paymentCms\component\cache;
use paymentCms\component\JDate;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class line_monitoring extends innerController {
	public  static function newLog(){
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
		if ( $sensor->getId() != $data['Sensor_id'] ) {
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
		$log->setSensorId($sensor->getId());
		$log->setShiftId($shiftId);
		$log->setEmployersId($shiftWorker);
		$log->setShiftGroupId($shift_time_group);
		$log->setCounter($data['counter']);
		$log->setTileKind($data['Tile_Kind']);
		$log->setMotorSpeed($data['Motor_Speed']);
		$log->setPhase($sensor->getPhase());
		$log->setUnit($sensor->getUnit());
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
					'sensor_id' => $sensor->getId() ,
					'label' => $sensor->getLabel(),
					'tile_id' => $log->getTileKind(),
					'shift_id' => $log->getShiftId(),
					'counter' => $log->getCounter(),
					'absTime' => $log->getAbsTime(),
					'motorSpeed' => $log->getMotorSpeed(),
					'phase' => $sensor->getPhase(),
					'unitId' => $sensor->getUnit(),
					'tileDegree' => $sensor->getTileDegree(),
				]));$ws->send('disconnect');
				$ws->close();
			}
		}


		return [true];
	}


    public static function sensorActivity(){
        $data = request::post( 'Sensor_id,time,active,Tile_Kind');
        $rules =[
            'Sensor_id'	=> ['required', 'شماره یکتای سنسور'],
            'active'	=> ['required', 'وضعیت'],
            'Tile_Kind'	=> ['required', 'نوع کاشی'],
        ];
        $valid = validate::check($data, $rules);
        if ($valid->isFail()) {
            return self::jsonError($valid->errorsIn());
        }

        /* @var sensors $sensor */
        $sensor = parent::model(['LineMonitoring','sensors'] , [$data['Sensor_id'] ] , 'id = ? ');
        if ( $sensor->getId() != $data['Sensor_id'] ) {
            return self::jsonError('شماره یکتا سنسور یافت نشد!');
        }

        $Time = $data['time'];

        if ( $Time == null )
            $Time = date('Y-m-d H:i:s');
        $strTime = strtotime($Time);

        if ( $shifts = cache::get('lastShiftGet' , null ,'LineMonitoring') ){
            if ( ! ($strTime <= $shifts['endTimeStamp'] and $strTime >= $shifts['startTimeStamp'] ) ) {
                $_SERVER['JsonOff'] = true;
                $shifts =  shift::index($strTime)['result'];
                unset($_SERVER['JsonOff']);
            }

        } else {
            $_SERVER['JsonOff'] = true;
            $shifts =  shift::index($strTime)['result'];
            unset($_SERVER['JsonOff']);
        }

        $shiftId = $shifts['shift_id'];
        $shiftWorker = $shifts['taskmaster_id'];
        $shift_time_group = $shifts['shift_time_group'];

        /* @var sensor_active_log_archive $logArchive */
        if ( $data['active'] == 1 ){
            $logArchive = parent::model(['LineMonitoring','sensor_active_log_archive'] , [$sensor->getId() , ''] , ' Sensor_id = ? and ( End_Time is null or End_Time = ? ) ');
            if ( $logArchive->getSensor_id() == $sensor->getId() ){
                $logArchive->setEnd_Time( $Time );
                $logArchive->setJEnd_Time(JDate::jdate('Y/n/j H:i:s',$strTime ) );
                $logArchive->setEnd_Shift_id( $shiftId );
                $logArchive->setEnd_Shift_group_id( $shift_time_group );
                $logArchive->setEnd_employers_id( $shiftWorker );
                $logArchive->setEnd_Tile_Kind( $data['Tile_Kind'] );
                if ( $logArchive->upDateDataBase() ){
                    $sensor->setActive(1);
                    $sensor->upDateDataBase();

                    return self::json(null);
                }
                return self::jsonError(model::getLastQuery());
            } else {
                $sensor->setActive(1);
                $sensor->upDateDataBase();
                return self::json('Cant Find Deactive log!');
            }
        } else {
            $logArchive = parent::model(['LineMonitoring','sensor_active_log_archive'] , [$sensor->getId() , ''] , ' Sensor_id = ? and ( End_Time is null or End_Time = ? ) ');
            if ( $logArchive->getSensor_id() != $sensor->getId() ){
                $logArchive->setSensor_id( $sensor->getId() );
                $logArchive->setPhase( $sensor->getPhase() );
                $logArchive->setTileDegree( $sensor->getTileDegree() );
                $logArchive->setUnit( $sensor->getUnit() );
                $logArchive->setStart_time( $Time );
                $logArchive->setJStart_time( JDate::jdate('Y/n/j H:i:s',$strTime ));
                $logArchive->setEnd_Time( null );
                $logArchive->setJEnd_Time( null );
                $logArchive->setStart_shift_id( $shiftId );
                $logArchive->setStart_Shift_group_id( $shift_time_group );
                $logArchive->setStart_employers_id( $shiftWorker );
                $logArchive->setStart_Tile_Kind( $data['Tile_Kind'] );
                $logArchive->setEnd_Shift_id( null );
                $logArchive->setEnd_Shift_group_id( null );
                $logArchive->setEnd_employers_id( null );
                $logArchive->setEnd_Tile_Kind( null );
                $logArchive->setReason( null );
                $logArchive->setDescription( null );
                if ( $logArchive->insertToDataBase() ){
                    $sensor->setActive(0);
                    $sensor->upDateDataBase();

                    return self::json(null);
                }
                return self::jsonError(model::getLastQuery());
            } else {
                $sensor->setActive(0);
                $sensor->upDateDataBase();
                return self::json('duplicate request!');
            }
        }

    }

    public static function camSwitchActivity(){
        $data = request::post( 'id,time,active');
        $Switch = parent::model(['LineMonitoring','CamSwitch'] , [$data['id'] ] , 'id = ? ');
        if ( $Switch->getid() != $data['id'] ) {
            return self::jsonError('شماره یکتا کلید یافت نشد!');
        }

        $Time = $data['time'];

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
            $shifts =  shift::index($strTime)['result'];
            unset($_SERVER['JsonOff']);
        }

        $shiftId = $shifts['shift_id'];
        $shiftWorker = $shifts['taskmaster_id'];
        $shift_time_group = $shifts['shift_time_group'];

        if ( $data['active'] == 1 ){
            $logArchive = parent::model(['LineMonitoring','Switch_active_log_archive'] , [$Switch->getId() , ''] , ' id = ? and ( End_Time is null or End_Time = ? ) ');
            if ($logArchive->getId() == $Switch->getId() ){
                $logArchive->setEnd_Time( $data['time'] );
                $logArchive->setJEnd_Time(  JDate::jdate('Y/n/j H:i:s',strtotime($data['time']) ) );
                $logArchive->setEnd_Shift_id( $shiftId );
                $logArchive->setEnd_Shift_group_id( $shift_time_group );
                $logArchive->setEnd_employers_id( $shiftWorker );
                if ( $logArchive->upDateDataBase() ){
                    $Switch->setActive(1);
                    $Switch->upDateDataBase();

                    $log  = parent::model(['LineMonitoring','Switch_active_log']  );
                    $log->setFromArray($logArchive->returnAsArray());
                    $log->updateOneRow();

                    return self::json(null);
                }
                return self::jsonError(model::getLastQuery());
            } else {
                $Switch->setActive(1);
                $Switch->upDateDataBase();
                return self::json('Cant Find Deactive log!');
            }
        } else {

            $logArchive = parent::model(['LineMonitoring','Switch_active_log_archive'] , [$Switch->getId() , ''] , ' id = ? and ( End_Time is null or End_Time = ? ) ');
            if ( $logArchive->getId() != $Switch->getId() ){
                $logArchive->setId( $Switch->getId() );
                $logArchive->setPhase( $Switch->getPhase() );
                $logArchive->setUnit( $Switch->getUnit() );
                $logArchive->setStart_time( $data['time'] );
                $logArchive->setJStart_time( JDate::jdate('Y/n/j H:i:s',strtotime($data['time']) ));
                $logArchive->setEnd_Time( null );
                $logArchive->setJEnd_Time( null );
                $logArchive->setStart_shift_id( $shiftId );
                $logArchive->setStart_Shift_group_id( $shift_time_group );
                $logArchive->setStart_employers_id( $shiftWorker );
                $logArchive->setEnd_Shift_id( null );
                $logArchive->setEnd_Shift_group_id( null );
                $logArchive->setEnd_employers_id( null );
                $logArchive->setReason( null );
                $logArchive->setDescription( null );
                if ( $logArchive->insertToDataBase() ){
                    $Switch->setActive(0);
                    $Switch->upDateDataBase();

                    $log  = parent::model(['LineMonitoring','Switch_active_log']  );
                    $log->setFromArray($logArchive->returnAsArray());
                    $log->insertToDataBase();

                    return self::json(null);
                }
                return self::jsonError(model::getLastQuery());
            } else {
                $Switch->setActive(0);
                $Switch->upDateDataBase();
                return self::json('duplicate request!');
            }
        }

    }
}


