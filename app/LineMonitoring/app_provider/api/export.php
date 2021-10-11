<?php


namespace App\LineMonitoring\app_provider\api;


use App\api\controller\innerController;
use App\shiftWork\app_provider\api\shift;
use App\LineMonitoring\model\data_merge;
use paymentCms\component\JDate;
use paymentCms\component\model;
use paymentCms\component\mold\Mold;
use paymentCms\component\request;
use paymentCms\component\validate;

/**
 * Created by Yeganehha .
 * User: Erfan Ebrahimi (http://ErfanEbrahimi.ir)
 * Date: 3/24/2019
 * Time: 10:15 AM
 * project : paymentCMS
 * virsion : 0.0.0.1
 * update Time : 3/24/2019 - 10:15 AM
 * Discription of this Page :
 */


if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');


class export extends innerController {
	public function  index($Data=0,$variableIN=NULL,$showField=NULL) {
		$get = request::post('unitId,phase,StartTime,EndTime,tile_kind,showField,shifts,getPDF=1' ,null);
        if ($variableIN == null){
        $_SERVER['JsonOff'] = true;
        $shiftData =  shift::index();
        unset($_SERVER['JsonOff']);
        $shiftStart = $shiftData["result"]["startTime"];
        $shiftEnd = $shiftData["result"]["endTime"];
		$variable = array( );
        }
        else{
            $variable=$variableIN;
        }
        if ($showField != null)
            $get['showField'] = $showField;

		/* @var data_merge $model */
		$model = parent::model('data_merge');
		if (is_array($get['showField']) and count($get['showField']) > 0 ) {
			if (is_array($get['phase'] ) and count($get['phase'] ) > 0 ) {
				$variable[] = ' arch1.phase IN( '. implode(' , ' , $get['phase']) .' ) ';
			}
			if (is_array($get['unitId'] ) and count($get['unitId'] ) > 0 ) {
				$variable[] = ' arch1.unitId IN( '. implode(' , ' , $get['unitId']) .' ) ';
			}
			if (is_array($get['tile_kind'] ) and count($get['tile_kind'] ) > 0 ) {
				$variable[] = ' arch1.Tile_Kind IN( ' . implode(' , ', $get['tile_kind']) . ' ) ';
			}
			if (is_array($get['shifts'] ) and count($get['shifts'] ) > 0 ) {
				$variable[] = ' arch1.Shift_id IN( '. implode(' , ' , $get['shifts']) .' ) ';
			}
			if ($get['StartTime'] != null and $get['EndTime'] == null) {
				$variable[] = ' arch1.Start_time > "'.date('Y-m-d H:i:s', $get['StartTime'] / 1000).'"' ;
			} elseif ($get['StartTime'] == null and $get['EndTime'] != null) {
				$variable[] = ' arch1.Start_time < "'.date('Y-m-d H:i:s', $get['EndTime'] / 1000).'"';
			} elseif ($get['StartTime'] != null and $get['EndTime'] != null) {
				$variable[] = ' (arch1.Start_time BETWEEN "'. date('Y-m-d H:i:s', $get['StartTime'] / 1000).'" AND "'.date('Y-m-d H:i:s', $get['EndTime'] / 1000).'") ';
			} elseif ($get['StartTime'] == null and $get['EndTime'] == null and $variableIN==NULL) {            
				$variable[] = ' (arch1.Start_time BETWEEN "'. $shiftStart .'" AND "'.$shiftEnd.'") ';
			}
			$header = [];
			$joinWith = false;
			for ( $i = 0 ;$i < count($get['showField']) ; $i++ ){
				if ( $get['showField'][$i] == "data.phase" )
					$header[] = 'فاز';
				elseif ( $get['showField'][$i] == "data.unit" )
                    {$header[] = 'واحد';
                    $get['showField'][$i] = "data.unitName";
                }
				elseif ( $get['showField'][$i] == "CONCAT(data.tile_width, '×', data.tile_length)" )
					$header[] = 'سایز تولیدی';
				elseif ( $get['showField'][$i] == "data.label" )
					$header[] = 'عنوان کاشی';
				elseif ( $get['showField'][$i] == "data.counterAll" )
					$header[] = 'تولید کل';
				elseif ( $get['showField'][$i] == "data.m1" )
					$header[] = 'متراژ 1';
				elseif ( $get['showField'][$i] == "data.m2" )
					$header[] = 'متراژ 2';
				elseif ( $get['showField'][$i] == "data.m3" )
					$header[] = 'متراژ 3';
				elseif ( $get['showField'][$i] == "data.m4" )
					$header[] = 'متراژ U';
				elseif ( $get['showField'][$i] == "data.m5" )
					$header[] = 'متراژ W';
				elseif ( $get['showField'][$i] == "data.p1" )
					$header[] = 'درصد 1';
				elseif ( $get['showField'][$i] == "data.p2" )
					$header[] = 'درصد 2';
				elseif ( $get['showField'][$i] == "data.p3" )
					$header[] = 'درصد 3';
				elseif ( $get['showField'][$i] == "data.p4" )
					$header[] = 'درصد U';
				elseif ( $get['showField'][$i] == "data.p5" )
					$header[] = 'درصد W';
				elseif ( $get['showField'][$i] == "arch1.reason" ) {
					$header[] = 'عنوان توقف';
					$joinWith = true ;
                }elseif ( $get['showField'][$i] == "arch1.description" ) {
					$header[] = 'توضیحات توقف';
					$joinWith = true ;
				} elseif ( $get['showField'][$i] == "arch1.JStart_time" ) {
					$header[] = 'زمان شروع توقف';
					$joinWith = true ;
				} elseif ( $get['showField'][$i] == "TIMESTAMPDIFF(MINUTE,arch1.Start_time,arch1.End_Time)" ) {
					$header[] = 'مدت زمان توقف(دقیقه)';
					$joinWith = true ;
				}elseif ( $get['showField'][$i] == "concat(Floor(SUM(TIMESTAMPDIFF(MINUTE,arch1.Start_time,arch1.End_Time))/60 ), ' ساعت ' , MOD(SUM(TIMESTAMPDIFF(MINUTE,arch1.Start_time,arch1.End_Time)),60) , ' دقیقه') as OFFTime" ) {
					$header[] = 'کل توقفات';
					$joinWith = true ;
				}
			}
			$search = data_merge::creatExportTable(((count($variable) == 0) ?  ' 1 '  : implode(' and ', $variable)));
			if ($joinWith and $variableIN==NULL){
                if ($get['StartTime'] != null and $get['EndTime'] == null ) {
				model::join('sensor_active_log_archive arch1', 'data.phase = arch1.phase and arch1.unitId = data.unit and data.Tile_Kind = arch1.Start_Tile_Kind and arch1.Start_time > "'.date('Y-m-d H:i:s', $get['StartTime'] / 1000).'" and arch1.End_Time > arch1.Start_time  ' );
                } elseif ($get['StartTime'] == null and $get['EndTime'] != null) {
                    model::join('sensor_active_log_archive arch1', 'data.phase = arch1.phase and arch1.unitId = data.unit and arch1.Start_time < "'.date('Y-m-d H:i:s', $get['EndTime'] / 1000).'" and arch1.End_Time > arch1.Start_time ' );
                } elseif ($get['StartTime'] != null and $get['EndTime'] != null) {
                    model::join('sensor_active_log_archive arch1', 'data.phase = arch1.phase and arch1.unitId = data.unit and data.Tile_Kind = arch1.Start_Tile_Kind and (arch1.Start_time BETWEEN "'. date('Y-m-d H:i:s', $get['StartTime'] / 1000).'" AND "'.date('Y-m-d H:i:s', $get['EndTime'] / 1000).'") and arch1.End_Time > arch1.Start_time ' );
                } elseif ($get['StartTime'] == null and $get['EndTime'] == null) {
                    model::join('sensor_active_log_archive arch1', 'data.phase = arch1.phase and arch1.unitId = data.unit and data.Tile_Kind = arch1.Start_Tile_Kind and (arch1.Start_time BETWEEN "'. $shiftStart .'" AND "'.$shiftEnd.'") and arch1.End_Time > arch1.Start_time ' );
                }
                model::join('off_sensor_reasons offsensor', 'arch1.reason = offsensor.label');
                model::join('off_sensor_reasons Parent'   , 'offsensor.parentId = Parent.id');
            }
            else{
                model::join('sensor_active_log_archive arch1', 'data.phase = arch1.phase and arch1.unitId = data.unit and data.Tile_Kind = arch1.Start_Tile_Kind and ' . implode(' and ', $variable) . ' and arch1.End_Time > arch1.Start_time ' );
            }
			$search = $model->search([1] , '?'  , $search .' data' , implode(' , ' , $get['showField']) ) ;
            if ($Data == 1)
                return $search;
			if ( is_array($search) and count($search) > 0 ) {
				$GLOBALS['timeStart'] = '';
				if ($get['getPDF']) {
					$mold = new  Mold();
					$mold->path('default', 'LineMonitoring');
					$mold->view('exportPdf.mold.html');
					$mold->set('headersTable' , $header);
					$mold->set('datasTable' , $search);
					$htmlpersian = $mold->render();
					$this->callHooks('makePDF',['htmlpersian'=>$htmlpersian,'nameOfFile'=>date('Y-M-d H-i') , 'landscape' => true]);
				} else{
					header('Content-Encoding: UTF-8');
					header('Content-type: text/csv; charset=UTF-8');
					header("Content-Disposition: attachment; filename=" . 'Export Log (' . date('Y-M-d H-i') . ').csv');
					header("Pragma: no-cache");
					header("Expires: 0");
					header('Content-Transfer-Encoding: binary');
					echo "\xEF\xBB\xBF";
					$fp = fopen('php://output', 'w');
					fputcsv($fp, $header);
					for ($i = 0; $i < count($search); $i++) {
						fputcsv($fp, $search[$i]);
					}
					fclose($fp);
					return true;
				}
			}else{
				return self::jsonError('نتیجه ای یافت نشد !');
			}
		} else {
			return self::jsonError('مقادیر ارسالی معتبر نمی باشد!');
		}
	}
}