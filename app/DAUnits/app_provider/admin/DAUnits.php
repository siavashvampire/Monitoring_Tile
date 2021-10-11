<?php

namespace App\DAUnits\app_provider\admin;

use App;
use App\core\controller\fieldService;
use App\core\controller\httpErrorHandler;
use App\user\app_provider\api\checkAccess;
use controller;
use Exception;
use paymentCms\component\JDate;
use paymentCms\component\model;
use paymentCms\component\request;
use App\user\app_provider\api\user;
use paymentCms\component\validate;
use paymentCms\component\Response;
use paymentCms\component\arrays;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class DAUnits extends controller
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

        $sortWith = [['column' => 'unit.id', 'type' => 'asc']];
        $model = parent::model('DAUnits');
        $numberOfAll = $model->getCount($value, $variable);
        $pagination = parent::pagination($numberOfAll, $get['page'], $get['perEachPage']);
        $search = $model->getItems($value, $variable, $sortWith, $pagination);
        $this->mold->set('items', $search);

        $editAccess = checkAccess::index(user::getUserLogin()['user_group_id'], 'admin', 'DAUnits', 'index', 'DAUnits')["status"];
        $this->mold->set('editAccess', $editAccess);
        $this->mold->set('ChangeURL', 'DAUnits');

        $this->mold->path('default', 'DAUnits');
        $this->mold->view('DAUnitsList.mold.html');
        $this->mold->setPageTitle(rlang('DAUnits'));
        $this->mold->set('activeMenu', 'DAUnitsList');
    }

    public function index($id = null)
    {
        $get = request::post('label,IP,type,appName', null);
        if ($id != null) {
            $model = parent::model('DAUnits', $id);

            if ($model->getId() != $id) {
                httpErrorHandler::E404();
            }
            $this->mold->set('apps', parent::model('DAUnits_app')->getAppWithId($model->getId()));


        } else
            $model = parent::model('DAUnits');


        $this->mold->set('model', $model);

        if (request::isPost()) {
            $rules = [
                "label" => ["required", rlang('name') . " " . rlang('DAUnits')],
            ];
            $valid = validate::check($get, $rules);
            $this->mold->offAutoCompile();

            $GLOBALS['timeStart'] = '';
            if ($valid->isFail()) {
                Response::jsonMessage($valid->errorsIn(), false);
                return false;
            }


            $model->setlabel($get['label']);
            $model->setIP($get['IP']);
            $model->setStatus(0);
            $model->setType($get['type']);
            $Dis = 'واحد جمع آوری اطلاعات با نام ';

            $Dis = $Dis . $model->getlabel();
            if ($id == null) {
                if ($model->insertTodataBase()) {
                    $Dis = $Dis . 'ثبت شد ';
                    $this->callHooks('addLog', [$Dis, 'DAUnits']);

                } else
                    Response::jsonMessage(rlang('insert') . ' ' . rlang("fail") . ' ' . rlang("was"), false);

            } elseif ($id != null) {
                if ($model->upDateDataBase()) {
                    $Dis = $Dis . 'تغییر یافت. ';
                    $this->callHooks('addLog', [$Dis, 'DAUnits']);

                } else
                    Response::jsonMessage(rlang('insert') . ' ' . rlang("fail") . ' ' . rlang("was"), false);


            }

            if ($model->getId() > 0) {
                $modelApp = parent::model('DAUnits_app');
                $modelApp->setDAUnitsId($model->getId());
                $modelApp->deleteAllRow();

                for ($i = 0; $i < count($get['appName']); $i++) {

                    if ($get['appName'][$i] != "") {
                        $modelApp->setLabel($get['appName'][$i]);
                        for ($j = $i + 1; $j < count($get['appName']); $j++) {
                            if ($get['appName'][$i] == $get['appName'][$j])
                                Response::jsonMessage(arrays::dataToStrArray(rlang('similarAppNames'), [$i + 1, $j + 1]), false);
                        }

                        try {
                            $modelApp->insertToDataBase();

                        } catch (Exception $e) {
                            $modelApp->deleteAllRow();
                            Response::jsonMessage(rlang('pleaseTryAGain'), false);
                            return false;
                        }

                    }

                }
            } else
                Response::jsonMessage(rlang('insert') . ' ' . rlang("fail") . ' ' . rlang("was"), false);
            if ($id == null)
                Response::jsonMessage("ثبت اطلاعات با موفقیت انجام شد", true);
            else
                Response::jsonMessage("ویرایش اطلاعات با موفقیت انجام شد", true);


        }

        $this->mold->set('appsTotal', App::appsListWithPLC());
        $this->mold->set('types', parent::model('DAUnits_Type')->getType());
        $this->mold->path('default', 'DAUnits');
        $this->mold->set('activeMenu', 'DAUnits');
        $this->mold->view('DAUnits.mold.html');
    }

    private static function tr_num($str, $mod = 'en')
    {
        $num_a = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $key_a = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        return ($mod == 'fa') ? str_replace($num_a, $key_a, $str) : str_replace($key_a, $num_a, $str);
    }
}