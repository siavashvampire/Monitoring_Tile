<?php

namespace App\contract\app_provider\admin;

use App;
use App\core\controller\fieldService;
use App\core\controller\httpErrorHandler;
use app\contract\model\evaluation_type;
use app\contract\model\evaluation_data;
use App\user\app_provider\api\checkAccess;
use App\user\app_provider\api\user;
use App\user\model\user_group;
use controller;
use paymentCms\component\JDate;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class evaluation extends controller
{
    public function index($id = null)
    {
        $userId = user::getUserLogin(true);

        if ($id != null) {
            /* @var evaluation_data $eval_data */
            $eval_data = $this->model(['contract', 'evaluation_data'], $id);

            if ($eval_data->getId() != $userId or $eval_data->getId() != $id) {
                httpErrorHandler::E404();
                return null;
            }
        } else {

            /* @var evaluation_data $eval_data */
            $eval_data = $this->model(['contract', 'evaluation_data']);
        }

        if (request::isPost()) {
            $get = request::post('confirm_time,group_id,evaluated,type_id');
            $dateShamsi = explode('/', $get['confirm_time']);
            $confirm_time = JDate::jalali_to_gregorian($dateShamsi[0], $dateShamsi[1], $dateShamsi[2], "-") . ' 23:59:59';
            $eval_data->setCreateDate(date('Y-m-d H:i:s'));
            $eval_data->setType($get['type_id']);
            $eval_data->setConfirmDate($confirm_time);
            $eval_data->setCreator(user::getUserLogin(true));
            $eval_data->setFinished(false);
            if ($get['evaluated'] == null) {
                $get['evaluated'] = array();
                $users = user::getUsersByGroupId($get['group_id'])["result"];
                foreach ($users as $user) {
                    $get['evaluated'][] = $user["userId"];
                }
            }
            $okPos = true;
            foreach ($get['evaluated'] as $evaluated) {
                $eval_data->setEvaluated($evaluated);
                if ($id != null) {
                    if (!$eval_data->upDateDataBase()) {
                        $okPos = false;
                    }
                } else {
                    if (!$eval_data->insertToDataBase()) {
                        $okPos = false;
                    }
                }
            }
            if ($okPos) {
                $this->alert('success', '', 'نظر شما با موفقیت ثبت شد.');
            } else {
                $this->alert('danger', '', 'لطفا مجددا تلاش کنید!');
            }

        }
        $_SERVER['JsonOff'] = true;
        $this->mold->set('user_group', user::getGroups()["result"]);
        unset($_SERVER['JsonOff']);
        $this->mold->path('voteFillId', $id);
        $this->mold->path('default', 'contract');
        $this->mold->view('FD_Evaluation_choose.mold.html');
        $this->mold->setPageTitle('ارزیابی');
    }

    public function list()
    {
        $get = request::post('page=1,perEachPage=25,typeName,finished,confirmEnd,startTime,endTime,sortWith', null);

        $user = user::getUserLogin();
        $value = array();
        $variable = array();

        $sortWith = array();

        $sortRest = array();
        if ($get['sortWith'] != null and is_array($get['sortWith'])) {
            foreach ($get['sortWith'] as $sort) {
                $temp = explode('*', $sort);
                $sortWith[] = $temp[0];
                if ($temp[1] == "desc")
                    $sortRest[] = SORT_DESC;
                if ($temp[1] == "asc")
                    $sortRest[] = SORT_ASC;
            }
        } else {
            $sortWith[] = 'confirmDate';
            $sortWith[] = 'type';
            $sortWith[] = 'lname';
            $sortWith[] = 'fname';
            $sortWith[] = 'groupName';
            $sortRest[] = SORT_ASC;
            $sortRest[] = SORT_ASC;
            $sortRest[] = SORT_ASC;
            $sortRest[] = SORT_ASC;
            $sortRest[] = SORT_ASC;
        }

        if ($get['typeName'] != null) {
            $temp = array();
            foreach ($get['typeName'] as $item) {
                $value[] = $item;
                $temp[] = 'type.id = ?';
            }
            $variable[] = '(' . implode(' or ', $temp) . ')';

        }
        if ($get['confirmEnd'] != null) {
            $temp = array();
            foreach ($get['confirmEnd'] as $item) {
                $value[] = date('Y-m-d 23:59:59');
                if ($item == 1)
                    $temp[] = 'evaluation_data.confirmDate >= ?';
                else
                    $temp[] = 'evaluation_data.confirmDate < ?';
            }
            $variable[] = '(' . implode(' or ', $temp) . ')';
        }
        if ($get['endTime'] != null) {
            $value[] = date('Y-m-d 23:59:59', $get['endTime'] / 1000);
            $variable[] = 'evaluation_data.confirmDate <= ?';
        }
        if ($get['startTime'] != null) {
            $value[] = date('Y-m-d 00:00:00', $get['startTime'] / 1000);
            $variable[] = 'evaluation_data.confirmDate >= ?';
        }

        $eval = $this->model(['contract', 'evaluation_data'])->getEvaluationList($user["userId"], $user["user_group_id"], (int)$this->setting('evaluationAdmin'), $sortWith, $sortRest, $value, $variable, $get['finished']);
        $type = $this->model(['contract', 'evaluation_type'])->getEvaluationTypeByUserGroupId($user["user_group_id"],(int)$this->setting('evaluationAdmin'));

        $allFields['result'] = [];

        foreach ($eval as $evalOne) {
            $allField = fieldService::showFilledOutForm($evalOne["type"], 'evaluation_type', $evalOne["id"], 'evaluation_data');
            $allFields['result'][] = $allField['result'];
        }

        $editAccess = checkAccess::index($user['user_group_id'], 'admin', 'evaluation', 'index', 'contract')["status"];

        $this->mold->set('editAccess', $editAccess);
        $this->mold->set('typeNames', $type);
        $this->mold->set('eval', $eval);
        $this->mold->set('allFields', $allFields['result']);

        $this->mold->path('default', 'contract');
        $this->mold->view('FD_Evaluation_list.mold.html');
        $this->mold->setPageTitle('ارزیابی');
    }

    public function newType()
    {
        $this->evalFields();
    }

    public function evalFields($groupAccess = null, $voteId = null)
    {
        if ($groupAccess == null)
            $groupAccess = user::getUserLogin()["user_group_id"];
        /* @var user_group $model */
        $model = $this->model(['user', 'user_group'], $groupAccess);
        if ($model->getUserGroupId() != $groupAccess) {
            httpErrorHandler::E404();
            return false;
        }

        /* @var evaluation_type $eval_type */
        if ($voteId != "") {
            $eval_type = $this->model('evaluation_type', $voteId);
            if ($eval_type->getId() != $voteId) {
                $this->alert('danger', '', 'نظر سنجی مد نظر یافت نشد!');
            }
        } else {
            $eval_type = $this->model('evaluation_type');
        }

        if (request::isPost()) {
            $get = request::post('name,receiver,numberDay,moreField,deleteField');
            $rules = [
                "receiver" => ["required", 'گیرنده'],
                "name" => ["required", 'نام ارزیابی'],
            ];
            $valid = validate::check($get, $rules);
            if ($valid->isFail()) {
                $this->alert('danger', '', $valid->errorsIn());
            }
            if (substr($get['receiver'], 0, 1) == 'U') {
                $receiver = substr($get['receiver'], 1);
                $UnitCheck = true;
            } else {
                $receiver = $get['receiver'];
                $UnitCheck = false;
            }
            $eval_type->setName($get['name']);
            $eval_type->setEvaluatorGroup($receiver);
            $eval_type->setCheckByUnit($UnitCheck);
            $eval_type->setEvaluatedGroup($groupAccess);
            $eval_type->setShowToReceiver($get['numberDay']);
            if ($voteId != "") {
                $eval_type->upDateDataBase();
            } else {
                $eval_type->insertToDataBase();
            }


            $resultUpdateField = fieldService::updateFields($eval_type->getId(), 'evaluation_type', $get['moreField'], $get['deleteField']);
            if (!$resultUpdateField['status']) {
                $this->alert('warning', null, rlang('pleaseTryAGain') . '<br>' . $resultUpdateField['massage'], 'error');
            } else {
                if ($voteId == null) {
                    Response::redirect(App::getBaseAppLink('evaluation/evalFields/' . $groupAccess . '/' . $eval_type->getId(), 'admin'));
                    return true;
                }
                $this->alert('success', null, 'فیلد های نظرسنجی با موفقیت ویرایش شد');
            }
        }


        $access = user::getGroups()["result"];
        $eval = $model->search($groupAccess, ' evaluatedGroup = ?', 'evaluation_type', 'name,id');

        $this->mold->set('access', $access);
        $this->mold->set('eval', $eval);
        $this->mold->set('nowOnAccess', $groupAccess);
        $this->mold->set('type', $eval_type);


        fieldService::getFieldsToEdit($eval_type->getId(), 'evaluation_type', $this->mold);
        $this->mold->path('default', 'contract');
        $this->mold->view('evaluation_typeEditor.mold.html');
        $this->mold->path('default');
        $this->mold->setPageTitle('ارزیابی');
        $this->mold->set('activeMenu', 'vote');
        return null;
    }

    public function fill($id, $semi = "false", $dangerText = "")
    {
        $semi = $semi == "true";

        $userId = user::getUserLogin(true);
        if ($dangerText != "")
            $this->alert('danger', '', $dangerText);


        if ($id != null) {
            /* @var evaluation_data $eval_data */
            $eval_data = $this->model(['contract', 'evaluation_data'], $id);

            if ($semi)
                $eval_data->setFinished(false);


            if (($eval_data->getEvaluated() != $userId and $eval_data->getFinished()) or ($eval_data->getId() != $id)) {
                httpErrorHandler::E404();
                return null;
            }
            if ($semi)
                $eval_data->setId(null);


        } else {
            httpErrorHandler::E404();
            return null;
        }
        if (request::isPost()) {
            $get = request::post('customField');

            if ($semi) {
                $eval_data->setFillOutDate(date('Y-m-d H:i:s'));
                $eval_data->setEvaluator(user::getUserLogin(true));
                $eval_data->setFinished(false);
                $resultFirst = $eval_data->insertToDataBase();
            } else
                $resultFirst = true;
            if ($resultFirst) {
                $fieldUpdate = fieldService::updateFillOutForm($eval_data->getType(), 'evaluation_type', $get['customField'], $eval_data->getId(), 'evaluation_data');

                if ($fieldUpdate["status"] == false) {
                    $this->alert('danger', '', $fieldUpdate["massage"]);
                    if ($semi) {
                        Response::redirect(app::getBaseAppLink('evaluation/fill/' . $eval_data->getId() . "/false/" . $fieldUpdate["massage"], 'admin'));
                        return null;
                    }
                } else {
                    $eval_data->setFillOutDate(date('Y-m-d H:i:s'));
                    $eval_data->setEvaluator(user::getUserLogin(true));
                    $eval_data->setFinished(true);

                    $result = $eval_data->upDateDataBase();

                    if ($result) {
                        Response::redirect(app::getBaseAppLink('evaluation/list', 'admin'));
                        return null;
                        $this->alert('success', '', 'نظر شما با موفقیت ثبت شد.');
                    } else {
                        $this->alert('danger', '', 'لطفا مجددا تلاش کنید!');
                        return null;
                    }
                }
            }
        }

        $fields = fieldService::showFilledOutFormWithAllFields($eval_data->getType(), 'evaluation_type', $eval_data->getId(), 'evaluation_data', true, $this->mold);

        $this->mold->set('EvaluatedPerson', $eval_data->getEvaluatedPerson()[0]);
        $this->mold->path('default', 'contract');
        $this->mold->view('FD_Evaluation.mold.html');
        $this->mold->setPageTitle('ارزیابی');
    }
}