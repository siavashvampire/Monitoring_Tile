<?php

namespace App\product\app_provider\admin;

use App;
use App\core\controller\httpErrorHandler;
use App\LineMonitoring\app_provider\api\phases;
use App\user\app_provider\api\checkAccess;
use App\user\app_provider\api\user;
use controller;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class product extends controller
{
    private $item_label = "کاشی";
    private $ChangeURL = "product";
    private $log_name = 'product';
    private $model_name = 'product';
    private $app_name = 'product';
    private $class_name = 'product';
    private $active_menu = 'product';
    private $list_html_file_path = 'product_list.mold.html';
    private $html_file_path = 'product.mold.html';

    public function list(): bool
    {
        /* @var \App\product\model\product $model */
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

        $model = parent::model($this->model_name);
        $numberOfAll = ($model->search($value, (count($variable) == 0) ? null : implode(' and ', $variable), null, 'COUNT(id) as co')) [0]['co'];
        $pagination = parent::pagination($numberOfAll, $get['page'], $get['perEachPage']);
        $search = $model->search($value, ((count($variable) == 0) ? null : implode(' and ', $variable)), null, '*', ['column' => 'label', 'type' => 'asc'], [$pagination['start'], $pagination['limit']]);
        $this->mold->path('default', $this->app_name);
        $this->mold->view($this->list_html_file_path);
        $this->mold->setPageTitle(rlang('list') . " " . $this->item_label);
        $this->mold->set('activeMenu', $this->active_menu);
        $this->mold->set('items', $search);
        $this->mold->set('item_label', $this->item_label);
        $this->mold->set('ChangeURL', $this->ChangeURL);
        $editAccess = checkAccess::index(user::getUserLogin()['user_group_id'], 'admin', $this->class_name, 'index', $this->app_name)["status"];
        $this->mold->set('editAccess', $editAccess);
        return false;
    }

    public function index($id = null): bool
    {
        /* @var \App\product\model\product $model */
        if ($id != null) {
            $model = parent::model($this->model_name, $id);
            if ($model->getId() != $id) {
                httpErrorHandler::E404();
                return false;
            }
            $this->mold->set('model', $model);
        } else
            $model = parent::model($this->model_name);

        if (request::ispost()) {
            $get = request::post('label');
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
            Response::redirect(App::getBaseAppLink($this->class_name . '/list/','admin'));
        }

        $this->mold->path('default', $this->app_name);
        $this->mold->view($this->html_file_path);
        if( $id == null)
            $this->mold->setPageTitle(rlang('insert') . " " . $this->item_label);
        elseif( $id != null)
            $this->mold->setPageTitle(rlang('Edit') . " " . $this->item_label);

        $this->mold->set('activeMenu' , $this->active_menu);
        $this->mold->set('item_label', $this->item_label);
        $this->mold->set('colors', App\product\app_provider\api\product::color()["result"]);
        $this->mold->set('phases', phases::index()["result"]);
        $this->mold->set('sizes', App\product\app_provider\api\product::size()["result"]);
        $this->mold->set('templates', App\product\app_provider\api\product::size()["result"]);
        return false;
    }
}