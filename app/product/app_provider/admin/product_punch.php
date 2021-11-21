<?php
namespace App\product\app_provider\admin;

use controller;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class product_punch extends controller {
    private $item_label = "پانچ";
    private $model_name = 'product_punch';
    private $log_name = 'product_punch';
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
		$this->mold->set('items' , $search);
	}

	public function update(){
        /* @var \App\product\model\product_size $model */
		$get = request::post('id,name' ,null);
		$rules = [
			"name" => ["required", rlang('name') . rlang('insert') . " " . $this->item_label],
		];
		$valid = validate::check($get, $rules);
		$this->mold->offAutoCompile();
		$GLOBALS['timeStart'] = '';
		if ($valid->isFail()){
			Response::jsonMessage($valid->errorsIn(),false);
			return false;
		}

        if ($get['id'] != '') {
            $model = parent::model($this->model_name, $get['id']);
            if ($model->getId() != $get['id']) {
                Response::jsonMessage($this->item_label . " " . rlang('cantFindSpecific'), false);
                return false;
            }
        } else
            $model = parent::model($this->model_name);

        $Dis = $this->item_label . " " . rlang('with') . " " . rlang('name') . " ";
        $Dis .= $model->getLabel() . " ";

        $model->setLabel($get['label']);
        $model->setLength($get['length']);
        $model->setWidth($get['width']);
        $model->setThickness($get['thickness']);

        if ($get['id'] != '') {

            $Dis .= rlang('be') . " " . $this->item_label . " " . rlang('with') . " " . rlang('name') . " ";
            $Dis .= $model->getlabel() . " ";
            $Dis .= rlang('changed');
            $model->upDateDataBase();
        } else {
            $Dis .= $model->getLabel() . " ";
            $Dis = $Dis . rlang('inserted');
            $model->insertToDataBase();
        }

        $this->callHooks('addLog', [$Dis, $this->log_name]);
        Response::jsonMessage(rlang('changeSuccessfully'), true);
        return false;
	}
}