<?php
namespace App\weighbridge\app_provider\admin;

use App\core\controller\fieldService;
use App\core\controller\httpErrorHandler;
use App\user\app_provider\api\checkAccess;
use controller;
use paymentCms\component\JDate;
use paymentCms\component\model;
use paymentCms\component\request;
use App\user\app_provider\api\user;
use paymentCms\component\validate;
use paymentCms\component\Response;
use paymentCms\component\arrays;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class Truck_Kind extends controller {
    public function List(){
		$get = request::post('page=1,perEachPage=25,label,sortWith' ,null);
        
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
			if ( $get['label'] != null ) {
                $value[] = '%'.$get['label'].'%' ;
				$variable[] = ' label Like ? ';
			}
			if ( $get['sortWith'] != null and is_array($get['sortWith']) ) {
				unset($sortWith);
				foreach ($get['sortWith'] as $sort) {
					$temp = explode('|', $sort);
					$sortWith[] = ['column' => $temp[0], 'type' => $temp[1]];
				}
			}

		}
        
        $sortWith    = [['column' => 'id' , 'type' =>'asc']] ;
		$model       = parent::model('Truck_Kind');
		$numberOfAll = $model->getCount($value,$variable);
		$pagination  = parent::pagination($numberOfAll,$get['page'],$get['perEachPage']);
		$search      = $model->getItems($value,$variable,$sortWith,$pagination);
        
        $this->mold->set('items' , $search);
        
        $editAccess = checkAccess::index(user::getUserLogin()['user_group_id'],'admin','Truck_Kind','index','weighbridge')["status"];
        $this->mold->set('editAccess' , $editAccess);
        
		$this->mold->path('default', 'weighbridge');
		$this->mold->view('Truck_KindList.mold.html');
		$this->mold->setPageTitle(rlang('Truck_Kind'));
		$this->mold->set('activeMenu' , 'Truck_Kind');
	}
	public function index($id = null){
        $get = request::post('label,port' ,null);
        if ($id != null){
            $model = parent::model('Truck_Kind',$id);
            
            if ( $model->getId() != $id){
                    httpErrorHandler::E404();
                    return false ;
                }
        }
        else
            $model = parent::model('Truck_Kind');
        
        $this->mold->set('model', $model);
            
        if ( request::ispost()) {
            $rules = [
                "label" => ["required", rlang('name')." ".rlang('Truck_Kind')],
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
            $model->setlabel($get['label']);

            $Dis = ' نوع کامیون با نام ';
            $Dis = $Dis . $model->getlabel();
            
            if( $id == null and $model->insertToDataBase()){
                $Dis = $Dis . ' ثبت شد';
                $this->callHooks('addLog', [$Dis , 'Truck_Kind']);

                Response::jsonMessage(rlang('insert') . ' ' .  rlang("successfully") . ' ' .  rlang("was"),true);
                return false;
            }
            elseif( $id != null and $model->upDateDataBase()){
                $Dis = $Dis . ' تغییر یافت';
                $this->callHooks('addLog', [$Dis , 'Truck_Kind']);

                Response::jsonMessage(rlang('insert') . ' ' .  rlang("successfully") . ' ' .  rlang("was"),true);
                return false;
            }
            else{
                Response::jsonMessage(rlang('insert') . ' ' .  rlang("fail") . ' ' .  rlang("was"),false);
            }            
        }
        
        $this->mold->path('default', 'weighbridge');
        $this->mold->view('Truck_Kind.mold.html');
        $this->mold->set('activeMenu' , 'Truck_Kind');
        if( $id == null)
            $this->mold->setPageTitle(rlang('insert') . ' ' .  rlang('Truck_Kind'));
        elseif( $id != null)
            $this->mold->setPageTitle(rlang('edit') . ' ' .  rlang('Truck_Kind'));
    }
    private static function tr_num($str, $mod = 'en') {
		$num_a = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
		$key_a = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
		return ($mod == 'fa') ? str_replace($num_a, $key_a, $str) : str_replace($key_a, $num_a, $str);
	}
}