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

class quotes extends controller {
    public function List($id=null){
		$get = request::post('page=1,perEachPage=25,label,sortWith' ,null);
        
		$rules = [
			"page" => ["required|match:>0", rlang('page')],
			"perEachPage" => ["required|match:>0|match:<501", rlang('page')],
		];
		$valid = validate::check($get, $rules);
		$value = array( );
		$variable = array( );

		$sortWith = [['column' => 'quotes.id' , 'type' =>'asc']] ;
		if ($valid->isFail()){
			//TODO:: add error is not valid data
            
		} else {
			if ( $get['label'] != null ) {
                $value[] = '%'.$get['label'].'%' ;
				$variable[] = ' quotes.label Like ? ';
			}
            if ( $id != null ) {
                $value[] = $id ;
				$variable[] = ' quotes.device_id = ? ';
			}
			if ( $get['sortWith'] != null and is_array($get['sortWith']) ) {
				unset($sortWith);
				foreach ($get['sortWith'] as $sort) {
					$temp = explode('|', $sort);
					$sortWith[] = ['column' => $temp[0], 'type' => $temp[1]];
				}
			}

		}
        
		$model = parent::model('quotes');
		$numberOfAll = ($model->search( (array) $value  , ( count($variable) == 0 ) ? null : implode(' and ' , $variable) , 'quotes quotes', 'COUNT(quotes.id) as co' )) [0]['co'];
		$pagination = parent::pagination($numberOfAll,$get['page'],$get['perEachPage']);
        
        model::join('devices  devices','devices.id = quotes.device_id');
		$search      = $model->search( (array) $value  , ( ( count($variable) == 0 ) ? null : implode(' and ' , $variable) )  , 'quotes quotes' , 'quotes.*,devices.label as device_Name'  , $sortWith , [$pagination['start'] , $pagination['limit'] ] );
        $this->mold->set('items' , $search);
        
        $user = user::getUserLogin();
        $editAccess = checkAccess::index($user['user_group_id'],'admin','quotes','index','PictureIT')["status"];
        $this->mold->set('editAccess' , $editAccess);
        
		$this->mold->path('default', 'PictureIT');
		$this->mold->view('quotesList.mold.html');
		$this->mold->setPageTitle(rlang('quotes'));
		$this->mold->set('activeMenu' , 'quotes');
	}
	public function index($id = null){
        $get = request::post('device_id,label' ,null);
        if ($id != null)
        {
            $model = parent::model('quotes',$id);
            
            if ( $model->getId() != $id){
                    httpErrorHandler::E404();
                    return false ;
                }
        }
        else
            $model = parent::model('quotes');
        
        $this->mold->set('model', $model);
            
        if ( request::ispost()) {
            $rules = [
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
            $model->setDevice_id($get['device_id']);
            $model->setSend_Time(date('Y-m-d H:i:s'));
            $Dis = 'متن با نام ';
            $Dis = $Dis . $model->getlabel();
            if( $id == null and $model->insertToDataBase()){
                $Dis = $Dis . ' ثبت شد';
                $this->callHooks('addLog', [$Dis , 'quotes']);

                Response::jsonMessage("insert successfully",true);
                return false;
            }
            elseif( $id != null and $model->upDateDataBase()){
                $Dis = $Dis . ' تغییر یافت';
                $this->callHooks('addLog', [$Dis , 'quotes']);

                Response::jsonMessage("insert successfully",true);
                return false;
            }
            else{
                Response::jsonMessage("Problem in Insert",false);
            }            
        }
        
        $this->mold->set('devices', parent::model('devices')->getDevices());
        
        $this->mold->path('default', 'PictureIT');
        $this->mold->view('quotes.mold.html');
        $this->mold->set('activeMenu' , 'quotes');
        if( $id == null)
            $this->mold->setPageTitle('insert' . ' ' .  rlang('quote'));
        elseif( $id != null)
            $this->mold->setPageTitle('edit' . ' ' .  rlang('quote'));
    }
    private static function tr_num($str, $mod = 'en') {
		$num_a = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
		$key_a = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
		return ($mod == 'fa') ? str_replace($num_a, $key_a, $str) : str_replace($key_a, $num_a, $str);
	}
}