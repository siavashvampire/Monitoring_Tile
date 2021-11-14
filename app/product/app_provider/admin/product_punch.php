<?php
namespace App\product\app_provider\admin;

use controller;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class product_punch extends controller {
    private $item_label = "پانچ";
    private $model_name = 'product_punch';
    private $app_name = 'product';
    private $active_menu = 'product_punch';
    private $html_file_path = 'product_punch.mold.html';
	public function index(){
        /* @var \app\product\model\product_punch $model */
        $model = parent::model($this->model_name);

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
        

        $numberOfAll = $model->getCount($value, $variable);
		$pagination = parent::pagination($numberOfAll,$get['page'],$get['perEachPage']);
        $search = $model->getItems($value, $variable, ['column' => 'id' , 'type' =>'asc'], $pagination);
		$this->mold->path('default', $this->app_name);
		$this->mold->view($this->html_file_path);
		$this->mold->setPageTitle(rlang('insert') . " " . $this->item_label);
		$this->mold->set('activeMenu' , $this->active_menu);
		$this->mold->set('product_punch' , $search);
	}

	public function update(){
		$get = request::post('unitId,name' ,null);
		$rules = [
			"name" => ["required", 'نام' . rlang('insert') . " " . $this->item_label],
		];
		$valid = validate::check($get, $rules);
		$this->mold->offAutoCompile();
		$GLOBALS['timeStart'] = '';
		if ($valid->isFail()){
			Response::jsonMessage($valid->errorsIn(),false);
			return false;
		}
        
		if ( $get['unitId'] != '' ) {
			$model = parent::model($this->model_name, $get['unitId']);
			if ( $model->getId() != $get['unitId']) {
				Response::jsonMessage(rlang('insert') . " " . $this->item_label . 'مد نظر یافت نشد!',false);
				return false;
			}
            $Dis = (rlang('insert') . " " . $this->item_label);
            $Dis = $Dis . $model->getlabel();
            $Dis = $Dis . ' به' . rlang('insert') . " " . $this->item_label;
            $model->setlabel($get['name']);
            $Dis = $Dis . $model->getlabel();
            $Dis = $Dis . ' تغییر پیدا کرد';
            $model->upDateDataBase();
		} else{
			$model = parent::model($this->model_name);
            $model->setlabel($get['name']);
            $Dis = rlang('insert') . " " . $this->item_label;
            $Dis = $Dis . $model->getlabel();
            $Dis = $Dis . ' ثبت شد';
            $model->insertToDataBase();
        }

		$this->callHooks('addLog', [$Dis , $this->model_name]);
		Response::jsonMessage('تغییرات انجام شد.',true);
		return false;
	}
}