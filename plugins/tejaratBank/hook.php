<?php


namespace plugin\tejaratBank;


use App\invoice\app_provider\api\invoice;
use App\invoice\model\transactions;
use pluginController;
use SoapClient;


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
		return $this->setting('gateWayNameTejarat' , 'tejaratBank');
	}

	public function _tejaratBank_startTransaction($transaction){
		$MerchantId = $this->setting('MerchantIdTejarat' , 'tejaratBank');

		/* @var transactions $transaction */
		$client = new SoapClient('https://ikc.shaparak.ir/XToken/Tokens.xml', array('soap_version'   => SOAP_1_1));

		$params['amount'] = $transaction->getPrice() * 10 ;
		$params['merchantId'] = $MerchantId;
		$params['invoiceNo'] = $transaction->getInvoiceId();
		$params['paymentId'] = $transaction->getTransactionId();
//		$params['specialPaymentId'] = "123456789123";
		$params['revertURL'] = invoice::generateCallBackUrl($transaction->getTransactionId()) ;
		$params['description'] =  'pay invoice' .$transaction->getInvoiceId() .' - '.$transaction->getTransactionId();
		$result = $client->__soapCall("MakeToken", array($params));
		if($result->MakeTokenResult->result)
		{
			$show['status'] = true ;
			$show['massage'] = 'send' ;
			$show['link'] ='https://ikc.shaparak.ir/TPayment/Payment/index';
			$show['type'] ='post';
			$show['inputs']['token'] = $result->MakeTokenResult->token ;
			$show['inputs']['merchantId'] = $MerchantId ;
			$show['codeOne'] = '' ;
			$show['codeTwo'] = $result->MakeTokenResult->token ;
		} else {
			$show['status'] = false ;
			$show['massage'] = $this->errors('-50').' ('.$result->MakeTokenResult->message.') ' ;
		}
		return $show;
	}
	public function _tejaratBank_checkTransaction($transaction){

		/* @var transactions $transaction */
		if($_POST['resultCode'] == '100'){
			$MerchantId = $this->setting('MerchantIdTejarat' , 'tejaratBank');
			$Sha1KeyTejarat = $this->setting('Sha1KeyTejarat' , 'tejaratBank');

			$client = new SoapClient('https://ikc.shaparak.ir/XVerify/Verify.xml', array('soap_version'   => SOAP_1_1));
			$params['token'] =  $transaction->getTransactionCodeTwo() ; // please replace currentToken
			$params['merchantId'] = $MerchantId;
			$params['referenceNumber'] = $_POST['referenceId'];
			$params['sha1Key'] = $Sha1KeyTejarat ;
			$result = $client->__soapCall("KicccPaymentsVerification", array($params));
			$result = $result->KicccPaymentsVerificationResult ;
			if ( $result == $transaction->getPrice() * 10 ){
				$show['status'] = true ;
				$show['payStatus'] = true ;
				$show['massage'] = $this->errors($_POST['resultCode']) ;
				$show['codeOne'] = $_POST['referenceId'] ;
				$show['codeTwo'] = $_POST['invoiceNumber']  ;
			} else {
				$show['status'] = true ;
				$show['payStatus'] = false ;
				$show['payStatusType'] = 'feiled';
				$show['massage'] = $this->errors($_POST['resultCode']) ;
				$show['codeOne'] = $_POST['referenceId'] ;
				$show['codeTwo'] = $_POST['invoiceNumber']  ;
			}
		} else {
			$show['status'] = true ;
			$show['payStatus'] = false ;
			$show['payStatusType'] = 'canceled';
			$show['massage'] =  $this->errors($_POST['resultCode']) ;
			$show['codeOne'] = $_POST['referenceId'] ;
			$show['codeTwo'] = $_POST['invoiceNumber']  ;
		}
		return $show;
	}


	private function errors($code){
		return rlang('E_'.$code );
	}
}