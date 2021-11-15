<?php

namespace App\ElectricalSubstation\app_provider\api;

use App\api\controller\innerController;
use paymentCms\component\request;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class get_device_data extends innerController
{
    public static function index($unit_id = 1, $substation_id = 1, $field = ['DATE_FORMAT(JStart_time, "%Y")', 'DATE_FORMAT(JStart_time, "%m.%d")', 'DATE_FORMAT(Start_time, "%H.%i")'], $tableName = 'elecsub_data'): array
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