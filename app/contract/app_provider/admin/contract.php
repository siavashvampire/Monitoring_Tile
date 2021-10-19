<?php
namespace App\contract\app_provider\admin;

use App;
use App\contract\model\contracts;
use App\contract\model\contracts_vote;
use App\core\controller\fieldService;
use App\core\controller\httpErrorHandler;
use app\contract\model\vote;
use App\user\app_provider\api\user;
use App\user\model\user_group;
use controller;
use paymentCms\component\cache;
use paymentCms\component\JDate;
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
    public function list(){
        $get = request::all('page=1,perEachPage=25,contractStartFrom,contractStartUntil,contractEndFrom,contractEndUntil,groupIds,status' ,null);
        $rules = [
            "page" => ["required|match:>0", rlang('page')],
            "perEachPage" => ["required|match:>0|match:<501", rlang('page')],
        ];
        $valid = validate::check($get, $rules);
        $value = array( );
        $variable = array( );
        $value[] = -1 ;
        $variable[] = 'c.contractId <> ?' ;
        $sortWith =  ['column' => 'c.contractId' , 'type' =>'desc'] ;
        if ($valid->isFail()){
            //TODO:: add error is not valid data

        } else {

            if ( $get['contractStartFrom'] != null and $get['contractStartUntil'] == null ) {
                $value[] = date('Y-m-d 00:00:00' , ( $get['contractStartFrom'] / 1000 ) );
                $variable[] = ' c.startDate >= ?';
            } elseif ( $get['contractStartFrom'] == null and $get['contractStartUntil'] != null ) {
                $value[] = date('Y-m-d 00:00:00' , ( $get['contractStartUntil'] / 1000 ) );
                $variable[] = ' c.startDate <= ?';
            } elseif ( $get['contractStartFrom'] != null and $get['contractStartUntil'] != null ) {
                $value[] = date('Y-m-d 00:00:00' , ( $get['contractStartFrom'] / 1000 ) );
                $value[] = date('Y-m-d 00:00:00' , ( $get['contractStartUntil'] / 1000 ) );
                $variable[] = ' c.startDate between ? And ? ';
            }
            if ( $get['contractEndFrom'] != null and $get['contractEndUntil'] == null ) {
                $value[] = date('Y-m-d 23:59:59' , ( $get['contractEndFrom'] / 1000 ) );
                $variable[] = ' c.endDate >= ?';
            } elseif ( $get['contractEndFrom'] == null and $get['contractEndUntil'] != null ) {
                $value[] = date('Y-m-d 23:59:59' , ( $get['contractEndUntil'] / 1000 ) );
                $variable[] = ' c.endDate <= ?';
            } elseif ( $get['contractEndFrom'] != null and $get['contractEndUntil'] != null ) {
                $value[] = date('Y-m-d 23:59:59' , ( $get['contractEndFrom'] / 1000 ) );
                $value[] = date('Y-m-d 23:59:59' , ( $get['contractEndUntil'] / 1000 ) );
                $variable[] = ' c.endDate between ? And ? ';
            }

            if ( $get['groupIds'] != null ) {
                $value = array_merge($value , $get['groupIds']) ;
                $value[] = 0 ;
                $variable[] = 'c.contractGroup In ( '. str_repeat('? ,', count($get['groupIds'])).' ? )' ;
            }
            if ( $get['status'] != "all") {
                if ($get['status'] == "0") {
                    $variable[] = 'NOW() NOT between c.startDate and c.endDate';
                } else {
                    $variable[] = 'NOW() between c.startDate and c.endDate';
                }
            }
        }

        /* @var user_group $modelAccess */
        $modelAccess = $this->model(['user' , 'user_group']);
        $access = $modelAccess->search(null,null);
        $this->mold->set('access',$access);




        /* @var contracts $model */
        $model = parent::model('contracts');
        $numberOfAll = ($model->search( (array) $value  , ( count($variable) == 0 ) ? null : implode(' and ' , $variable) , 'contracts c' , 'COUNT(c.contractId) as co' )) [0]['co'];
        $pagination = parent::pagination($numberOfAll,$get['page'],$get['perEachPage']);
        model::join('user_group ug', ' c.contractGroup = ug.user_groupId ', "LEFT");
        model::join('user u', ' c.userId = u.userId ', "LEFT");
        $search = $model->search( (array) $value  , ( ( count($variable) == 0 ) ? null : implode(' and ' , $variable) )  , 'contracts c', 'c.*,u.fname,u.lname,u.email,ug.name, IF(NOW() between c.startDate and c.endDate, "1", "0") as status'  , $sortWith , [$pagination['start'] , $pagination['limit'] ] );
        //show(model::getLastQuery());
        $this->mold->path('default', 'contract');
        $this->mold->view('contractList.mold.html');
        $this->mold->setPageTitle(rlang('contracts'));
        $this->mold->set('activeMenu' , 'contractList');
        $this->mold->set('contracts' , $search);


    }
    public function listVote(){
        $get = request::all('page=1,perEachPage=25,voteSendFrom,voteSendUntil,voteCompletedFrom,voteCompletedUntil,status=all' ,null);
        $rules = [
            "page" => ["required|match:>0", rlang('page')],
            "perEachPage" => ["required|match:>0|match:<501", rlang('page')],
        ];
        $valid = validate::check($get, $rules);
        $value = array( );
        $variable = array( );
        $value[] = -1 ;
        $variable[] = 'c.contractId <> ?' ;
        $sortWith =  ['column' => 'c.contractId' , 'type' =>'desc'] ;
        if ($valid->isFail()){
            //TODO:: add error is not valid data

        } else {

            if ( $get['voteSendFrom'] != null and $get['voteSendUntil'] == null ) {
                $value[] = date('Y-m-d 00:00:00' , ( $get['voteSendFrom'] / 1000 ) );
                $variable[] = ' c.creatDate >= ?';
            } elseif ( $get['voteSendFrom'] == null and $get['voteSendUntil'] != null ) {
                $value[] = date('Y-m-d 00:00:00' , ( $get['voteSendUntil'] / 1000 ) );
                $variable[] = ' c.creatDate <= ?';
            } elseif ( $get['voteSendFrom'] != null and $get['voteSendUntil'] != null ) {
                $value[] = date('Y-m-d 00:00:00' , ( $get['voteSendFrom'] / 1000 ) );
                $value[] = date('Y-m-d 00:00:00' , ( $get['voteSendUntil'] / 1000 ) );
                $variable[] = ' c.creatDate between ? And ? ';
            }
            if ( $get['voteCompletedFrom'] != null and $get['voteCompletedUntil'] == null ) {
                $value[] = date('Y-m-d 23:59:59' , ( $get['voteCompletedFrom'] / 1000 ) );
                $variable[] = ' c.fillOutDate >= ?';
            } elseif ( $get['voteCompletedFrom'] == null and $get['voteCompletedUntil'] != null ) {
                $value[] = date('Y-m-d 23:59:59' , ( $get['voteCompletedUntil'] / 1000 ) );
                $variable[] = ' c.fillOutDate <= ?';
            } elseif ( $get['voteCompletedFrom'] != null and $get['voteCompletedUntil'] != null ) {
                $value[] = date('Y-m-d 23:59:59' , ( $get['voteCompletedFrom'] / 1000 ) );
                $value[] = date('Y-m-d 23:59:59' , ( $get['voteCompletedUntil'] / 1000 ) );
                $variable[] = ' c.fillOutDate between ? And ? ';
            }

            if ( $get['status'] != "all") {
                if ($get['status'] == "0") {
                    $variable[] = 'c.fillOutDate is null';
                } else {
                    $variable[] = 'c.fillOutDate is not null';
                }
            }
        }



        /* @var contracts_vote $model */
        $model = parent::model('contracts_vote');
        $numberOfAll = ($model->search( (array) $value  , ( count($variable) == 0 ) ? null : implode(' and ' , $variable) , 'contracts_vote c' , 'COUNT(c.fillOutId) as co' )) [0]['co'];
        $pagination = parent::pagination($numberOfAll,$get['page'],$get['perEachPage']);
        model::join('vote v', ' c.voteId = v.voteId ', "LEFT");
        model::join('user u', ' c.userId = u.userId ', "LEFT");
        model::join('contracts co', ' c.contractId = co.contractId ', "LEFT");
        model::join('user_group ug', ' u.user_group_id = ug.user_groupId ', "LEFT");
        $search = $model->search( (array) $value  , ( ( count($variable) == 0 ) ? null : implode(' and ' , $variable) )  , 'contracts_vote c', 'c.*,co.userId as contactUserId,v.voteName,u.fname,u.lname,ug.name, IF(c.fillOutDate is not null, "1", "0") as status'  , $sortWith , [$pagination['start'] , $pagination['limit'] ] );
        //show(model::getLastQuery());
        $this->mold->path('default', 'contract');
        $this->mold->view('contractVoteList.mold.html');
        $this->mold->setPageTitle(rlang(['Poll','contracts']));
        $this->mold->set('activeMenu' , 'contractVoteList');
        $this->mold->set('contracts' , $search);


    }
}