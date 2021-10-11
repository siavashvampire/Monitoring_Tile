<?php

namespace App\wallet\app_provider\admin ;
use App\user\app_provider\api\user;
use App\wallet\model\user_wallet;
use App\wallet\model\wallet_action;
use controller;
use paymentCms\component\JDate;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\strings;
use paymentCms\component\validate;

/**
 * Created by Yeganehha .
 * User: Erfan Ebrahimi (http://ErfanEbrahimi.ir)
 * Date: 3/12/2020
 * Time: 7:16 PM
 * project : payment
 * virsion : 0.0.0.1
 * update Time : 3/12/2020 - 7:16 PM
 * Discription of this Page :
 */


if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');


class wallet extends controller {
	public function index(){
		$get = request::post('page=1,perEachPage=15,description,walletId,userId,price,status,startDate,endDate' ,null);
		$rules = [
			"page" => ["required|match:>0", rlang('page')],
			"perEachPage" => ["required|match:>0|match:<501", rlang('page')],
		];
		$value = array( 1);
		$variable = array( ' ? ' );
		$valid = validate::check($get, $rules);
		if ($valid->isFail()){
			$get['page'] = 1 ;
			$get['perEachPage'] = 15 ;
		} else {
			if ( $get['description'] != null ) {
				$value[] = '%'.$get['description'].'%';
				$variable[] = ' wallet.description LIKE ?';
			}
			if ( $get['userId'] != null ) {
				$value[] = $get['userId'];
				$variable[] = ' wallet.userId = ?';
			}
			if ( $get['walletId'] != null ) {
				$value[] = $get['walletId'];
				$variable[] = ' wallet.actionId = ?';
			}
			if ( $get['price'] != null ) {
				$value[] = $get['price'];
				$variable[] = ' wallet.price = ?';
			}
			if ( $get['startDate'] != null and $get['endDate'] == null ) {
				$offDuty = explode('-',$get['startDate']);
				$date = JDate::jalali_to_gregorian($offDuty[0],$offDuty[1],$offDuty[2],'-');
				$value[] = $date;
				$variable[] = ' wallet.dateAction >= ?';
			} elseif ( $get['startDate'] == null and $get['endDate'] != null ) {
				$offDuty = explode('-',$get['endDate']);
				$date = JDate::jalali_to_gregorian($offDuty[0],$offDuty[1],$offDuty[2],'-');
				$value[] = $date;
				$variable[] = ' wallet.dateAction <= ?';
			} elseif ( $get['startDate'] != null and $get['endDate'] != null ) {
				$offDuty = explode('-',$get['startDate']);
				$date = JDate::jalali_to_gregorian($offDuty[0],$offDuty[1],$offDuty[2],'-');
				$value[] = $date;
				$offDuty = explode('-',$get['endDate']);
				$date = JDate::jalali_to_gregorian($offDuty[0],$offDuty[1],$offDuty[2],'-');
				$value[] = $date;
				$variable[] = ' wallet.dateAction between ? And ? ';
			}
			if ( $get['status'] != null ) {
				$value = array_merge($value, (array) $get['status'] );
				$variable[] = ' wallet.status in ( '.strings::deleteWordLastString(str_repeat(' ? , ', count($get['clinicId'])), ' , ') . ') ';
			}
		}
		/* @var wallet_action $model */

		$model = parent::model(['wallet','wallet_action']);
		$numberOfAll = ($model->search( $value  ,  implode(' and ' , $variable) , 'wallet_action wallet', 'COUNT(wallet.actionId) as co' )) [0]['co'];
		$pagination = parent::pagination($numberOfAll,$get['page'],$get['perEachPage']);

		model::join('user user' , 'wallet.userId = user.userId' );
		$search = $model->search( $value  ,  implode(' and ' , $variable)    , 'wallet_action wallet', 'wallet.*,user.fname,user.lname'  , ['column' => 'wallet.actionId' , 'type' =>'desc'] , [$pagination['start'] , $pagination['limit'] ] );

		$this->mold->path('default', 'wallet');
		$this->mold->view('listTransactionAdmin.mold.html');
		$this->mold->set('invoices' , $search);
		$this->mold->set('pagination' ,$pagination);
		$this->mold->setPageTitle(rlang(['list','transactions','transactions'] ));
	}


	public function withdraws(){
		$get = request::post('page=1,perEachPage=15,description,walletId,userId,price,status,startDate,endDate' ,null);
		$rules = [
			"page" => ["required|match:>0", rlang('page')],
			"perEachPage" => ["required|match:>0|match:<501", rlang('page')],
		];
		$value = array( 'withdrawRequest' );
		$variable = array( ' wallet.status = ? ' );
		$valid = validate::check($get, $rules);
		if ($valid->isFail()){
			$get['page'] = 1 ;
			$get['perEachPage'] = 15 ;
		} else {
			if ( $get['description'] != null ) {
				$value[] = '%'.$get['description'].'%';
				$variable[] = ' wallet.description LIKE ?';
			}
			if ( $get['userId'] != null ) {
				$value[] = $get['userId'];
				$variable[] = ' wallet.userId = ?';
			}
			if ( $get['walletId'] != null ) {
				$value[] = $get['walletId'];
				$variable[] = ' wallet.actionId = ?';
			}
			if ( $get['price'] != null ) {
				$value[] = $get['price'];
				$variable[] = ' wallet.price = ?';
			}
			if ( $get['startDate'] != null and $get['endDate'] == null ) {
				$offDuty = explode('-',$get['startDate']);
				$date = JDate::jalali_to_gregorian($offDuty[0],$offDuty[1],$offDuty[2],'-');
				$value[] = $date;
				$variable[] = ' wallet.dateAction >= ?';
			} elseif ( $get['startDate'] == null and $get['endDate'] != null ) {
				$offDuty = explode('-',$get['endDate']);
				$date = JDate::jalali_to_gregorian($offDuty[0],$offDuty[1],$offDuty[2],'-');
				$value[] = $date;
				$variable[] = ' wallet.dateAction <= ?';
			} elseif ( $get['startDate'] != null and $get['endDate'] != null ) {
				$offDuty = explode('-',$get['startDate']);
				$date = JDate::jalali_to_gregorian($offDuty[0],$offDuty[1],$offDuty[2],'-');
				$value[] = $date;
				$offDuty = explode('-',$get['endDate']);
				$date = JDate::jalali_to_gregorian($offDuty[0],$offDuty[1],$offDuty[2],'-');
				$value[] = $date;
				$variable[] = ' wallet.dateAction between ? And ? ';
			}
		}
		/* @var wallet_action $model */

		$model = parent::model(['wallet','wallet_action']);
		$numberOfAll = ($model->search( $value  ,  implode(' and ' , $variable) , 'wallet_action wallet', 'COUNT(wallet.actionId) as co' )) [0]['co'];
		$pagination = $this->pagination($numberOfAll,$get['page'],$get['perEachPage']);
		model::join('user user' , 'wallet.userId = user.userId' );
		$search = $model->search( $value  ,  implode(' and ' , $variable)    , 'wallet_action wallet', 'wallet.*,user.fname,user.lname'  , ['column' => 'wallet.actionId' , 'type' =>'desc'] , [$pagination['start'] , $pagination['limit'] ] );

		$this->mold->path('default', 'wallet');
		$this->mold->view('listWithDrowAdmin.mold.html');
		$this->mold->set('invoices' , $search);
		$this->mold->set('pagination' ,$pagination);
		$this->mold->setPageTitle(rlang(['list','requestWithdraw'] ));
	}


	function acceptWithDraw(){
		$get = request::post('actionId,status=1,description' ,null);
		$rules = [
			"actionId" => ["required|match:>0", rlang('actionId')],
			"status" => ["required|match:>=0|match:=<1", rlang('status')],
		];
		$valid = validate::check($get, $rules);
		if ($valid->isFail()){
			$this->alert('danger','',$valid->errorsIn());
			return false;
		}
		/* @var wallet_action $model */

		$model = parent::model(['wallet','wallet_action'] , $get['actionId']);
		if ($model->getActionId() != $get['actionId']){
			$this->alert('danger','',rlang('cantFindActionId'));
			return false;
		}
		if ( $get['status'] ){
			$model->setStatus('withdrawAccept');
			if ( $get['description'] != '')
				$model->setDescription( $model->getDescription()."\n".rlang('transactionCode').' : '.$get['description'] );
			if ( $model->upDateDataBase() ) {
				$user = user::getUserById($model->getUserId());
				$this->callHooks('sendSms', ['phone' => $user->getPhone(), 'text' => rlang('withdrawAcceptSmsPrice').$model->getPrice().rlang('withdrawAcceptSmsTransactionCode').$model->getActionId(), 'type' => 'withDrawRequestAccept']);
				$this->alert('success','',rlang('withdrawAcceptAdmin'));
				return false;
			}
		} else {
			$model->setStatus('withdrawReject');
			if ( $get['description'] != '')
				$model->setDescription( $model->getDescription()."\n".rlang('description').' : '.$get['description'] );
			if ( $model->upDateDataBase() ) {
				/* @var user_wallet $user_wallet */
				$user_wallet = parent::model(['wallet','user_wallet'] , $model->getUserId());
				$user_wallet->setWallet( $user_wallet->getWallet() + $model->getPrice() );
				if ( $user_wallet->upDateDataBase() ){
					$user = user::getUserById($model->getUserId());
					$this->callHooks('sendSms', ['phone' => $user->getPhone(), 'text' => rlang('withdrawRejectSmsCode').$model->getActionId().rlang('withdrawRejectSmsDescription').$get['description'], 'type' => 'withDrawRequestReject']);
					$this->alert('success','',rlang('withdrawRejectAdmin'));
					return false;
				}
				$user = user::getUserById($model->getUserId());
				$this->callHooks('sendSms', ['phone' => $user->getPhone(), 'text' => rlang('withdrawRejectSmsCode').$model->getActionId().rlang('withdrawRejectSmsDescription').$get['description'], 'type' => 'withDrawRequestReject']);
				$this->alert('danger','',rlang('withdrawRejectButHasError').' '.$model->getActionId() );
				return false;
			}
		}
		$this->alert('danger','',rlang('pleaseTryAGain') );
		return false;
	}

}