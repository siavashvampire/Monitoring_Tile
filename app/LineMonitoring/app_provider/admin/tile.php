<?php
namespace App\LineMonitoring\app_provider\admin;

use app\LineMonitoring\model\sensors;
use app\LineMonitoring\model\tile_kind;
use controller;
use paymentCms\component\cache;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class tile extends controller {
	public function index(){
		$get = request::post('page=1,perEachPage=25,name,width,length' ,null);
		$rules = [
			"page" => ["required|match:>0", rlang('page')],
			"perEachPage" => ["required|match:>0|match:<501", rlang('page')],
		];
		$valid = validate::check($get, $rules);
		$value = array( );
		$variable = array( );
		if ($valid->isFail()){
			//TODO:: add error is not valid data

		} else {
			if ( $get['name'] != null ) {
				$value[] = '%'.$get['name'].'%' ;
				$variable[] = ' label Like ? ';
			}
			if ( $get['width'] != null ) {
				$value[] = $get['width'] ;
				$variable[] = ' tile_width = ? ';
			}
			if ( $get['length'] != null ) {
				$value[] = $get['length'] ;
				$variable[] = ' tile_length = ? ';
			}

		}
        
		/* @var tile_kind $model */
		$model = parent::model('tile_kind');
		$numberOfAll = ($model->search( (array) $value  , ( count($variable) == 0 ) ? null : implode(' and ' , $variable) , null, 'COUNT(id) as co' )) [0]['co'];
		$pagination = parent::pagination($numberOfAll,$get['page'],$get['perEachPage']);
		$search = $model->search( (array) $value  , ( ( count($variable) == 0 ) ? null : implode(' and ' , $variable) )  , null, '*'  , ['column' => 'label' , 'type' =>'asc'] , [$pagination['start'] , $pagination['limit'] ] );
		$this->mold->path('default', 'LineMonitoring');
		$this->mold->view('tileList.mold.html');
		$this->mold->setPageTitle('لیست کاشی ها');
		$this->mold->set('activeMenu' , 'tile');
		$this->mold->set('tiles' , $search);
	}

	public function update(){
		$get = request::post('id,label,tile_width,tile_length' ,null);
		$rules = [
			"label" => ["required", 'نام کاشی'],
			"tile_width" => ["required|floatInt|match:>0", 'طول کاشی'],
			"tile_length" => ["required|floatInt|match:>0", 'عرض کاشی'],
		];
		$valid = validate::check($get, $rules);
		$this->mold->offAutoCompile();
		$GLOBALS['timeStart'] = '';
		if ($valid->isFail()){
			Response::jsonMessage($valid->errorsIn(),false);
			return false;
		}
		/* @var tile_kind $model */
		if ( $get['id'] != '' ) {
			$model = parent::model('tile_kind', $get['id']);
			if ( $model->getId() != $get['id']) {
				Response::jsonMessage('کاشی مد نظر یافت نشد!',false);
				return false;
			}
		} else
			$model = parent::model('tile_kind');

		$model->setTileLength($get['tile_length']);
		$model->setLabel($get['label']);
		$model->setTileWidth($get['tile_width']);
        $Dis = 'کاشی با نام ';
        $Dis = $Dis . $model->getLabel();
		if ( $get['id'] != '' ){
            $Dis = $Dis . ' تغییر یافت';
            $this->callHooks('addLog', [$Dis , 'Tile']);
			$model->upDateDataBase();
        }else{
            $Dis = $Dis . ' ثبت شد';
            $this->callHooks('addLog', [$Dis , 'Tile']);
			$model->insertToDataBase();
        }

		/* @var sensors $sensor */
		$sensor = parent::model('sensors');
		$sensor->setUnreadForPlc($model->getId());

		cache::clear('is_sensor_update' , 'LineMonitoring');
		Response::jsonMessage('تغییرات انجام شد.',true);
		return false;
	}
}