<?php

namespace App\weighbridge\app_provider\admin;

use App\core\controller\httpErrorHandler;
use App\user\app_provider\api\checkAccess;
use App\weighbridge\model\customer;
use controller;
use paymentCms\component\request;
use App\user\app_provider\api\user;
use paymentCms\component\validate;
use paymentCms\component\Response;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class customers extends controller
{
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
        $model = parent::model('customer');
        $numberOfAll = $model->getItemCount($value, $variable);
        $pagination = parent::pagination($numberOfAll, $get['page'], $get['perEachPage']);
        $search = $model->getItems($value, $variable, $sortWith, $pagination);

        $this->mold->set('items', $search);
//        show($search);
        $editAccess = checkAccess::index(user::getUserLogin()['user_group_id'], 'admin', 'Truck', 'index', 'weighbridge')["status"];
        $this->mold->set('editAccess', $editAccess);

        $this->mold->path('default', 'weighbridge');
        $this->mold->view('customerList.mold.html');
        $this->mold->setPageTitle(rlang('customer'));
        $this->mold->set('activeMenu', 'customer');
    }

    public function index($id = null)
    {
        /** @var customer $model */
        $model = parent::model('customer');

        $get = request::post('name,idNumber,Credit,address,telePhone,phone,accountNumber,status,settlementType,Carrier,creditCheck,deleteOnExport,truckId', null);
        if ($id != null) {
            $model = parent::model('customer', $id);

            if ($model->getId() != $id) {
                httpErrorHandler::E404();
                return false;
            }
            $model->setTruckId(explode(',', $model->getTruckId()));
        }


        $this->mold->set('model', $model);


        $this->mold->set('carrier', parent::model('customer_carrier')->getItems());
        $this->mold->set('settlementType', parent::model('customer_settlementType')->getItems());
        $this->mold->set('status', parent::model('customer_status')->getItems());
        $this->mold->set('Trucks', parent::model('Truck')->getItems());

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
            $model->setName($get['name']);
            $model->setIdNumber($get['idNumber']);
            $model->setCredit($get['Credit']);
            $model->setAddress($get['address']);
            $model->setPhone($get['telePhone']);
            $model->setCellPhone($get['phone']);
            $model->setAccountNumber($get['accountNumber']);
            $model->setActive($get['status']);
            $model->setSettlementType($get['settlementType']);
            $model->setCarrier($get['Carrier']);
            $model->setCreditCheck($get['creditCheck']);
            $model->setDeleteOnExport($get['deleteOnExport']);
            $model->setRegistrar(user::getUserLogin(true));
            $model->setRegisterTime(date('Y-m-d H:i:s'));
            $model->setTruckId(implode(',', $get['truckId']));

            $Dis = 'کامیون با نام ';
//            Response::jsonMessage($id, false);
            if ($id == null) {
                if ($model->insertToDataBase()) {

                    $Dis = $Dis . ' ثبت شد';
                    $this->callHooks('addLog', [$Dis, 'Truck']);

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
        $this->mold->view('customer.mold.html');
        $this->mold->set('activeMenu', 'customer');
        if ($id == null)
            $this->mold->setPageTitle(rlang('insert') . ' ' . rlang('customer'));
        else
            $this->mold->setPageTitle(rlang('edit') . ' ' . rlang('customer'));
    }

    private static function tr_num($str, $mod = 'en')
    {
        $num_a = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $key_a = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        return ($mod == 'fa') ? str_replace($num_a, $key_a, $str) : str_replace($key_a, $num_a, $str);
    }
}