<?php


namespace plugin\meliPayamk;

use Exception;
use plugin\meliPayamk\api\MelipayamakApi;
use pluginController;
/**
 * Created by Yeganehha .
 * User: Erfan Ebrahimi (http://ErfanEbrahimi.ir)
 * Date: 3/31/2020
 * Time: 3:44 PM
 * project : payment
 * virsion : 0.0.0.1
 * update Time : 3/31/2020 - 3:44 PM
 * Discription of this Page :
 */


if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');


class hook extends pluginController {


	public function _sendSms($phone , $text , $type){
		try{
			$username = $this->setting('username' , 'meliPayamk');
			$password =  $this->setting('password' , 'meliPayamk');
			$sign =  $this->setting('sign' , 'meliPayamk');
			$api = new MelipayamakApi($username,$password);
			$sms = $api->sms();
			$from =  $this->setting('from' , 'meliPayamk');
			if ( $type == 'verificationCode')
				$text = rlang('loginPasswordText').$text ;

			if ( $sign != '' )
				$text .= "\n".$sign;
			$response = $sms->send($phone,$from,$text);
			$json = json_decode($response);
			return $json->Value; //RecId or Error Number
		}catch(Exception $e){
			return $e->getMessage();
		}
	}


	public function _settingFooter(){

		$username = $this->setting('username' , 'meliPayamk');
		$password =  $this->setting('password' , 'meliPayamk');
		if ( $username != null and $password != null) {
			$api = new MelipayamakApi($username,$password);
			$sms = $api->sms();
			$response = $sms->getCredit();
			$responseNumber = $sms->getNumbers();
			$json = json_decode($response,true);
			$jsonNumber = json_decode($responseNumber,true);
			$this->mold->set('smsCredit' , $json['Value']);
			$this->mold->set('smsNumber' , array_column($jsonNumber['Data'],'Number'));
		}
		$this->mold->view('configuration.meliPayamk.mold.html');
	}

}