<?php

namespace App\contract;

use app;
use App\contract\model\vote;
use App\core\controller\fieldService;
use App\contract\model\contracts_vote;
use App\user\app_provider\api\user;
use paymentCms\component\cache;
use paymentCms\component\model;
use pluginController;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class hook extends pluginController
{
    private $unitsOneInSendVote = [
        '1' => [ 2, 3 , 4 ], // sarparsti ba unit id 1 , javabe nazarsanji unit haye 2 , 3 , 4 ra midahad
        '8' => [ 5, 6 , 7 ], // sarparsti ba unit id 8 , javabe nazarsanji unit haye 5 , 6 , 7 ra midahad
    ];
    public function _adminHeaderNavbar($vars2)
    {
        $this->menu->after('users', 'contractTab', 'قرارداد', "#", 'fa fa-file-text-o', '', null, 'admin/contract/list/contract');
        $this->menu->addChild('contractTab', 'contractList', 'قرارداد ها', app::getBaseAppLink('contract/list', 'admin'), 'fa fa-file-text-o', '',  'admin/contract/list/contract');
        $this->menu->addChild('contractTab', 'contractVoteList', 'نظرسنجی قرارداد', app::getBaseAppLink('contract/listVote', 'admin'), 'fa fa-file-text-o', '', 'admin/contract/list/contract');
        $this->menu->addChild('contractTab', 'contract', 'تنظیمات قرارداد', app::getBaseAppLink('contract', 'admin'), 'fa fa-file-text', '', 'admin/contract/index/contract');
        $this->menu->addChild('contractTab', 'evaluation', 'فرم ساز', app::getBaseAppLink('evaluation/newType', 'admin'), 'fa fa-id-badge', '', 'admin/evaluation/newType/contract');
        $this->menu->addChild('contractTab', 'evaluation_list', 'لیست ارزیابی ها', app::getBaseAppLink('evaluation/list', 'admin'), 'fa fa-list-ol', '',  'admin/evaluation/list/contract');
        $this->menu->addChild('contractTab', 'evaluation_insert', 'ثبت ارزیابی', app::getBaseAppLink('evaluation', 'admin'), 'fa fa-check-square-o', '',  'admin/evaluation/index/contract');
        $user = user::getUserLogin();
        $contractsVote = model::searching([$user['userId']], ' userId	= ? and fillOutDate is null', 'contracts_vote', '*');

        if ($contractsVote !== true and count($contractsVote) > 0) {
            $this->mold->set('firstFillOutId', $contractsVote[0]['fillOutId']);
            $this->mold->set('firstFillOutIdCount', count($contractsVote));

            $getPath = $this->mold->getPath();
            $this->mold->path('default', 'contract');
            $this->mold->view('newVote.admin.hook.mold.html');
            $this->mold->path($getPath['folder'], $getPath['app']);
        }
    }

    public function _userProfileShowInAdmin($user, $fields)
    {
        $getPath = $this->mold->getPath();
        $this->mold->path('default', 'contract');

		$contracts = model::searching([$user->getUserId()],' userId	= ? ' ,'contracts','*');
		$this->mold->set('listGroups', $contracts);

        $this->mold->view('contracts.user.hook.mold.html');
        $this->mold->path($getPath['folder'], $getPath['app']);
    }


    public function _adminDashboard()
    {
        /*
        $user = user::getUserLogin();
        $contractsVote = model::searching([$user['userId']], ' userId	= ? and fillOutDate is null', 'contracts_vote', '*');

        if ($contractsVote !== true and count($contractsVote) > 0) {
            $this->mold->set('firstFillOutId', $contractsVote[0]['fillOutId']);
            $this->mold->set('firstFillOutIdCount', count($contractsVote));

            $getPath = $this->mold->getPath();
            $this->mold->path('default', 'contract');
            $this->mold->view('newVote.admin.hook.mold.html');
            $this->mold->path($getPath['folder'], $getPath['app']);
        }
        */

//        $Votes = model::searching([$user['userId']], ' userId	= ?', 'votes_only', '*');
//
//        if ($Votes != true and count($Votes) > 0) {
//            $this->mold->set('votesid', $Votes[0]['fillOutId']);
//            $this->mold->set('votesidCount', count($Votes));
//
//            $getPath = $this->mold->getPath();
//            $this->mold->path('default', 'contract');
//            $this->mold->view('newVote.admin.hook.mold.html');
//            $this->mold->path($getPath['folder'], $getPath['app']);
//        }

        $search = model::searching( array()  ,  null  , 'sensors', '*'  , ['column' => 'showSort' , 'type' =>'asc'] );
        $this->mold->set('sensorsChart' , $search);
        $getPath = $this->mold->getPath();
        $this->mold->path('default', 'contract');
//        $this->mold->view('chart.admin.hook.mold.html');
        $this->mold->path($getPath['folder'], $getPath['app']);

    }

    public function _doBeforeLoginWithPhase()
    {
        if (cache::get('lastContractCheck', null, 'contract') != date('Y-m-d')) {
            model::join('contracts contracts', '( contracts.contractGroup = vote.contractGroup and DATE_SUB(DATE_FORMAT(contracts.endDate, "%Y-%m-%d") , INTERVAL vote.ShowToReceiver DAY) = DATE_FORMAT(NOW(), "%Y-%m-%d" ) )', 'INNER');
            $listTypeVote = model::searching([1], ' ? and ShowToReceiver >= 0 and ShowToReceiver is not null ', 'vote vote', 'contracts.contractId,contracts.userId,vote.voteId,vote.checkByUnit');

            $cacheUnitId = [];
            $cachePhaseId = [];
            $cacheUsersShouldSearch = [];
            foreach ($listTypeVote as $TypeVote) {
                /* @var contracts_vote $contractVote */
                $contractVote = $this->model(['contract', 'contracts_vote']);
                $contractVote->setContractId($TypeVote['contractId']);
                $contractVote->setVoteId($TypeVote['voteId']);
                $contractVote->setCreatDate(date('Y-m-d H:i:s'));
                $userFind = null;
                /* @var vote $vote */
                $vote = $this->model(['contract', 'vote'] , $TypeVote['voteId'] );
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
            cache::save(date('Y-m-d'), 'lastContractCheck', 48 * 60 * 60, 'contract');
        }
    }

    public function _doBeforeLogin(){
        if (cache::get('lastContractCheck', null, 'contract') != date('Y-m-d')) {
            model::join('contracts contracts', '( contracts.contractGroup = vote.contractGroup and DATE_SUB(DATE_FORMAT(contracts.endDate, "%Y-%m-%d") , INTERVAL vote.ShowToReceiver DAY) = DATE_FORMAT(NOW(), "%Y-%m-%d" ) )', 'INNER');
            $listTypeVote = model::searching([1], ' ? and ShowToReceiver >= 0 and ShowToReceiver is not null ', 'vote vote', 'contracts.contractId,contracts.userId,vote.voteId,vote.checkByUnit');


            $cacheUnitId = [];
            $cacheUsersShouldSearch = [];
            foreach ($listTypeVote as $TypeVote) {
                /* @var contracts_vote $contractVote */
                $contractVote = $this->model(['contract', 'contracts_vote']);
                $contractVote->setContractId($TypeVote['contractId']);
                $contractVote->setVoteId($TypeVote['voteId']);
                $contractVote->setCreatDate(date('Y-m-d H:i:s'));
                $userFind = null;
                /* @var vote $vote */
                $vote = $this->model(['contract', 'vote'] , $TypeVote['voteId'] );
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
                    }
                    else
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
                    break;
                }

                $contractVote->setUserId($userFind);
                $contractVote->insertToDataBase();
            }
            cache::save(date('Y-m-d'), 'lastContractCheck', 48 * 60 * 60, 'contract');
        }
    }


    public function _settingFooter()
    {
        $getPath = $this->mold->getPath();
        $this->mold->path('default', 'contract');
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


    public function _fieldService_listOfTypes($vars2)
    {
        return [
            ['type' => 'salary', 'name' => rlang('salary')],
        ];
    }


    public function _fieldService_showToFillOut_salary($vars2)
    {
        $value = '';
        if (isset($this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']])) {
            $value = $this->mold->get('Mold')['post']['customField'][$this->mold->get('field')['fieldId']];
        } elseif (isset($this->mold->get('field')['value'])) {
            $value = $this->mold->get('field')['value'];
        }
        $html = '<div class="' . $this->mold->get('fillOutFieldServiceFormCssClassAllDiv') . '">
    <label class="' . $this->mold->get('fillOutFieldServiceFormCssClassLabelDiv') . '" for="field_' . $this->mold->get('field')['fieldId'] . '">' . $this->mold->get('field')['title'] . ' ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? '<span class="text-danger">*</span>' : '') . '</label>
    <div class="' . $this->mold->get('fillOutFieldServiceFormCssClassInputDiv') . '">
        <input value="'.$value.'" type="number" min="0" class="form-control" id="field_' . $this->mold->get('field')['fieldId'] . '"  name="customField[' . $this->mold->get('field')['fieldId'] . '][]" ' . (($this->mold->get('field')['status'] == 'required' and !$this->mold->get('shouldNotUserRequired')) ? 'required' : '') . ' >
        ' . (($this->mold->get('field')['description'] != '') ? '<div class="small text-gray">' . $this->mold->get('field')['description'] . '</div>' : '') . '
    </div>
</div>';

        return $html;

    }

    public function _fieldService_showValue_salary($fieldInformation = null)
    {
        return $fieldInformation['value'];
    }

}