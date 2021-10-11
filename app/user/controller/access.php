<?php


namespace App\user\controller;


use App;
use App\core\controller\fieldService;
use App\user\app_provider\api\user;
use controller;
use paymentCms\component\cache;
use paymentCms\component\cookie;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\session;
use paymentCms\component\validate;

/**
 * Created by Yeganehha .
 * User: Erfan Ebrahimi (http://ErfanEbrahimi.ir)
 * Date: 4/27/2019
 * Time: 6:00 PM
 * project : paymentCMS
 * virsion : 0.0.0.1
 * update Time : 4/27/2019 - 6:00 PM
 * Discription of this Page :
 *
 */


if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

/*
 *
 */
class access extends controller  {

	/**
	 * [global-access]
	 */
	public function showAvatar($userId=null){
//		header ("Pragma-directive: no-cache");
//		header ("Cache-directive: no-cache");
//		header ("Cache-control: no-cache");
//		header ("Pragma: no-cache");
//		header ("Expires: 0");
		session_cache_limiter('public');
		header('Cache-control: max-age='.(60*60*24*30));
		header('Expires: '.gmdate(DATE_RFC1123,time()+60*60*24*30));
		$notFindFile = app::getAppPath('theme/assets/image','user').'avatar.svg';
		if ( $userId == null or !intval($userId) ){
			header('Content-Type: image/svg+xml');
			readfile($notFindFile);
			$this->mold->offAutoCompile();
			exit;
		}
		$fileUserWant = app::getAppPath('storage','user') . intval($userId).'.jpg';
		if ( file_exists($fileUserWant)){
			header('Content-Type: image/jpeg');
			readfile($fileUserWant);
			$this->mold->offAutoCompile();
			exit;
		}
		header('Content-Type: image/svg+xml');
		readfile($notFindFile);
		$this->mold->offAutoCompile();
		exit;
	}

	/**
	 * [global-access]
	 */
	public function login($status = null){

		if ( session::has('userAppLoginInformation') ) {
			Response::redirect(App::getBaseAppLink(null, 'admin'));
			exit;
		}



//		if (isset($_POST['username'])) {
//			$_POST['username'] = str_replace('+', '', $_POST['username']);
//			$_POST['username'] = (substr($_POST['username'], 0, 1) != '0') ? '0' . $_POST['username'] : $_POST['username'];
//		}

		if ( $status == 'insertDone')
			$this->alert('success', '', rlang('insertUserSuccessFully') );
		$this->mold->view('login.mold.html');
		$this->mold->setPageTitle(rlang('loginInToAccount'));
		$this->callHooks('loginBeforePost' , []);
		if ( request::isPost()) {
			$result = user::login(false);
			if ( isset($result['status'])  and ! $result['status']){
				$this->alert('danger','',$result['massage']);
				$this->mold->unshow('register.mold.html');
				return false ;
			}

			session::regenerateSessionId();
			if ( cookie::get('isFromApp') == 'yes') $expireDay = 365 ; else $expireDay = 1 ;
			session::lifeTime($expireDay ,'day')->set('userAppLoginInformation',$result['result']);
			$this->callHooks('addLog' , [rlang(['login', 'user']), 'login user']);
			if ( request::isGet('callBack') ){
				Response::redirect(urldecode(request::getOne('callBack')));
			} else
				Response::redirect(App::getBaseAppLink(null,'admin'));
		} else {
			session::clear();
			session::stop();
			setcookie("phpsessid", "", time()-3600,'/');
			setcookie("PHPSESSID", "", time()-3600,'/');
		}
		if ( request::isGet('callBack')){
			$this->mold->set('callBack' , urlencode(request::getOne('callBack')) );
		}
		$this->mold->unshow('register.mold.html');
	}

	/**
	 * [notUser-access]
	 */
	public function register($defaultAccess = null){
		if ( $defaultAccess == null )
			$defaultAccess = cache::get('userDefaultPageAccessForRegister',null , 'user');
		if ( $defaultAccess == null ){
			Response::redirect(App::getBaseAppLink('access/login','user'));
		}

		fieldService::getFieldsToFillOut($defaultAccess,'user_register',$this->mold);
		$this->callHooks('userRegisterPage' , [$defaultAccess] );
		$this->mold->view('register.mold.html');
		$this->mold->setPageTitle(rlang('eFormRegister'));
		$this->mold->set('access',$defaultAccess);
		$this->mold->set('defaultField' ,cache::get('defaultFieldRegisterPageStatus'.$defaultAccess,null , 'user') );
		$this->mold->setPageTitle(rlang('register'));
		if ( request::isPost('registerForm')) {
			$_POST['groupId'] = $defaultAccess ;
			$_POST['block'] = 0 ;
			$result = user::editUser(null,$_POST);
			if ( $result['status'] ){
				if ( request::isGet('callBack') ){
					Response::redirect(App::getBaseAppLink('access/login/insertDone').'?callBack='.urldecode(request::getOne('callBack')) , 'user');
				} else
					Response::redirect(App::getBaseAppLink('access/login/insertDone') , 'user');
				return true;
			} else {
				$this->alert('danger', '', $result['massage'] );
				return false;
			}
		}
	}

	/**
	 * [user-access]
	 */
	public function logout(){
		if ( session::has('MarketerAppLoginInformation') ) {
			$marketer = session::get('MarketerAppLoginInformation');
			session::remove('userAppLoginInformation','MarketerAppLoginInformation');
			session::regenerateSessionId(true);
			if ( cookie::get('isFromApp') == 'yes') $expireDay = 365 ; else $expireDay = 1 ;
			session::lifeTime($expireDay ,'day')->set('userAppLoginInformation',$marketer);
			Response::redirect(App::getBaseAppLink('','admin'));
			exit;
		} else {
			$this->callHooks('addLog', [rlang(['logOut', 'user']), 'logout user']);
			session::remove('userAppLoginInformation', 'adminAppLoginInformation');
			Response::redirect(App::getBaseAppLink(null, 'admin'));
		}
	}


	/**
	 * [user-access]
	 */
	public function backToAdmin(){
		if ( session::has('adminAppLoginInformation') ) {
			$userId = user::getUserLogin(true);
			$admin = session::get('adminAppLoginInformation');
			session::remove('userAppLoginInformation','adminAppLoginInformation');
			session::regenerateSessionId(true);
			if ( cookie::get('isFromApp') == 'yes') $expireDay = 365 ; else $expireDay = 1 ;
			session::lifeTime($expireDay ,'day')->set('userAppLoginInformation',$admin);
			Response::redirect(App::getBaseAppLink('users/profile/'.$userId,'admin'));
			exit;
		}
		Response::redirect(App::getBaseAppLink(null,'user'));
		exit;
	}
}