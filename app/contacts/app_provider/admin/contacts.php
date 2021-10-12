<?php

namespace App\contacts\app_provider\admin;

use App\core\controller\httpErrorHandler;
use App\LineMonitoring\app_provider\api\phases;
use App\units\app_provider\api\units;
use App\user\app_provider\api\checkAccess;
use controller;
use paymentCms\component\request;
use App\user\app_provider\api\user;
use paymentCms\component\validate;
use paymentCms\component\Response;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class contacts extends controller
{
    public function List()
    {
        $get = request::post('page=1,perEachPage=25', null);

        $rules = [
            "page" => ["required|match:>0", rlang('page')],
            "perEachPage" => ["required|match:>0|match:<501", rlang('page')],
        ];

        $valid = validate::check($get, $rules);
        $value = array();
        $variable = array();


        if ($valid->isFail()) {
            //TODO:: add error is not valid data

        }

        $sortWith = [['column' => 'item.id', 'type' => 'asc']];
        $model = parent::model('phone');
        $numberOfAll = $model->getCount($value, $variable);
        $pagination = parent::pagination($numberOfAll, $get['page'], $get['perEachPage']);
        $contacts = $model->getItems($value, $variable, $sortWith, $pagination);
        $units = new units();
        $phases = new phases();

        foreach($contacts as $x => $contact) {
            $contacts[$x]["units"] = implode(',',array_column($units->getById($contact["units"])['result'], 'Name'));
            $contacts[$x]["phase"] = implode(',',array_column($phases->getById($contact["phase"])['result'], 'label'));
        }
        $this->mold->set('items', $contacts);
//        show($contacts);


        $editAccess = checkAccess::index(user::getUserLogin()['user_group_id'], 'admin', 'contacts', 'index', 'contacts')["status"];
        $this->mold->set('editAccess', $editAccess);
        $this->mold->set('ChangeURL', 'contacts');

        $this->mold->path('default', 'contacts');
        $this->mold->view('contactsList.mold.html');
        $this->mold->setPageTitle(rlang('contacts'));
        $this->mold->set('activeMenu', 'contactsList');
    }

    public function index($id = null)
    {
        $get = request::post('name,Phone,send_allow,Access,unit,phase,type', null);
        if ($id != null) {
            $model = parent::model('phone', $id);

            if ($model->getId() != $id) {
                httpErrorHandler::E404();
            }

        } else
            $model = parent::model('phone');


        $this->mold->set('model', $model);


        if (request::isPost()) {


            $rules = [
                "name" => ["required", rlang('name') . " " . rlang('contacts')],
                "phase" => ["required", rlang('phase') . " " . rlang('contacts')],
                "unit" => ["required", rlang('unit') . " " . rlang('contacts')],
                "type" => ["required", rlang('type') . " " . rlang('contacts')],
                "Phone" => ["required", rlang('phone') . " " . rlang('contacts')],
            ];

            $valid = validate::check($get, $rules);
            $this->mold->offAutoCompile();

            $GLOBALS['timeStart'] = '';
            if ($valid->isFail()) {
                Response::jsonMessage($valid->errorsIn(), false);
                return false;
            }

            $model->setName($get['name']);
            $model->setPhone($get['Phone']);
            $model->setSendAllow($get['send_allow']);
            $model->setAccess($get['Access']);
            $model->setUnits($get['unit']);
            $model->setPhase($get['phase']);


            $model->setType($get['type']);
            $Dis = 'مخاطب با نام ';

            $Dis = $Dis . $model->getName();
            if ($id == null) {
                if ($model->insertTodataBase()) {
                    $Dis = $Dis . 'ثبت شد ';
                    $this->callHooks('addLog', [$Dis, 'contacts']);
                    Response::jsonMessage("ثبت مخاطب انجام شد", true);

                } else
                    Response::jsonMessage(rlang('insert') . ' ' . rlang("fail") . ' ' . rlang("was"), false);

            } elseif ($id  != null) {
                if ($model->upDateDataBase()) {
                    $Dis = $Dis . 'تغییر یافت. ';
                    $this->callHooks('addLog', [$Dis, 'contacts']);
                    Response::jsonMessage("ویرایش مخاطب انجام شد", true);

                } else
                    Response::jsonMessage(rlang('insert') . ' ' . rlang("fail") . ' ' . rlang("was"), false);
            }
        }

        $this->mold->path('default', 'contacts');

        $this->mold->set('activeMenu', 'contacts');
        $this->mold->set('phone_type', parent::model('phone_type')->getType());
        $this->mold->view('contacts.mold.html');
        $this->mold->set('units', units::all()["result"]);
        $this->mold->set('phases', phases::all()["result"]);
        $editAccess = checkAccess::index(user::getUserLogin()['user_group_id'], 'admin', 'contacts', 'List', 'contacts')["status"];
        $this->mold->set('editAccess', $editAccess);
        $this->mold->set('ChangeURL', 'contacts/List');

    }

    private static function tr_num($str, $mod = 'en')
    {
        $num_a = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $key_a = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        return ($mod == 'fa') ? str_replace($num_a, $key_a, $str) : str_replace($key_a, $num_a, $str);
    }
}