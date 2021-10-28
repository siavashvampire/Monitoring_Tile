<?php

namespace App\weighbridge\app_provider\admin;

use App\core\controller\httpErrorHandler;
use App\weighbridge\app_provider\api\customer;
use App\weighbridge\app_provider\api\customer_api;
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


        $this->mold->set('model2', $model);
        $this->mold->set('customers', customer::index()["result"]);
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
            $model->setTimeSend(jdate::jdate('Y/m/d H:i:s', strtotime($model->getTimeSend())));
            $model->setJTimeSend($this->tr_num(str_replace("-","/",$model->getJTimeSend()) , 'fa'));
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
                    $this->callHooks('addLog', [$Dis, 'Truck']);

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

    private static function tr_num($str, $mod = 'en')
    {
        $num_a = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $key_a = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        return ($mod == 'fa') ? str_replace($num_a, $key_a, $str) : str_replace($key_a, $num_a, $str);
    }
}