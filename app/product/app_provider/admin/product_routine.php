<?php

namespace App\product\app_provider\admin;

use App;
use App\core\controller\httpErrorHandler;
use App\shiftWork\app_provider\api\shift;
use App\user\app_provider\api\checkAccess;
use App\user\app_provider\api\user;
use controller;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class product_routine extends controller
{
    private $item_label = "کنترل روتین";
    private $ChangeURL = "product_routine";
    private $QC_download = "product_export/routine";
    private $listChangeURL = "product/list";
    private $log_name = 'product_routine';
    private $model_name = 'product_routine';
    private $app_name = 'product';
    private $class_name = 'product_routine';
    private $active_menu = 'product';
    private $list_html_file_path = 'product_routine_list.mold.html';
    private $html_file_path = 'product_routine.mold.html';

    public function list($product = null): bool
    {
        /* @var App\product\model\product_routine $model */
        $get = request::post('page=1,perEachPage=25');
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
        if ($product != null) {
            $value[] = $product;
            $variable[] = 'item.product = ? ';
        }

        $model = parent::model($this->model_name);
        $model->setProduct($product);
        $search = $model->getItems($value, $variable);
        $this->mold->path('default', $this->app_name);
        $this->mold->view($this->list_html_file_path);
        $this->mold->setPageTitle(rlang('list') . " " . $this->item_label);
        $this->mold->set('activeMenu', $this->active_menu);
        $this->mold->set('items', $search);
        $this->mold->set('item_label', $this->item_label);
        $this->mold->set('ChangeURL', $this->ChangeURL);
        $this->mold->set('product', $product);
        $this->mold->set('productLabel', App\product\app_provider\api\product::index($product)["result"][0]["label"]);

        $editAccess = checkAccess::index(user::getUserLogin()['user_group_id'], 'admin', $this->class_name,
            'index', $this->app_name)["status"];
        $this->mold->set('editAccess', $editAccess);
        $this->mold->set('QC_download', $this->QC_download);
        $this->mold->set('sizeLabel', $model->getSizeLabel());
//        show($search);

        return false;
    }

    public function index($product, $id = null): bool
    {
        /* @var App\product\model\product_routine $model */
        if ($id != null) {
            $model = parent::model($this->model_name, $id);
            if ($model->getId() != $id or $model->getProduct() != $product) {
                httpErrorHandler::E404();
                return false;
            }
            $this->mold->set('model', $model);
        } else {
            $model = parent::model($this->model_name);
            $model->setProduct($product);
        }

        if (request::ispost()) {
            $get = request::post('shift,max_length,min_length,max_width,min_width,max_thickness,min_thickness,resistance,oblique,max_wrap_diameter,min_wrap_diameter,max_wrap_center,min_wrap_center,max_wrap_edge,min_wrap_edge,straight,mean_water_attraction,max_temperature,min_temperature,cycle,specific_pressure');
            $rules = [
                "shift" => ["required", rlang('shift')],
            ];
            $valid = validate::check($get, $rules);
            $GLOBALS['timeStart'] = '';
            if ($valid->isFail()) {
                $this->alert('danger', '', $valid->errorsIn());
//                Response::jsonMessage($valid->errorsIn(), false);
//                return false;
            }
            $Dis = $this->item_label . " " . rlang('with') . " " . rlang('name') . " ";
            $Dis .= $model->getProductLabel() . " ";
            $model->setProduct($product);
            $model->setRoutineDate(date('Y-m-d H:i:s'));
            $model->setShift($get['shift']);
            $model->setLengthMax($get['max_length']);
            $model->setLengthMin($get['min_length']);
            $model->setWidthMax($get['max_width']);
            $model->setWidthMin($get['min_width']);
            $model->setThicknessMax($get['max_thickness']);
            $model->setThicknessMin($get['min_thickness']);
            $model->setResistance($get['resistance']);
            $model->setOblique($get['oblique']);
            $model->setWrapDiameterMax($get['max_wrap_diameter']);
            $model->setWrapDiameterMin( $get['min_wrap_diameter']);
            $model->setWrapCenterMax($get['max_wrap_center']);
            $model->setWrapCenterMin($get['min_wrap_center']);
            $model->setWrapEdgeMax($get['max_wrap_edge']);
            $model->setWrapEdgeMin($get['min_wrap_edge']);
            $model->setStraight($get['straight']);
            $model->setMeanWaterAttraction($get['mean_water_attraction']);
            $model->setTemperatureMax($get['max_temperature']);
            $model->setTemperatureMin($get['min_temperature']);
            $model->setCycle($get['cycle']);
            $model->setSpecificPressure($get['specific_pressure']);
            $model->setController(user::getUserLogin(true));

            if ($id != null) {
                if ($model->upDateDataBase()) {
                    $Dis .= rlang('be') . " " . $this->item_label . " " . rlang('with') . " " . rlang('name') . " ";
                    $Dis .= $model->getProductLabel() . " ";
                    $Dis .= rlang('changed');

                    Response::redirect(App::getBaseAppLink($this->class_name . '/list/' . $product, 'admin'));
                    $this->callHooks('addLog', [$Dis, $this->log_name]);
                } else {
                    $this->alert('danger', '', rlang('pleaseTryAGain'));
                }

            } else {
                if ($model->insertToDataBase()) {
                    $Dis .= $model->getProductLabel() . " ";
                    $Dis = $Dis . rlang('inserted');

                    Response::redirect(App::getBaseAppLink($this->class_name . '/list/' . $product, 'admin'));
                    $this->callHooks('addLog', [$Dis, $this->log_name]);
                } else {
//                    show(model::getLastQuery());
                    $this->alert('danger', '', rlang('pleaseTryAGain'));
                }
            }

        }
        $this->mold->path('default', $this->app_name);
        $this->mold->view($this->html_file_path);
        if ($id == null)
            $this->mold->setPageTitle(rlang('insert') . " " . $this->item_label);
        else
            $this->mold->setPageTitle(rlang('Edit') . " " . $this->item_label);

        $this->mold->set('ChangeURL', $this->listChangeURL);
        $this->mold->set('item_label', $this->item_label);
        $editAccess = checkAccess::index(user::getUserLogin()['user_group_id'], 'admin', $this->class_name, 'list', $this->app_name)["status"];
        $this->mold->set('editAccess', $editAccess);
        $this->mold->set('activeMenu', $this->active_menu);
        $this->mold->set('productLabel', $model->getProductLabel());
        $this->mold->set('sizeLabel', $model->getSizeLabel());
        $this->mold->set('size', $model->getSizeModel());
        $this->mold->set('shifts', shift::shift()["result"]);
        return false;
    }

}