<?php

namespace App\weighbridge\app_provider\admin;

use App\core\controller\httpErrorHandler;
use App\user\app_provider\api\checkAccess;
use App\weighbridge\app_provider\api\customer;
use App\weighbridge\app_provider\api\operation_type;
use App\weighbridge\app_provider\api\payment_method;
use App\weighbridge\model\payments;
use controller;
use paymentCms\component\JDate;
use paymentCms\component\request;
use App\user\app_provider\api\user;
use paymentCms\component\validate;
use paymentCms\component\Response;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class payment extends controller
{
    public function index($id = null)
    {
        /** @var payments $model */
        $model = parent::model('payments');

        $get = request::post('Time_Send,JTime_Send,customer,account_status,operation_type,amount,description,payment_method,receipt_number');
        if ($id != null) {
            $model = parent::model('payments', $id);

            if ($model->getId() != $id) {
                httpErrorHandler::E404();
                return false;
            }
        }

        $user = user::getUserLogin(false);
        $this->mold->set('user', $user);
        $this->mold->set('model2', $model);
        $this->mold->set('customers', customer::index()["result"]);
        $this->mold->set('operation_type', operation_type::index()["result"]);
        $this->mold->set('payment_method', payment_method::index()["result"]);

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
            $shamsi = explode('/', $get['Time_Send']);
            $miladi = JDate::jalali_to_gregorian($shamsi[0], $shamsi[1], $shamsi[2], '/');
            $get['Time_Start'] = $get['Time_Start'] / 1000;
            $get['Time_End'] = $get['Time_End'] / 1000;
            $model->setTimeSend(date('Y-m-d H:i:s', strtotime(date('Y-m-d ', strtotime($miladi)) . date('H:i:00', strtotime($get['Time_Send_justT'])))));
            $model->setJTimeSend(JDate::jdate('Y-m-d', strtotime(date('Y-m-d ', strtotime($miladi)) . date('H:i:00', strtotime($get['Time_Send_justT'])))));
            $model->setCustomer($get['customer']);
            $model->setAccountStatus($get['account_status']);
            $model->setOperationType($get['operation_type']);
            $model->setAmount($get['amount']);
            $model->setDescription($get['description']);
            $model->setPaymentMethod($get['payment_method']);
            $model->setReceiptNumber($get['receipt_number']);
            $model->setUser(user::getUserLogin());


            $Dis = 'پرداخت با نام ';
            if ($id == null) {
                if ($model->insertToDataBase()) {

                    $Dis = $Dis . ' ثبت شد';
                    $this->callHooks('addLog', [$Dis, 'payment']);

                    Response::jsonMessage(rlang('insert') . ' ' . rlang("successfully") . ' ' . rlang("was"), true);
                    return false;
                } else {
                    Response::jsonMessage(rlang('insert') . ' ' . rlang("fail") . ' ' . rlang("was"), false);
                    return false;
                }
            } else{
                if ($model->upDateDataBase()) {
                    $Dis = $Dis . ' تغییر یافت';
                    $this->callHooks('addLog', [$Dis, 'payment']);

                    Response::jsonMessage(rlang('insert') . ' ' . rlang("successfully") . ' ' . rlang("was"), true);
                    return false;
                } else {
                    Response::jsonMessage(rlang('insert') . ' ' . rlang("fail") . ' ' . rlang("was"), false);
                    return false;
                }
            }
        }

        $this->mold->path('default', 'weighbridge');
        $this->mold->view('payment.mold.html');
        $this->mold->set('activeMenu', 'payment');
        if ($id == null)
            $this->mold->setPageTitle(rlang('insert') . ' ' . rlang('payment'));
        else
            $this->mold->setPageTitle(rlang('edit') . ' ' . rlang('payment'));
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
        /** @var payments $model */
        $model = parent::model('payments');
        $numberOfAll = $model->getItemCount($value, $variable);
        $pagination = parent::pagination($numberOfAll, $get['page'], $get['perEachPage']);
        $search = $model->getItems($value, $variable, $sortWith, $pagination);

        $this->mold->set('items', $search);
        $editAccess = checkAccess::index(user::getUserLogin()['user_group_id'], 'admin', 'payment', 'index', 'weighbridge')["status"];
        $this->mold->set('editAccess', $editAccess);

        $this->mold->path('default', 'weighbridge');
        $this->mold->view('paymentList.mold.html');
        $this->mold->setPageTitle(rlang('payment'));
        $this->mold->set('activeMenu', 'payment');
    }


    private static function tr_num($str, $mod = 'en')
    {
        $num_a = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $key_a = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        return ($mod == 'fa') ? str_replace($num_a, $key_a, $str) : str_replace($key_a, $num_a, $str);
    }
}