<?php


namespace plugin\loginWithSms;


use paymentCms\component\cache;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\security;
use paymentCms\component\validate;
use paymentCms\model\user;
use pluginController;

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

	public function _loginBeforePost(){
		if ( ! request::isPost('password') and request::isPost() ){
			$randomCode = rand(10000,99999);
			/* @var user $model */
			$model = parent::model('user' ,[request::postOne('username'),request::postOne('username')],' ( phone = ? or email = ?) and block = 0 ');
			if ( $model->getPhone() != request::postOne('username') and $model->getEmail() != request::postOne('username') ){
				$this->mold->set('alertUserNotFound' , true);
				$this->mold->set('showPassword' , false);
			} else {
				$this->mold->set('showPassword' , true);
				if ( $model->getPhone() != null )
					self::callHooks('sendSms' , ['phone' => $model->getPhone() , 'text' => $randomCode , 'type' => 'verificationCode']);
				if ( $model->getEmail() != null )
					self::callHooks('sendEmail' , ['email' => $model->getEmail() , 'body' => $randomCode , 'type' => 'verificationCode']);
			}
			$model->setPassword($randomCode);
			$model->upDateDataBase();
			$_SERVER['REQUEST_METHOD'] = '';
		} elseif ( request::isPost('password') ){
			$this->mold->set('showPassword' , true);
		} else
			$this->mold->set('showPassword' , false);
		$this->mold->view('loginSmsWithJs.loginWithSms.mold.html');
	}

	public  function _userRegisterPage($groupId){
		if ( ! request::isPost('emailSmsVerificationCode') and request::isPost('registerForm') ){
			$get = request::post('email,phone' ,null);
			$rulesStatus = cache::get('defaultFieldRegisterPageStatus'.$groupId  ,null , 'user');
			if ( $rulesStatus['emailNameStatus'] == 'required')
				$rules["email"] = ["required|email", rlang('email')];
			if ( $rulesStatus['phoneNameStatus'] == 'required')
				$rules["phone"] = ["required|mobile", rlang('phone')];
			$valid = validate::check($get, $rules);
			if ($valid->isFail()) {
				$this->mold->set('alertUserNotFoundRegister' , $valid->errorsIn());
				$this->mold->set('showPasswordRegister' , false);
			} else {

				$randomCode = rand(10000, 99999);

				$this->mold->set('showPasswordRegister', true);
				if ($get['phone'] != null) self::callHooks('sendSms', ['phone' => $get['phone'], 'text' => $randomCode, 'type' => 'verificationCode']);
				if ($get['email'] != null) self::callHooks('sendEmail', ['email' => $get['email'], 'body' => $randomCode, 'type' => 'verificationCode']);

				$this->mold->set('hashRegister', security::encrypt($randomCode . $get['phone'] . $get['email']));
			}
			unset($_POST['registerForm']);
		} elseif ( request::isPost('emailSmsVerificationCode') ){
			$get = request::post('email,phone,emailSmsVerificationCode,emailSmsVerificationCodeHash' ,null);
			$passwordUserSendHash = security::encrypt($get['emailSmsVerificationCode'].$get['phone'].$get['email']);
			if ( $passwordUserSendHash != $get['emailSmsVerificationCodeHash']){
				$this->mold->set('alertUserNotFoundRegister' , 'کد اعتبار سنجی صحیح نمی باشد!');
				$this->mold->set('hashRegister', $get['emailSmsVerificationCodeHash']);
				$this->mold->set('showPasswordRegister' , true);
				unset($_POST['registerForm']);
			}
			unset($_POST['emailSmsVerificationCode'],$_POST['emailSmsVerificationCodeHash']);
		} else
			$this->mold->set('showPasswordRegister' , false);
		$this->mold->view('registerSmsWithJs.loginWithSms.mold.html');
	}
}