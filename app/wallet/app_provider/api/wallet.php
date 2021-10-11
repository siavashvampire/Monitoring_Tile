<?php

namespace App\wallet\app_provider\api ;
use App;
use App\api\controller\innerController;
use App\invoice\app_provider\api\invoice;
use App\user\app_provider\api\user;
use App\wallet\model\user_wallet;
use App\wallet\model\wallet_action;
use paymentCms\component\model;
use paymentCms\component\request;
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


class wallet extends innerController {

	public static function chargeWallet($data = null ){
		if ( $data == null )
			$data = $_POST;

		$canDeposit = parent::setting('canDeposit','wallet');
		if ( $canDeposit != 'yes' )
			return parent::jsonError('cantDeposit');

		$maxDeposit = parent::setting('maxDepositMoney','wallet');
		$minDeposit = parent::setting('lowDepositMoney','wallet');
		$data = request::getFromArray($data,'userId,price,module');
		$rules = [
			"userId" => ["required|match:>0", rlang('userId')],
			"price" => ["required|match:>=".$minDeposit."|match:<=".$maxDeposit, rlang('price')],
			"module" => ["required", rlang('payWith')],
		];
		$valid = validate::check($data, $rules);
		if ($valid->isFail()){
			return parent::jsonError($valid->errorsIn());
		}
		/* @var wallet_action $model */
		$model = parent::model('wallet_action' );
		$model->setUserId($data['userId']);
		$model->setStatus('pending');
		$model->setInvoiceId(null);
		$model->setPrice($data['price']);
		$model->setTimeAction(date('H:i:s'));
		$model->setDateAction(date('Y-m-d'));
		$model->setIp(getIP());
		$model->setDescription(rlang('chargeUser'));
		if ( $model->insertToDataBase() ) {
			$_SERVER['JsonOff'] =false;
			$user = user::getUserById($data['userId']);
			$invoiceData = [
				'firstName' => $user->getFname(),
				'lastName' => $user->getLname(),
				'phone' => $user->getPhone(),
				'price' => $data['price'],
				'description' => rlang('chargeUser') . ' #'.$model->getActionId() ,
				'gatewayModule' => $data['module'],
				'hookAction' => 'walletChargeAccept,' . $model->getActionId(),
				'returnTo' => App::getBaseAppLink('wallet/lists/payed', 'user')
			];
			$invoice = invoice::generate(null, $invoiceData);
			unset($_SERVER['JsonOff']);
			if ( $invoice['status']){
				$model->setInvoiceId($invoice['result']['id']);
				$model->upDateDataBase();
				return self::json(['id' => $model->getActionId() , 'link' => $invoice['result']['link'].'/pay' ]);
			} else {
				$model->deleteFromDataBase();
				return self::jsonError($invoice['massage']);
			}
		} else
			return parent::jsonError('pleaseTryAgainLater');
	}

	/**
	 * @param $userDoThis
	 * @param $userId
	 * @param $price
	 * @param $description
	 *                    [no-access]
	 *
	 * @return bool
	 */
	public static function addToWallet($userDoThis,$userId,$price,$description){
		/* @var wallet_action $model */
		$model = parent::model(['wallet','wallet_action'] );
		$model->setUserId($userId);
		$model->setStatus('deposit');
		$model->setInvoiceId(null);
		$model->setPrice($price);
		$model->setTimeAction(date('H:i:s'));
		$model->setDateAction(date('Y-m-d'));
		$model->setIp(getIP());
		$model->setDescription($description.' ('. rlang('from') .' #'.$userDoThis .')');
		if ( $model->insertToDataBase() ){
			/* @var user_wallet $modelUser */
			$modelUser = parent::model(['wallet','user_wallet'] ,$model->getUserId());
			$modelUser->setWallet($modelUser->getWallet() + $model->getPrice() );
			if ( $modelUser->upDateDataBase() )
				return true ;
		}
		return false ;
	}

	/**
	 * @param $userDoThis
	 * @param $userId
	 * @param $price
	 * @param $description
	 *                    [no-access]
	 *
	 * @return bool
	 */
	public static function reduceFromWallet($userDoThis, $userId, $price, $description){
		/* @var wallet_action $model */
		$model = parent::model(['wallet','wallet_action'] );
		$model->setUserId($userId);
		$model->setStatus('withdrawAccept');
		$model->setInvoiceId(null);
		$model->setPrice($price);
		$model->setTimeAction(date('H:i:s'));
		$model->setDateAction(date('Y-m-d'));
		$model->setIp(getIP());
		$model->setDescription($description.' ('. rlang('from') .' #'.$userDoThis .')');
		if ( $model->insertToDataBase() ){
			/* @var user_wallet $modelUser */
			$modelUser = parent::model(['wallet','user_wallet'] ,$model->getUserId());
			$modelUser->setWallet($modelUser->getWallet() - $model->getPrice() );
			if ( $modelUser->upDateDataBase() )
				return true ;
		}
		return false ;
	}



	public static function lists($data = null , $user = null){
		if ( $data == null )
			$data = $_POST;

		if ( $user == null )
			$user = parent::getUserApiFromToken();
		$get = request::getFromArray($data,'page=1,perEachPage=15' ,null);
		$rules = [
			"page" => ["required|match:>0", rlang('page')],
			"perEachPage" => ["required|match:>0|match:<501", rlang('page')],
		];
		$valid = validate::check($get, $rules);
		if ($valid->isFail()){
			$get['page'] = 1 ;
			$get['perEachPage'] = 15 ;
		}
		/* @var wallet_action $model */

		$model = parent::model(['wallet','wallet_action']);
		$numberOfAll = ($model->search( [$user->getUserId()]  ,  ' userId = ? and  status != "pending" ' , null, 'COUNT(actionId) as co' )) [0]['co'];
		$pagination = parent::pagination($numberOfAll,$get['page'],$get['perEachPage']);

		$search = $model->search([$user->getUserId()]  , ' userId = ? and status != "pending" '   , null, '*'  , ['column' => 'actionId' , 'type' =>'desc'] , [$pagination['start'] , $pagination['limit'] ] );
		return parent::json(['pagination' => $pagination , 'result' => $search ] );
	}

	public static function getWalletPrice($userId = null){

		if ( $userId == null ) {
			$user = parent::getUserApiFromToken();
			$userId = $user->getUserId();
		}

		/* @var user_wallet $model */
		$model = parent::model('user_wallet' , $userId);
		if ( $model->getUserId() == null ) {
			$model->setUserId($userId);
			$model->setWallet(0);
			if ( $model->insertToDataBase() ){
				return parent::json($model->getWallet());
			} else
				return parent::jsonError('cantMakeWallet');
		} elseif ( $model->getUserId() != $userId ) {
			return parent::jsonError('userNotFound');
		}
		return parent::json($model->getWallet());
	}

	public static function getWithdrawInfo($userId = null){


		if ( $userId == null ) {
			$user = parent::getUserApiFromToken();
			$userId = $user->getUserId();
		}

		/* @var user_wallet $model */
		$model = parent::model(['wallet','user_wallet'] , $userId);
		if ( $model->getUserId() == null ) {
			$model->setUserId($userId);
			$model->setWallet(0);
			if ( $model->insertToDataBase() ){
				return parent::json($model->returnAsArray());
			} else
				return parent::jsonError('cantMakeWallet');
		} elseif ( $model->getUserId() != $userId ) {
			return parent::jsonError('userNotFound');
		}
		return parent::json($model->returnAsArray());
	}


	public static function requestWithdraw($userId = null , $data = null ){

		if ( $userId == null ) {
			$user = parent::getUserApiFromToken();
			$userId = $user->getUserId();
		}

		if ( $data == null )
			$data = $_POST;

		/* @var user_wallet $modelInfo */
		$modelInfo = parent::model('user_wallet' , $userId);
		if ( $modelInfo->getUserId() != $userId )
			return parent::jsonError('userNotFound');

		$canDeposit = parent::setting('canWithDraw','wallet');
		if ( $canDeposit != 'yes' )
			return parent::jsonError('cantWithDraw');

		$minDeposit = parent::setting('lowWithdrawMoney','wallet');
		$data = request::getFromArray($data,'price,fnameBank,lnameBank,shaba,bank');
		$rules = [
			"price" => ["required|match:>=".$minDeposit."|match:<=".$modelInfo->getWallet(), rlang('price')],
			"fnameBank" => ["required", rlang('fnameBank')],
			"lnameBank" => ["required", rlang('lnameBank')],
			"shaba" => ["required", rlang('shaba')],
			"bank" => ["required", rlang('bank')],
		];
		$valid = validate::check($data, $rules);
		if ($valid->isFail()){
			return parent::jsonError($valid->errorsIn());
		}
		/* @var wallet_action $model */
		$model = parent::model('wallet_action' );
		$model->setUserId($userId);
		$model->setStatus('withdrawRequest');
		$model->setInvoiceId(null);
		$model->setPrice($data['price']);
		$model->setTimeAction(date('H:i:s'));
		$model->setDateAction(date('Y-m-d'));
		$model->setIp(getIP());
		$model->setDescription(rlang('requestWithdraw') . ' : '. $data['fnameBank'] .' '.$data['lnameBank'] .' - '. $data['bank'] .' '. $data['shaba'] );
		if ( $model->insertToDataBase() ) {
			$modelInfo->setBankFName($data['fnameBank']);
			$modelInfo->setBankLName($data['lnameBank']);
			$modelInfo->setBankName($data['bank']);
			$modelInfo->setShabaNumber($data['shaba']);
			$modelInfo->setWallet( $modelInfo->getWallet() - $data['price']);
			if ( $modelInfo->upDateDataBase() ){
				return self::json($model->getActionId());
			} else {
				$model->deleteFromDataBase();
				return self::jsonError('pleaseTryAgainLater');
			}
		} else
			return parent::jsonError('pleaseTryAgainLater');

	}
}