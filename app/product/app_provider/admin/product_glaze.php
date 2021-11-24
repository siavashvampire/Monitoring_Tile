<?php

namespace App\product\app_provider\admin;

use App\user\app_provider\api\checkAccess;
use App\user\app_provider\api\user;
use controller;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class product_glaze extends controller
{
    private $item_label = "لعاب";
    private $model_name = 'product_glaze';
    private $controller_name = 'product_glaze';
    private $log_name = 'product_glaze';
    private $app_name = 'product';
    private $active_menu = 'product_glaze';
    private $html_file_path = 'product_glaze.mold.html';
    private $child_url = 'product_glaze';

    public function index($parent = null ): bool
    {
        /* @var \App\product\model\product_glaze $model */
        $model = parent::model($this->model_name);

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
        }
        if ($parent){
            $value[] = $parent;
            $variable[] = 'item.parent = ? ';
            $this->mold->set('parentModel' ,parent::model($this->model_name,$parent));
        }else{
            $value[] = 1;
            $variable[] = '? ';
            $variable[] = 'item.parent IS NULL';
            $this->mold->set('isParent' , true);
        }

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
        $this->mold->set('child_url', $this->child_url);

        return false;
    }

    public function update(): bool
    {
        /* @var \App\product\model\product_glaze $model */
        $get = request::post('id,label,parent');
        $rules = [
            "label" => ["required", rlang('name') . " " . $this->item_label],
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

        if ($get['parent'])
            $model->setParent($get['parent']);

        $Dis = $this->item_label . " " . rlang('with') . " " . rlang('name') . " ";
        $Dis .= $model->getLabel() . " ";

        $model->setLabel($get['label']);


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