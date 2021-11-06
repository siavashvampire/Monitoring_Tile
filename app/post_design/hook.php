<?php

namespace App\post_design;

use app;
use App\core\controller\fieldService;
use App\user\app_provider\api\user;
use paymentCms\component\cache;
use paymentCms\component\model;
use pluginController;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class hook extends pluginController
{
    public function _adminHeaderNavbar($vars2)
    {
        $this->menu->after('users', 'postTab', 'نامه', "#", 'fa fa-file-text-o', '', null, 'admin/post/list/post_design');
        $this->menu->addChild('postTab', 'post', 'فرم ساز', app::getBaseAppLink('post/newType', 'admin'), 'fa fa-id-badge', '', 'admin/post/newType/post_design');
        $this->menu->addChild('postTab', 'post_list', 'لیست نامه ها', app::getBaseAppLink('post/list', 'admin'), 'fa fa-list-ol', '',  'admin/post/list/post_design');
        $this->menu->addChild('postTab', 'post_insert', 'ثبت نامه جدید', app::getBaseAppLink('post', 'admin'), 'fa fa-check-square-o', '',  'admin/post/index/post_design');
        $user = user::getUserLogin();
        $contractsVote = model::searching([$user['userId']], ' userId	= ? and fillOutDate is null', 'contracts_vote', '*');

        if ($contractsVote !== true and count($contractsVote) > 0) {
            $this->mold->set('firstFillOutId', $contractsVote[0]['fillOutId']);
            $this->mold->set('firstFillOutIdCount', count($contractsVote));

            $getPath = $this->mold->getPath();
            $this->mold->path('default', 'post_design');
            $this->mold->view('newVote.admin.hook.mold.html');
            $this->mold->path($getPath['folder'], $getPath['app']);
        }
    }

    public function _userProfileShowInAdmin($user, $fields)
    {
        $getPath = $this->mold->getPath();
        $this->mold->path('default', 'post_design');

		$contracts = model::searching([$user->getUserId()],' userId	= ? ' ,'contracts','*');
		$this->mold->set('listGroups', $contracts);

        $this->mold->view('contracts.user.hook.mold.html');
        $this->mold->path($getPath['folder'], $getPath['app']);
    }


    public function _adminDashboard()
    {
    }

    public function _doBeforeLoginWithPhase()
    {
        if (cache::get('lastContractCheck', null, 'post_design') != date('Y-m-d')) {
            model::join('contracts contracts', '( contracts.contractGroup = vote.contractGroup and DATE_SUB(DATE_FORMAT(contracts.endDate, "%Y-%m-%d") , INTERVAL vote.ShowToReceiver DAY) = DATE_FORMAT(NOW(), "%Y-%m-%d" ) )', 'INNER');
            $listTypeVote = model::searching([1], ' ? and ShowToReceiver >= 0 and ShowToReceiver is not null ', 'vote vote', 'contracts.contractId,contracts.userId,vote.voteId,vote.checkByUnit');

            $cacheUnitId = [];
            $cachePhaseId = [];
            $cacheUsersShouldSearch = [];
            foreach ($listTypeVote as $TypeVote) {
                /* @var contracts_vote $contractVote */
                $contractVote = $this->model(['post_design', 'contracts_vote']);
                $contractVote->setContractId($TypeVote['contractId']);
                $contractVote->setVoteId($TypeVote['voteId']);
                $contractVote->setCreatDate(date('Y-m-d H:i:s'));
                $userFind = null;
                /* @var vote $vote */
                $vote = $this->model(['post_design', 'vote'] , $TypeVote['voteId'] );
                if ($TypeVote['checkByUnit']) {
                    if (!isset($cacheUnitId[$TypeVote['userId']])) {
                        $user = user::getUserById($TypeVote['userId']);
                        $fields = fieldService::showFilledOutFormWithAllFields($user->getUserGroupId(), 'user_register', $user->getUserId(), 'user_register', true);
                        $unitId = null;
                        $phase = null;
                        if (is_array($fields['result'])) {
                            foreach ($fields['result'] as $index => $fields) {
                                if ($fields['type'] == 'fieldCall_units_units') {
                                    $unitId = $fields['value'];
                                } elseif ($fields['type'] == 'fieldCall_LineMonitoring_phase') {
                                    $phase = $fields['value'];
                                }
                                if ($unitId != null and $phase != null) break;
                            }
                        }
                        unset($fields);
                        $cacheUnitId[$TypeVote['userId']] = $unitId;
                        $cachePhaseId[$TypeVote['userId']] = $phase;
                    }
                    else {
                        $unitId = $cacheUnitId[$TypeVote['userId']];
                        $phase = $cachePhaseId[$TypeVote['userId']];
                    }

                    if (!isset($cacheUsersShouldSearch[$vote->getVoteReceiver()])) {
                        $usersShouldSearch = model::searching([$vote->getVoteReceiver()], ' user_group_id 	= ? and block = 0 and verified = 1 ', 'user', '*');
                        $cacheUsersShouldSearch[$vote->getVoteReceiver()] = $usersShouldSearch;
                    }
                    else
                        $usersShouldSearch = $cacheUsersShouldSearch[$vote->getVoteReceiver()];
                    if ($unitId != null and $phase != null and count($usersShouldSearch) > 0) {
                        foreach ($usersShouldSearch as $index => $userSearched) {
                            if (!isset($cacheUnitId[$userSearched['userId']])) {
                                $tempUserFindUnit = null;
                                $tempValueFindUnit = null;
                                $tempUserFindPhase = null;
                                $tempValueFindPhase = null;
                                $fields = fieldService::showFilledOutFormWithAllFields($userSearched['user_group_id'], 'user_register', $userSearched['userId'], 'user_register', true);
                                if (is_array($fields['result'])) {
                                    foreach ($fields['result'] as $index2 => $fields) {
                                        if ($fields['type'] == 'fieldCall_units_units') {
                                            if ($unitId == $fields['value']) {
                                                $tempUserFindUnit = $userSearched['userId'];
                                                $tempValueFindUnit = $fields['value'];
                                            }
                                        } elseif ($fields['type'] == 'fieldCall_LineMonitoring_phase') {
                                            if ($phase == $fields['value']) {
                                                $tempUserFindPhase = $userSearched['userId'];
                                                $tempValueFindPhase = $fields['value'];
                                            }
                                        }
                                        if ($tempUserFindUnit != null and $tempUserFindPhase == $tempUserFindUnit) {
                                            $userFind = $userSearched['userId'];
                                            $cacheUnitId[$userSearched['userId']] = $tempValueFindUnit;
                                            $cachePhaseId[$userSearched['userId']] = $tempValueFindPhase;
                                            break;
                                        }
                                    }
                                    if ($userFind != null) break;
                                }
                                unset($fields);
                            }
                            else {
                                if ($unitId == $cacheUnitId[$userSearched['userId']] and $phase == $cachePhaseId[$userSearched['userId']]) {
                                    $userFind = $userSearched['userId'];
                                    break;
                                }
                            }
                        }
                    }
                    elseif ($unitId != null and $phase == null and count($usersShouldSearch) > 0) {
                        foreach ($usersShouldSearch as $index => $userSearched) {
                            if (!isset($cacheUnitId[$userSearched['userId']])) {
                                $fields = fieldService::showFilledOutFormWithAllFields($userSearched['user_group_id'], 'user_register', $userSearched['userId'], 'user_register', true);
                                if (is_array($fields['result'])) {
                                    foreach ($fields['result'] as $index2 => $fields) {
                                        if ($fields['type'] == 'fieldCall_units_units') {
                                            if ($unitId == $fields['value']) {
                                                $userFind = $userSearched['userId'];
                                            }
                                            $cacheUnitId[$userSearched['userId']] = $fields['value'];
                                            break;
                                        }
                                    }
                                    if ($userFind != null) break;
                                }
                                unset($fields);
                            } else {
                                if ($unitId == $cacheUnitId[$userSearched['userId']]) {
                                    $userFind = $userSearched['userId'];
                                    break;
                                }
                            }
                        }
                    }
                    elseif ($unitId == null and $phase != null and count($usersShouldSearch) > 0) {
                        foreach ($usersShouldSearch as $index => $userSearched) {
                            if (!isset($cachePhaseId[$userSearched['userId']])) {
                                $fields = fieldService::showFilledOutFormWithAllFields($userSearched['user_group_id'], 'user_register', $userSearched['userId'], 'user_register', true);
                                if (is_array($fields['result'])) {
                                    foreach ($fields['result'] as $index2 => $fields) {
                                        if ($fields['type'] == 'fieldCall_LineMonitoring_phase') {
                                            if ($phase == $fields['value']) {
                                                $userFind = $userSearched['userId'];
                                            }
                                            $cachePhaseId[$userSearched['userId']] = $fields['value'];
                                            break;
                                        }
                                    }
                                    if ($userFind != null) break;
                                }
                                unset($fields);
                            } else {
                                if ($phase == $cachePhaseId[$userSearched['userId']]) {
                                    $userFind = $userSearched['userId'];
                                    break;
                                }
                            }
                        }
                    }
                    elseif ($unitId == null and $phase == null and count($usersShouldSearch) > 0) {
                        $userFind = $usersShouldSearch[0]['userId'];
                    }
                    unset($usersShouldSearch);
                } else {

                    if (!isset($cacheUsersShouldSearch[$vote->getVoteReceiver()])) {
                        $usersShouldSearch = model::searching([$vote->getVoteReceiver()], ' user_group_id 	= ? and block = 0 and verified = 1 ', 'user', '*');
                        $cacheUsersShouldSearch[$vote->getVoteReceiver()] = $usersShouldSearch;
                    } else
                        $usersShouldSearch = $cacheUsersShouldSearch[$vote->getVoteReceiver()];
                    if (count($usersShouldSearch) > 0) {
                        $userFind = $usersShouldSearch[0]['userId'];
                    }
                    unset($usersShouldSearch);
                }

                if ($userFind == null) {
                    break;
                }

                $contractVote->setUserId($userFind);
                $contractVote->insertToDataBase();
            }
            cache::save(date('Y-m-d'), 'lastContractCheck', 48 * 60 * 60, 'post_design');
        }
    }

    public function _doBeforeLogin(){
        if (cache::get('lastContractCheck', null, 'post_design') != date('Y-m-d')) {
            model::join('contracts contracts', '( contracts.contractGroup = vote.contractGroup and DATE_SUB(DATE_FORMAT(contracts.endDate, "%Y-%m-%d") , INTERVAL vote.ShowToReceiver DAY) = DATE_FORMAT(NOW(), "%Y-%m-%d" ) )', 'INNER');
            $listTypeVote = model::searching([1], ' ? and ShowToReceiver >= 0 and ShowToReceiver is not null ', 'vote vote', 'contracts.contractId,contracts.userId,vote.voteId,vote.checkByUnit');


            $cacheUnitId = [];
            $cacheUsersShouldSearch = [];
            foreach ($listTypeVote as $TypeVote) {
                /* @var contracts_vote $contractVote */
                $contractVote = $this->model(['post_design', 'contracts_vote']);
                $contractVote->setContractId($TypeVote['contractId']);
                $contractVote->setVoteId($TypeVote['voteId']);
                $contractVote->setCreatDate(date('Y-m-d H:i:s'));
                $userFind = null;
                /* @var vote $vote */
                $vote = $this->model(['post_design', 'vote'] , $TypeVote['voteId'] );
                if ($TypeVote['checkByUnit']) {
                    if (!isset($cacheUnitId[$TypeVote['userId']])) {
                        $user = user::getUserById($TypeVote['userId']);
                        $fields = fieldService::showFilledOutFormWithAllFields($user->getUserGroupId(), 'user_register', $user->getUserId(), 'user_register', true);
                        $unitId = null;
                        if (is_array($fields['result'])) {
                            foreach ($fields['result'] as $index => $fields) {
                                if ($fields['type'] == 'fieldCall_units_units') {
                                    $unitId = $fields['value'];
                                    break;
                                }
                            }
                        }
                        unset($fields);
                        $cacheUnitId[$TypeVote['userId']] = $unitId;
                    }
                    else {
                        $unitId = $cacheUnitId[$TypeVote['userId']];
                    }
                    if ( $unitId == -4  ) $unitId = null ;
                    if (!isset($cacheUsersShouldSearch[$vote->getVoteReceiver()])) {
                        $usersShouldSearch = model::searching([$vote->getVoteReceiver()], ' user_group_id 	= ? and block = 0 and verified = 1 ', 'user', '*');
                        $cacheUsersShouldSearch[$vote->getVoteReceiver()] = $usersShouldSearch;
                        if ( isset($this->userGroupOneInSendVote[$vote->getVoteReceiver()]) ){
                            foreach ($this->userGroupOneInSendVote[$vote->getVoteReceiver()] as $newGroups) {
                                $usersShouldSearch = model::searching([$newGroups], ' user_group_id 	= ? and block = 0 and verified = 1 ', 'user', '*');
                                $cacheUsersShouldSearch[$vote->getVoteReceiver()] = array_merge($cacheUsersShouldSearch[$vote->getVoteReceiver()] , $usersShouldSearch);
                            }
                        }
                    }

                    $usersShouldSearch = $cacheUsersShouldSearch[$vote->getVoteReceiver()];

                    if ($unitId != null and count($usersShouldSearch) > 0) {
                        foreach ($usersShouldSearch as $index => $userSearched) {
                            if (!isset($cacheUnitId[$userSearched['userId']])) {
                                $fields = fieldService::showFilledOutFormWithAllFields($userSearched['user_group_id'], 'user_register', $userSearched['userId'], 'user_register', true);
                                if (is_array($fields['result'])) {
                                    foreach ($fields['result'] as $index2 => $fields) {
                                        if ($fields['type'] == 'fieldCall_units_units') {
                                            if ($unitId == $fields['value'] or $fields['value'] == -4 ) {
                                                $userFind = $userSearched['userId'];
                                            }
                                            if ( isset($this->unitsOneInSendVote[$fields['value']]) and in_array($unitId , $this->unitsOneInSendVote[$fields['value']] )){
                                                $userFind = $userSearched['userId'];
                                            }
                                            $cacheUnitId[$userSearched['userId']] = $fields['value'];
                                            break;
                                        }
                                    }
                                    if ($userFind != null) break;
                                }
                                unset($fields);
                            } else {
                                if ($unitId == $cacheUnitId[$userSearched['userId']] or $cacheUnitId[$userSearched['userId']] == -4 ) {
                                    $userFind = $userSearched['userId'];
                                    break;
                                }
                                if ( isset($this->unitsOneInSendVote[$cacheUnitId[$userSearched['userId']]]) and in_array($unitId , $this->unitsOneInSendVote[$cacheUnitId[$userSearched['userId']]] )){
                                    $userFind = $userSearched['userId'];
                                    break;
                                }
                            }
                        }
                    }
                    elseif ($unitId == null  and count($usersShouldSearch) > 0) {
                        $userFind = $usersShouldSearch[0]['userId'];
                    }
                    unset($usersShouldSearch);
                } else {

                    if (!isset($cacheUsersShouldSearch[$vote->getVoteReceiver()])) {
                        $usersShouldSearch = model::searching([$vote->getVoteReceiver()], ' user_group_id 	= ? and block = 0 and verified = 1 ', 'user', '*');
                        $cacheUsersShouldSearch[$vote->getVoteReceiver()] = $usersShouldSearch;
                    } else
                        $usersShouldSearch = $cacheUsersShouldSearch[$vote->getVoteReceiver()];
                    if (count($usersShouldSearch) > 0) {
                        $userFind = $usersShouldSearch[0]['userId'];
                    }
                    unset($usersShouldSearch);
                }

                if ($userFind == null) {
                    continue;
                }
                $contractVote->setUserId($userFind);
                $contractVote->insertToDataBase();
            }
            cache::save(date('Y-m-d'), 'lastContractCheck', 48 * 60 * 60, 'post_design');
        }
    }


    public function _settingFooter()
    {
        $getPath = $this->mold->getPath();
        $this->mold->path('default', 'post_design');
        $Groups = user::getGroups()["result"];
        $fieldsOf = [];
        if (is_array($Groups)) {
            foreach ($Groups as $group) {
                $fieldsOf[] = ['name' => $group['name'], 'groupId' => $group['user_groupId']];
            }
        }
        $this->mold->set('listGroups', $fieldsOf);

        $this->mold->view('configuration.system.mold.html');
        $this->mold->path($getPath['folder'], $getPath['app']);
        $this->mold->set('dirStartUP', payment_path . 'startup');
    }

}