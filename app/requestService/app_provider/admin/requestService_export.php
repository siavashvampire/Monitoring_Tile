<?php
namespace App\requestService\app_provider\admin;

use App\LineMonitoring\app_provider\api\phases;
use App\requestService\model\requestService;
use App\Sections\app_provider\api\sections;
use controller;
use paymentCms\component\model;
use paymentCms\component\request;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class requestService_export extends controller {
	public function  index(){
		$get = request::post('unitId,phase,StartTime,EndTime,line' ,null);
        
		$variable = array( );

        /** @var requestservice $model */
        $model = parent::model('requestService');

		$value  = [] ;
		if (request::isPost() ) {
			if (is_array($get['phase']) and count($get['phase']) > 0) {
				$variable[] = ' rs.phase IN( ' . implode(' , ', $get['phase']) . ' ) ';
				array_merge($value,$get['phase']);
			}
			if (is_array($get['unitId']) and count($get['unitId']) > 0) {
				$variable[] = ' rs.unitId IN( ' . implode(' , ', $get['unitId']) . ' ) ';
				array_merge($value,$get['unitId']);
			}
			if (is_array($get['line']) and count($get['line']) > 0) {
				$variable[] = ' rs.Line IN( ' . implode(' , ', $get['line']) . ' ) ';
				array_merge($value,$get['line']);
			}
			if ($get['StartTime'] != null and $get['EndTime'] == null) {
				$variable[] = ' rs.Time_Send > "' . date('Y-m-d H:i:s', $get['StartTime'] / 1000) . '"';
				$value[] = date('Y-m-d H:i:s', $get['StartTime'] / 1000);
			} elseif ($get['StartTime'] == null and $get['EndTime'] != null) {
				$variable[] = ' rs.Time_Send < "' . date('Y-m-d H:i:s', $get['EndTime'] / 1000) . '"';
				$value[] = date('Y-m-d H:i:s', $get['EndTime'] / 1000);
			} elseif ($get['StartTime'] != null and $get['EndTime'] != null) {
				$variable[] = ' (rs.Time_Send BETWEEN "' . date('Y-m-d H:i:s', $get['StartTime'] / 1000) . '" AND "' . date('Y-m-d H:i:s', $get['EndTime'] / 1000) . '") ';
				$value[] = date('Y-m-d H:i:s', $get['StartTime'] / 1000);
				$value[] = date('Y-m-d H:i:s', $get['EndTime'] / 1000);
			}


			$header = [
				'تاریخ درخواست',
				'شماره درخواست',
				'ساعت درخواست',
				'واحد درخواست کننده',
				'فاز',
				'نام دستگاه/تجهیز',
				'حالت تعمیرات',
				'مدت توقف',
				'واحد مجری',
				'ساعت شروع',
				'ساعت اتمام',
				'زمان کارکرد(دقیقه)',
				'شرح خرابی و عملیات انجام شده',
				'نفر کارکرد',
				'نفر ساعت',
			];
			$requestservice_worktitles = $model->search( null , ' 1 ' , 'requestservice_worktitle');
			if ( is_array($requestservice_worktitles) ){
				for ( $i = 0 ; $i < count($requestservice_worktitles) ; $i++ ){
					$header[] = $requestservice_worktitles[$i]['Title'];
				}
			}
            
			model::join('sections units', 'units.id = rs.section ' );
			model::join('sections unitsWorker', 'unitsWorker.id = rs.WorkerSection ' );
			model::join('requestservice_system_status system_status', 'system_status.id = rs.System_Status ' );
			$search = $model->search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)) , 'requestservice' .' rs' , 'rs.JTime_Send ,rs.requestCode ,DATE_FORMAT(rs.Time_Send,\'%H:%i:%s\') as Time_Send_jt ,units.label as senderUnitName  ,rs.phase ,rs.System_Name ,system_status.Title as systemStatus ,rs.offTime , unitsWorker.Name as workerUnitName , DATE_FORMAT(rs.Time_Start,\'%H:%i:%s\') as Time_start_jt , DATE_FORMAT(rs.Time_End,\'%H:%i:%s\') as Time_end_jt , TIMESTAMPDIFF(MINUTE,rs.Time_Start,rs.Time_End) as workTime ,rs.Sender_note ,rs.HumanNumber , rs.HumanNumber * TIMESTAMPDIFF(MINUTE,rs.Time_Start,rs.Time_End) as workTime2 , rs.WorkTitle as WorkTitle' ) ;
            if ( is_array($search) and count($search) > 0 ) {
                header('Content-Encoding: UTF-8');
				header('Content-type: text/csv; charset=UTF-8');
				header("Content-Disposition: attachment; filename=" . 'Export Log (' . date('Y-M-d H:i:s') . ').csv');
				header("Pragma: no-cache");
				header("Expires: 0");
				header('Content-Transfer-Encoding: binary');
				
                $this->mold->offAutoCompile();
				$GLOBALS['timeStart'] = '';
				echo "\xEF\xBB\xBF";
                
				$fp = fopen('php://output', 'w');
				fputcsv($fp, $header);
				for ($i = 0; $i < count($search); $i++) {
					$WorkTitle = $search[$i]['WorkTitle'] ;
					unset($search[$i]['WorkTitle']);
					if ( is_array($requestservice_worktitles) ){
						for ( $i2 = 0 ; $i2 < count($requestservice_worktitles) ; $i2++ ){
							if (strpos($WorkTitle, strval($requestservice_worktitles[$i2]['id'])))
                            {
                                $search[$i][] = "1";
                            }                            
							else
								$search[$i][] = "";
						}
					}
					fputcsv($fp, $search[$i]);
				}
				fclose($fp);
				return true;
			}else{
				$this->alert('danger','','نتیجه ای یافت نشد !');
			}
		}


		$this->mold->path('default', 'LineMonitoring');
		$this->mold->view('RSExport.mold.html');
		$this->mold->setPageTitle('گزارش گیری خدمات');
		$this->mold->set('activeMenu' , 'RequestexportExcel');

        $this->mold->set('sections', sections::index() ["result"]);

        $this->mold->set('phases', phases::index()["result"]);
	}
}