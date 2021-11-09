<?php

namespace App\post_design\app_provider\admin;

use App;
use App\core\controller\fieldService;
use App\core\controller\httpErrorHandler;
use App\LineMonitoring\app_provider\api\phases;
use app\post_design\model\post_type;
use app\post_design\model\post_data;
use App\user\app_provider\api\checkAccess;
use App\user\app_provider\api\user;
use App\user\model\user_group;
use controller;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class post extends controller
{
    private $item_label = "نامه";
    private $model_name = 'post_data';
    private $type_model_name = 'post_type';
    private $app_name = 'post_design';
    private $active_menu = 'post_insert';
    private $html_file_path = 'FD_Evaluation_choose.mold.html';

    public function index($id = null)
    {
        /* @var post_data $eval_data */
        $userId = user::getUserLogin(true);

        if ($id != null) {
            $eval_data = $this->model([$this->app_name, $this->model_name], $id);

            if ($eval_data->getId() != $userId or $eval_data->getId() != $id) {
                httpErrorHandler::E404();
                return null;
            }
        } else {

            $eval_data = $this->model([$this->app_name, $this->model_name]);
        }

        if (request::isPost()) {
            $get = request::post('confirm_time,group_id,Agent,type_id,brand,phase');
            $eval_data->setCreateDate(date('Y-m-d H:i:s'));
            $eval_data->setType($get['type_id']);
            $eval_data->setCreator(user::getUserLogin(true));
            $eval_data->setFinished(0);
            $eval_data->setPhase($get['phase']);
            $eval_data->setBrand($get['brand']);
            if ($get['Agent'] == null) {
                $get['Agent'] = array();
                $users = user::getUsersByGroupId((int)$this->setting('postAgent'))["result"];
                foreach ($users as $user) {
                    $get['Agent'][] = $user["userId"];
                }
            }
            $okPos = true;
            $eval_data->setAgent($get['Agent']);
            if (!$eval_data->insertToDataBase()) {
                $okPos = false;
            }
//            foreach ($get['Agent'] as $evaluated) {
//
//                $eval_data->setAgent($evaluated);
//                if ($id != null) {
//                    if (!$eval_data->upDateDataBase()) {
//                        $okPos = false;
//                    }
//                } else {
//                    if (!$eval_data->insertToDataBase()) {
//                        $okPos = false;
//                    }
//                }
//            }
            if ($okPos) {
                $this->alert('success', '', 'نامه شما با موفقیت ثبت شد.');
            } else {
                $this->alert('danger', '', 'لطفا مجددا تلاش کنید!');
            }

        }
        $_SERVER['JsonOff'] = true;
        $this->mold->set('user_group', user::getGroups()["result"]);
        $this->mold->set('phases', phases::all()["result"]);
        unset($_SERVER['JsonOff']);
        $this->mold->set('AgentGroup', (int)$this->setting('postAgent'));
        $this->mold->path('voteFillId', $id);
        $this->mold->path('default', $this->app_name);
        $this->mold->view($this->html_file_path);
        $this->mold->setPageTitle(rlang('insert') . " " . $this->item_label);
        $this->mold->set('activeMenu', $this->active_menu);
    }

    public function list()
    {
        /** @var post_data $post_data_model */
        $post_data_model = $this->model([$this->app_name, $this->model_name]);
        /** @var post_type $post_type_model */
        $post_type_model = $this->model([$this->app_name, $this->type_model_name]);

        $get = request::post('page=1,perEachPage=25,typeName,finished,confirmEnd,startTime,endTime,sortWith');

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
                    $temp[] = 'post_data.confirmDate >= ?';
                else
                    $temp[] = 'post_data.confirmDate < ?';
            }
            $variable[] = '(' . implode(' or ', $temp) . ')';
        }
        if ($get['endTime'] != null) {
            $value[] = date('Y-m-d 23:59:59', $get['endTime'] / 1000);
            $variable[] = 'post_data.confirmDate <= ?';
        }
        if ($get['startTime'] != null) {
            $value[] = date('Y-m-d 00:00:00', $get['startTime'] / 1000);
            $variable[] = 'post_data.confirmDate >= ?';
        }

        if ($user["userId"] != (int)$this->setting('postAdminPerson')) {
            $variable[] = 'post_data.finished = ?';
            $value[] = 0;
        }

        $eval = $post_data_model->getEvaluationList($user["userId"], $user["user_group_id"], (int)$this->setting('postAdmin'), $sortWith, $sortRest, $value, $variable, [1]);
        $type = $post_type_model->getEvaluationTypeByUserGroupId($user["user_group_id"], (int)$this->setting('postAdmin'));

        $allFields['result'] = [];

        foreach ($eval as $evalOne) {
            $allField = fieldService::showFilledOutForm($evalOne["type"], 'post_type', $evalOne["id"], 'post_data');
            $allFields['result'][] = $allField['result'];
        }
        $editAccess = checkAccess::index($user['user_group_id'], 'admin', 'post', 'index', 'post_design')["status"];

        $this->mold->set('editAccess', $editAccess);
        $this->mold->set('canChange', true);
        if ($user["userId"] == (int)$this->setting('postAdmin'))
            $this->mold->set('canChangeFinished', true);
        else
            $this->mold->set('canChangeFinished', false);
        $this->mold->set('typeNames', $type);
        $this->mold->set('eval', $eval);
        $this->mold->set('allFields', $allFields['result']);
        $this->mold->set('activeMenu', 'post_list');

        $this->mold->path('default', 'post_design');
        $this->mold->view('FD_Evaluation_list.mold.html');
        $this->mold->setPageTitle('واحد فروش');
    }

    public function newType()
    {
        $this->evalFields();
    }

    public function evalFields($groupAccess = null, $voteId = null): bool
    {
        if ($groupAccess == null)
            $groupAccess = user::getUserLogin()["user_group_id"];
        /* @var user_group $model */
        $model = $this->model(['user', 'user_group'], $groupAccess);
        if ($model->getUserGroupId() != $groupAccess) {
            httpErrorHandler::E404();
            return false;
        }

        /* @var post_type $eval_type */
        if ($voteId != "") {
            $eval_type = $this->model('post_type', $voteId);
            if ($eval_type->getId() != $voteId) {
                $this->alert('danger', '', 'نظر سنجی مد نظر یافت نشد!');
            }
        } else {
            $eval_type = $this->model('post_type');
        }

        if (request::isPost()) {
            $get = request::post('name,receiver,numberDay,moreField,deleteField');
            $rules = [
                "name" => ["required", 'نام نامه'],
            ];
            $valid = validate::check($get, $rules);
            if ($valid->isFail()) {
                $this->alert('danger', '', $valid->errorsIn());
            }

            $eval_type->setName($get['name']);
            $eval_type->setEvaluatorGroup((int)$this->setting('postAdmin'));
            $eval_type->setCheckByUnit(false);
            $eval_type->setEvaluatedGroup((int)$this->setting('postAgent'));
            $eval_type->setShowToReceiver(1);
            if ($voteId != "") {
                $eval_type->upDateDataBase();
            } else {
                $eval_type->insertToDataBase();
            }

            $resultUpdateField = fieldService::updateFields($eval_type->getId(), 'post_type', $get['moreField'], $get['deleteField']);
            if (!$resultUpdateField['status']) {
                $this->alert('warning', null, rlang('pleaseTryAGain') . '<br>' . $resultUpdateField['massage'], 'error');
            } else {
                if ($voteId == null) {
                    Response::redirect(App::getBaseAppLink('post/evalFields/' . $groupAccess . '/' . $eval_type->getId(), 'admin'));
                    return true;
                }
                $this->alert('success', null, 'فیلد های نظرسنجی با موفقیت ویرایش شد');
            }
        }


        $access = user::getGroups()["result"];
        $eval = $model->search(null, null, 'post_type', 'name,id');

        $this->mold->set('access', $access);
        $this->mold->set('eval', $eval);
        $this->mold->set('nowOnAccess', $groupAccess);
        $this->mold->set('type', $eval_type);


        fieldService::getFieldsToEdit($eval_type->getId(), 'post_type', $this->mold);
        $this->mold->path('default', 'post_design');
        $this->mold->view('evaluation_typeEditor.mold.html');
        $this->mold->path('default');
        $this->mold->setPageTitle('فرم ساز');
        $this->mold->set('activeMenu', 'post');
        return false;
    }

    public function fill($id, $semi = "false", $dangerText = ""): bool
    {
        $semi = $semi == "true";

        if ($dangerText != "")
            $this->alert('danger', '', $dangerText);

        if ($id != null) {
            /* @var post_data $eval_data */
            $eval_data = $this->model(['post_design', 'post_data'], $id);

            if ($semi)
                $eval_data->setFinished(false);

            if ($semi)
                $eval_data->setId(null);


        } else {
            httpErrorHandler::E404();
            return false;
        }
        if (request::isPost()) {
            $get = request::post('customField');

            if ($semi) {
                $eval_data->setFillOutDate(date('Y-m-d H:i:s'));
                $eval_data->setFinished(false);
                $resultFirst = $eval_data->insertToDataBase();
            } else
                $resultFirst = true;
            if ($resultFirst) {
                $fieldUpdate = fieldService::updateFillOutForm($eval_data->getType(), 'post_type', $get['customField'], $eval_data->getId(), 'post_data');

                if ($fieldUpdate["status"] == false) {
                    $this->alert('danger', '', $fieldUpdate["massage"]);
                    if ($semi) {
                        Response::redirect(app::getBaseAppLink('post/fill/' . $eval_data->getId() . "/false/" . $fieldUpdate["massage"], 'admin'));
                        return false;
                    }
                } else {
                    $eval_data->setFillOutDate(date('Y-m-d H:i:s'));
                    $eval_data->setFinished(false);

                    $result = $eval_data->upDateDataBase();

                    if ($result) {
                        Response::redirect(app::getBaseAppLink('post/list', 'admin'));
                        //                        $this->alert('success', '', 'نظر شما با موفقیت ثبت شد.');
                    } else {
                        $this->alert('danger', '', 'لطفا مجددا تلاش کنید!');
                    }
                    return false;
                }
            }
        }

        fieldService::showFilledOutFormWithAllFields($eval_data->getType(), 'post_type', $eval_data->getId(), 'post_data', true, $this->mold);

        $this->mold->set('brand', $eval_data->getBrandLabel());
        $this->mold->set('EvaluatedPerson', $eval_data->getEvaluatedPerson());
        $this->mold->path('default', 'post_design');
        $this->mold->view('FD_Evaluation.mold.html');
        $this->mold->setPageTitle('واحد فروش');
        return false;
    }


}