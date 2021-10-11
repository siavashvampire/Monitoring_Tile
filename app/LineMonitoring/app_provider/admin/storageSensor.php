<?php

namespace App\LineMonitoring\app_provider\admin;

use App;
use App\core\controller\httpErrorHandler;
use App\LineMonitoring\app_provider\api\phases;
use App\LineMonitoring\app_provider\api\tiles;
use app\LineMonitoring\model\sensors;
use App\units\app_provider\api\units;
use App\LineMonitoring\app_provider\api\sensor;
use controller;
use paymentCms\component\request;
use App\user\app_provider\api\user;
use paymentCms\component\validate;
use paymentCms\component\Response;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class storageSensor extends controller
{
    public function List()
    {
        $get = request::post('page=1,perEachPage=25,name,tile_kind,Active,unitId,phase,sortWith', null);

        $rules = [
            "page" => ["required|match:>0", rlang('page')],
            "perEachPage" => ["required|match:>0|match:<501", rlang('page')],
        ];
        $valid = validate::check($get, $rules);
        $value = array();
        $variable = array();

        $sortWith = [['column' => 'VS.showSort', 'type' => 'asc']];
        if ($valid->isFail()) {
            //TODO:: add error is not valid data

        } else {
            if ($get['name'] != null) {
                $value[] = '%' . $get['name'] . '%';
                $variable[] = ' item.label Like ? ';
            }
            if ($get['tile_kind'] != null) {
                $value[] = $get['tile_kind'];
                $variable[] = ' item.tile_id = ? ';
            }
            if ($get['phase'] != null) {
                $value[] = $get['phase'];
                $variable[] = ' item.phase = ? ';
            }
            if ($get['unitId'] != null) {
                $value[] = $get['unitId'];
                $variable[] = ' item.unitId = ? ';
            }
            if ($get['sortWith'] != null and is_array($get['sortWith'])) {
                unset($sortWith);
                foreach ($get['sortWith'] as $sort) {
                    $temp = explode('|', $sort);
                    $sortWith[] = ['column' => $temp[0], 'type' => $temp[1]];
                }
            }
        }

        $search = sensor::index($value, $variable, 1, 1, $get['page'], $get['perEachPage'])["result"];
        $this->mold->path('default', 'LineMonitoring');
        $this->mold->view('storageSensorList.mold.html');
        $this->mold->setPageTitle('لیست سنسور های دخیره ساز');
        $this->mold->set('activeMenu', 'storageSensor');
        $this->mold->set('VS', $search);
        $this->mold->set('tiles', tiles::index());
        $this->mold->set('units', units::index()["result"]);
        $this->mold->set('phases', phases::index()["result"]);
    }

    public function index($VSId = null)
    {
        if ($VSId != null) {
            /* @var sensors $VS */
            $VS = parent::model('sensors', $VSId);
            if ($VS->getSensorId() != $VSId) {
                httpErrorHandler::E404();
                return false;
            }
            $VS->setSensorSign(explode(',', $VS->getSensorSign()));
            $VS->setSensorChosenId(explode(',', $VS->getSensorChosenId()));
            $this->mold->set('VSensor', $VS);
        } else
            $VS = parent::model('sensors');

        $this->mold->set('phases', phases::index()["result"]);

        $this->mold->set('tiles', tiles::index()["result"]);
        $this->mold->set('units', units::index()["result"]);
        $search = $VS->search(array(), null, 'sensors', '*', ['column' => 'showSort', 'type' => 'asc']);
        $this->mold->set('Sensors', $search);

        if (request::ispost()) {

            $get = request::post('Export=0,showSort,sensors,tile_kind,faz,unitId,tile_degree,SensorChosenId,SensorSign', null);

            $rules = [
                "sensors" => ["required", 'نام سنسور'],
                "showSort" => ["required", 'شماره رده بندی'],
                "tile_kind" => ["required", 'نوع کاشی'],
                "faz" => ["required", 'فاز'],
                "unitId" => ["required", 'واحد'],
                "tile_degree" => ["required", 'درجه کاشی'],
            ];
            $valid = validate::check($get, $rules);
            $this->mold->offAutoCompile();
            $GLOBALS['timeStart'] = '';
            if ($valid->isFail()) {
                Response::jsonMessage($valid->errorsIn(), false);
                return false;
            }
            $value = array();
            $variable = array();
            $VS->setLabel($get['sensors']);
            $VS->setshowSort($get['showSort']);
            $VS->setTileId($get['tile_kind']);
            $VS->setTile_Count(1);
            $VS->setPhase($get['faz']);
            $VS->setTileDegree($get['tile_degree']);
            $VS->setUnit($get['unitId']);
            $VS->setExport($get['Export']);

            $VS->setSensorPlcId(null);
            $VS->setPlcRead(1);
            $VS->setActive(1);
            $VS->setOffTime(0);
            $VS->setOffTime_Bale(0);
            $VS->setOffTime_SMS(0);
            $VS->setisVirtual(1);
            $VS->setisStorage(1);

            $VS->setSensorSign(implode(',', $get['SensorSign']));
            $VS->setSensorChosenId(implode(',', $get['SensorChosenId']));
            $Dis = 'سنسور دخیره ساز با نام ';
            $Dis = $Dis . $VS->getLabel();

            if ($VSId == null) {
                if ($VS->insertToDataBase()) {
                    $Dis = $Dis . ' ثبت شد';
                    $this->callHooks('addLog', [$Dis, 'Sensor']);
                    $this->alert('success', '', "ثبت سنسور دخیره ساز با موفقیت انجام شد");
                    Response::redirect(App::getBaseAppLink('storageSensor/List/', 'admin'));
                } else
                    $this->alert('danger', '', "ثبت سنسور دخیره ساز با مشکلی مواجه شده است");

            } elseif ($VSId != null) {
                if ($VS->upDateDataBase()) {
                    $Dis = $Dis . ' تغییر یافت';
                    $this->callHooks('addLog', [$Dis, 'Sensor']);
                    $this->alert('success', '', "ویرایش سنسور دخیره ساز با موفقیت انجام شد");
                    Response::redirect(App::getBaseAppLink('storageSensor/List/', 'admin'));
                } else
                    $this->alert('danger', '', "ثبت سنسور دخیره ساز با مشکلی مواجه شده است");

            }

        }
        $this->mold->path('default', 'LineMonitoring');
        $this->mold->view('storageSensor.mold.html');
        if ($VSId == null)
            $this->mold->setPageTitle('ثبت سنسور دخیره ساز');
        elseif ($VSId != null)
            $this->mold->setPageTitle('ویرایش سنسور دخیره ساز');
        $this->mold->set('activeMenu', 'storageSensor');
    }
}