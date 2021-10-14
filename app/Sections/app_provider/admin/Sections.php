<?php
namespace App\Sections\app_provider\admin;

use controller;
use paymentCms\component\cache;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class Sections extends controller {
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

		}

        if ( $get['name'] != null ) {
            $value[] = '%'.$get['name'].'%' ;
            $variable[] = ' item.label Like ? ';
        }
        
		/* @var \app\Sections\model\sections $model */
		$model = parent::model('sections');
        $numberOfAll = $model->getCount($value, $variable);
		$pagination = parent::pagination($numberOfAll,$get['page'],$get['perEachPage']);
        $search = $model->getItems($value, $variable, ['column' => 'item.id' , 'type' =>'asc'], $pagination);
		$this->mold->path('default', 'Sections');
		$this->mold->view('SectionsList.mold.html');
		$this->mold->setPageTitle('لیست بخش ها');
		$this->mold->set('activeMenu' , 'Sections');
		$this->mold->set('sections' , $search);
	}

	public function update(){
		$get = request::post('id,label' ,null);
		$rules = [
			"label" => ["required", 'نام بخش'],
		];
		$valid = validate::check($get, $rules);
		$this->mold->offAutoCompile();
		$GLOBALS['timeStart'] = '';
		if ($valid->isFail()){
			Response::jsonMessage($valid->errorsIn(),false);
			return false;
		}
		if ( $get['id'] != '' ) {
			$model = parent::model('sections', $get['id']);
			if ( $model->getId() != $get['id']) {
				Response::jsonMessage('بخش مد نظر یافت نشد!',false);
				return false;
			}
            $Dis = 'بخش  ';
            $Dis = $Dis . $model->getlabel();
            $Dis = $Dis . ' به بخش  ';
            $model->setlabel($get['label']);
            $Dis = $Dis . $model->getlabel();
            $Dis = $Dis . ' تغییر پیدا کرد';
            $model->upDateDataBase();
		} else{
			$model = parent::model('sections');
            $model->setlabel($get['label']);
            $Dis = 'بخش  ';
            $Dis = $Dis . $model->getlabel();
            $Dis = $Dis . ' ثبت شد';
            $model->insertToDataBase();
        }

        $this->callHooks('addLog', [$Dis , 'Sections']);
		Response::jsonMessage('تغییرات انجام شد.',true);
		return false;
	}
}