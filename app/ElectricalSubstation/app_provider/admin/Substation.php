<?php

namespace App\ElectricalSubstation\app_provider\admin;

use App\core\controller\httpErrorHandler;
use App\ElectricalSubstation\model\substation_Device;
use App\ElectricalSubstation\model\substation_deviceType;
use App\user\app_provider\api\checkAccess;
use controller;
use paymentCms\component\cache;
use paymentCms\component\request;
use App\user\app_provider\api\user;
use paymentCms\component\validate;
use paymentCms\component\Response;
use paymentCms\component\arrays;
use Exception;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class Substation extends controller
{
    public function Data($id = null)
    {
        /** @var \App\ElectricalSubstation\model\Substation $model */
        if ($id != null) {
            $model = parent::model('Substation', $id);

            if ($model->getId() != $id) {
                httpErrorHandler::E404();
                return false;
            }
            /** @var substation_Device $model_device */
            $model_device = parent::model('substation_Device');
            $this->mold->set('devices', $model_device->getItems($id));
        } else
            $model = parent::model('Substation');

        $this->mold->set('model', $model);


        $this->mold->path('default', 'ElectricalSubstation');
        $this->mold->view('SubstationData.mold.html');
        $this->mold->setPageTitle(rlang('Substation'));
        $this->mold->set('activeMenu', 'Substation');
    }

    public function List()
    {
        $get = request::post('page=1,perEachPage=25,label,sortWith');

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
            if ($get['label'] != null) {
                $value[] = '%' . $get['label'] . '%';
                $variable[] = ' Substation.label Like ? ';
            }
            if ($get['sortWith'] != null and is_array($get['sortWith'])) {
                unset($sortWith);
                foreach ($get['sortWith'] as $sort) {
                    $temp = explode('|', $sort);
                    $sortWith[] = ['column' => $temp[0], 'type' => $temp[1]];
                }
            }

        }

        $sortWith = [['column' => 'id', 'type' => 'asc']];
        /** @var \App\ElectricalSubstation\model\Substation $model */
        $model = parent::model('Substation');
        $numberOfAll = $model->getCount($value, $variable);
        $pagination = parent::pagination($numberOfAll, $get['page'], $get['perEachPage']);
        $items = $model->getItems($value, $variable, $sortWith, $pagination);

        $this->mold->set('items', $items);

        $editAccess = checkAccess::index(user::getUserLogin()['user_group_id'], 'admin', 'Substation', 'index', 'ElectricalSubstation')["status"];
        $this->mold->set('editAccess', $editAccess);
        $this->mold->set('viewAccess', $editAccess);

        $this->mold->path('default', 'ElectricalSubstation');
        $this->mold->view('SubstationList.mold.html');
        $this->mold->setPageTitle(rlang('Substation'));
        $this->mold->set('activeMenu', 'Substation');
    }

    public function index($id = null)
    {
        /** @var \App\ElectricalSubstation\model\Substation $model */
        /** @var substation_Device $model_device */
        /** @var substation_deviceType $model_device_type */

        $get = request::post('label,port,unitId,deviceType,deviceName,refreshTime');
        if ($id != null) {
            $model = parent::model('Substation', $id);

            $model_device = parent::model('substation_Device');
            $this->mold->set('devices', $model_device->getItems($id));


            if ($model->getId() != $id) {
                httpErrorHandler::E404();
                return false;
            }

        } else
            $model = parent::model('Substation');

        $this->mold->set('model', $model);

        $model_device_type = parent::model('substation_deviceType');
        $this->mold->set('devicesType', $model_device_type->getItems());

        if (request::ispost()) {
            $rules = [
                "label" => ["required", rlang('name') . " " . rlang('Substation')],
            ];
            $valid = validate::check($get, $rules);
            $this->mold->offAutoCompile();
            $GLOBALS['timeStart'] = '';
            if ($valid->isFail()) {
                Response::jsonMessage($valid->errorsIn(), false);
                return false;
            }

            $model->setlabel($get['label']);
            $model->setPort($get['port']);

            $Dis = 'پست با نام ';
            $Dis = $Dis . $model->getlabel();

            if ($id == null) {
                if ($model->insertToDataBase()) {
                    $Dis = $Dis . ' ثبت شد';
                    $this->callHooks('addLog', [$Dis, 'Substation']);
                } else {
                    Response::jsonMessage(rlang('insert') . ' ' . rlang("fail") . ' ' . rlang("was"), false);
                }

            } else {
                if ($model->upDateDataBase()) {
                    $Dis = $Dis . ' تغییر یافت';
                    $this->callHooks('addLog', [$Dis, 'Substation']);
                } else {
                    Response::jsonMessage(rlang('insert') . ' ' . rlang("fail") . ' ' . rlang("was"), false);
                }

            }

            if ($model->getId() > 0) {

                $model_device = parent::model('substation_Device');

                $model_device->setSubstationId($model->getId());
                $model_device->deleteAllRow();


                for ($i = 0; $i < count($get['deviceType']); $i++) {
                    for ($j = $i + 1; $j < count($get['deviceType']); $j++) {
                        if ($get['unitId'][$i] == $get['unitId'][$j])
                            Response::jsonMessage(arrays::dataToStrArray(rlang('similarUnitId'), [$i + 1, $j + 1]), false);
                        if ($get['deviceName'][$i] == $get['deviceName'][$j])
                            Response::jsonMessage(arrays::dataToStrArray(rlang('similarNames'), [$i + 1, $j + 1]), false);
                    }


                    if ($get['deviceType'][$i] != "") {
                        $model_device->setUnitId($get['unitId'][$i]);
                        $model_device->setDeviceType($get['deviceType'][$i]);
                        $model_device->setName($get['deviceName'][$i]);
                        $model_device->setRefreshTime($get['refreshTime'][$i]);

                        try {
                            $model_device->insertToDataBase();
                        } catch (Exception $e) {
                            $model_device->deleteAllRow();
                            Response::jsonMessage(rlang('pleaseTryAGain'), false);
                            return false;
                        }

                    }
                }

                cache::clear('isSubstation' , 'ElectricalSubstation');
                Response::jsonMessage("ثبت پست با موفقیت انجام شد", true);
                return false;
            }
            Response::jsonMessage(rlang('pleaseTryAGain'), false);
            return false;
        }

        $this->mold->path('default', 'ElectricalSubstation');
        $this->mold->view('Substation.mold.html');
        $this->mold->set('activeMenu', 'Substation');
        if ($id == null)
            $this->mold->setPageTitle(rlang('insert') . ' ' . rlang('Substation'));
        else
            $this->mold->setPageTitle(rlang('edit') . ' ' . rlang('Substation'));
    }

    private static function tr_num($str, $mod = 'en')
    {
        $num_a = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $key_a = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        return ($mod == 'fa') ? str_replace($num_a, $key_a, $str) : str_replace($key_a, $num_a, $str);
    }
}