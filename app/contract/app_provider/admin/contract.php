<?php
namespace App\contract\app_provider\admin;

use App;
use App\contract\model\contracts_vote;
use App\core\controller\fieldService;
use App\core\controller\httpErrorHandler;
use app\contract\model\vote;
use App\user\app_provider\api\user;
use App\user\model\user_group;
use controller;
use paymentCms\component\cache;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class contract extends controller {
	public function index($groupAccess = null){
        /* @var user_group $model */
		$model = $this->model(['user','user_group']);

//		$access = $model->search(null,null);
//		$this->mold->set('access',$access);

		$access = $model->search(null,null);
        if ($groupAccess == null ) {
            $groupAccess = $access[0]['user_groupId'];
        }
		$votes = $model->search($groupAccess,' contractGroup = ?' , 'vote' , 'voteName,voteId');

		$this->mold->set('votes',$votes);

		if ( request::isPost() ) {
			$form = request::post('moreField,deleteField');
            $resultUpdateField = fieldService::updateFields($groupAccess,'contract_with_user' ,$form['moreField'],$form['deleteField']);
			if ( ! $resultUpdateField['status'] ) {
				$this->alert('warning' , null, rlang('pleaseTryAGain').'<br>'.$resultUpdateField['massage'],'error');
			} else {
				$this->alert('success' , null, 'فیلد های قرارداد با موفقیت ویرایش شد');
			}
		}

		$this->mold->set('access',$access);
		$this->mold->set('nowOnAccess',$groupAccess);
		$this->mold->set('tabview','contract');
        $this->mold->set('activeMenu' , 'contract');


		fieldService::getFieldsToEdit($groupAccess,'contract_with_user',$this->mold);
		$this->mold->path('default', 'contract');
		$this->mold->view('contractEditor.mold.html');
		$this->mold->path('default');
		$this->mold->setPageTitle('قرارداد');
	}
	public function contractTemplate($groupAccess = null){
        /* @var user_group $model */
        /* @var user_group $modelUserGroup */
		$model = $this->model(['user','user_group']);

//		$access = $model->search(null,null);
//		$this->mold->set('access',$access);


		$access = $model->search(null,null);
        if ($groupAccess == null ) {
            $groupAccess = $access[0]['user_groupId'];
        }
		$votes = $model->search($groupAccess,' contractGroup = ?' , 'vote' , 'voteName,voteId');

		$this->mold->set('votes',$votes);

		$modelUserGroup = $this->model(['user','user_group'] , $groupAccess);
		if ( request::isPost() ) {
			$form = request::post('content');
			if ( $groupAccess != $modelUserGroup->getUserGroupId() ){
				$this->alert('warning' , null, rlang('pleaseTryAGain') ,'error');
			} else {
				$modelUserGroup->setContractTemplate($form['content']);
				if ( ! $modelUserGroup->upDateDataBase() ) {
					$this->alert('warning' , null, rlang('pleaseTryAGain'),'error');
				} else {
					$this->alert('success' , null, 'متن پیشفرض قرارداد با موفقیت ویرایش شد');
				}
			}
		}

		$this->mold->set('access',$access);
		$this->mold->set('nowOnAccess',$groupAccess);
		$this->mold->set('tabview','contractTemplate');
		$this->mold->set('contract',$modelUserGroup->getContractTemplate());


		$this->mold->set('fieldsContract', fieldService::getFieldsToEdit($groupAccess,'contract_with_user') );
		$this->mold->set('fieldsUser', fieldService::getFieldsToEdit($groupAccess,'user_register') );

		$this->mold->path('default', 'contract');
		$this->mold->view('contractEditor.mold.html');
		$this->mold->path('default');
		$this->mold->setPageTitle('قرارداد');
	}
	public function newVote($groupAccess ){
        $this->voteFields($groupAccess,null);
	}
	public function voteFields($groupAccess , $voteId = null ){
		/* @var user_group $model */
		$model = $this->model(['user','user_group'] , $groupAccess);
		if ( $model->getUserGroupId() != $groupAccess) {
			httpErrorHandler::E404();
			return false;
		}

		/* @var vote $vote */
		if ( $voteId != "" ) {
			$vote = $this->model('vote', $voteId);
			if ( $vote->getVoteId() != $voteId) {
				$this->alert('danger','','نظر سنجی مد نظر یافت نشد!');
			}
		} else {
			$vote = $this->model('vote');
		}

		if ( request::isPost() ) {
			$get = request::post('name,receiver,numberDay,moreField,deleteField' ,null);
			$rules = [
				"receiver" => ["required", 'گیرنده'],
				"name" => ["required", 'نام نظر سنجی'],
			];
			$valid = validate::check($get, $rules);
			if ($valid->isFail()){
				$this->alert('danger','',$valid->errorsIn());
			}
			if ( substr($get['receiver'] , 0 , 1 ) == 'U' ){
				$receiver = substr($get['receiver'] , 1  ) ;
				$UnitCheck = true ;
			} else {
				$receiver = $get['receiver'] ;
				$UnitCheck = false ;
			}
			$vote->setVoteName($get['name']);
			$vote->setVoteReceiver($receiver);
			$vote->setCheckByUnit($UnitCheck);
			$vote->setContractGroup($groupAccess);
			$vote->setShowToReceiver($get['numberDay']);
			if ( $voteId != "" ) {
				if ($vote->upDateDataBase()) {
					$resultFillOutForm = fieldService::fillOutForm($get['groupId'], 'user_register', $get['customField'], $model->getUserGroupId(), 'user_register');

				}
			}else {
				$vote->insertToDataBase();
			}


			$resultUpdateField = fieldService::updateFields($vote->getVoteId(),'contract_vote' ,$get['moreField'],$get['deleteField']);
			if ( ! $resultUpdateField['status'] ) {
				$this->alert('warning' , null, rlang('pleaseTryAGain').'<br>'.$resultUpdateField['massage'],'error');
			} else {
				if ( $voteId == null ) {
					Response::redirect(App::getBaseAppLink('contract/voteFields/'.$groupAccess.'/'.$vote->getVoteId(),'admin'));
					return true ;
				}
				$this->alert('success' , null, 'فیلد های نظرسنجی با موفقیت ویرایش شد');
			}
		}


		$access = $model->search(null,null);
		$votes = $model->search($groupAccess,' contractGroup = ?' , 'vote' , 'voteName,voteId');

		$this->mold->set('access',$access);
		$this->mold->set('votes',$votes);
		$this->mold->set('nowOnAccess',$groupAccess);
		$this->mold->set('tabview','newvote');
		$this->mold->set('vote',$vote);


		fieldService::getFieldsToEdit($vote->getVoteId(),'contract_vote',$this->mold);
		$this->mold->path('default', 'contract');
		$this->mold->view('contractEditor.mold.html');
		$this->mold->path('default');
		$this->mold->setPageTitle('قرارداد');

	}
	public function user($userId){
		$user = user::getUserById($userId);
		if ($user->getUserId() == null){
			httpErrorHandler::E404();
			return false ;
		}
		$this->callHooks('userProfileShowInAdmin',['user'=>$user,'fields'=>null]);
		model::join('user_group' , 'user_groupId = contractGroup');
		$contracts = model::searching([$user->getUserId()],' userId	= ? ' ,'contracts','*',['column' => 'endDate' , 'type' =>'desc']);

		$this->mold->set('listGroups', $contracts);
		$this->mold->set('user', $user);
		$this->mold->set('activeTab', 'contracts');

		$this->mold->path('default', 'contract');
		$this->mold->view('contracts.user.mold.html');
	}
}