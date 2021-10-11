<?php
namespace App\PictureIT\app_provider\admin;

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

class Device extends controller {
    public function List(){
		$get = request::post('page=1,perEachPage=25,label,sortWith' ,null);
        
		$rules = [
			"page" => ["required|match:>0", rlang('page')],
			"perEachPage" => ["required|match:>0|match:<501", rlang('page')],
		];
		$valid = validate::check($get, $rules);
		$value = array( );
		$variable = array( );

		$sortWith = [['column' => 'devices.id' , 'type' =>'asc']] ;
		if ($valid->isFail()){
			//TODO:: add error is not valid data
            
		} else {
			if ( $get['label'] != null ) {
                $value[] = '%'.$get['label'].'%' ;
				$variable[] = ' devices.label Like ? ';
			}
			if ( $get['sortWith'] != null and is_array($get['sortWith']) ) {
				unset($sortWith);
				foreach ($get['sortWith'] as $sort) {
					$temp = explode('|', $sort);
					$sortWith[] = ['column' => $temp[0], 'type' => $temp[1]];
				}
			}

		}
        
		$model = parent::model('devices');
		$numberOfAll = ($model->search( (array) $value  , ( count($variable) == 0 ) ? null : implode(' and ' , $variable) , 'devices devices', 'COUNT(devices.id) as co' )) [0]['co'];
		$pagination = parent::pagination($numberOfAll,$get['page'],$get['perEachPage']);
		$search      = $model->search( (array) $value  , ( ( count($variable) == 0 ) ? null : implode(' and ' , $variable) )  , 'devices devices' , 'devices.*'  , $sortWith , [$pagination['start'] , $pagination['limit'] ] );
        $this->mold->set('items' , $search);
        
        $user = user::getUserLogin();
        $editAccess = checkAccess::index($user['user_group_id'],'admin','Device','index','PictureIT')["status"];
        $this->mold->set('editAccess' , $editAccess);
        
		$this->mold->path('default', 'PictureIT');
		$this->mold->view('DevicesList.mold.html');
		$this->mold->setPageTitle(rlang('Devices'));
		$this->mold->set('activeMenu' , 'Devices');
	}
	public function index($id = null){
        $get = request::post('label,port' ,null);
        if ($id != null)
        {
            $model = parent::model('devices',$id);
            
            if ( $model->getId() != $id){
                    httpErrorHandler::E404();
                    return false ;
                }
        }
        else
            $model = parent::model('devices');
        
        $this->mold->set('model', $model);
            
        if ( request::ispost()) {
            $rules = [
                "label" => ["required", 'Device Name'],
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
            $model->setPort($get['port']);

            $Dis = 'دستگاه با نام ';
            $Dis = $Dis . $model->getlabel();
            if( $id == null and $model->insertToDataBase()){
                $Dis = $Dis . ' ثبت شد';
                $this->callHooks('addLog', [$Dis , 'device']);

                Response::jsonMessage("insert successfully",true);
                return false;
            }
            elseif( $id != null and $model->upDateDataBase()){
                $Dis = $Dis . ' تغییر یافت';
                $this->callHooks('addLog', [$Dis , 'device']);

                Response::jsonMessage("insert successfully",true);
                return false;
            }
            else{
                Response::jsonMessage("Problem in Insert",false);
            }            
        }
        
        $this->mold->path('default', 'PictureIT');
        $this->mold->view('Devices.mold.html');
        $this->mold->set('activeMenu' , 'Devices');
        if( $id == null)
            $this->mold->setPageTitle('insert' . ' ' .  rlang('Device'));
        elseif( $id != null)
            $this->mold->setPageTitle('edit' . ' ' .  rlang('Device'));
    }
    private static function tr_num($str, $mod = 'en') {
		$num_a = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
		$key_a = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
		return ($mod == 'fa') ? str_replace($num_a, $key_a, $str) : str_replace($key_a, $num_a, $str);
	}
}