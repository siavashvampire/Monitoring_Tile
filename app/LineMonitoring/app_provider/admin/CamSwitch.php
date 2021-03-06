<?php
namespace App\LineMonitoring\app_provider\admin;

use App\LineMonitoring\app_provider\api\phases;
use App\units\app_provider\api\units;
use controller;
use paymentCms\component\cache;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class CamSwitch extends controller {
	public function index(){
		$get = request::post('page=1,perEachPage=25,name,Sensor_plc_id,Active,IgnoreSensor,unitId,phase,sortWith' ,null);

		$rules = [
			"page" => ["required|match:>0", rlang('page')],
			"perEachPage" => ["required|match:>0|match:<501", rlang('page')],
		];
		$valid = validate::check($get, $rules);
		$value = array( );
		$variable = array( );

        
		$sortWith = [['column' => 'CamSwitch.Switch_plc_id' , 'type' =>'desc']] ;
		if ($valid->isFail()){
			//TODO:: add error is not valid data
            
		} else {
			if ( $get['name'] != null ) {
                $value[] = '%'.$get['name'].'%' ;
				$variable[] = ' CamSwitch.label Like ? ';
			}
			if ( $get['Sensor_plc_id'] != null ) {
				$value[] = $get['Sensor_plc_id'] ;
				$variable[] = ' CamSwitch.Sensor_plc_id = ? ';
			}
			if ( $get['Active'] != null ) {
				$value[] = $get['Active'] ;
				$variable[] = ' CamSwitch.Active = ? ';
			}
			if ( $get['phase'] != null ) {
				$value[] = $get['phase'] ;
				$variable[] = ' CamSwitch.phase = ? ';
			}		
            if ( $get['IgnoreSensor'] != null ) {
				$value[] = $get['IgnoreSensor'] ;
				$variable[] = ' CamSwitch.IgnoreSensor = ? ';
			}
			if ( $get['unitId'] != null ) {
				$value[] = $get['unitId'] ;
				$variable[] = ' CamSwitch.unit = ? ';
			}
			if ( $get['sortWith'] != null and is_array($get['sortWith']) ) {
				unset($sortWith);
				foreach ($get['sortWith'] as $sort) {
					$temp = explode('|', $sort);
					$sortWith[] = ['column' => $temp[0], 'type' => $temp[1]];
				}
			}
		}
        
		/* @var \app\LineMonitoring\model\CamSwitch $model */
		$model = parent::model('CamSwitch');
		$numberOfAll = ($model->search( (array) $value  , ( count($variable) == 0 ) ? null : implode(' and ' , $variable) , 'CamSwitch CamSwitch', 'COUNT(CamSwitch.id) as co' )) [0]['co'];
		$pagination = parent::pagination($numberOfAll,$get['page'],$get['perEachPage']);
		model::join('units units' , 'units.id = CamSwitch.unit ');
		$search = $model->search( (array) $value  , ( ( count($variable) == 0 ) ? null : implode(' and ' , $variable) )  , 'CamSwitch CamSwitch' , 'CamSwitch.*,units.label as unitLabel'  , $sortWith , [$pagination['start'] , $pagination['limit'] ] );
		$this->mold->path('default', 'LineMonitoring');
		$this->mold->view('CamSwitchList.mold.html');
		$this->mold->setPageTitle('???????? ???????? ????????????');
		$this->mold->set('activeMenu' , 'CamSwitch');
		$this->mold->set('Switchs' , $search);

        $this->mold->set('units', units::index()["result"]);
        $this->mold->set('phases', phases::index()["result"]);
        
        

	}
	public function update(){
		$get = request::post('id,label,plcId,Active=0,RenderCheck,DelayTime,IgnoreSensor,Phase,unitId' ,null);
		$rules = [
			"label" => ["required", '?????? ????????'],
		];
		$valid = validate::check($get, $rules);
		$this->mold->offAutoCompile();
		$GLOBALS['timeStart'] = '';
		if ($valid->isFail()){
			Response::jsonMessage($valid->errorsIn(),false);
			return false;
		}
		if ( $get['id'] != '' ) {
			$model = parent::model('CamSwitch', $get['id']);
			if ( $model->getId() != $get['id']) {
				Response::jsonMessage('???????? ???? ?????? ???????? ??????!',false);
				return false;
			}
            
			$numberOfPLC  = ($model->search( [$get['plcId'],$get['id']]  , 'Switch_plc_id = ? and id != ? ' , 'CamSwitch', 'COUNT(id) as co' )) [0]['co'];
            
			if ( $numberOfPLC >  0 and $get['plcId'] != "" ) {
				Response::jsonMessage('?????????? ???????? ???????? ???????????? ??????!',false);
				return false;
			}
		} else {
			$model = parent::model('CamSwitch');
			$numberOfPLC  = ($model->search( [$get['plcId']]  , 'Switch_plc_id = ? ' , 'CamSwitch', 'COUNT(id) as co' )) [0]['co'];
			if ( $numberOfPLC >  0) {
				Response::jsonMessage('?????????? ???????? ???????? ???????????? ??????!',false);
				return false;
			}
		}
        
        $model->setLabel($get['label']);
		$model->setSwitchPlcId( ( $get['plcId'] != "" ) ? $get['plcId']  : null );
		$model->setPlcRead(0);
		$model->setActive(( $get['plcId'] != "" ) ? $get['Active']  : 0);
		$model->setPhase($get['Phase']);
		$model->setUnit($get['unitId']);
		$model->setDelayTime($get['DelayTime']);
		$model->setIgnoreSensor(',' . implode(',',$get['IgnoreSensor']) . ',');
		$model->setRenderCheck($get['RenderCheck']);
        
        $Dis = '???????? ???? ?????? ';
        $Dis = $Dis . $model->getLabel();
        
        
		if ( $get['id'] != '' ){
            $Dis = $Dis . ' ?????????? ????????';
            $this->callHooks('addLog', [$Dis , 'Switch']);
			$model->upDateDataBase();
        }
		else{
            $Dis = $Dis . ' ?????? ????';
            $this->callHooks('addLog', [$Dis , 'Switch']);
			$model->insertToDataBase();
        }
		cache::clear('is_switch_update' , 'LineMonitoring');
		Response::jsonMessage("?????????????? ???? ???????????? ?????????? ????.",true);
		return false;
	}
}