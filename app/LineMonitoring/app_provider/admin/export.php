<?php
namespace App\LineMonitoring\app_provider\admin;

use App\LineMonitoring\app_provider\api\phases;
use App\LineMonitoring\app_provider\api\tiles;
use App\requestService\model\requestService;
use App\shiftWork\app_provider\api\totalDate;
use App\shiftWork\app_provider\api\shift;
use App\LineMonitoring\model\data_archive;
use App\LineMonitoring\model\data_merge;
use App\units\app_provider\api\units;
use controller;
use paymentCms\component\JDate;
use paymentCms\component\model;
use paymentCms\component\request;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class export extends controller {
	public function  index() {
		$get = request::post('unitId,phase,StartTime,EndTime,tile_kind,showField,shifts,getPDF=1');
        $_SERVER['JsonOff'] = true;
        $shiftData = shift::index();
        unset($_SERVER['JsonOff']);
        $shiftStart = $shiftData["result"]["startTime"];
        $shiftEnd = $shiftData["result"]["endTime"];
		$variable = array( );
		/* @var data_archive $model */
		$model = parent::model('data_archive');
		if (request::isPost() and is_array($get['showField']) and count($get['showField']) > 0 ) {
			if (is_array($get['phase'] ) and count($get['phase'] ) > 0 ) {
				$variable[] = ' arch1.phase IN( '. implode(' , ' , $get['phase']) .' ) ';
			}
			if (is_array($get['unitId'] ) and count($get['unitId'] ) > 0 ) {
				$variable[] = ' arch1.unit IN( '. implode(' , ' , $get['unitId']) .' ) ';
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
			} elseif ($get['StartTime'] == null and $get['EndTime'] == null) {
				$variable[] = ' (arch1.Start_time BETWEEN "'. $shiftStart .'" AND "'.$shiftEnd.'") ';
			}
			$header = [];
			$joinWith = false;
			for ( $i = 0 ;$i < count($get['showField']) ; $i++ ){
				if ( $get['showField'][$i] == "data.phase" )
					$header[] = 'فاز';
				elseif ( $get['showField'][$i] == "data.unit" )
                    {$header[] = 'واحد';
                    $get['showField'][$i] = "data.unitLabel";
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
				elseif ( $get['showField'][$i] == "Parent.label" ) {
					$header[] = 'سرفصل توقف';
					$joinWith = true ;
				}	
                elseif ( $get['showField'][$i] == "arch1.reason" ) {
					$header[] = 'عنوان توقف';
					$joinWith = true ;
				}
                elseif ( $get['showField'][$i] == "arch1.description" ) {
					$header[] = 'توضیحات توقف';
					$joinWith = true ;
				} elseif ( $get['showField'][$i] == "arch1.JStart_time" ) {
					$header[] = 'زمان شروع توقف';
					$joinWith = true ;
				} elseif ( $get['showField'][$i] == "TIMESTAMPDIFF(MINUTE,arch1.Start_time,arch1.End_Time)" ) {
					$header[] = 'مدت زمان توقف(دقیقه)';
					$joinWith = true ;
				}
			}
			$search = data_archive::creatExportTable(((count($variable) == 0) ?  ' 1 '  : implode(' and ', $variable)));
            if ($joinWith){
                if ($get['StartTime'] != null and $get['EndTime'] == null ) {
				model::join('sensor_active_log_archive arch1', 'data.phase = arch1.phase and arch1.unit = data.unit and data.Tile_Kind = arch1.Start_Tile_Kind and arch1.Start_time > "'.date('Y-m-d H:i:s', $get['StartTime'] / 1000).'" and arch1.End_Time > arch1.Start_time  ' );
                } elseif ($get['StartTime'] == null and $get['EndTime'] != null) {
                    model::join('sensor_active_log_archive arch1', 'data.phase = arch1.phase and arch1.unit = data.unit and arch1.Start_time < "'.date('Y-m-d H:i:s', $get['EndTime'] / 1000).'" and arch1.End_Time > arch1.Start_time ' );
                } elseif ($get['StartTime'] != null and $get['EndTime'] != null) {
                    model::join('sensor_active_log_archive arch1', 'data.phase = arch1.phase and arch1.unit = data.unit and data.Tile_Kind = arch1.Start_Tile_Kind and (arch1.Start_time BETWEEN "'. date('Y-m-d H:i:s', $get['StartTime'] / 1000).'" AND "'.date('Y-m-d H:i:s', $get['EndTime'] / 1000).'") and arch1.End_Time > arch1.Start_time ' );
                } elseif ($get['StartTime'] == null and $get['EndTime'] == null) {
                    model::join('sensor_active_log_archive arch1', 'data.phase = arch1.phase and arch1.unit = data.unit and data.Tile_Kind = arch1.Start_Tile_Kind and (arch1.Start_time BETWEEN "'. $shiftStart .'" AND "'.$shiftEnd.'") and arch1.End_Time > arch1.Start_time ' );
                }
                model::join('off_sensor_reasons offsensor', 'arch1.reason = offsensor.label');
                model::join('off_sensor_reasons Parent'   , 'offsensor.parentId = Parent.id');
            }

			$search = $model->search([1] , '?'  , $search .' data' , implode(' , ' , $get['showField']) ) ;
			if ( is_array($search) and count($search) > 0 ) {
				$this->mold->offAutoCompile();
				$GLOBALS['timeStart'] = '';
				if ($get['getPDF']) {
					$this->mold->path('default', 'LineMonitoring');
					$views = $this->mold->getViews();
					$this->mold->unshow($views);
					$this->mold->view('exportPdf.mold.html');
					$this->mold->set('headersTable' , $header);
					$this->mold->set('datasTable' , $search);
					$this->mold->unshow('footer.mold.html');
					$htmlpersian = $this->mold->render();
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
				$this->alert('danger','','نتیجه ای یافت نشد !');
			}
		}

		$this->mold->path('default', 'LineMonitoring');
		$this->mold->view('export2.mold.html');
		$this->mold->setPageTitle('گزارش گیری');
		$this->mold->set('activeMenu' , 'exportExcel2');

        $this->mold->set('units', units::index()["result"]);
        $this->mold->set('phases', phases::index()["result"]);

		$this->mold->set('tiles'  , tiles::index()["result"]);
		$this->mold->set('shifts' , shift::index()["result"]);

	}
    public function  Merge() {
		$get = request::post('unitId,phase,StartTime,EndTime,tile_kind,showField,shifts,getPDF=1,Shift,Day' ,null);
        
        $_SERVER['JsonOff'] = true;
        if ($get['StartTime'] != null){
            $shamsi = explode('/', $get['StartTime']);

            $DayData = totalDate::Day(0,strtotime(JDate::jalali_to_gregorian($shamsi[0] , $shamsi[1] , $shamsi[2] , '-'))+43200);
            $get['StartTime'] = $DayData["result"]["dayStart"];
        }
        if ($get['EndTime'] != null){
            $shamsi = explode('/', $get['EndTime']);
            $DayData = totalDate::Day(0,strtotime(JDate::jalali_to_gregorian($shamsi[0] , $shamsi[1] , $shamsi[2] , '-'))+43200);
            $get['EndTime']   = $DayData["result"]["dayEnd"];
        }
        
        
        if ($get['Shift'] != null){
            $shiftData = shift::index(time() - $get['Shift']*43200);
            
            $get['StartTime'] = $shiftData["result"]["startTime"];
            $get['EndTime']   = $shiftData["result"]["endTime"];
        } 
        if ($get['Day'] != null){
            
            $DayData = totalDate::Day($get['Day']);
  
            $get['StartTime'] = $DayData["result"]["dayStart"];
            $get['EndTime']   = $DayData["result"]["dayEnd"];
        }
        unset($_SERVER['JsonOff']);
        
        $variableble = array( );
		/* @var data_merge $model */
		$model = parent::model('data_merge');
		if (request::isPost() and is_array($get['showField']) and count($get['showField']) > 0 ) {
			if (is_array($get['phase'] ) and count($get['phase'] ) > 0 ) {
				$variable[] = ' arch1.phase IN( '. implode(' , ' , $get['phase']) .' ) ';
			}
			if (is_array($get['unitId'] ) and count($get['unitId'] ) > 0 ) {
				$variable[] = ' arch1.unit IN( '. implode(' , ' , $get['unitId']) .' ) ';
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
			}
			$header = [];
			$joinWith = false;
			for ( $i = 0 ;$i < count($get['showField']) ; $i++ ){
				if ( $get['showField'][$i] == "data.phase" )
					$header[] = 'فاز';
				elseif ( $get['showField'][$i] == "data.unit" )
                    {$header[] = 'واحد';
                    $get['showField'][$i] = "data.unitLabel";
                }
                elseif ( $get['showField'][$i] == "sensors.label" )
                    $header[] = 'نام سنسور';
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
				elseif ( $get['showField'][$i] == "reasonType.Title" ) {
					$header[] = 'نوع توقف';
					$joinWith = true ;
				}
                elseif ( $get['showField'][$i] == "Parent.label" ) {
					$header[] = 'سرفصل توقف';
					$joinWith = true ;
				}	
                elseif ( $get['showField'][$i] == "arch1.reason" ) {
					$header[] = 'عنوان توقف';
					$joinWith = true ;
				}
                elseif ( $get['showField'][$i] == "arch1.description" ) {
					$header[] = 'توضیحات توقف';
					$joinWith = true ;
				} elseif ( $get['showField'][$i] == "arch1.JStart_time" ) {
					$header[] = 'زمان شروع توقف';
					$joinWith = true ;
				} elseif ( $get['showField'][$i] == "TIMESTAMPDIFF(MINUTE,arch1.Start_time,arch1.End_Time)" ) {
					$header[] = 'مدت زمان توقف(دقیقه)';
					$joinWith = true ;
				}
			}
			$search = data_merge::creatExportTable(((count($variable) == 0) ?  ' 1 '  : implode(' and ', $variable)));
            if ($joinWith){
                if ($get['StartTime'] != null and $get['EndTime'] == null ) {
				model::join('sensor_active_log_archive arch1', 'data.phase = arch1.phase and arch1.unit = data.unit and data.Tile_Kind = arch1.Start_Tile_Kind and arch1.Start_time > "'. $get['StartTime'].'" and arch1.End_Time > arch1.Start_time  ' );
                } elseif ($get['StartTime'] == null and $get['EndTime'] != null) {
                    model::join('sensor_active_log_archive arch1', 'data.phase = arch1.phase and arch1.unit = data.unit and arch1.Start_time < "'.$get['EndTime'].'" and arch1.End_Time > arch1.Start_time ' );
                } elseif ($get['StartTime'] != null and $get['EndTime'] != null) {
                    model::join('sensor_active_log_archive arch1', 'data.phase = arch1.phase and arch1.unit = data.unit and data.Tile_Kind = arch1.Start_Tile_Kind and (arch1.Start_time BETWEEN "'. $get['StartTime'] .'" AND "'.$get['EndTime'].'") and arch1.End_Time > arch1.Start_time ' );
                } 
                model::join('sensors sensors', 'sensors.id = arch1.Sensor_id');
                model::join('off_sensor_reasons offsensor', 'arch1.reason = offsensor.label');
                model::join('off_sensor_reasons Parent'   , 'offsensor.parentId = Parent.id');
                model::join('reasonType reasonType'   , 'reasonType.id = arch1.reasonType');
            }

			$search = $model->search([1] , '?'  , $search .' data' , implode(' , ' , $get['showField']) ) ;
			if ( is_array($search) and count($search) > 0 ) {
				$this->mold->offAutoCompile();
				$GLOBALS['timeStart'] = '';
				if ($get['getPDF']) {
					$this->mold->path('default', 'LineMonitoring');
					$views = $this->mold->getViews();
					$this->mold->unshow($views);
					$this->mold->view('exportPdf.mold.html');
					$this->mold->set('headersTable' , $header);
					$this->mold->set('datasTable' , $search);
					$this->mold->unshow('footer.mold.html');
					$htmlpersian = $this->mold->render();
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
				$this->alert('danger','','نتیجه ای یافت نشد !');
			}
		}

		$this->mold->path('default', 'LineMonitoring');
		$this->mold->view('export2.mold.html');
		$this->mold->setPageTitle('گزارش گیری');
		$this->mold->set('activeMenu' , 'exportExcel2');

        $this->mold->set('units', units::index()["result"]);
        $this->mold->set('phases', phases::index()["result"]);
		$this->mold->set('tiles'  , tiles::index()["result"]);
		$this->mold->set('shifts' , parent::model(['shiftWork','shift_work'])->getShiftWork());

	}
    public function  Production() {
		$get = request::post('unitId,phase,StartTime,EndTime,tile_kind,showField,shifts,getPDF=1,Shift,Day');

        $_SERVER['JsonOff'] = true;
        if ($get['StartTime'] != null){
            $shamsi = explode('/', $get['StartTime']);

            $DayData = totalDate::Day(0,strtotime(JDate::jalali_to_gregorian($shamsi[0] , $shamsi[1] , $shamsi[2] , '-'))+43200);
            $get['StartTime'] = $DayData["result"]["dayStart"];
        }
        if ($get['EndTime'] != null){
            $shamsi = explode('/', $get['EndTime']);
            $DayData = totalDate::Day(0,strtotime(JDate::jalali_to_gregorian($shamsi[0] , $shamsi[1] , $shamsi[2] , '-'))+43200);
            $get['EndTime']   = $DayData["result"]["dayEnd"];
        }
        
        
        if ($get['Shift'] != null){
            $shiftData = shift::index(time() - $get['Shift']*43200);
            
            $get['StartTime'] = $shiftData["result"]["startTime"];
            $get['EndTime']   = $shiftData["result"]["endTime"];
        } 
        if ($get['Day'] != null){
            
            $DayData = totalDate::Day($get['Day']);
  
            $get['StartTime'] = $DayData["result"]["dayStart"];
            $get['EndTime']   = $DayData["result"]["dayEnd"];
        }
        unset($_SERVER['JsonOff']);
        
        $variableble = array( );
		/* @var data_merge $model */
		$model = parent::model('data_merge');
		if (request::isPost() and is_array($get['showField']) and count($get['showField']) > 0 ) {
			if (is_array($get['phase'] ) and count($get['phase'] ) > 0 ) {
				$variable[] = ' arch1.phase IN( '. implode(' , ' , $get['phase']) .' ) ';
			}
			if (is_array($get['unitId'] ) and count($get['unitId'] ) > 0 ) {
				$variable[] = ' arch1.unit IN( '. implode(' , ' , $get['unitId']) .' ) ';
			}
			if (is_array($get['tile_kind'] ) and count($get['tile_kind'] ) > 0 ) {
				$variable[] = ' arch1.Tile_Kind IN( ' . implode(' , ', $get['tile_kind']) . ' ) ';
			}
			if (is_array($get['shifts'] ) and count($get['shifts'] ) > 0 ) {
				$variable[] = ' arch1.Shift_id IN( '. implode(' , ' , $get['shifts']) .' ) ';
			}
			if ($get['StartTime'] != null and $get['EndTime'] == null) {
				$variable[] = ' arch1.Start_time > "'.$get['StartTime'].'"' ;
			} elseif ($get['StartTime'] == null and $get['EndTime'] != null) {
				$variable[] = ' arch1.Start_time < "'.$get['EndTime'].'"';
			} elseif ($get['StartTime'] != null and $get['EndTime'] != null) {
				$variable[] = ' (arch1.Start_time BETWEEN "'.$get['StartTime'].'" AND "'.$get['EndTime'].'") ';
			}
			$header = [];
			$joinWith = false;
			for ( $i = 0 ;$i < count($get['showField']) ; $i++ ){
				if ( $get['showField'][$i] == "data.phase" )
					$header[] = 'فاز';
				elseif ( $get['showField'][$i] == "data.unit" )
                    {$header[] = 'واحد';
                    $get['showField'][$i] = "data.unitLabel";
                }
                elseif ( $get['showField'][$i] == "sensors.label" )
                    $header[] = 'نام سنسور';
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
				elseif ( $get['showField'][$i] == "reasonType.Title" ) {
					$header[] = 'نوع توقف';
					$joinWith = true ;
				}
                elseif ( $get['showField'][$i] == "Parent.label" ) {
					$header[] = 'سرفصل توقف';
					$joinWith = true ;
				}	
                elseif ( $get['showField'][$i] == "arch1.reason" ) {
					$header[] = 'عنوان توقف';
					$joinWith = true ;
				}
                elseif ( $get['showField'][$i] == "arch1.description" ) {
					$header[] = 'توضیحات توقف';
					$joinWith = true ;
				} elseif ( $get['showField'][$i] == "arch1.JStart_time" ) {
					$header[] = 'زمان شروع توقف';
					$joinWith = true ;
				} elseif ( $get['showField'][$i] == "TIMESTAMPDIFF(MINUTE,arch1.Start_time,arch1.End_Time)" ) {
					$header[] = 'مدت زمان توقف(دقیقه)';
					$joinWith = true ;
				}
			}
			$search = data_merge::creatExportTable(((count($variable) == 0) ?  ' 1 '  : implode(' and ', $variable)));
            if ($joinWith){
                if ($get['StartTime'] != null and $get['EndTime'] == null ) {
				model::join('sensor_active_log_archive arch1', 'data.phase = arch1.phase and arch1.unit = data.unit and data.Tile_Kind = arch1.Start_Tile_Kind and arch1.Start_time > "'. $get['StartTime'].'" and arch1.End_Time > arch1.Start_time  ' );
                } elseif ($get['StartTime'] == null and $get['EndTime'] != null) {
                    model::join('sensor_active_log_archive arch1', 'data.phase = arch1.phase and arch1.unit = data.unit and arch1.Start_time < "'.$get['EndTime'].'" and arch1.End_Time > arch1.Start_time ' );
                } elseif ($get['StartTime'] != null and $get['EndTime'] != null) {
                    model::join('sensor_active_log_archive arch1', 'data.phase = arch1.phase and arch1.unit = data.unit and data.Tile_Kind = arch1.Start_Tile_Kind and (arch1.Start_time BETWEEN "'. $get['StartTime'] .'" AND "'.$get['EndTime'].'") and arch1.End_Time > arch1.Start_time ' );
                } 
                model::join('sensors sensors', 'sensors.id = arch1.Sensor_id');
                model::join('off_sensor_reasons offsensor', 'arch1.reason = offsensor.label');
                model::join('off_sensor_reasons Parent'   , 'offsensor.parentId = Parent.id');
                model::join('reasonType reasonType'   , 'reasonType.id = arch1.reasonType');
            }

			$search = $model->search([1] , '?'  , $search .' data' , implode(' , ' , $get['showField']) ) ;
			if ( is_array($search) and count($search) > 0 ) {
				$this->mold->offAutoCompile();
				$GLOBALS['timeStart'] = '';
				if ($get['getPDF']) {
					$this->mold->path('default', 'LineMonitoring');
					$views = $this->mold->getViews();
					$this->mold->unshow($views);
					$this->mold->view('exportPdf.mold.html');
					$this->mold->set('headersTable' , $header);
					$this->mold->set('datasTable' , $search);
					$this->mold->unshow('footer.mold.html');
					$htmlpersian = $this->mold->render();
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
				$this->alert('danger','','نتیجه ای یافت نشد !');
			}
		}

		$this->mold->path('default', 'LineMonitoring');
		$this->mold->view('exportProduction.mold.html');
		$this->mold->setPageTitle('گزارش گیری تولید');
		$this->mold->set('activeMenu' , 'exportProduction');

        $this->mold->set('units', units::index()["result"]);
        $this->mold->set('phases', phases::index()["result"]);
		$this->mold->set('tiles'  , tiles::index()["result"]);
		$this->mold->set('shifts' , parent::model(['shiftWork','shift_work'])->getShiftWork());

	}
    public function  Stops() {
		$get = request::post('unitId,phase,StartTime,EndTime,tile_kind,showField,shifts,getPDF=1,Shift,Day' ,null);
        $_SERVER['JsonOff'] = true;
        if ($get['StartTime'] != null){
            $shamsi = explode('/', $get['StartTime']);

            $DayData = totalDate::Day(0,strtotime(JDate::jalali_to_gregorian($shamsi[0] , $shamsi[1] , $shamsi[2] , '-'))+43200);
            $get['StartTime'] = $DayData["result"]["dayStart"];
        }
        if ($get['EndTime'] != null){
            $shamsi = explode('/', $get['EndTime']);
            $DayData = totalDate::Day(0,strtotime(JDate::jalali_to_gregorian($shamsi[0] , $shamsi[1] , $shamsi[2] , '-'))+43200);
            $get['EndTime']   = $DayData["result"]["dayEnd"];
        }
        
        
        if ($get['Shift'] != null){
            $shiftData = shift::index(time() - $get['Shift']*43200);
            
            $get['StartTime'] = $shiftData["result"]["startTime"];
            $get['EndTime']   = $shiftData["result"]["endTime"];
        } 
        if ($get['Day'] != null){
            
            $DayData = totalDate::Day($get['Day']);
  
            $get['StartTime'] = $DayData["result"]["dayStart"];
            $get['EndTime']   = $DayData["result"]["dayEnd"];
        }
        unset($_SERVER['JsonOff']);
        
        $variableble = array( );
		/* @var data_merge $model */
		$model = parent::model('data_merge');
		if (request::isPost() and is_array($get['showField']) and count($get['showField']) > 0 ) {
			if (is_array($get['phase'] ) and count($get['phase'] ) > 0 ) {
				$variable[] = ' arch1.phase IN( '. implode(' , ' , $get['phase']) .' ) ';
			}
			if (is_array($get['unitId'] ) and count($get['unitId'] ) > 0 ) {
				$variable[] = ' arch1.unit IN( '. implode(' , ' , $get['unitId']) .' ) ';
			}
			if (is_array($get['tile_kind'] ) and count($get['tile_kind'] ) > 0 ) {
				$variable[] = ' arch1.Tile_Kind IN( ' . implode(' , ', $get['tile_kind']) . ' ) ';
			}
			if (is_array($get['shifts'] ) and count($get['shifts'] ) > 0 ) {
				$variable[] = ' arch1.Shift_id IN( '. implode(' , ' , $get['shifts']) .' ) ';
			}
			if ($get['StartTime'] != null and $get['EndTime'] == null) {
				$variable[] = ' arch1.Start_time > "'.$get['StartTime'].'"' ;
			} elseif ($get['StartTime'] == null and $get['EndTime'] != null) {
				$variable[] = ' arch1.Start_time < "'.$get['EndTime'].'"';
			} elseif ($get['StartTime'] != null and $get['EndTime'] != null) {
				$variable[] = ' (arch1.Start_time BETWEEN "'.$get['StartTime'].'" AND "'.$get['EndTime'].'") ';
			}
			$header = [];
			$joinWith = false;
			for ( $i = 0 ;$i < count($get['showField']) ; $i++ ){
				if ( $get['showField'][$i] == "data.phase" )
					$header[] = 'فاز';
				elseif ( $get['showField'][$i] == "data.unit" )
                    {$header[] = 'واحد';
                    $get['showField'][$i] = "data.unitLabel";
                }
                elseif ( $get['showField'][$i] == "sensors.label" )
                    $header[] = 'نام سنسور';
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
				elseif ( $get['showField'][$i] == "reasonType.Title" ) {
					$header[] = 'نوع توقف';
					$joinWith = true ;
				}
                elseif ( $get['showField'][$i] == "Parent.label" ) {
					$header[] = 'سرفصل توقف';
					$joinWith = true ;
				}	
                elseif ( $get['showField'][$i] == "arch1.reason" ) {
					$header[] = 'عنوان توقف';
					$joinWith = true ;
				}
                elseif ( $get['showField'][$i] == "arch1.description" ) {
					$header[] = 'توضیحات توقف';
					$joinWith = true ;
				} elseif ( $get['showField'][$i] == "arch1.JStart_time" ) {
					$header[] = 'زمان شروع توقف';
					$joinWith = true ;
				} elseif ( $get['showField'][$i] == "TIMESTAMPDIFF(MINUTE,arch1.Start_time,arch1.End_Time)" ) {
					$header[] = 'مدت زمان توقف(دقیقه)';
					$joinWith = true ;
				}
			}
			$search = data_merge::creatExportTable(((count($variable) == 0) ?  ' 1 '  : implode(' and ', $variable)));
            if ($joinWith){
                if ($get['StartTime'] != null and $get['EndTime'] == null ) {
				model::join('sensor_active_log_archive arch1', 'data.phase = arch1.phase and arch1.unit = data.unit and data.Tile_Kind = arch1.Start_Tile_Kind and arch1.Start_time > "'. $get['StartTime'].'" and arch1.End_Time > arch1.Start_time  ' );
                } elseif ($get['StartTime'] == null and $get['EndTime'] != null) {
                    model::join('sensor_active_log_archive arch1', 'data.phase = arch1.phase and arch1.unit = data.unit and arch1.Start_time < "'.$get['EndTime'].'" and arch1.End_Time > arch1.Start_time ' );
                } elseif ($get['StartTime'] != null and $get['EndTime'] != null) {
                    model::join('sensor_active_log_archive arch1', 'data.phase = arch1.phase and arch1.unit = data.unit and data.Tile_Kind = arch1.Start_Tile_Kind and (arch1.Start_time BETWEEN "'. $get['StartTime'] .'" AND "'.$get['EndTime'].'") and arch1.End_Time > arch1.Start_time ' );
                }  
                model::join('sensors sensors', 'sensors.id = arch1.Sensor_id');
                model::join('off_sensor_reasons offsensor', 'arch1.reason = offsensor.label');
                model::join('off_sensor_reasons Parent'   , 'offsensor.parentId = Parent.id');
                model::join('reasonType reasonType'   , 'reasonType.id = arch1.reasonType');
            }

			$search = $model->search([1] , '?'  , $search .' data' , implode(' , ' , $get['showField']) ) ;
			if ( is_array($search) and count($search) > 0 ) {
				$this->mold->offAutoCompile();
				$GLOBALS['timeStart'] = '';
				if ($get['getPDF']) {
					$this->mold->path('default', 'LineMonitoring');
					$views = $this->mold->getViews();
					$this->mold->unshow($views);
					$this->mold->view('exportPdf.mold.html');
					$this->mold->set('headersTable' , $header);
					$this->mold->set('datasTable' , $search);
					$this->mold->unshow('footer.mold.html');
					$htmlpersian = $this->mold->render();
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
				$this->alert('danger','','نتیجه ای یافت نشد !');
			}
		}

		$this->mold->path('default', 'LineMonitoring');
		$this->mold->view('exportStops.mold.html');
		$this->mold->setPageTitle('گزارش گیری توقفات');
		$this->mold->set('activeMenu' , 'exportStops');

        $this->mold->set('units', units::index()["result"]);
        $this->mold->set('phases', phases::index()["result"]);
		$this->mold->set('tiles'  , tiles::index()["result"]);
		$this->mold->set('shifts' , parent::model(['shiftWork','shift_work'])->getShiftWork());

	}
    public function  chart() {
        $search = model::searching( array()  ,  null  , 'sensors', '*'  , ['column' => 'showSort' , 'type' =>'asc'] );
        $this->mold->set('sensorsChart' , $search);
        
		$this->mold->path('default', 'LineMonitoring');
        $this->mold->view('chartGoogle.mold.html');
		$this->mold->setPageTitle('نمودار');
		$this->mold->set('activeMenu' , 'chart');
        

	}
}