<?php
namespace App\requestService\app_provider\admin;

use controller;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class Consumable_Parts extends controller {
	public function index(){
		$get = request::post('page=1,perEachPage=25,name' ,null);
		$rules = [
			"page" => ["required|match:>0", rlang('page')],
			"perEachPage" => ["required|match:>0|match:<501", rlang('page')],
		];
		$valid = validate::check($get, $rules);
		$value = array( );
		$variable = array( );
        
        if ( $get['name'] != null ) {
            $value[] = '%'.$get['name'].'%' ;
            $variable[] = ' Name Like ? ';
        }
        
		$model = parent::model('consumable_Parts');
		$numberOfAll = ($model->search( (array) $value  , ( count($variable) == 0 ) ? null : implode(' and ' , $variable) , null, 'COUNT(id) as co' )) [0]['co'];
		$pagination = parent::pagination($numberOfAll,$get['page'],$get['perEachPage']);
		$search = $model->search( (array) $value  , ( ( count($variable) == 0 ) ? null : implode(' and ' , $variable) )  , null, '*'  , ['column' => 'id' , 'type' =>'asc'] , [$pagination['start'] , $pagination['limit'] ] );
		$this->mold->path('default', 'requestService');
		$this->mold->view('Consumable_PartsList.mold.html');
		$this->mold->setPageTitle('لیست بخش ها');
		$this->mold->set('activeMenu' , 'Consumable_Parts');
		$this->mold->set('parts' , $search);
	}
	public function update(){
		$get = request::post('id,name,unit' ,null);
		$rules = [
			"name" => ["required", 'نام قطعه'],
		];
		$valid = validate::check($get, $rules);
		$this->mold->offAutoCompile();
		$GLOBALS['timeStart'] = '';
		if ($valid->isFail()){
			Response::jsonMessage($valid->errorsIn(),false);
			return false;
		}
        
		if ( $get['id'] != '' ) {
			$model = parent::model('consumable_Parts', $get['id']);
			if ( $model->getId() != $get['id']) {
				Response::jsonMessage('قطعه مد نظر یافت نشد!',false);
				return false;
			}
		} else
			$model = parent::model('consumable_Parts');

		$model->setName($get['name']);
		$model->setUnit($get['unit']);
		if ( $get['id'] != '' )
			$model->upDateDataBase();
		else
			$model->insertToDataBase();
		
		Response::jsonMessage('تغییرات انجام شد.',true);
		return false;
	}
}