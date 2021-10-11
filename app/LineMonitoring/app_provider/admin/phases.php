<?php
namespace App\LineMonitoring\app_provider\admin;

use App\core\controller\fieldService;
use App\core\controller\httpErrorHandler;
use app\LineMonitoring\model\sensors;
use App\user\app_provider\api\checkAccess;
use controller;
use Exception;
use paymentCms\component\JDate;
use paymentCms\component\model;
use paymentCms\component\request;
use App\user\app_provider\api\user;
use paymentCms\component\validate;
use paymentCms\component\Response;
use paymentCms\component\arrays;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class phases extends controller {
    public function List(){
		$get = request::post('page=1,perEachPage=25,label,sortWith' ,null);

		$rules = [
			"page" => ["required|match:>0", rlang('page')],
			"perEachPage" => ["required|match:>0|match:<501", rlang('page')],
		];
		$valid = validate::check($get, $rules);
		$value = array( );
		$variable = array( );

		$sortWith = [['column' => 'phases.id' , 'type' =>'asc']] ;
		if ($valid->isFail()){
			//TODO:: add error is not valid data
            
		} else {
			if ( $get['label'] != null ) {
                $value[] = '%'.$get['label'].'%' ;
				$variable[] = ' phases.label Like ? ';
			}
			if ( $get['sortWith'] != null and is_array($get['sortWith']) ) {
				unset($sortWith);
				foreach ($get['sortWith'] as $sort) {
					$temp = explode('|', $sort);
					$sortWith[] = ['column' => $temp[0], 'type' => $temp[1]];
				}
			}

		}
        
		$model = parent::model('phases');
		$numberOfAll = ($model->search( (array) $value  , ( count($variable) == 0 ) ? null : implode(' and ' , $variable) , 'phases phases', 'COUNT(phases.id) as co' )) [0]['co'];
		$pagination = parent::pagination($numberOfAll,$get['page'],$get['perEachPage']);
		$search      = $model->search( (array) $value  , ( ( count($variable) == 0 ) ? null : implode(' and ' , $variable) )  , 'phases phases' , 'phases.*'  , $sortWith , [$pagination['start'] , $pagination['limit'] ] );
        $this->mold->set('items' , $search);
        
        $user = user::getUserLogin();
        $editAccess = checkAccess::index($user['user_group_id'],'admin','phases','index','LineMonitoring')["status"];
        $this->mold->set('editAccess' , $editAccess);
        
		$this->mold->path('default', 'LineMonitoring');
		$this->mold->view('phasesList.mold.html');
		$this->mold->setPageTitle('لیست فازها');
		$this->mold->set('activeMenu' , 'phases');
	}
	public function index($id = null){
        $get = request::post('label,startTime,endTime,budget,budgetDiff,firstDegree,secondDegree,thirdDegree,fourthDegree,fifthDegree,firstDegreePer,secondDegreePer,thirdDegreePer,fourthDegreePer,fifthDegreePer,startTimeSearch,endTimeSearch,Which' ,null);

        if ($id != null)
        {
	        /* @var sensors $VS */
            $model = parent::model('phases',$id);
            
            if ( $model->getId() != $id){
                    httpErrorHandler::E404();
                    return false ;
                }
            
            $modelBudgets = parent::model('phases_budget');
            $modelBudgets->setPhase_id($model->getId());
            
            if ( $get['Which'] == null) {
                $Budgets = $modelBudgets->getPhasesBudget();
            }
            else{
                if ($get['startTimeSearch'] != null and $get['endTimeSearch'] == null){
                    $shamsi = explode('/', $get['startTimeSearch']);
                    $miladi = JDate::jalali_to_gregorian($shamsi[0] , $shamsi[1] , $shamsi[2] , '-');
                    $Budgets = $modelBudgets->getPhasesBudget(null, $miladi,null);
                    $this->mold->set('startTimeSearch', $this->tr_num($get['startTimeSearch'] , 'fa'));
                }
                if ($get['startTimeSearch'] == null and $get['endTimeSearch'] != null){
                    $shamsi = explode('/', $get['endTimeSearch']);
                    $miladi = JDate::jalali_to_gregorian($shamsi[0] , $shamsi[1] , $shamsi[2] , '-');
                    $Budgets = $modelBudgets->getPhasesBudget(null,null,$miladi);
                    $this->mold->set('endTimeSearch', $this->tr_num($get['endTimeSearch'] , 'fa'));
                }
                if ($get['startTimeSearch'] != null and $get['endTimeSearch'] != null){
                    $shamsi = explode('/', $get['startTimeSearch']);
                    $miladi = JDate::jalali_to_gregorian($shamsi[0] , $shamsi[1] , $shamsi[2] , '-');
                    $shamsi = explode('/', $get['endTimeSearch']);
                    $miladi2 = JDate::jalali_to_gregorian($shamsi[0] , $shamsi[1] , $shamsi[2] , '-');
                    $Budgets = $modelBudgets->getPhasesBudget(null,$miladi,$miladi2);
                    $this->mold->set('startTimeSearch', $this->tr_num($get['startTimeSearch'] , 'fa'));
                    $this->mold->set('endTimeSearch', $this->tr_num($get['endTimeSearch'] , 'fa'));
                }
                if ($get['startTimeSearch'] == null and $get['endTimeSearch'] == null){
                    $Budgets = $modelBudgets->getPhasesBudget();
                }
            }
            $this->mold->set('Budgets', $Budgets);
        }
        else
            $model = parent::model('phases');
        
        $this->mold->set('model', $model);
            
        if ( request::ispost()) {
            if ( $get['Which'] == null){
                $rules = [
                    "label" => ["required", 'نام فاز'],
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

                $Dis = 'فاز با نام ';
                $Dis = $Dis . $model->getlabel();
                if( $id == null){
                    $model->insertToDataBase();
                    $Dis = $Dis . ' ثبت شد';
                    $this->callHooks('addLog', [$Dis , 'phase']);
    //                Response::redirect(\App::getBaseAppLink('phases/List/','admin'));
                }
                elseif( $id != null){
                    $model->upDateDataBase();
                    $Dis = $Dis . ' تغییر یافت';
                    $this->callHooks('addLog', [$Dis , 'phase']);
    //                Response::redirect(\App::getBaseAppLink('phases/List/','admin'));
                }
                else{
                    Response::jsonMessage("ثبت فاز با مشکلی مواجه شده است",false);
    //                Response::redirect(\App::getBaseAppLink('phases/'.$id,'admin'));
                }

                if ( $model->getId() > 0) {
                    if ($get['startTime'] != null){
                        $modelBudget = parent::model('phases_budget');                
                        $modelBudget->setPhase_id($model->getId());
                        if ($get['startTimeSearch'] != null and $get['endTimeSearch'] == null){
                            $shamsi = explode('/', $get['startTimeSearch']);
                            $miladi = JDate::jalali_to_gregorian($shamsi[0] , $shamsi[1] , $shamsi[2] , '-');
                            $modelBudget->deleteAllRow(null,$miladi,null);
                        }
                        if ($get['startTimeSearch'] == null and $get['endTimeSearch'] != null){
                            $shamsi = explode('/', $get['endTimeSearch']);
                            $miladi = JDate::jalali_to_gregorian($shamsi[0] , $shamsi[1] , $shamsi[2] , '-');
                            $modelBudget->deleteAllRow(null,null,$miladi);
                        }
                        if ($get['startTimeSearch'] != null and $get['endTimeSearch'] != null){
                            $shamsi = explode('/', $get['startTimeSearch']);
                            $miladi = JDate::jalali_to_gregorian($shamsi[0] , $shamsi[1] , $shamsi[2] , '-');
                            $shamsi = explode('/', $get['endTimeSearch']);
                            $miladi2 = JDate::jalali_to_gregorian($shamsi[0] , $shamsi[1] , $shamsi[2] , '-');
                            $modelBudget->deleteAllRow(null,$miladi,$miladi2);
                        }
                        if ($get['startTimeSearch'] == null and $get['endTimeSearch'] == null){
                            $modelBudget->deleteAllRow();
                        }

                        for ( $i = 0 ; $i < count($get['startTime']) ; $i++ ){
                            if ($get['startTime'][$i] != ""){
                                $shamsi = explode('/', $get['startTime'][$i]);
                                $miladiS[$i] = JDate::jalali_to_gregorian($shamsi[0] , $shamsi[1] , $shamsi[2] , '-');
                                $modelBudget->setStartTime($miladiS[$i]);
                                $modelBudget->setJStartTime($get['startTime'][$i]);
                                $shamsi = explode('/', $get['endTime'][$i]);
                                $miladiE[$i] = JDate::jalali_to_gregorian($shamsi[0] , $shamsi[1] , $shamsi[2] , '-');
                                $modelBudget->setEndTime($miladiE[$i]);
                                $modelBudget->setJEndTime($get['endTime'][$i]);

                                $modelBudget->setBudget($get['budget'][$i]);
                                $modelBudget->setBudgetDiff($get['budgetDiff'][$i]);

                                $modelBudget->setFirstDegree($get['firstDegree'][$i]);
                                $modelBudget->setSecondDegree($get['secondDegree'][$i]);
                                $modelBudget->setThirdDegree($get['thirdDegree'][$i]);
                                $modelBudget->setFourthDegree($get['fourthDegree'][$i]);
                                $modelBudget->setFifthDegree($get['fifthDegree'][$i]);
                                $modelBudget->setFirstDegreePer($get['firstDegreePer'][$i]);
                                $modelBudget->setSecondDegreePer($get['secondDegreePer'][$i]);
                                $modelBudget->setThirdDegreePer($get['thirdDegreePer'][$i]);
                                $modelBudget->setFourthDegreePer($get['fourthDegreePer'][$i]);
                                $modelBudget->setFifthDegreePer($get['fifthDegreePer'][$i]);
                                $miladiE[$i] = strtotime($miladiE[$i]);
                                $miladiS[$i] = strtotime($miladiS[$i]);

                                if ($modelBudget->getBudget() <= $modelBudget->getBudgetDiff()){
        //                            $modelBudget->deleteAllRow();
                                    Response::jsonMessage(arrays::dataToStrArray(rlang('BudgetDifferenceError'), $i+1),false);
                                    return false;
                                } 
                                if (!($modelBudget->getBudget() == $modelBudget->getFirstDegree() + $modelBudget->getSecondDegree() + $modelBudget->getThirdDegree() + $modelBudget->getFourthDegree() + $modelBudget->getFifthDegree())){
        //                            $modelBudget->deleteAllRow();
                                    Response::jsonMessage(arrays::dataToStrArray(rlang('TotalCountError'), $i+1),false);
                                    return false;
                                } 
                                if (!($miladiE[$i] >= $miladiS[$i])){
        //                            $modelBudget->deleteAllRow();
                                    Response::jsonMessage(arrays::dataToStrArray(rlang('StartEndTimeError'), $i+1),false);
                                    return false;
                                } 
                                try{
                                    $modelBudget->insertToDataBase();
                                } catch(Exception $e){
                                    $modelBudget->deleteAllRow();
                                    Response::jsonMessage(rlang('pleaseTryAGain'),false);
                                    return false;
                                }
                            }
                        }


                        for ( $i = 0 ; $i < count($miladiS) ; $i++ ){
                            for ( $j = 0 ; $j < count($miladiS) ; $j++ ){
                                if ($i != $j){
                                    if ($miladiS[$i] != "" and $miladiE[$i] != ""){
                                        if (($miladiS[$i] >= $miladiS[$j] and $miladiS[$i] <= $miladiE[$j]) or ($miladiE[$i] >= $miladiS[$j] and $miladiE[$i] <= $miladiE[$j])){
        //                                    $modelBudget->deleteAllRow();
                                            Response::jsonMessage(arrays::dataToStrArray(rlang('StartEndTimeInterfrenceError'), [$j+1, $i+1]),false);
                                            return false;
                                        }
                                    }
                                }
                            }
                        }
                    }

                    Response::jsonMessage("ثبت فاز با موفقیت انجام شد",true);
                    return false;
                }
                Response::jsonMessage(rlang('pleaseTryAGain'),false);
                return false; 
            }
        }
        
        $this->mold->path('default', 'LineMonitoring');
        $this->mold->view('phases.mold.html');
        $this->mold->set('activeMenu' , 'phases');
        if( $id == null)
            $this->mold->setPageTitle(rlang('insert') . ' ' .  rlang('phase'));
        elseif( $id != null)
            $this->mold->setPageTitle(rlang('edit') . ' ' .  rlang('phase'));
    }
    private static function tr_num($str, $mod = 'en') {
		$num_a = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
		$key_a = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
		return ($mod == 'fa') ? str_replace($num_a, $key_a, $str) : str_replace($key_a, $num_a, $str);
	}
}