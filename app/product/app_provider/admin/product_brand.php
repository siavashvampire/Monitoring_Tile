<?php
namespace App\product\app_provider\admin;

use App\user\app_provider\api\user;
use controller;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class product_brand extends controller {
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

        /** @var \App\product\model\product_brand $model */
		$model = parent::model('product_brand');
        $numberOfAll = $model->getCount($value, $variable);
		$pagination = parent::pagination($numberOfAll,$get['page'],$get['perEachPage']);
        $search = $model->getItems($value, $variable, ['column' => 'id' , 'type' =>'asc'], $pagination);
		$this->mold->path('default', 'product');
		$this->mold->view('product_brand_list.mold.html');
		$this->mold->setPageTitle('لیست برند ها');
		$this->mold->set('activeMenu' , 'product_brand');
		$this->mold->set('units' , $search);
		$this->mold->set('item_label' , 'برند');
		$this->mold->set('agents' , user::getUsersByGroupId((int)$this->setting('postAgent','post_design'))["result"]);
	}

	public function update(){
		$get = request::post('unitId,name,agent' ,null);
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

        /** @var \App\product\model\product_brand $model */
		if ( $get['unitId'] != '' ) {
            $model = parent::model('product_brand', $get['unitId']);
			if ( $model->getId() != $get['unitId']) {
				Response::jsonMessage('واحد مد نظر یافت نشد!',false);
				return false;
			}
            $Dis = 'واحد  ';
            $Dis = $Dis . $model->getlabel();
            $Dis = $Dis . ' به واحد  ';
            $model->setlabel($get['name']);
            $model->setAgent($get['agent']);
            $Dis = $Dis . $model->getlabel();
            $Dis = $Dis . ' تغییر پیدا کرد';
            $model->upDateDataBase();
		} else{
			$model = parent::model('product_brand');
            $model->setlabel($get['name']);
            $model->setAgent($get['agent']);
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