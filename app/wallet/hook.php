<?php


namespace App\wallet;

use app;
use App\invoice\app_provider\api\invoice;
use App\invoice\model\transactions;
use App\user\app_provider\api\user;
use App\wallet\model\user_wallet;
use App\wallet\model\wallet_action;
use paymentCms\component\cache;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\security;
use paymentCms\component\strings;
use pluginController;

/**
 * Created by Yeganehha .
 * User: Erfan Ebrahimi (http://ErfanEbrahimi.ir)
 * Date: 4/16/2019
 * Time: 11:16 AM
 * project : paymentCMS
 * virsion : 0.0.0.1
 * update Time : 4/16/2019 - 11:16 AM
 * Discription of this Page :
 */




if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');


class hook extends pluginController {

	public function _adminHeaderNavbar($vars2){
		$this->menu->addChild('invoices','listWalletActions' , rlang(['list','transactions','wallet'] ) , app::getBaseAppLink('wallet','admin')  );
		$this->menu->after('invoices','listWalletWithDraw' , rlang(['list','requestWithdraw']) , app::getBaseAppLink('wallet/withdraws','admin') , 'fa fa-bank' );

	}

	/**
	 * add menu for client area
	 */
	public function _clientMenu() {
		$user = user::getUserLogin();
		if ($user == false) return;
		$this->menu->after('invoices','wallet' , rlang('wallet' ) , app::getBaseAppLink('wallet','user') , 'mdi mdi-credit-card-plus' );
		$canDeposit = parent::setting('canDeposit','wallet' , true);
		if ( $canDeposit == 'yes' )
			$this->menu->addChild('wallet','depositWallet' , rlang(['charge','wallet'] ) , app::getBaseAppLink('wallet','user'));
		$this->menu->addChild('wallet','listWithdraw' , rlang(['list','transactions','wallet'] ) , app::getBaseAppLink('wallet/lists','user')  );
		$canWithDraw = parent::setting('canWithDraw','wallet' , true);
		if ( $canWithDraw == 'yes' )
			$this->menu->addChild('wallet','requestWallet' , rlang('requestWithdraw' ) , app::getBaseAppLink('wallet/requestWithdraw','user')  );


	}

	public function _walletChargeAccept($actionId , $invoice){
		/* @var wallet_action $model */
		$model = $this->model(['wallet', 'wallet_action'] ,$actionId , 'actionId = ? ');
		$model->setStatus('deposit');
		if ( $model->upDateDataBase() ) {
			/* @var user_wallet $modelUser */
			$modelUser = $this->model(['wallet', 'user_wallet'] ,$model->getUserId());
			$modelUser->setWallet($modelUser->getWallet() + $model->getPrice() );
			$modelUser->upDateDataBase();
		}
	}

	public function _invoiceGateWays(){
		if ( user::getUserLogin(true) > 0 )
			return rlang('payInvoiceWithWallet') ;
	}

	public function _wallet_startTransaction($transaction){
		if ( user::getUserLogin(true) > 0 ) {
			/* @var transactions $transaction */
			$show['status'] = true;
			$show['massage'] = 'send';
			$show['link'] = invoice::generateCallBackUrl($transaction->getTransactionId());
			$show['type'] = 'post';
			$show['inputs']['CallbackURL'] = invoice::generateCallBackUrl($transaction->getTransactionId());
			$show['inputs']['price'] = $transaction->getPrice();
			$show['inputs']['userId'] = user::getUserLogin(true);
			$show['inputs']['hash'] = security::encrypt($show['inputs']['price'].'_'.$show['inputs']['userId']);
			$show['codeOne'] = time();
			$show['codeTwo'] = '';
			return $show;
		} else {
			$show['status'] = false;
			$show['massage'] = 'userNotLogin';
			return $show;
		}
	}

	public function _wallet_checkTransaction($transaction){
		/* @var transactions $transaction */
		if ( security::encrypt(request::postOne('price').'_'.request::postOne('userId') ) == request::postOne('hash') ){

			/* @var user_wallet $modelInfo */
			$modelInfo = $this->model(['wallet','user_wallet'] , request::postOne('userId'));

			if ( $modelInfo->getWallet() < request::postOne('price') ){
				$show['status'] = true ;
				$show['payStatus'] = false ;
				$show['payStatusType'] = 'canceled';
				$show['massage'] =  'ERROR!(don\'t have enough money)' ;
				$show['codeOne'] = time() ;
				$show['codeTwo'] = null  ;
				return $show;
			}

			/* @var wallet_action $model */
			$model = $this->model(['wallet','wallet_action'] );
			$model->setUserId(request::postOne('userId'));
			$model->setStatus('withdrawAccept');
			$model->setInvoiceId($transaction->getInvoiceId());
			$model->setPrice(request::postOne('price'));
			$model->setTimeAction(date('H:i:s'));
			$model->setDateAction(date('Y-m-d'));
			$model->setIp(getIP());
			$model->setDescription(rlang('payInvoiceWithWallet') );
			if ( $model->insertToDataBase() ) {
				$modelInfo->setWallet( $modelInfo->getWallet() - request::postOne('price'));
				if ( $modelInfo->upDateDataBase() ){
					$show['status'] = true ;
					$show['payStatus'] = true ;
					$show['massage'] = 'paid' ;
					$show['codeOne'] = $model->getActionId() ;
					$show['codeTwo'] = ''  ;
					return $show;
				} else {
					$show['status'] = true ;
					$show['payStatus'] = false ;
					$show['payStatusType'] = 'canceled';
					$show['massage'] =  'ERROR!(cant Update Wallet)' ;
					$show['codeOne'] = time() ;
					$show['codeTwo'] = null  ;
					return $show;
				}
			} else {
				$show['status'] = true ;
				$show['payStatus'] = false ;
				$show['payStatusType'] = 'canceled';
				$show['massage'] =  'ERROR!(cant insert Wallet Action)' ;
				$show['codeOne'] = time() ;
				$show['codeTwo'] = null  ;
				return $show;
			}
		} else {
			$show['status'] = true ;
			$show['payStatus'] = false ;
			$show['payStatusType'] = 'canceled';
			$show['massage'] =  'ERROR!(data not valid)' ;
			$show['codeOne'] = time() ;
			$show['codeTwo'] = null  ;
			return $show;
		}
	}
}