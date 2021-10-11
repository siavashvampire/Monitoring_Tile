<?php
namespace App\shiftWork\app_provider\admin;

use app\shiftWork\model\shift_time;
use app\shiftWork\model\shift_work;
use controller;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class shiftWork extends controller {
	public function index(){
		$get = request::post('page=1,perEachPage=25,name,shiftWorker' ,null);
		$rules = [
			"page" => ["required|match:>0", rlang('page')],
			"perEachPage" => ["required|match:>0|match:<501", rlang('page')],
		];
		$valid = validate::check($get, $rules);
		$value = array( );
		$variable = array( );
        $value[] = -1 ;
        $variable[] = ' shift_id <> ? ';
		if ($valid->isFail()){
			//TODO:: add error is not valid data

		} else {
			if ( $get['name'] != null ) {
				$value[] = '%'.$get['name'].'%' ;
				$variable[] = ' shift_name Like ? ';
			}
			if ( $get['shiftWorker'] != null ) {
				$value[] = $get['shiftWorker'] ;
				$variable[] = ' taskmaster_id = ? ';
			}

		}

		/* @var shift_work $model */
		$model = parent::model('shift_work');
		$numberOfAll = ($model->search( (array) $value  , ( count($variable) == 0 ) ? null : implode(' and ' , $variable) , null, 'COUNT(shift_id) as co' )) [0]['co'];
		$pagination = parent::pagination($numberOfAll,$get['page'],$get['perEachPage']);
		model::join('user' , 'taskmaster_id = userId');
		$search = $model->search( (array) $value  , ( ( count($variable) == 0 ) ? null : implode(' and ' , $variable) )  , null, '*'  , ['column' => 'shift_name' , 'type' =>'asc'] , [$pagination['start'] , $pagination['limit'] ] );
		$this->mold->path('default', 'shiftWork');
		$this->mold->view('shiftWorkList.mold.html');
		$this->mold->setPageTitle('لیست شیفت ها');
		$this->mold->set('activeMenu' , 'shiftWork');
		$this->mold->set('tiles' , $search);
		$idOfTaskWorker = $this->setting('taskmaster' , 'LineMonitoring');
		$search = $model->search( [$idOfTaskWorker]  , 'user_group_id = ? '  , 'user', '*'  , ['column' => 'fname' , 'type' =>'asc']  );
		$this->mold->set('access' , $search);
	}
    public function getDays(){
		$this->mold->offAutoCompile();
		$GLOBALS['timeStart'] = '';
		$get = request::post('shift_id' ,null);
		/* @var shift_work $model */
		$model = parent::model('shift_work', $get['shift_id']);
		if ( $model->getShiftId() != $get['shift_id']) {
			Response::jsonMessage('شیفت مد نظر یافت نشد!',false);
			return false;
		}
		$search = $model->search( [$model->getShiftId()] ,  'shift_id = ? '  , 'shift_time'  , '' , ['column' => 'shift_time_group' , 'type' =>'asc']);
		Response::jsonMessage(null,true,array('name' => $model->getShiftName() , 'taskmaster'=> $model->getTaskmasterId() , 'times' => $search));
		return false;
	}
	/**
	 * @return bool
	 */
	public function update(){
		$get = request::post('id,name,shiftWorker,weekDayNumber,onDutyTime,offDutyTime,groupId' ,null);
		$rules = [
			"name" => ["required", 'نام شیفت'],
			"shiftWorker" => ["required|int|match:>0", 'سرشیفت'],
			"weekDayNumber.*" => ["required", 'روز'],
			"onDutyTime.*" => ["required", 'شروع شیفت'],
			"offDutyTime.*" => ["required", 'پایان شیفت'],
			"groupId.*" => ["required|int", 'کد گروه'],
		];
		$valid = validate::check($get, $rules);
		$this->mold->offAutoCompile();
		$GLOBALS['timeStart'] = '';
		if ($valid->isFail()){
			Response::jsonMessage($valid->errorsIn(),false);
			return false;
		}
		/* @var shift_work $model */
		if ( $get['id'] != '' ) {
			$model = parent::model('shift_work', $get['id']);
			if ( $model->getShiftId() != $get['id']) {
				Response::jsonMessage('شیفت مد نظر یافت نشد!',false);
				return false;
			}
		} else
			$model = parent::model('shift_work');

		$model->setShiftName($get['name']);
		$model->setTaskmasterId($get['shiftWorker']);
		if ( $get['id'] != '' )
			$model->upDateDataBase();
		else
			$model->insertToDataBase();

		if ( $model->getShiftId() > 0 ) {
			/* @var shift_time $modelTime */
			$modelTime = parent::model('shift_time');
			$modelTime->setShiftId($model->getShiftId());
			$modelTime->deleteAllRow();
			for ( $i = 0 ; $i < count($get['weekDayNumber']) ; $i++ ){
				$modelTime->setOnDay($get['weekDayNumber'][$i]);
				$modelTime->setShiftTimeGroup($get['groupId'][$i]);
				$modelTime->setStartTime(substr($this->tr_num($get['onDutyTime'][$i]) , 0 , 5 ).':00');
				$modelTime->setEndTime(substr($this->tr_num($get['offDutyTime'][$i]) , 0 , 5 ).':59');
				try{
					$modelTime->insertToDataBase();
				} catch(\Exception $e){
					Response::jsonMessage('لطفا مجددا تلاش کنید!',false);
					return false;
				}

			}
            $Dis = 'شیفت ';
            $Dis = $Dis . $model->getShiftName();
            $Dis = $Dis . ' تغییر یافت';
            $this->callHooks('addLog', [$Dis , 'Shifts']);
			Response::jsonMessage('تغییرات انجام شد.', true);
			return false;
		}
		Response::jsonMessage('لطفا مجددا تلاش کنید!',false);
		return false;
	}
	private static function tr_num($str, $mod = 'en') {
		$num_a = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
		$key_a = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
		return ($mod == 'fa') ? str_replace($num_a, $key_a, $str) : str_replace($key_a, $num_a, $str);
	}

}