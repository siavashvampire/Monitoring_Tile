<?php

namespace App\contract\app_provider\admin;

use app;
use App\core\controller\fieldService;
use App\core\controller\httpErrorHandler;
use App\contract\model\contracts;
use App\contract\model\contracts_vote;
use App\contract\model\vote;
use App\user\app_provider\api\user;
use App\user\model\user_group;
use controller;
use paymentCms\component\JDate;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class contractAction extends controller
{
    public function index($userId, $contractId = null)
    {
        $user = user::getUserById($userId);

        if ($user->getUserId() == null) {
            httpErrorHandler::E404();
            return false;
        }
        if (request::isPost('daysExpire')) {
            $contractId = $this->updateContract($user, $contractId);
        }
        if ($contractId != null) {
            /* @var contracts $contract */
            $contract = $this->model(['contract', 'contracts'], $contractId);
            if ($contract->getContractId() != $contractId or $contract->getUserId() != $user->getUserId()) {
                httpErrorHandler::E404();
                return false;
            }
            $fields = fieldService::showFilledOutFormWithAllFields($user->getUserGroupId(), 'contract_with_user', $contract->getContractId(), 'contract_with_user', true, $this->mold);

            $this->mold->set('contract', $contract);

            model::join('vote vote', 'vote.voteId = contracts_vote.voteId');
            $votesDoneForm = model::searching([$contract->getContractId()], ' contracts_vote.contractId = ? ', 'contracts_vote contracts_vote', '*');
            if (count($votesDoneForm) == 0) $votesDoneForm = true;
            $this->mold->set('votesDoneForm', $votesDoneForm);

            $votesForm = model::searching([$user->getUserGroupId()], ' contractGroup = ? ', 'vote', '*');

            $this->mold->set('votesForm', $votesForm);


            $this->mold->set('contractor', user::getUserById($contract->getContractor()));

            /* @var user_group $modelUserGroup */
            $modelUserGroup = $this->model(['user', 'user_group'], $user->getUserGroupId());
            $contractTemplate = str_replace(
                [
                    '[|FN|]',
                    '[|LN|]',
                    '[|N|]',
                    '[|P|]',
                    '[|E|]',
                    '[|D|]',
                    '[|T|]',
                    '[|SC|]',
                    '[|SE|]',
                    '[|SD|]'
                ],
                [
                    $user->getFname(),
                    $user->getLname(),
                    $user->getName(),
                    $user->getPhone(),
                    $user->getEmail(),
                    JDate::jdate('Y/m/d'),
                    JDate::jdate('H:i:s'),
                    JDate::jdate('Y/m/d', strtotime($contract->getStartDate())),
                    JDate::jdate('Y/m/d', strtotime($contract->getEndDate())),
                    $contract->getContractDays(),
                ],
                $modelUserGroup->getContractTemplate()
            );
            if (is_array($fields['result']))
                foreach ($fields['result'] as $field)
                    $contractTemplate = str_replace('[|C' . $field['fieldId'] . '|]', $field['value'], $contractTemplate);
            $fields = fieldService::showFilledOutFormWithAllFields($user->getUserGroupId(), 'user_register', $user->getUserId(), 'user_register', true);
            if (is_array($fields['result']))
                foreach ($fields['result'] as $field)
                    $contractTemplate = str_replace('[|U' . $field['fieldId'] . '|]', $field['value'], $contractTemplate);
            $this->mold->set('contractTemplate', $contractTemplate);
        } else {
            $fields = fieldService::getFieldsToFillOut($user->getUserGroupId(), 'contract_with_user', $this->mold);
        }

        $this->mold->set('showVote', isset($_GET['voteShow']));
        $this->mold->set('user', $user);
        $this->mold->path('default', 'contract');
        $this->mold->view('contracts.viewAjax.mold.html');
    }

    public function otherVoted( $userId , $contractId )
    {
        $user = user::getUserById($userId);
        if ($user->getUserId() == null) {
            httpErrorHandler::E404();
            return false;
        }
        /* @var contracts $contract */
        $contract = $this->model(['contract', 'contracts'], $contractId);
        if ($contract->getContractId() != $contractId or $contract->getUserId() != $user->getUserId()) {
            httpErrorHandler::E404();
            return false;
        }
        model::join('vote vote', 'vote.voteId = contracts_vote.voteId');
        $votesDoneForm = model::searching([$contract->getContractId()], ' contracts_vote.contractId = ? ', 'contracts_vote contracts_vote', '*');
        if (count($votesDoneForm) == 0) $votesDoneForm = true;
        $this->mold->set('votesDoneForm', $votesDoneForm);
        $this->mold->path('default', 'contract');
        $this->mold->view('contractsVoted.viewAjax.mold.html');
    }

    public function printContract($userId, $contractId)
    {
        $user = user::getUserById($userId);

        if ($user->getUserId() == null) {
            httpErrorHandler::E404();
            return false;
        }


        /* @var contracts $contract */
        $contract = $this->model(['contract', 'contracts'], $contractId);
        if ($contract->getContractId() != $contractId or $contract->getUserId() != $user->getUserId()) {
            httpErrorHandler::E404();
            return false;
        }
        $fields = fieldService::showFilledOutFormWithAllFields($user->getUserGroupId(), 'contract_with_user', $contract->getContractId(), 'contract_with_user', true, $this->mold);
        $fieldsUser = fieldService::showFilledOutFormWithAllFields($user->getUserGroupId(), 'user_register', $user->getUserId(), 'user_register', true);

        $this->mold->set('contract', $contract);
        $this->mold->set('fieldsUser', $fieldsUser['result']);

        model::join('vote vote', 'vote.voteId = contracts_vote.voteId');
        $votesDoneForm = model::searching([$contract->getContractId()], ' contracts_vote.contractId = ? ', 'contracts_vote contracts_vote', '*');
        if (count($votesDoneForm) > 0 and $votesDoneForm != null) {
            foreach ($votesDoneForm as $key => $votes) {
                $fields = fieldService::showFilledOutFormWithAllFields($votes['voteId'], 'contract_vote', $votes['fillOutId'], 'contract_vote', true);
                $votesDoneForm[$key]['fields'] = $fields['result'];
            }


            $this->mold->set('votesDoneForm', $votesDoneForm);
        }
        $this->mold->set('contractor', user::getUserById($contract->getContractor()));


        $this->mold->set('user', $user);
        $this->mold->unshow('header.mold.html', 'footer.mold.html');
        $this->mold->path('default', 'contract');
        $this->mold->view('contracts.print.mold.html');
    }

    public function showFillVote($fillOutId)
    {


        /* @var contracts_vote $contracts_vote */
        $contracts_vote = $this->model(['contract', 'contracts_vote'], $fillOutId);
        if ($contracts_vote->getFillOutId() != $fillOutId) {
            httpErrorHandler::E404();
            return false;
        }
        $fields = fieldService::showFilledOutFormWithAllFields($contracts_vote->getVoteId(), 'contract_vote', $contracts_vote->getFillOutId(), 'contract_vote', true, $this->mold);

        /* @var vote $vote */
        $vote = $this->model(['contract', 'vote'], $contracts_vote->getVoteId());
        $this->mold->set('vote', $vote);
        $this->mold->set('contracts_vote', $contracts_vote);

        $this->mold->set('fillOutBy', user::getUserById($contracts_vote->getUserId()));

        $this->mold->path('default', 'contract');
        $this->mold->view('contractsVote.viewAjax.mold.html');
    }

    public function sendVote($contractId)
    {
        /* @var contracts $contract */
        $contract = $this->model(['contract', 'contracts'], $contractId);
        if ($contract->getContractId() != $contractId) {
//			httpErrorHandler::E404();
//			return false ;
        }
        $get = request::post('voteId', null);
        $rules = [
            "voteId" => ["required|int|match:>0", 'نوع نظرسنجی'],
        ];
        $valid = validate::check($get, $rules);
        if ($valid->isFail()) {
            $this->mold->set('errors', $valid->errorsIn());
            $this->index($contract->getUserId(), $contract->getContractId());
            return null;
        }
        /* @var vote $vote */
        $vote = $this->model(['contract', 'vote'], $get['voteId']);
        if ($vote->getVoteId() != $get['voteId'] or $vote->getContractGroup() != $contract->getContractGroup()) {
            httpErrorHandler::E404();
            return false;
        }
        /* @var contracts_vote $contractVote */
        $contractVote = $this->model(['contract', 'contracts_vote']);
        $contractVote->setContractId($contract->getContractId());
        $contractVote->setVoteId($vote->getVoteId());
        $contractVote->setCreatDate(date('Y-m-d H:i:s'));
        $userFind = null;
        if ($vote->getCheckByUnit()) {
            $user = user::getUserById($contract->getUserId());
            $fields = fieldService::showFilledOutFormWithAllFields($user->getUserGroupId(), 'user_register', $user->getUserId(), 'user_register', true);
            $unitId = null;
            $phase = null;
            if (is_array($fields['result'])) {
                foreach ($fields['result'] as $index => $fields) {
                    if ($fields['type'] == 'fieldCall_contract_units') {
                        $unitId = $fields['value'];
                    } elseif ($fields['type'] == 'fieldCall_contract_phase') {
                        $phase = $fields['value'];
                    }
                    if ($unitId != null and $phase != null) break;
                }
            }

            $usersShouldSearch = model::searching([$vote->getVoteReceiver()], ' user_group_id 	= ? and block = 0 and verified = 1 ', 'user', '*');
            if ($unitId != null and $phase != null and count($usersShouldSearch) > 0) {
                foreach ($usersShouldSearch as $index => $userSearched) {
                    $tempUserFindUnit = null;
                    $tempUserFindPhase = null;
                    $fields = fieldService::showFilledOutFormWithAllFields($userSearched['user_group_id'], 'user_register', $userSearched['userId'], 'user_register', true);
                    if (is_array($fields['result'])) {
                        foreach ($fields['result'] as $index2 => $fields) {
                            if ($fields['type'] == 'fieldCall_contract_units') {
                                if ($unitId == $fields['value']) {
                                    $tempUserFindUnit = $userSearched['userId'];
                                }
                            } elseif ($fields['type'] == 'fieldCall_contract_phase') {
                                if ($phase == $fields['value']) {
                                    $tempUserFindPhase = $userSearched['userId'];
                                }
                            }
                            if ($tempUserFindUnit != null and $tempUserFindPhase == $tempUserFindUnit) {
                                $userFind = $tempUserFindUnit;
                                break;
                            }
                        }
                        if ($userFind != null) break;
                    }
                }
            } elseif ($unitId != null and $phase == null and count($usersShouldSearch) > 0) {
                foreach ($usersShouldSearch as $index => $userSearched) {
                    $fields = fieldService::showFilledOutFormWithAllFields($userSearched['user_group_id'], 'user_register', $userSearched['userId'], 'user_register', true);
                    if (is_array($fields['result'])) {
                        foreach ($fields['result'] as $index2 => $fields) {
                            if ($fields['type'] == 'fieldCall_contract_units') {
                                if ($unitId == $fields['value']) {
                                    $userFind = $userSearched['userId'];
                                }
                                break;
                            }
                        }
                        if ($userFind != null) break;
                    }
                }
            } elseif ($unitId == null and $phase != null and count($usersShouldSearch) > 0) {
                foreach ($usersShouldSearch as $index => $userSearched) {
                    $fields = fieldService::showFilledOutFormWithAllFields($userSearched['user_group_id'], 'user_register', $userSearched['userId'], 'user_register', true);
                    if (is_array($fields['result'])) {
                        foreach ($fields['result'] as $index2 => $fields) {
                            if ($fields['type'] == 'fieldCall_contract_phase') {
                                if ($phase == $fields['value']) {
                                    $userFind = $userSearched['userId'];
                                }
                                break;
                            }
                        }
                        if ($userFind != null) break;
                    }
                }
            } elseif ($unitId == null and count($usersShouldSearch) > 0) {
                $userFind = $usersShouldSearch[0]['userId'];
            }
            unset($usersShouldSearch);
        } else {
            //$user = user::getUserById($contract->getUserId());
            $usersShouldSearch = model::searching([$vote->getVoteReceiver()], ' user_group_id 	= ? and block = 0 and verified = 1 ', 'user', '*');
            if (count($usersShouldSearch) > 0) {
                $userFind = $usersShouldSearch[0]['userId'];
            }
            unset($usersShouldSearch);
        }

        if ($userFind == null) {
            $this->mold->set('errors', 'کاربری برای تکمیل فرم یافت نشد!');
            $this->index($contract->getUserId(), $contract->getContractId());
            return null;
        }

        $contractVote->setUserId($userFind);
        if ($contractVote->insertToDataBase())
            $this->mold->set('success', 'نظرسنجی با موفقیت برای کاربر مد نظر ایجاد شد!');
        else
            $this->mold->set('errors', 'لطفا مجددا تلاش کنید!');
        $this->index($contract->getUserId(), $contract->getContractId());
        return null;
    }

    public function listVote($status = false)
    {
        if ($status) {
            $this->alert('success', '', 'نظر شما با موفقیت ثبت شد.');
        }
        $userId = user::getUserLogin(true);

        model::join('contracts contracts', 'contracts.contractId =  contracts_vote.contractId');
        model::join('user user', 'contracts.userId =  user.userId');
        $contractsVote = model::searching([$userId], ' contracts_vote.userId	= ?  and fillOutDate is null', 'contracts_vote contracts_vote', 'user.fname,user.lname,contracts_vote.fillOutId,contracts_vote.creatDate');
        if ($contractsVote !== true and count($contractsVote) == 0) {
            Response::redirect(app::getBaseAppLink('home', 'admin'));
            return null;
        }
        if ($contractsVote !== true and count($contractsVote) == 1) {
            Response::redirect(app::getBaseAppLink('contractAction/fill/' . $contractsVote[0]['fillOutId'] , 'admin'));
            return null;
        }
        if ($contractsVote !== true and count($contractsVote) > 1)
            $this->mold->set('contractsVote', $contractsVote);

        $this->mold->path('default', 'contract');
        $this->mold->view('financeDepartmentList.mold.html');
        $this->mold->setPageTitle(rlang('Polls'));
    }

    public function fill($voteFillId, $status = false)
    {
        if ($status) {
            $this->alert('success', '', 'نظر شما با موفقیت ثبت شد.');
        }
        $userId = user::getUserLogin(true);
        /* @var contracts_vote $contractVote */
        $contractVote = $this->model(['contract', 'contracts_vote'], $voteFillId);
        if ($contractVote->getUserId() != $userId or $contractVote->getFillOutId() != $voteFillId) {
            httpErrorHandler::E404();
            return null;
        }

        /* @var contracts $contract */
        $contract = $this->model(['contract', 'contracts'], $contractVote->getContractId());
        $goNext = false;
        if (request::isPost('customField')) {
            $get = request::post('customField', null);

            $resultFillOutForm = fieldService::fillOutForm($contractVote->getVoteId(), 'contract_vote', $get['customField'], $contractVote->getFillOutId(), 'contract_vote');
            if ($resultFillOutForm['status']) {
                $contractVote->setFillOutDate(date('Y-m-d H:i:s'));
                if ($contractVote->upDateDataBase()) {
                    $this->alert('success', '', 'نظر شما با موفقیت ثبت شد.');
                    $goNext = true;
                } else {
                    $this->alert('success', '', 'لطفا مجددا تلاش کنید!');
                }
            } else {
                $this->alert('success', '', 'لطفا مجددا تلاش کنید!');
            }
        }
        model::join('contracts contracts', 'contracts.contractId =  contracts_vote.contractId');
        model::join('user user', 'contracts.userId =  user.userId');
        $contractsVote = model::searching([$userId], ' contracts_vote.userId	= ?  and fillOutDate is null', 'contracts_vote contracts_vote', 'user.fname,user.lname,contracts_vote.fillOutId');
        if ($contractsVote !== true and count($contractsVote) == 0) {
            Response::redirect(app::getBaseAppLink('home', 'admin'));
            return null;
        }
        if ($goNext and $contractsVote !== true and count($contractsVote) >= 1) {
            Response::redirect(app::getBaseAppLink('contractAction/listVote/1', 'admin'));
            return null;
        }

        $this->mold->set('user', user::getUserById($contract->getUserId()));
        $this->mold->set('contractVote', $contractVote);

        $fields = fieldService::getFieldsToFillOut($contractVote->getVoteId(), 'contract_vote', $this->mold);
//		show($fields);
        $this->mold->path('voteFillId', $voteFillId);
        $this->mold->path('default', 'contract');
        $this->mold->view('financeDepartment.mold.html');
        $this->mold->setPageTitle('نظرسنجی');
    }

    private function updateContract($user, $contractId = null)
    {
        $get = request::post('daysExpire,startDate,customField', null);
        $rules = [
            "daysExpire" => ["required|int|match:>0", 'تعداد روز قرارداد'],
            "startDate" => ["required", 'تاریخ شروع قرارداد'],
        ];
        $valid = validate::check($get, $rules);
        if ($valid->isFail()) {
            $this->mold->set('errors', $valid->errorsIn());
            return null;
        }
//        show($get['daysExpire']);
        /* @var contracts $contract */
        /* @var \paymentCms\model\user $user */
        if ($contractId == null) {
            $contract = $this->model(['contract', 'contracts']);
        } else {
            $contract = $this->model(['contract', 'contracts'], $contractId);
            if ($contract->getContractId() != $contractId or $contract->getUserId() != $user->getUserId()) {
                httpErrorHandler::E404();
                return false;
            }
        }

        $dateShamsi = explode('/', $get['startDate']);
        $dataStartJalali = JDate::jalali_to_gregorian($dateShamsi[0], $dateShamsi[1], $dateShamsi[2], "-") . ' 00:00:00';
        $dataEndJalali = date('Y-m-d 23:59:59', strtotime($dataStartJalali . ' +' . $get['daysExpire'] . ' day'));

        $contract->setUserId($user->getUserId());
        $contract->setEndDate($dataEndJalali);
        $contract->setStartDate($dataStartJalali);
        $contract->setContractor(user::getUserLogin(true));
        $contract->setContractGroup($user->getUserGroupId());

        if ($contractId == null) {
            if ($contract->insertToDataBase()) {
                $resultFillOutForm = fieldService::fillOutForm($user->getUserGroupId(), 'contract_with_user', $get['customField'], $contract->getContractId(), 'contract_with_user');
            }
        } else {
            if ($contract->upDateDataBase()) {
                $resultFillOutForm = fieldService::updateFillOutForm($user->getUserGroupId(), 'contract_with_user', $get['customField'], $contract->getUserId(), 'contract_with_user');
            }
        }

        $this->mold->set('success', 'قرار داد جدید نوشته شد.');
        return $contract->getContractId();
    }
}