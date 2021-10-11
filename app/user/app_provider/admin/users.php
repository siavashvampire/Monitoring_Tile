<?php


namespace App\user\app_provider\admin;


use App;
use App\core\controller\fieldService;
use App\core\controller\httpErrorHandler;
use App\user\app_provider\api\user;
use App\user\model\user_group;
use controller;
use paymentCms\component\cache;
use paymentCms\component\JDate;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\session;
use paymentCms\component\strings;
use paymentCms\component\validate;
use paymentCms\model\api;


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


class users extends controller {
	private function index(){
		$this->lists();
	}
	public function login($userId){
		$admin = user::getUserLogin();
		$user = user::getUserById($userId);
		session::regenerateSessionId(false);
		session::lifeTime(1 ,'day')->set('userAppLoginInformation',$user->returnAsArray());
		session::lifeTime(1 ,'day')->set('adminAppLoginInformation',$admin);
		Response::redirect(App::getBaseAppLink(null,'user'));
		exit;
	}
	public function lists($defaultAccess = null) {
		$get = request::all('page=1,perEachPage=25,fname,lname,email,phone,userId,customField,groupId,status,contractEnd,sortWith' ,null);
		$rules = [
			"page" => ["required|match:>0", rlang('page')],
			"perEachPage" => ["required|match:>0|match:<501", rlang('page')],
		];
		$valid = validate::check($get, $rules);
		$value = array( );
		$variable = array( );
		$cfvVariable = [] ;
        $value[] = -1 ;
        $variable[] = 'u.userId <> ?' ;
		$sortWith =  ['column' => 'u.userId' , 'type' =>'desc'] ;
		if ($valid->isFail()){
			//TODO:: add error is not valid data

		} else {
			if ( $get['customField'] != null and is_array($get['customField'])) {
				foreach ($get['customField'] as $idCustomField => $valueCustomField ){
					if ( is_array($valueCustomField) )
						$valueCustomField = implode(' - ' , $valueCustomField);
					if ($valueCustomField != null or $valueCustomField != '') {
						if ( fieldService::whereSave() ){
							$cfvVariable[] = '  cfv.f_'.$idCustomField.' LIKE "%' . $valueCustomField . '%" ';
						} else {
							$cfvVariable[] = ' ( cfv.fieldId = '.$idCustomField.' and cfv.value LIKE "%' . $valueCustomField . '%" ) ';
						}
					}
				}
			}
			if ( $get['fname'] != null ) {
				$value[] = '%'.$get['fname'].'%' ;
				$variable[] = 'u.fname LIKE ?' ;
			}
			if ( $get['lname'] != null ) {
				$value[] = '%'.$get['lname'].'%' ;
				$variable[] = 'u.lname LIKE ?' ;
			}
			if ( $get['email'] != null ) {
				$value[] = '%'.$get['email'].'%' ;
				$variable[] = 'u.email LIKE ?' ;
			}
			if ( $get['phone'] != null ) {
				$value[] = '%'.$get['phone'].'%' ;
				$variable[] = 'u.phone LIKE ?' ;
			}
			if ( $get['userId'] != null ) {
				$value[] = '%'.$get['userId'].'%' ;
				$variable[] = 'u.userId LIKE ?' ;
			}
			if ( $get['contractEnd'] != null ) {
				$dateShamsi = explode('/',$get['contractEnd']);
				$value[] = JDate::jalali_to_gregorian($dateShamsi[0],$dateShamsi[1],$dateShamsi[2],"-").' 23:59:59';
				$variable[] = 'c.endDate = ?' ;
			}
			if ( $get['groupId'] != null ) {
				$value[] = $get['groupId'] ;
				$variable[] = 'u.user_group_id = ?' ;
				$defaultAccess = $get['groupId'] ;
			}
			if ( $get['status'] != null and $get['status'] != 'block' ) {
				$value[] = $get['status'] ;
				$variable[] = 'u.verified = ?' ;
			}
			if ( $get['status'] != null and $get['status'] == 'block' ) {
				$value[] = 1 ;
				$variable[] = 'u.block = ?' ;
			}

			if ( $get['sortWith'] != null and is_array($get['sortWith']) ) {
				unset($sortWith);
				foreach ($get['sortWith'] as $sort) {
					$temp = explode('|', $sort);
					$sortWith[] = ['column' => $temp[0], 'type' => $temp[1]];
				}
			}
		}

		/* @var user_group $modelAccess */
		$modelAccess = $this->model('user_group');
		$access = $modelAccess->search(null,null);
		$this->mold->set('access',$access);
		$this->mold->set('accessDefault',$defaultAccess);




		$model = parent::model('user');
		if ( count($cfvVariable) > 0 ) {
			if ( fieldService::whereSave() )
				model::join('customFieldValue_'.$defaultAccess.'_user_register cfv', ' ( u.userId = cfv.objectId and cfv.objectType = "user_register" and (' . implode(' and ', $cfvVariable) . ') )', "INNER");
			else
				model::join('fieldvalue cfv', ' ( u.userId = cfv.objectId and cfv.objectType = "user_register" and (' . implode(' or ', $cfvVariable) . ') )', "INNER");
		}
		if ( $get['contractEnd'] != null ) {
			model::join('contracts c', ' u.userId = c.userId ');
		}
		$numberOfAll = ($model->search( (array) $value  , ( count($variable) == 0 ) ? null : implode(' and ' , $variable) , 'user u' , 'COUNT(u.userId) as co' )) [0]['co'];
		$pagination = parent::pagination($numberOfAll,$get['page'],$get['perEachPage']);
		if ( count($cfvVariable) > 0 ) {
			if ( fieldService::whereSave() )
				model::join('customFieldValue_'.$defaultAccess.'_user_register cfv', ' ( u.userId = cfv.objectId and cfv.objectType = "user_register" and (' . implode(' and ', $cfvVariable) . ') )', "INNER");
			else
				model::join('fieldvalue cfv', ' ( u.userId = cfv.objectId and cfv.objectType = "user_register" and (' . implode(' or ', $cfvVariable) . ') )', "INNER");
		}

		if ( $get['contractEnd'] != null ) {
			model::join('contracts c', ' u.userId = c.userId ');
		}
		model::join('user_group ug', ' user_group_id = ug.user_groupId ', "LEFT");
		$search = $model->search( (array) $value  , ( ( count($variable) == 0 ) ? null : implode(' and ' , $variable) )  , 'user u', '*'  , $sortWith , [$pagination['start'] , $pagination['limit'] ] );

		fieldService::getFieldsToFillOut($defaultAccess,'user_register' , $this->mold );
		$this->mold->path('default', 'user');
		$this->mold->view('userList.mold.html');
		$this->mold->setPageTitle(rlang('users'));
		$this->mold->set('activeMenu' , 'users');
		$this->mold->set('users' , $search);
	}
	public function insert($defaultAccess = null){
		if ( request::isPost() ) {
			$_POST['verified'] = 1 ;
			$this->checkData();
		}
		/* @var user_group $model */
		$model = $this->model('user_group');
		$access = $model->search(null,null);
		$this->mold->set('access',$access);

		if ( $defaultAccess == null ) {
			$defaultAccess = cache::get('userDefaultPageAccessForRegister', null, 'user');
			if ($defaultAccess == null) {
				$groupAccess = $model->search([0], 'loginRequired = ? ', null, '*', ['column' => 'user_groupId', 'type' => 'desc'], [0, 1]);
				if (isset($groupAccess[0])) {
					$defaultAccess = $groupAccess[0]['user_groupId'];
					cache::save($defaultAccess, 'userDefaultPageAccessForRegister', PHP_INT_MAX, 'user');
				}
			}
		}
		if ( request::isPost('groupId') )
			$defaultAccess = request::postOne('groupId');

		$this->mold->set('accessDefault',$defaultAccess);

		/* @var \paymentCms\model\user $tempUser */
		$tempUser = $this->model('user'  );
		$tempUser->setUserGroupId($defaultAccess);
		$fields = fieldService::getFieldsToFillOut($defaultAccess,'user_register' ,$this->mold);
		$this->callHooks('userProfileShowInAdmin',['user'=>$tempUser,'fields'=>$fields]);
		$this->mold->set('newUser',true);
		$this->mold->path('default', 'user');
		$this->mold->view('userProfile.mold.html');
		$this->mold->setPageTitle(rlang(['add','user']));
	}
	public function profile($userId,$updateStatus = null){
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
		} elseif ( $updateStatus != null)  {
			$this->mold->set('activeTab' , $updateStatus);
		}

		/* @var user_group $model */
		$model = $this->model('user_group');
		$access = $model->search(null,null);

		$fields = fieldService::showFilledOutFormWithAllFields($user->getUserGroupId(),'user_register',$user->getUserId() , 'user_register' , true,$this->mold);
        $this->callHooks('userProfileShowInAdmin',['user'=>$user,'fields'=>$fields]);
		$this->mold->set('access',$access);
		$this->mold->set('user',$user);
		$this->mold->path('default', 'user');
		$this->mold->view('userProfile.mold.html');
		$this->mold->setPageTitle(rlang(['profile','user']));
		return $user;
	}
    public function Edit_profile($userId,$updateStatus = null){
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
		} elseif ( $updateStatus != null)  {
			$this->mold->set('activeTab' , $updateStatus);
		}

		/* @var user_group $model */
		$model = $this->model('user_group');
		$access = $model->search(null,null);

		$fields = fieldService::showFilledOutFormWithAllFields($user->getUserGroupId(),'user_register',$user->getUserId() , 'user_register' , true,$this->mold);
		$this->callHooks('userProfileShowInAdmin',['user'=>$user,'fields'=>$fields]);
		$this->mold->set('access',$access);
		$this->mold->set('user',$user);
		$this->mold->path('default', 'user');
		$this->mold->view('userProfile.mold.html');
		$this->mold->setPageTitle(rlang(['profile','user']));
		return $user;
	}

//	/**
//	 * @param null $updateStatus
//	 * [user-access]
//	 * @return bool|\paymentCms\model\user
//	 */
	public function myProfile($updateStatus = null){
		$userLogin = user::getUserLogin();
		$this->mold->set('myProfile' , true);
		$myProfile = true ;
		$_POST['groupId'] = $userLogin['user_group_id'];
		$userId = $userLogin['userId'];

		if ( request::isPost() ) {
			$this->checkData($userId , true);
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

		/* @var user_group $model */
		$model = $this->model('user_group');
		$access = $model->search(null,null);

		$this->mold->set('access',$access);
		$this->mold->set('user',$user);
		$this->mold->path('default', 'user');
		$this->mold->view('userProfile.mold.html');
		$this->mold->setPageTitle(rlang(['profile','user']));
		return $user;
	}

	/**
	 * @param null $userId
	 *
	 * @return bool
	 * [no-access]
	 */
	private function checkData($userId = null,$myPerofile = false){
		if ( $userId != null and !isset($_POST['verified']))
			$_POST['verified'] = -2 ;
		$result = user::editUser($userId,$_POST);
		if ( $result['status'] ){
			if ( $myPerofile )
				$link = 'myProfile' ;
			else
				$link = 'profile/'.$result['result'] ;
			if ($userId == null) {
				Response::redirect(App::getBaseAppLink('users/' . $link . '/insertDone', 'admin'));
			} else {
				Response::redirect(App::getBaseAppLink('users/' . $link . '/updateDone', 'admin'));
			}
			exit;
		} else {
			$this->alert('danger', '', $result['massage'] );
			$this->mold->set('activeTab','edit');
			return false;
		}
	}


	public function insertForm($groupAccess = null){
		/* @var user_group $modelAccess */
		$modelAccess = $this->model('user_group');

		if ( $groupAccess == null ){
			// TODO add this cache to database
			$defaultAccess = cache::get('userDefaultPageAccessForRegister',null , 'user');
			if ( $defaultAccess == null ){
				$defaultAccess =  $modelAccess->search([0],'loginRequired = ? ' ,null,'*',['column' => 'user_groupId' , 'type' => 'desc'] ,[0,1]);
				if ( isset($defaultAccess[0]) ){
					$groupAccess = $defaultAccess[0]['user_groupId'];
					cache::save($groupAccess ,'userDefaultPageAccessForRegister',PHP_INT_MAX , 'user');
				}
			} else {
				$groupAccess = $defaultAccess;
			}
		} elseif ( $groupAccess == 'changeDefault' ){
			if ( request::isPost() ) {
				$form = request::post('defaultAccessRegister');
				$rules = [
					"defaultAccessRegister" => ["required|match:>0", rlang('permission')],
				];
				$valid = validate::check($form, $rules);
				if ($valid->isFail()){
					$this->alert('warning' , null, $valid->errorsIn(),'error');
				}
				cache::save($form['defaultAccessRegister'] ,'userDefaultPageAccessForRegister',PHP_INT_MAX , 'user');
				$groupAccess = $form['defaultAccessRegister'];
				Response::redirect(App::getBaseAppLink('users/insertForm/' .$groupAccess ,'admin'));
			}
		}
		if ( request::isPost() ) {
			$form = request::post('moreField,deleteField,firstNameStatus,lastNameStatus,emailNameStatus,phoneNameStatus,rePasswordStatus,passwordStatus,verifiedStatus,avatarStatus');
			$arraySet= ['firstNameStatus'=>$form['firstNameStatus'] , 'lastNameStatus'=>$form['lastNameStatus'] , 'emailNameStatus'=>$form['emailNameStatus'] , 'phoneNameStatus'=>$form['phoneNameStatus'] ,'passwordStatus'=>$form['passwordStatus'] ,'rePasswordStatus'=>$form['rePasswordStatus'] ,'avatarStatus'=>$form['avatarStatus'],'verifiedStatus'=>$form['verifiedStatus']  ];
			cache::save($arraySet ,'defaultFieldRegisterPageStatus'.$groupAccess ,PHP_INT_MAX , 'user');
			$resultUpdateField = fieldService::updateFields($groupAccess,'user_register' ,$form['moreField'],$form['deleteField']);
			if ( ! $resultUpdateField['status'] ) {
				$this->alert('warning' , null, rlang('pleaseTryAGain').'<br>'.$resultUpdateField['massage'],'error');
			} else {
				$this->alert('success' , null, rlang('eFormRegisterSuccess'));
			}
		}
//		/* @var \App\user\model\user_group $model */
//		$model = $this->model(['user','user_group']);
//		$access = $model->search(null,null);
//		$this->mold->set('access',$access);


		$access = $modelAccess->search(null,null);
		$this->mold->set('access',$access);
		$this->mold->set('accessDefault',cache::get('userDefaultPageAccessForRegister',null , 'user'));
		$this->mold->set('nowOnAccess',$groupAccess);


		fieldService::getFieldsToEdit($groupAccess,'user_register',$this->mold);
		$this->mold->path('default', 'user');
		$this->mold->view('formEditor.mold.html');
		$this->mold->set('field',cache::get('defaultFieldRegisterPageStatus'.$groupAccess,null , 'user'));
		$this->mold->path('default');
		$this->mold->setPageTitle(rlang('eFormRegister'));
	}
}