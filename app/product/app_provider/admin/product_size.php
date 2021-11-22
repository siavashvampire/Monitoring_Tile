<?php

namespace App\product\app_provider\admin;

use App\user\app_provider\api\checkAccess;
use App\user\app_provider\api\user;
use controller;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class product_size extends controller
{
    private $item_label = "سایز کاشی";
    private $log_name = 'product_size';
    private $model_name = 'product_size';
    private $controller_name = 'product_size';
    private $app_name = 'product';
    private $active_menu = 'product_size';
    private $html_file_path = 'product_size.mold.html';

    public function index(): bool
    {
        /* @var \App\product\model\product_size $model */
        $get = request::post('page=1,perEachPage=25,label,width,length,thickness');
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
                $value[] = '%' . $get['name'] . '%';
                $variable[] = 'item.label Like ? ';
            }
            if ($get['width'] != null) {
                $value[] = $get['width'];
                $variable[] = 'item.width = ? ';
            }
            if ($get['length'] != null) {
                $value[] = $get['length'];
                $variable[] = 'item.length = ? ';
            }
            if ($get['thickness'] != null) {
                $value[] = $get['thickness'];
                $variable[] = 'item.thickness = ? ';
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
        $editAccess = checkAccess::index(user::getUserLogin()['user_group_id'], 'admin', $this->controller_name, 'update', $this->app_name)["status"];
        $this->mold->set('editAccess', $editAccess);
        return false;
    }

    public function update(): bool
    {
        /* @var \App\product\model\product_size $model */
        $get = request::post('id,label,width,length,thickness');
        $rules = [
            "label" => ["required", rlang('name') . " " . $this->item_label],
            "length" => ["required|floatInt|match:>0", rlang('length') . " " . $this->item_label],
            "width" => ["required|floatInt|match:>0", rlang('width') . " " . $this->item_label],
            "thickness" => ["required|floatInt|match:>0", rlang('thickness') . " " . $this->item_label],
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
        $model->setLength($get['length']);
        $model->setWidth($get['width']);
        $model->setThickness($get['thickness']);

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