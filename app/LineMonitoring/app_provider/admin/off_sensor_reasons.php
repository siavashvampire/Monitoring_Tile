<?php
namespace App\LineMonitoring\app_provider\admin;

use controller;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class off_sensor_reasons extends controller {
	public function index($fatherId = null){
		$this->lists($fatherId);
	}
	/**
	 * @param null $fatherId
	 *
	 */
	public function lists($fatherId = null) {
		$get = request::post('page=1,perEachPage=25,name' ,null);
		$rules = [
			"page" => ["required|match:>0", rlang('page')],
			"perEachPage" => ["required|match:>0|match:<501", rlang('page')],
		];
		$valid = validate::check($get, $rules);
		$value = array( );
		$variable = array( );
		if ($valid->isFail()){

		} else {
			if ( $get['name'] != null ) {
				$value[] = '%'.$get['name'].'%' ;
				$variable[] = 'label LIKE ?' ;
			}
		}
		/* @var \App\LineMonitoring\model\off_sensor_reasons $model */
		if ( $get['name'] == null) {
			if ($fatherId == null) {
				$value[] = '1';
				$variable[] = 'parentId is Null and ?  ';
			} else {
				$value[] = $fatherId;
				$variable[] = 'parentId = ?  ';

				$model = $this->model('off_sensor_reasons', $fatherId);
				$this->mold->set('specialtyFather', $model->returnAsArray());
			}
		}

		$model = $this->model('off_sensor_reasons');
		$numberOfAll = ($model->search( (array) $value  , ( count($variable) == 0 ) ? null : implode(' and ' , $variable) , null, 'COUNT(id) as co' )) [0]['co'];
		$pagination = parent::pagination($numberOfAll,$get['page'],$get['perEachPage']);
		$search = $model->search( (array) $value  , ( ( count($variable) == 0 ) ? null : implode(' and ' , $variable) )  , null, '*'  , ['column' => 'id' , 'type' =>'asc'] , [$pagination['start'] , $pagination['limit'] ] );
		$this->mold->path('default', 'LineMonitoring');
		$this->mold->view('off_sensor_reasons.mold.html');
		$this->mold->setPageTitle('تنظیمات علت توقفات');
		$this->mold->set('activeMenu' , 'off_sensor_reasons');
		$this->mold->set('specialties' , $search);
		$this->mold->set('specialtyFatherId' , $fatherId);
	}


	/**
	 * @param null $userId
	 *
	 * @return bool
	 *
	 */
	public function checkData(){
		$this->mold->offAutoCompile();
		$get = request::post('fatherId,id=0,name' ,null);
		$rules = [
			"name" => ["required", 'علت خطا']
		];
		$valid = validate::check($get, $rules);
		if ($valid->isFail()){
			Response::jsonMessage($valid->errorsIn(),false);
			return false;
		} else {
			/* @var \App\LineMonitoring\model\off_sensor_reasons $model */
			$model = $this->model('off_sensor_reasons');
			$model->setLabel($get['name']);
            $numberOfPLC  = ($model->search( $get['name']  , 'label = ?' , 'off_sensor_reasons', 'COUNT(id) as co' )) [0]['co'];
			if ( $numberOfPLC >  0) {
				Response::jsonMessage('علت تکراری است!',false);
				return false;
			}
			if ( $get['fatherId'] > 0  )
				$model->setParentId($get['fatherId']);
			if ( $get['id'] > 0 ){
				$model->setId($get['id']);
				if ( $model->upDateDataBase() ) {
                    $Dis = 'علت توقفات به  ';
                    $Dis = $Dis . $model->getLabel();
                    $Dis = $Dis . ' تغییر یافت';
                    $this->callHooks('addLog', [$Dis , 'off_sensor_reasons']);
					Response::jsonMessage('تغییرات با موفقیت ثبت شد.',true);
					return true;
				} else {
					Response::jsonMessage(rlang('pleaseTryAGain'),false);
					return false;
				}
			} else {
				if ( $model->insertToDataBase() ) {
                    $Dis = 'علت توقفات به  ';
                    $Dis = $Dis . $model->getLabel();
                    $Dis = $Dis . ' تغییر یافت';
                    $this->callHooks('addLog', [$Dis , 'off_sensor_reasons']);
					Response::jsonMessage('علت با موفقیت ثبت شد.',true,$model->getId());
					return $model->getId();
				} else {
					Response::jsonMessage(rlang('pleaseTryAGain'),false);
					return false;
				}
			}
		}
	}

}