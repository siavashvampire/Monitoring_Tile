<?php


namespace plugin\idpay;


use App\invoice\app_provider\api\invoice;
use App\invoice\model\transactions;
use paymentCms\component\request;
use paymentCms\model\configuration;
use pluginController;
use function Sodium\increment;

/**
 * Created by Yeganehha .
 * User: Erfan Ebrahimi (http://ErfanEbrahimi.ir)
 * Date: 3/26/2019
 * Time: 3:20 PM
 * project : paymentCMS
 * virsion : 0.0.0.1
 * update Time : 3/26/2019 - 3:20 PM
 * Discription of this Page :
 */


if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');


class hook extends pluginController {


	public function _invoiceGateWays(){
		$name = $this->setting('gateWayName' , 'idpay');
		if ( $name == null )
			return rlang('gateWayIdPay') ;
		return $name ;
	}

	public function _idpay_startTransaction($transaction){
		/* @var transactions $transaction */

		$sandBox = $this->setting('sandBox' , 'idpay');
		if ( $sandBox == rlang('sandBoxOn') )
			$sandBox = '1' ;
		else
			$sandBox = '0' ;
		$apiKey = $this->setting('apiKey' , 'idpay');
		if ( $apiKey == null ){
			$show['status'] = false ;
			$show['massage'] = rlang('pleaseInsertApiKey') ;
			return $show;
		}
		if ( $transaction->getPrice() < 100 or $transaction->getPrice() > 50000000 ){
			$show['status'] = false ;
			$show['massage'] = rlang('priceIncorrect') ;
			return $show;
		}

		$params = array(
			'order_id' => $transaction->getInvoiceId(),
			'amount' => $transaction->getPrice() * 10 ,
			'desc' => 'pay invoice' .$transaction->getInvoiceId(),
			'callback' => invoice::generateCallBackUrl($transaction->getTransactionId()),
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.idpay.ir/v1.1/payment');
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'X-API-KEY: '.$apiKey,
			'X-SANDBOX: '.$sandBox
		));

		$result = json_decode(curl_exec($ch),true);
		curl_close($ch);

		if( isset($result['error_code'])) {
			$show['status'] = false ;
			$show['massage'] = $result['error_message'].' ('.$result['error_code'].')' ;
			return $show;
		}
		$show['status'] = true ;
		$show['massage'] = 'send' ;
		$show['link'] = $result['link'];
		$show['type'] ='get';
		$show['inputs']['Test_name'] = 'value of thei fild for send to bank' ;
		$show['codeOne'] = '' ;
		$show['codeTwo'] = $result['id'] ;
		return $show;
	}
	public function _idpay_checkTransaction($transaction){

		/* @var transactions $transaction */
		$sandBox = $this->setting('sandBox' , 'idpay');
		if ( $sandBox == rlang('sandBoxOn') )
			$sandBox = '1' ;
		else
			$sandBox = '0' ;
		$apiKey = $this->setting('apiKey' , 'idpay');
		if ( $apiKey == null ){
			$show['status'] = true ;
			$show['payStatus'] = false ;
			$show['payStatusType'] = 'canceled';
			$show['codeOne'] = request::postOne('track_id') ;
			$show['codeTwo'] =  $transaction->getTransactionCodeTwo() ;
			$show['massage'] = rlang('pleaseInsertApiKey') ;
			return $show;
		}

		if ( request::postOne('status') == '100') {
			$params = array(
				'id' => $transaction->getTransactionCodeTwo(),
				'order_id' => $transaction->getInvoiceId(),
			);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://api.idpay.ir/v1.1/payment/verify');
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'X-API-KEY: '.$apiKey,
				'X-SANDBOX: '.$sandBox
			));

			$result = json_decode(curl_exec($ch) , true);
			curl_close($ch);

			if ( $result['status'] == 100 ){
				$show['status'] = true ;
				$show['payStatus'] = true ;
				$show['massage'] = 'done' ;
				$show['codeOne'] = $result['track_id'] ;
				$show['codeTwo'] =  $result['id'];
			} else {
				$show['status'] = true ;
				$show['payStatus'] = false ;
				$show['payStatusType'] = 'canceled';
				$show['massage'] =  rlang('postResult'. request::postOne('status')) ;
				$show['codeOne'] = $result['track_id'] ;
				$show['codeTwo'] =  $result['id'];
			}
		} else {
			$show['status'] = true ;
			$show['payStatus'] = false ;
			$show['payStatusType'] = 'canceled';
			$show['massage'] =  rlang('postResult'. request::postOne('status')) ;
			$show['codeOne'] = request::postOne('track_id') ;
			$show['codeTwo'] =  $transaction->getTransactionCodeTwo() ;
		}

		return $show;
	}
}