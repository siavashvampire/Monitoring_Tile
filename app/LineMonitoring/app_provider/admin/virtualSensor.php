<?php
namespace App\LineMonitoring\app_provider\admin;

use App;
use App\core\controller\httpErrorHandler;
use App\LineMonitoring\app_provider\api\phases;
use app\LineMonitoring\model\sensors;
use App\units\app_provider\api\units;
use controller;
use paymentCms\component\model;
use paymentCms\component\request;
use App\LineMonitoring\app_provider\api\tiles;
use paymentCms\component\validate;
use paymentCms\component\Response;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class virtualSensor extends controller {
	public function List(){
        $get = request::post('page=1,perEachPage=25,name,tile_kind,Active,unitId,phase,sortWith' ,null);
        
		$rules = [
			"page" => ["required|match:>0", rlang('page')],
			"perEachPage" => ["required|match:>0|match:<501", rlang('page')],
		];
		$valid = validate::check($get, $rules);
		$value = array( );
		$variable = array( );
        $variable[] = ' VS.isVirtual Like ? ';
        $value[] = 1 ;
        $variable[] = ' VS.isStorage Like ? ';
        $value[] = 0 ;

		$sortWith = [['column' => 'VS.showSort' , 'type' =>'asc']] ;
		if ($valid->isFail()){
			//TODO:: add error is not valid data
            
		} else {
			if ( $get['name'] != null ) {
                $value[] = '%'.$get['name'].'%' ;
				$variable[] = ' VS.label Like ? ';
			}
			if ( $get['tile_kind']    != null ) {
				$value[] = $get['tile_kind'] ;
				$variable[] = ' VS.id = ? ';
			}
			if ( $get['phase'] != null ) {
				$value[] = $get['phase'] ;
				$variable[] = ' VS.phase = ? ';
			}
			if ( $get['unitId'] != null ) {
				$value[] = $get['unitId'] ;
				$variable[] = ' VS.unit = ? ';
			}
			if ( $get['sortWith'] != null and is_array($get['sortWith']) ) {
				unset($sortWith);
				foreach ($get['sortWith'] as $sort) {
					$temp = explode('|', $sort);
					$sortWith[] = ['column' => $temp[0], 'type' => $temp[1]];
				}
			}

		}
		/* @var sensors $model */
		$model = parent::model('sensors');
		$numberOfAll = ($model->search( (array) $value  , ( count($variable) == 0 ) ? null : implode(' and ' , $variable) , 'sensors VS', 'COUNT(VS.id) as co' )) [0]['co'];
		$pagination = parent::pagination($numberOfAll,$get['page'],$get['perEachPage']);
        $model->join('tile_kind tile_kind' , 'tile_kind.id = VS.tile_id ');
        $model->join('units units' , 'units.id = VS.unit ');
        $search = $model->search( (array) $value  , ( ( count($variable) == 0 ) ? null : implode(' and ' , $variable) )  , 'sensors VS' , 'VS.*,tile_kind.label,units.label as unitLabel'  , $sortWith , [$pagination['start'] , $pagination['limit'] ] );
		$this->mold->path('default', 'LineMonitoring');
		$this->mold->view('VirtualsensorList.mold.html');
		$this->mold->setPageTitle('لیست سنسور های مجازی');
		$this->mold->set('activeMenu' , 'virtualSensor');
		$this->mold->set('VS' , $search);
		$this->mold->set('tiles'  , tiles::index()["result"]);

        $this->mold->set('units'  , units::index()["result"]);
		$this->mold->set('phases' , phases::index()["result"]);
	}
    public function index($VSId = null){
        if ($VSId != null)
        {
	        /* @var sensors $VS */
            $VS = parent::model('sensors',$VSId);
            if ( $VS->getId() != $VSId){
                    httpErrorHandler::E404();
                    return false ;
                }
            $VS->setSensorSign(explode(',', $VS->getSensorSign()));
            $VS->setSensorChosenId(explode(',',$VS->getSensorChosenId()));
            $this->mold->set('VSensor', $VS);
        }
        else
            $VS = parent::model('sensors');

        $this->mold->set('phases' , phases::index()["result"]);

        $this->mold->set('tiles'  , tiles::index()["result"]);
        $this->mold->set('units'  , units::index()["result"]);
        $search = $VS->search( array()  ,  null  , 'sensors', '*'  , ['column' => 'showSort' , 'type' =>'asc'] );
        $this->mold->set('Sensors' , $search);
            
        if ( request::ispost() ) {
            
            $get = request::post('Export=0,showSort,sensors,tile_kind,faz,unitId,tile_degree,SensorChosenId,SensorSign' ,null);

            $rules = [
                "sensors" => ["required", 'نام سنسور'],
            ];
            $valid = validate::check($get, $rules);
            $this->mold->offAutoCompile();
            $GLOBALS['timeStart'] = '';
            if ($valid->isFail()){
                Response::jsonMessage($valid->errorsIn(),false);
                return false;
            }
            $value = array( );
            $variable = array( );
            
            $VS->setLabel($get['sensors']);
            $VS->setshowSort($get['showSort']);
            $VS->setTileId($get['tile_kind']);
            $VS->setTile_Count(1);
            $VS->setPhase($get['faz']);
            $VS->setTileDegree($get['tile_degree']);
            $VS->setUnit($get['unitId']);
            $VS->setExport($get['Export']);
            
            $VS->setSensorPlcId(null);
            $VS->setPlcRead(1);
            $VS->setActive(1);
            $VS->setOffTime(0);
            $VS->setOffTime_Bale(0);
            $VS->setOffTime_SMS(0);
            $VS->setisVirtual(1);
            $VS->setisStorage(0);

            $VS->setSensorSign(implode(',',$get['SensorSign']));
            $VS->setSensorChosenId(implode(',',$get['SensorChosenId']));
            
            $Dis = 'سنسور مجازی با نام ';
            $Dis = $Dis . $VS->getLabel();
            if( $VSId == null and $VS->insertToDataBase()){
                $Dis = $Dis . ' ثبت شد';
                $this->callHooks('addLog', [$Dis , 'Sensor']);
                $this->alert('success' , '',"ثبت سنسور مجازی با موفقیت انجام شد");
                Response::redirect(App::getBaseAppLink('virtualSensor/List/','admin'));
            }
            elseif( $VSId != null and $VS->upDateDataBase()){
                $Dis = $Dis . ' تغییر یافت';
                $this->callHooks('addLog', [$Dis , 'Sensor']);
                $this->alert('success' , '',"ویرایش سنسور مجازی با موفقیت انجام شد");
                Response::redirect(App::getBaseAppLink('virtualSensor/List/','admin'));
            }
            else{
                $this->alert('danger' , '',"ثبت سنسور مجازی با مشکلی مواجه شده است");
            }
        }
        $this->mold->path('default', 'LineMonitoring');
        $this->mold->view('virtualSensor.mold.html');
        if( $VSId == null)
            $this->mold->setPageTitle('ثبت سنسور مجازی');
        elseif( $VSId != null)
            $this->mold->setPageTitle('ویرایش سنسور مجازی');
        
        $this->mold->set('activeMenu' , 'virtualSensor');
    }       
}