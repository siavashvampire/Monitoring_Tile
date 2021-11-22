<?php

namespace App\product\app_provider\admin;

use App\Sections\app_provider\admin\Sections;
use App\user\app_provider\api\checkAccess;
use App\user\app_provider\api\user;
use controller;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class product_brand extends controller
{
    private $item_label = "برند";
    private $log_name = 'product_brand';
    private $controller_name = 'product_brand';
    private $model_name = 'product_brand';
    private $app_name = 'product';
    private $active_menu = 'product_brand';
    private $html_file_path = 'product_brand.mold.html';

    public function index(): bool
    {
        /** @var \App\product\model\product_brand $model */
        $get = request::post('page=1,perEachPage=25,label');
        $rules = [
            "page" => ["required|match:>0", rlang('page')],
            "perEachPage" => ["required|match:>0|match:<501", rlang('page')],
        ];
        $valid = validate::check($get, $rules);
        $value = array();
        $variable = array();
        if ($valid->isFail()) {
            Response::jsonMessage($valid->errorsIn(), false);
            return false;
        } else {
            if ($get['label'] != null) {
                $value[] = '%' . $get['label'] . '%';
                $variable[] = ' item.label Like ? ';
            }

        }

        $model = parent::model($this->model_name);
        $numberOfAll = $model->getCount($value, $variable);
        $pagination = parent::pagination($numberOfAll, $get['page'], $get['perEachPage']);
        $pagination = [$pagination['start'], $pagination['limit']];
        $search = $model->getItems($value, $variable, ['column' => 'id', 'type' => 'asc'], $pagination);
        $this->mold->path('default', $this->app_name);
        $this->mold->view($this->html_file_path);
        $this->mold->setPageTitle(rlang('list') . " " . $this->item_label);
        $this->mold->set('activeMenu', $this->active_menu);
        $this->mold->set('items', $search);
        $this->mold->set('item_label', $this->item_label);
        $this->mold->set('agents', user::getUsersByGroupId((int)$this->setting('postAgent', 'post_design'))["result"]);
        $editAccess = checkAccess::index(user::getUserLogin()['user_group_id'], 'admin', $this->controller_name, 'update', $this->app_name)["status"];
        $this->mold->set('editAccess', $editAccess);
        return false;
    }

    public function update(): bool
    {
        /** @var \App\product\model\product_brand $model */
        $get = request::post('id,label,agent');

        $rules = [
            "label" => ["required", rlang('name') . " " . $this->item_label],
            "agent" => ["required|floatInt|match:>0", rlang('name') . " " . rlang('agent')],
        ];

        $valid = validate::check($get, $rules);
        $this->mold->offAutoCompile();
        $GLOBALS['timeStart'] = '';
        if ($valid->isFail()) {
            Response::jsonMessage($valid->errorsIn(), false);
            return false;
        }

        if ($get['id'] != '') {
            $model = parent::model($this->model_name, $get['id']);
            if ($model->getId() != $get['id']) {
                Response::jsonMessage($this->item_label . " " . rlang('cantFindSpecific'), false);
                return false;
            }
        } else
            $model = parent::model($this->model_name);

        $Dis = $this->item_label . " " . rlang('with') . " " . rlang('name') . " ";
        $Dis .= $model->getLabel() . " ";

        $model->setLabel($get['label']);
        $model->setAgent($get['agent']);

        if ($get['id'] != '') {
            $Dis .= rlang('be') . " " . $this->item_label . " " . rlang('with') . " " . rlang('name') . " ";
            $Dis .= $model->getlabel() . " ";
            $Dis .= rlang('changed');
            $model->upDateDataBase();
        } else {
            $Dis .= $model->getLabel() . " ";
            $Dis = $Dis . rlang('inserted');
            $model->insertToDataBase();
        }

        $this->callHooks('addLog', [$Dis, $this->log_name]);
        Response::jsonMessage(rlang('changeSuccessfully'), true);
        return false;
    }
}