<?php

namespace App\weighbridge\app_provider\admin;

use App\core\controller\httpErrorHandler;
use App\user\app_provider\api\checkAccess;
use App\weighbridge\app_provider\api\weight_unit;
use App\weighbridge\model\products;
use controller;
use paymentCms\component\JDate;
use paymentCms\component\request;
use App\user\app_provider\api\user;
use paymentCms\component\validate;
use paymentCms\component\Response;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class product extends controller
{
    public function index($id = null)
    {
        /** @var products $model */
        $model = parent::model('products');

        $get = request::post('label,weight_loss,weight_unit,description,standard,amount,mass,massInReceipt,unit_price_sale,previous_price_sale,Time_Send_sale,previous_Time_Send_sale,unit_price_buy,previous_price_buy,Time_Send_buy,previous_Time_Send_buy');
        if ($id != null) {
            $model = parent::model('products', $id);

            if ($model->getId() != $id) {
                httpErrorHandler::E404();
                return false;
            }
        }

        $user = user::getUserLogin(false);
        $this->mold->set('model', $model);
        $this->mold->set('weight_unit', weight_unit::index()["result"]);



        if (request::ispost()) {

            $rules = [
            ];
            $valid = validate::check($get, $rules);
            $this->mold->offAutoCompile();

            $GLOBALS['timeStart'] = '';

            if ($valid->isFail()) {
                Response::jsonMessage($valid->errorsIn(), false);
                return false;
            }

            $shamsi = explode('/', $get['Time_Send_sale']);
            $miladi = JDate::jalali_to_gregorian($shamsi[0], $shamsi[1], $shamsi[2], '/');

            $model->setLabel($get['label']);
            $model->setWeightLoss($get['weight_loss']);
            $model->setWeightUnit($get['weight_unit']);
            $model->setDescription($get['description']);
            $model->setStandard($get['standard']);

            $model->setAmount($get['amount']);
            $model->setMass($get['mass']);
            $model->setMassInReceipt($get['massInReceipt']);
            $model->setUnitPriceSale($get['unit_price_sale']);
            $model->setPreviousPriceSale($get['previous_price_sale']);

            $model->setTimeSendSale(date('Y-m-d H:i:s', strtotime(date('Y-m-d ', strtotime($miladi)) . date('H:i:00', strtotime($get['Time_Send_sale'])))));

            $model->setPreviousTimeSendSale(date('Y-m-d H:i:s', strtotime(date('Y-m-d ', strtotime($miladi)) . date('H:i:00', strtotime($get['previous_Time_Send_sale'])))));
            $model->setUnitPriceBuy($get['unit_price_buy']);
            $model->setPreviousPriceBuy($get['previous_price_buy']);
            $model->setTimeSendBuy(date('Y-m-d H:i:s', strtotime(date('Y-m-d ', strtotime($miladi)) . date('H:i:00', strtotime($get['Time_Send_buy'])))));
            $model->setPreviousTimeSendBuy(date('Y-m-d H:i:s', strtotime(date('Y-m-d ', strtotime($miladi)) . date('H:i:00', strtotime($get['previous_Time_Send_buy'])))));

            $Dis = 'کالا با نام ';
            if ($id == null) {
                if ($model->insertToDataBase()) {

                    $Dis = $Dis . ' ثبت شد';
                    $this->callHooks('addLog', [$Dis, 'product']);

                    Response::jsonMessage(rlang('insert') . ' ' . rlang("successfully") . ' ' . rlang("was"), true);
                    return false;
                } else {
                    Response::jsonMessage(rlang('insert') . ' ' . rlang("fail") . ' ' . rlang("was"), false);
                    return false;
                }
            } else{
                if ($model->upDateDataBase()) {
                    $Dis = $Dis . ' تغییر یافت';
                    $this->callHooks('addLog', [$Dis, 'product']);

                    Response::jsonMessage(rlang('insert') . ' ' . rlang("successfully") . ' ' . rlang("was"), true);
                    return false;
                } else {
                    Response::jsonMessage(rlang('insert') . ' ' . rlang("fail") . ' ' . rlang("was"), false);
                    return false;
                }
            }
        }

        $this->mold->path('default', 'weighbridge');
        $this->mold->view('product.mold.html');
        $this->mold->set('activeMenu', 'product');
        if ($id == null)
            $this->mold->setPageTitle(rlang('insert') . ' ' . rlang('product'));
        else
            $this->mold->setPageTitle(rlang('edit') . ' ' . rlang('product'));
    }

    public function List()
    {
        $get = request::post('page=1,perEachPage=25,sortWith', null);

        $rules = [
            "page" => ["required|match:>0", rlang('page')],
            "perEachPage" => ["required|match:>0|match:<501", rlang('page')],
        ];

        $valid = validate::check($get, $rules);
        $value = array();
        $variable = array();

        if ($valid->isFail()) {
            //TODO:: add error is not valid data

        } else {
            if ($get['sortWith'] != null and is_array($get['sortWith'])) {
                unset($sortWith);
                foreach ($get['sortWith'] as $sort) {
                    $temp = explode('|', $sort);
                    $sortWith[] = ['column' => $temp[0], 'type' => $temp[1]];
                }
            }

        }

        $sortWith = [['column' => 'id', 'type' => 'asc']];
        /** @var products $model */
        $model = parent::model('products');
        $numberOfAll = $model->getItemCount($value, $variable);
        $pagination = parent::pagination($numberOfAll, $get['page'], $get['perEachPage']);
        $search = $model->getItems($value, $variable, $sortWith, $pagination);
        $this->mold->set('items', $search);


        $this->mold->path('default', 'weighbridge');
        $this->mold->view('productList.mold.html');
        $this->mold->setPageTitle(rlang('product'));
        $this->mold->set('activeMenu', 'product');

    }


    private static function tr_num($str, $mod = 'en')
    {
        $num_a = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $key_a = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        return ($mod == 'fa') ? str_replace($num_a, $key_a, $str) : str_replace($key_a, $num_a, $str);
    }
}