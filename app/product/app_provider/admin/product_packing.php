<?php

namespace App\product\app_provider\admin;

use App\user\app_provider\api\checkAccess;
use App\user\app_provider\api\user;
use App\user\controller\api;
use controller;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class product_packing extends controller
{
    private $item_label = "بسته بندی";
    private $model_name = 'product_packing';
    private $controller_name = 'product_packing';
    private $log_name = 'product_packing';
    private $app_name = 'product';
    private $active_menu = 'product_packing';
    private $html_file_path = 'product_packing.mold.html';

    public function index(): bool
    {
        /* @var \App\product\model\product_packing $model */
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
                $value[] = '%' . $get['label'] . '%';
                $variable[] = 'item.label Like ? ';
            }
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
        $this->mold->set('carton', \App\product\app_provider\api\product::carton()["result"]);
        $this->mold->set('pallet', \App\product\app_provider\api\product::pallet()["result"]);
        $this->mold->set('pallet_size', \App\product\app_provider\api\product::pallet_size()["result"]);
        $this->mold->set('carton_size', \App\product\app_provider\api\product::carton_size()["result"]);
        $this->mold->set('carton_theme', \App\product\app_provider\api\product::carton_theme()["result"]);
        $this->mold->set('glue', \App\product\app_provider\api\product::glue()["result"]);
        $this->mold->set('strap', \App\product\app_provider\api\product::strap()["result"]);
        $this->mold->set('plastic', \App\product\app_provider\api\product::plastic()["result"]);
        $this->mold->set('item_label', $this->item_label);
        $editAccess = checkAccess::index(user::getUserLogin()['user_group_id'], 'admin', $this->controller_name, 'update', $this->app_name)["status"];
        $this->mold->set('editAccess', $editAccess);
        return false;

    }

    public function update(): bool
    {
        /* @var \App\product\model\product_packing $model */
        $get = request::post('id,label,carton,glue,strap,plastic,glue_weight,plastic_weight,strap_weight,number_of_tiles');
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



        $Dis = $this->item_label . " " . rlang('with') . " " . rlang('name') . " ";
        $Dis .= $model->getLabel() . " ";

        $model->setLabel($get['label']);
        $model->setCartonPackingCarton($get['carton_packing_carton']);
        $model->setCartonPackingCartonSize($get['carton_packing_carton_size']);
        $model->setCartonPackingCartonTheme($get['carton_packing_carton_theme']);
        $model->setCartonPackingCartonWeight($get['carton_packing_carton_weight']);
        $model->setCartonPackingGlue($get['carton_packing_glue']);
        $model->setCartonPackingStrap($get['carton_packing_strap']);
        $model->setCartonPackingStrapWeight($get['carton_packing_strap_weight']);
        $model->setCartonPackingGlueAmount($get['carton_packing_glue_amount']);
        $model->setCartonPackingPlastic($get['carton_packing_plastic']);
        $model->setCartonPackingPlasticWeight($get['carton_packing_plastic_weight']);
        $model->setCartonPackingNumberOfTiles($get['carton_packing_number_of_tiles']);
        $model->setPalletPackingPallet($get['pallet_packing_pallet']);
        $model->setPalletPackingPalletSize($get['pallet_packing_pallet_size']);
        $model->setPalletPackingPalletWeight($get['pallet_packing_pallet_weight']);
        $model->setPalletPackingStrap($get['pallet_packing_strap']);
        $model->setPalletPackingStrapWeight($get['pallet_packing_strap_weight']);
        $model->setPalletPackingPlastic($get['pallet_packing_plastic']);
        $model->setPalletPackingPlasticWeight($get['pallet_packing_plastic_weight']);
        $model->setPalletPackingCartonOnPallet($get['pallet_packing_carton_on_pallet']);
        $model->setPalletPackingCarton($get['pallet_packing_carton']);

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