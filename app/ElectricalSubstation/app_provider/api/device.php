<?php

namespace App\ElectricalSubstation\app_provider\api;

use App\api\controller\innerController;
use App\ElectricalSubstation\model\substation_Device;
use paymentCms\component\request;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class device extends innerController
{
    public static function index($substation_id = null, $unit_id = null): array
    {
        $get = request::post('unit_id,substation_id');

        $value = array();
        $variable = array();

        if ($get['unit_id'] != null) {
            $value[] = $get['unit_id'];
            $variable[] = 'unit_id = ?';
        }

        if ($unit_id != null) {
            $value[] = $unit_id;
            $variable[] = 'unit_id = ?';
        }


        if ($get['substation_id'] != null) {
            $value[] = $get['substation_id'];
            $variable[] = 'substation_id = ?';
        }

        if ($substation_id != null) {
            $value[] = $substation_id;
            $variable[] = 'substation_id = ?';
        }

        $variable = implode(',', $variable);

        /** @var substation_Device $model_device */
        $model_device = parent::model('substation_Device', $value, $variable);

        return self::json($model_device->getItems());
    }

    public static function data($unit_id = 1, $substation_id = 1, $field = ['DATE_FORMAT(JStart_time, "%Y")', 'DATE_FORMAT(JStart_time, "%m.%d")', 'DATE_FORMAT(Start_time, "%H.%i")'], $tableName = 'elecsub_data'): array
    {
        $get = request::post('unit_id,substation_id,field,tableName');

        if ($get['unit_id'] == null)
            $get['unit_id'] = $unit_id;


        if ($get['substation_id'] == null)
            $get['substation_id'] = $substation_id;

        if ($get['field'] == null)
            $get['field'] = $field;

        if ($get['tableName'] == null)
            $get['tableName'] = $tableName;

        $model = parent::model(['ElectricalSubstation', $get['tableName']], [$get['substation_id'], $get['unit_id']], 'substation_id = ? AND unitId = ?');

        return self::json($model->getData($get['field']));
    }
}