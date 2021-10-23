<?php

namespace App\LineMonitoring\app_provider\admin;

use App\LineMonitoring\app_provider\api\tiles;
use App\LineMonitoring\app_provider\api\phases;
use app\LineMonitoring\model\sensors;
use App\units\app_provider\api\units;
use controller;
use paymentCms\component\cache;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class sensor extends controller
{
    public function index()
    {
        $get = request::post('page=1,perEachPage=25,name,tile_kind,tile_Count,Sensor_plc_id,OffTime,OffTime_Bale,OffTime_SMS,Active,unitId,phase,sortWith');

        $rules = [
            "page" => ["required|match:>0", rlang('page')],
            "perEachPage" => ["required|match:>0|match:<501", rlang('page')],
        ];
        $valid = validate::check($get, $rules);
        $value = array();
        $variable = array();
        $variable[] = ' item.isVirtual Like ? ';
        $value[] = 0;

        $sortWith = [['column' => 'item.showSort', 'type' => 'asc']];

        if ($valid->isFail()) {
            show($valid->errorsIn());

        } else {
            if ($get['name'] != null) {
                $value[] = '%' . $get['name'] . '%';
                $variable[] = ' item.label Like ? ';
            }
            if ($get['tile_kind'] != null) {
                $value[] = $get['tile_kind'];
                $variable[] = ' item.id = ? ';
            }
            if ($get['Sensor_plc_id'] != null) {
                $value[] = $get['Sensor_plc_id'];
                $variable[] = ' item.Sensor_plc_id = ? ';
            }
            if ($get['Active'] != null) {
                $value[] = $get['Active'];
                $variable[] = ' item.Active = ? ';
            }
            if ($get['phase'] != null) {
                $value[] = $get['phase'];
                $variable[] = ' item.phase = ? ';
            }
            if ($get['unitId'] != null) {
                $value[] = $get['unitId'];
                $variable[] = ' item.unit = ? ';
            }
            if ($get['sortWith'] != null and is_array($get['sortWith'])) {
                unset($sortWith);
                foreach ($get['sortWith'] as $sort) {
                    $temp = explode('|', $sort);
                    $sortWith[] = ['column' => $temp[0], 'type' => $temp[1]];
                }
            }

        }
//        $numberOfAll = ($model->search($value, (count($variable) == 0) ? null : implode(' and ', $variable), 'sensors sensors', 'COUNT(sensors.id) as co')) [0]['co'];
//        $numberOfAll = \App\LineMonitoring\app_provider\api\sensor::index($value,$variable);
        /* @var sensors $model */
        $model = parent::model('sensors');
        $numberOfAll = $model->getCount($value, $variable);
        $pagination = parent::pagination($numberOfAll, $get['page'], $get['perEachPage']);
        $pagination = [$pagination['start'], $pagination['limit']];
        $search = $model->getItems($value, $variable, $sortWith, $pagination);
        $this->mold->path('default', 'LineMonitoring');
        $this->mold->view('sensorList.mold.html');
        $this->mold->setPageTitle('لیست سنسور ها');
        $this->mold->set('activeMenu', 'sensors');
        $this->mold->set('sensors', $search);

        $this->mold->set('tiles', tiles::index()["result"]);
        $this->mold->set('units', units::index()["result"]);
        $this->mold->set('phases', phases::index()["result"]);

    }

    public function update(): bool
    {
        $get = request::post('sensor_id,showSort,sensors,plcId,tile_kind,tile_Count,OffTime,OffTime_Bale,OffTime_SMS,Active=0,faz,unitId,tile_degree,Export=0');
        $rules = [
            "sensors" => ["required", 'نام سنسور'],
            "plcId" => ["required|int|match:>=0", 'شماره سنسور'],
            "tile_Count" => ["required|int|match:>=1", 'شمارش سنسور'],
            "OffTime" => ["required|int|match:>=0", 'زمان خاموشی سنسور'],
            "OffTime_Bale" => ["required|int|match:>=0", 'زمان خاموشی بله سنسور'],
            "OffTime_SMS" => ["required|int|match:>=0", 'زمان خاموشی اس ام اس سنسور'],
        ];
        $valid = validate::check($get, $rules);
        $this->mold->offAutoCompile();
        $GLOBALS['timeStart'] = '';
        if ($valid->isFail()) {
            Response::jsonMessage($valid->errorsIn(), false);
            return false;
        }
        /* @var sensors $model */
        if ($get['sensor_id'] != '') {
            $model = parent::model('sensors', $get['sensor_id']);
            if ($model->getId() != $get['sensor_id']) {
                Response::jsonMessage('سنسور مد نظر یافت نشد!', false);
                return false;
            }
            $numberOfPLC = ($model->search([$get['plcId'], $get['sensor_id']], 'Sensor_plc_id = ? and id != ? ', 'sensors', 'COUNT(id) as co')) [0]['co'];
            if ($numberOfPLC > 0 and $get['plcId'] != "") {
                Response::jsonMessage('شماره پورت سنسور تکراری است!', false);
                return false;
            }
        } else {
            $model = parent::model('sensors');
            $numberOfPLC = ($model->search([$get['plcId']], 'Sensor_plc_id = ? ', 'sensors', 'COUNT(id) as co')) [0]['co'];
            if ($numberOfPLC > 0) {
                Response::jsonMessage('شماره پورت سنسور تکراری است!', false);
                return false;
            }
        }

        $model->setLabel($get['sensors']);
        $model->setshowSort($get['showSort']);
        $model->setSensorPlcId(($get['plcId'] != "") ? $get['plcId'] : null);
        $model->setTileId($get['tile_kind']);
        $model->setTile_Count($get['tile_Count']);
        $model->setPlcRead(0);
        $model->setActive(($get['plcId'] != "") ? $get['Active'] : 0);
        $model->setOffTime($get['OffTime']);
        $model->setOffTime_Bale($get['OffTime_Bale']);
        $model->setOffTime_SMS($get['OffTime_SMS']);
        $model->setPhase($get['faz']);
        $model->setTileDegree($get['tile_degree']);
        $model->setUnit($get['unitId']);
        $model->setExport($get['Export']);
        $model->setisVirtual(0);
        $model->setisStorage(0);
        $Dis = 'سنسور با نام ';
        $Dis = $Dis . $model->getLabel();
        if ($get['sensor_id'] != '') {
            $Dis = $Dis . ' تغییر یافت';
            $this->callHooks('addLog', [$Dis, 'Sensor']);
            $model->upDateDataBase();
        } else {
            $Dis = $Dis . ' ثبت شد';
            $this->callHooks('addLog', [$Dis, 'Sensor']);
            $model->insertToDataBase();
        }
        cache::clear('isTileKindUpdate', 'LineMonitoring');
        Response::jsonMessage('تغییرات انجام شد.', true);
        return false;
    }
}