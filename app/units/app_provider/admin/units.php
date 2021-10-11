<?php
namespace App\units\app_provider\admin;

use controller;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class units extends controller {
	public function index(){
		$get = request::post('page=1,perEachPage=25,name' ,null);
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
				$variable[] = ' Name Like ? ';
			}

		}
        
		/* @var \app\LineMonitoring\model\units $model */
		$model = parent::model('units');
        $numberOfAll = $model->getCount($value, $variable);
		$pagination = parent::pagination($numberOfAll,$get['page'],$get['perEachPage']);
        $search = $model->getItems($value, $variable, ['column' => 'id' , 'type' =>'asc'], $pagination);
		$this->mold->path('default', 'units');
		$this->mold->view('UnitsList.mold.html');
		$this->mold->setPageTitle('لیست واحد ها');
		$this->mold->set('activeMenu' , 'units');
		$this->mold->set('units' , $search);
	}

	public function update(){
		$get = request::post('unitId,name' ,null);
		$rules = [
			"name" => ["required", 'نام واحد'],
		];
		$valid = validate::check($get, $rules);
		$this->mold->offAutoCompile();
		$GLOBALS['timeStart'] = '';
		if ($valid->isFail()){
			Response::jsonMessage($valid->errorsIn(),false);
			return false;
		}
        
		if ( $get['unitId'] != '' ) {
			$model = parent::model('units', $get['unitId']);
			if ( $model->getId() != $get['unitId']) {
				Response::jsonMessage('واحد مد نظر یافت نشد!',false);
				return false;
			}
            $Dis = 'واحد  ';
            $Dis = $Dis . $model->getlabel();
            $Dis = $Dis . ' به واحد  ';
            $model->setlabel($get['name']);
            $Dis = $Dis . $model->getlabel();
            $Dis = $Dis . ' تغییر پیدا کرد';
            $model->upDateDataBase();
		} else{
			$model = parent::model('units');
            $model->setlabel($get['name']);
            $Dis = 'واحد  ';
            $Dis = $Dis . $model->getlabel();
            $Dis = $Dis . ' ثبت شد';
            $model->insertToDataBase();
        }

		$this->callHooks('addLog', [$Dis , 'units']);
		Response::jsonMessage('تغییرات انجام شد.',true);
		return false;
	}
}