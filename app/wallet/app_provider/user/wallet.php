<?php

namespace App\wallet\app_provider\user ;
use App\core\controller\httpErrorHandler;
use App\invoice\app_provider\api\invoice;
use App\user\app_provider\api\user;
use controller;
use paymentCms\component\request;
use paymentCms\component\Response;

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
		$canDeposit = parent::setting('canDeposit','wallet');
		if ( $canDeposit != 'yes' )
			$this->alert('danger', '',rlang('cantDeposit'));

		$userLogin = user::getUserLogin(true);
		$walletPrice = \App\wallet\app_provider\api\wallet::getWalletPrice($userLogin);
		if ( $walletPrice['status'] == false ){
			$this->mold->offAutoCompile();
			httpErrorHandler::E404();
			return false;
		}
		if ( request::isPost('price') ){
			$charge = \App\wallet\app_provider\api\wallet::chargeWallet(['userId' => $userLogin , 'price' =>request::postOne('price'), 'module' =>request::postOne('radioBank')]);
			if (! $charge['status'] ){
				if ( $charge['massage'] == 'cantDeposit')
					$this->alert('danger', '',rlang('cantDeposit'));
				elseif ( $charge['massage'] == 'pleaseTryAgainLater')
					$this->alert('danger', '',rlang('pleaseTryAgainLater'));
				else
					$this->alert('danger', '',$charge['massage']);
			} else {
				Response::redirect($charge['result']['link']);
			}
		}
		$module = invoice::getPaymentModule();
		$this->mold->set('module' , $module['result']);
		$this->mold->path('default', 'wallet');
		$this->mold->view('deposit.mold.html');
		$this->mold->set('cash' , $walletPrice['result']);
		$this->mold->setPageTitle(rlang(['charge','wallet'] ));
	}

	public function lists(){
		$userLoginId = user::getUserLogin(true);
		$userLogin = user::getUserById($userLoginId);
		if ($userLogin->getUserId() == null or $userLoginId == null ){
			$this->mold->offAutoCompile();
			httpErrorHandler::E404();
			return false;
		}
		$walletPrice = \App\wallet\app_provider\api\wallet::lists($_POST,$userLogin);
		$this->mold->path('default', 'wallet');
		$this->mold->view('actionListClient.mold.html');
		$this->mold->set('invoices' , $walletPrice['result']['result']);
		$this->mold->set('pagination' , ['total' => $walletPrice['result']['pagination']['total'] ,'perEachPage' =>  $walletPrice['result']['pagination']['perEachPage'] , 'currentPage' =>  $walletPrice['result']['pagination']['currentPage']]);
		$this->mold->setPageTitle(rlang(['list','transactions','transactions'] ));
	}

	public function requestWithdraw(){
		$canDeposit = parent::setting('canWithDraw','wallet');
		if ( $canDeposit != 'yes' )
			$this->alert('danger', '',rlang('cantWithDraw'));

		$userLogin = user::getUserLogin(true);
		if ( request::isPost('price') ){
			$charge = \App\wallet\app_provider\api\wallet::requestWithdraw($userLogin,$_POST);
			if (! $charge['status'] ){
				if ( $charge['massage'] == 'cantWithDraw')
					$this->alert('danger', '',rlang('cantWithDraw'));
				elseif ( $charge['massage'] == 'pleaseTryAgainLater')
					$this->alert('danger', '',rlang('pleaseTryAgainLater'));
				else
					$this->alert('danger', '',$charge['massage']);
			} else {
				$this->alert('success', '' , rlang('requestSent'));
			}
		}
		$walletInfo = \App\wallet\app_provider\api\wallet::getWithdrawInfo($userLogin);
		if ( $walletInfo['status'] == false ){
			$this->mold->offAutoCompile();
			httpErrorHandler::E404();
			return false;
		}
		$this->mold->path('default', 'wallet');
		$this->mold->view('withDraw.mold.html');
		$this->mold->set('cash' , $walletInfo['result']['wallet']);
		$this->mold->set('info' , $walletInfo['result']);
		$this->mold->setPageTitle(rlang('requestWithdraw'));
	}
}