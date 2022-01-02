<?php

namespace App\product\app_provider\admin;

use App;
use App\core\controller\httpErrorHandler;
use App\LineMonitoring\app_provider\api\phases;
use App\shiftWork\app_provider\api\totalDate;
use App\user\app_provider\api\checkAccess;
use App\user\app_provider\api\user;
use controller;
use paymentCms\component\JDate;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class product_qc extends controller
{
    private $item_label = "کنترل کیفی";
    private $ChangeURL = "product_qc";
    private $QC_download = "product_export";
    private $listChangeURL = "product_qc/list";
    private $log_name = 'product_qc';
    private $model_name = 'product_qc';
    private $app_name = 'product';
    private $class_name = 'product_qc';
    private $active_menu = 'product_qc_list';
    private $list_html_file_path = 'product_qc_list.mold.html';
    private $html_file_path = 'product_qc.mold.html';

    public function list($product = null): bool
    {
        /* @var App\product\model\product_qc $model */
        $get = request::post('page=1,perEachPage=25,label,phase,code,file_code,size,controller');

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
                $variable[] = 'product.label Like ? ';
            }
        }
        if ($get['phase'] != null) {
            $variable[] = ' product.phase = ?' ;
            $value[] = $get['phase'];
        }
        if ($get['size'] != null) {
            $variable[] = ' product.size = ?' ;
            $value[] = $get['size'];
        }
        if ($get['product'] != null) {
            $variable[] = ' item.product = ?' ;
            $value[] = $get['product'];
        }
        if ($get['controller'] != null) {
            $variable[] = ' item.controller = ?' ;
            $value[] = $get['controller'];
        }
        if ($get['code'] != null) {
            $variable[] = ' item.code = ?' ;
            $value[] = $get['code'];
        }
        if ($get['file_code'] != null) {
            $variable[] = 'ABS(item.file_code - ?) < 0.001' ;
            $value[] = $get['file_code'];
        }

        $model = parent::model($this->model_name);
        $model->setProduct($product);

        if ($product != null) {
            $value[] = $product;
            $variable[] = 'item.product = ? ';

            $this->mold->set('sizeLabel', $model->getSizeLabel());
            $this->mold->set('product', $product);
            $this->mold->set('productLabel', App\product\app_provider\api\product::index($product)["result"][0]["label"]);
        }

        $numberOfAll = ($model->getCount($value,$variable));
        $pagination = parent::pagination($numberOfAll, $get['page'], $get['perEachPage']);
        $pagination = [$pagination['start'], $pagination['limit']];
        $sort = ['column' => 'item.qc_date', 'type' => 'DESC'];

        $search = $model->getItems($value, $variable,$sort,$pagination);

        $this->mold->path('default', $this->app_name);
        $this->mold->view($this->list_html_file_path);
        $this->mold->setPageTitle(rlang('list') . " " . $this->item_label);
        $this->mold->set('activeMenu', $this->active_menu);
        $this->mold->set('items', $search);
        $this->mold->set('item_label', $this->item_label);
        $this->mold->set('ChangeURL', $this->ChangeURL);

        $editAccess = checkAccess::index(user::getUserLogin()['user_group_id'], 'admin', $this->class_name,
            'index', $this->app_name)["status"];
        $this->mold->set('editAccess', $editAccess);
        $this->mold->set('QC_download', $this->QC_download);

        $this->mold->set('phases', phases::index()["result"]);
        $this->mold->set('sizes', App\product\app_provider\api\product::size()["result"]);
        $this->mold->set('controllers', user::getUsersByGroupId((int)$this->setting('product_qc'))["result"]);
        return false;
    }

    public function index($product, $id = null): bool
    {
        /* @var App\product\model\product_qc $model */
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
            $get = request::post('thickness,body,engobe,glaze,novanc,sub_engobe,description,code,file_code');

            $rules = [
            ];
            $valid = validate::check($get, $rules);
            $GLOBALS['timeStart'] = '';
            if ($valid->isFail()) {
                Response::jsonMessage($valid->errorsIn(), false);
                return false;
            }
            $Dis = $this->item_label . " " . rlang('with') . " " . rlang('name') . " ";
            $Dis .= $model->getProductLabel() . " ";
            $model->setInsertDate(date('Y-m-d H:i:s'));
            $model->setQcDate(JDate::jdate('Y-m-d', totalDate::Day()["result"]["dayStartTime"]));
            $model->setBody($get['body']);
            $model->setEngobe($get['engobe']);
            $model->setThickness($get['thickness']);
            $model->setGlaze($get['glaze']);
            $model->setNovanc($get['novanc']);
            $model->setSubEngobe($get['sub_engobe']);
            $model->setFileCode($get['file_code']);
            $model->setCode($get['code']);
            $model->setDescription($get['description']);
            $model->setController(user::getUserLogin(true));

            if ($id != null) {
                if ($model->upDateDataBase()) {
                    $Dis .= rlang('be') . " " . $this->item_label . " " . rlang('with') . " " . rlang('name') . " ";
                    $Dis .= $model->getProductLabel() . " ";
                    $Dis .= rlang('changed');

                    $this->callHooks('addLog', [$Dis, $this->log_name]);
                    Response::redirect(App::getBaseAppLink($this->class_name . '/list/' . $product, 'admin'));
                } else {
                    $this->alert('danger', '', rlang('pleaseTryAGain'));

                }

            } else {
                if ($model->insertToDataBase()) {
                    $Dis .= $model->getProductLabel() . " ";
                    $Dis = $Dis . rlang('inserted');

                    $this->callHooks('addLog', [$Dis, $this->log_name]);
                    Response::redirect(App::getBaseAppLink($this->class_name . '/list/' . $product, 'admin'));
                } else {
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

        $this->mold->set('ChangeURL', $this->listChangeURL . "/" . $product);
        $this->mold->set('item_label', $this->item_label);
        $editAccess = checkAccess::index(user::getUserLogin()['user_group_id'], 'admin', $this->class_name, 'list', $this->app_name)["status"];
        $this->mold->set('editAccess', $editAccess);
        $this->mold->set('activeMenu', $this->active_menu);
        $this->mold->set('glazes', App\product\app_provider\api\product::glazeChild()["result"]);
        $this->mold->set('engobes', App\product\app_provider\api\product::engobe()["result"]);
        $this->mold->set('bodys', App\product\app_provider\api\product::body()["result"]);
        $this->mold->set('novanc', App\product\app_provider\api\product::novanc()["result"]);
        $this->mold->set('sub_engobe', App\product\app_provider\api\product::sub_engobe()["result"]);
        $this->mold->set('productLabel', App\product\app_provider\api\product::index($product)["result"][0]["label"]);
        $this->mold->set('sizeLabel', $model->getSizeLabel());

        return false;
    }

}