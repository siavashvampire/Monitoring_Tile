<?php


namespace App\user\app_provider\user;


use App;
use App\core\controller\fieldService;
use App\core\controller\httpErrorHandler;
use App\user\app_provider\api\user;
use controller;
use paymentCms\component\cache;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

/**
 * Created by Yeganehha .
 * User: Erfan Ebrahimi (http://ErfanEbrahimi.ir)
 * Date: 3/24/2019
 * Time: 10:15 AM
 * project : paymentCMS
 * virsion : 0.0.0.1
 * update Time : 3/24/2019 - 10:15 AM
 * Discription of this Page :
 */


if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');


class profile extends controller {
	public function index($updateStatus = null){
		$userLogin = user::getUserLogin();
		$this->mold->set('myProfile' , true);
		$myProfile = true ;
		$_POST['groupId'] = $userLogin['user_group_id'];
		$userId = $userLogin['userId'];

		if ( request::isPost() ) {
			$this->checkData($userId);
		}
		/* @var \paymentCms\model\user $user */
		$user = $this->model('user' , $userId );
		if ( $user->getUserId() != $userId ){
			httpErrorHandler::E404();
			return false ;
		}
		if ( $updateStatus == 'updateDone') {
			$this->alert('success' , '',rlang('editUserSuccessFully'));
			//			$this->mold->set('activeTab','edit');
		}elseif ( $updateStatus == 'insertDone') {
			$this->alert('success' , '',rlang('insertUserSuccessFully'));
		}


		$fields = fieldService::showFilledOutFormWithAllFields($user->getUserGroupId(),'user_register',$user->getUserId() , 'user_register' , true,$this->mold);
		$this->mold->set('user',$user);
		$this->mold->path('default', 'user');
		$this->mold->view('userProfileUserArea.mold.html');
		$this->mold->setPageTitle(rlang(['profile','user']));
		return $user;
	}

	private function checkData($userId = null){
		$result = user::editUser($userId,$_POST);
		if ( $result['status'] ){
			Response::redirect(App::getBaseAppLink('profile/updateDone', 'user'));
			exit;
		} else {
			$this->alert('danger', '', $result['massage'] );
			$this->mold->set('activeTab','edit');
			return false;
		}
	}

}