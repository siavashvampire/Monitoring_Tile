<?php
namespace App\weighbridge\app_provider\admin;

use App\core\controller\httpErrorHandler;
use App\user\app_provider\api\checkAccess;
use App\weighbridge\model\Truck;
use controller;
use paymentCms\component\request;
use App\user\app_provider\api\user;
use paymentCms\component\validate;
use paymentCms\component\Response;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class Trucks extends controller {
    public function List(){
		$get = request::post('page=1,perEachPage=25,sortWith' ,null);
        
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
			if ( $get['sortWith'] != null and is_array($get['sortWith']) ) {
				unset($sortWith);
				foreach ($get['sortWith'] as $sort) {
					$temp = explode('|', $sort);
					$sortWith[] = ['column' => $temp[0], 'type' => $temp[1]];
				}
			}

		}
        
        $sortWith    = [['column' => 'id' , 'type' =>'asc']] ;
		$model       = parent::model('Truck');
		$numberOfAll = $model->getItemCount($value,$variable);
		$pagination  = parent::pagination($numberOfAll,$get['page'],$get['perEachPage']);
		$search      = $model->getItems($value,$variable,$sortWith,$pagination);
        $this->mold->set('items' , $search);
        
        $editAccess = checkAccess::index(user::getUserLogin()['user_group_id'],'admin','Trucks','index','weighbridge')["status"];
        $this->mold->set('editAccess' , $editAccess);
        
		$this->mold->path('default', 'weighbridge');
		$this->mold->view('TruckList.mold.html');
		$this->mold->setPageTitle(rlang('Truck'));
		$this->mold->set('activeMenu' , 'Truck');
	}
	public function index($id = null){
        $get = request::post('mainNumberPlate,Number1Plate,CharNumberPlate,Number2Plate,Weight,Truck_Kind,workTitle,driverPhone1,driverName1,driverPhone2,driverName2,driverPhone3,driverName3,description' ,null);
        if ($id != null){
            /** @var Truck $model */
            $model = parent::model('Truck',$id);
            
            if ( $model->getId() != $id){
                    httpErrorHandler::E404();
                    return false ;
                }
        }

            /** @var Truck $model */
            $model = parent::model('Truck');

        $this->mold->set('model', $model);
        
        $result = array( );
        $result[] = ['label' => "الف"];
        $result[] = ['label' => "ب"];
        $result[] = ['label' => 2];
        $result[] = ['label' => 3];
        $result[] = ['label' => 4];
        $result[] = ['label' => 5];
        $result[] = ['label' => 6];
        $result[] = ['label' => 7];
        $result[] = ['label' => 8];
        $result[] = ['label' => 9];
        $result[] = ['label' => 10];
        $result[] = ['label' => 11];
        $result[] = ['label' => 12];
        $result[] = ['label' => 13];
        $result[] = ['label' => 14];
        
        $this->mold->set('Chars', $result);
        
        $Truck_Kind = parent::model('Truck_Kind')->getItems();
        $this->mold->set('Truck_Kinds', $Truck_Kind);
        
        $workTitles = parent::model('truck_work_title')->getItems();
        $this->mold->set('workTitles', $workTitles);
        
        if ( request::ispost()) {
            $rules = [
                "Weight" => ["required", rlang('Weight')." ".rlang('Truck')],
                "mainNumberPlate" => ["required", rlang('Weight')." ".rlang('Truck')],
                "Number1Plate" => ["required", rlang('Weight')." ".rlang('Truck')],
                "CharNumberPlate" => ["required", rlang('Weight')." ".rlang('Truck')],
                "Number2Plate" => ["required", rlang('Weight')." ".rlang('Truck')],
                "Truck_Kind" => ["required", rlang('Weight')." ".rlang('Truck')],
            ];
            $valid = validate::check($get, $rules);
            $this->mold->offAutoCompile();
            
            $GLOBALS['timeStart'] = '';
            if ($valid->isFail()){
                Response::jsonMessage($valid->errorsIn(),false);
                return false;
            }

            $model->setMainNumberPlate($get['mainNumberPlate']);
            $model->setNumber1Plate($get['Number1Plate']);
            $model->setCharNumberPlate($get['CharNumberPlate']);
            $model->setNumber2Plate($get['Number2Plate']);
            $model->setWeight($get['Weight']);
            $model->setRegistrar(user::getUserLogin(true));
            $model->setRegisterTime(date('Y-m-d H:i:s'));
            $model->setWork_Title($get['workTitle']);
            $model->setTruck_Kind($get['Truck_Kind']);
            $model->setDriver1($get['driverName1']);
            $model->setDriver1Number($get['driverPhone1']);
            $model->setDriver2($get['driverName2']);
            $model->setDriver2Number($get['driverPhone2']);
            $model->setDriver3($get['driverName3']);
            $model->setDriver3Number($get['driverPhone3']);
            $model->setDescription($get['description']);
            
            $Dis = 'کامیون با نام ';
            $Dis = $Dis . $model->getMainNumberPlate();
            
            if( $id == null and $model->insertToDataBase()){
                $Dis = $Dis . ' ثبت شد';
                $this->callHooks('addLog', [$Dis , 'Truck']);
                
                Response::jsonMessage(rlang('insert') . ' ' .  rlang("successfully") . ' ' .  rlang("was"),true);
                return false;
            }
            elseif( $id != null and $model->upDateDataBase()){
                $Dis = $Dis . ' تغییر یافت';
                $this->callHooks('addLog', [$Dis , 'Truck']);

                Response::jsonMessage(rlang('insert') . ' ' .  rlang("successfully") . ' ' .  rlang("was"),true);
                return false;
            }
            else{
                Response::jsonMessage(rlang('insert') . ' ' .  rlang("fail") . ' ' .  rlang("was"),false);
                return false;
            }            
        }
        
        $this->mold->path('default', 'weighbridge');
        $this->mold->view('Truck.mold.html');
        $this->mold->set('activeMenu' , 'Truck');
        if( $id == null)
            $this->mold->setPageTitle(rlang('insert') . ' ' .  rlang('Truck'));
        elseif( $id != null)
            $this->mold->setPageTitle(rlang('edit') . ' ' .  rlang('Truck'));
    }
    private static function tr_num($str, $mod = 'en') {
		$num_a = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
		$key_a = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
		return ($mod == 'fa') ? str_replace($num_a, $key_a, $str) : str_replace($key_a, $num_a, $str);
	}
}