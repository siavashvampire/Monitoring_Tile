<?php

namespace App\ElectricalSubstation\app_provider\api;

use App\api\controller\innerController;
use App\core\controller\fieldService;
use App\ElectricalSubstation\model\substation_Device;
use App\invoice\model\transactions;
use app\LineMonitoring\model\data;
use app\LineMonitoring\model\sensors;
use App\user\app_provider\api\user;
use paymentCms\component\cache;
use paymentCms\component\JDate;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\security;
use paymentCms\component\strings;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class get_device_data extends innerController
{
    public static function index($unit_id = 1, $substation_id = 1, $field = ['DATE_FORMAT(JStart_time, "%Y")','DATE_FORMAT(JStart_time, "%m.%d")','DATE_FORMAT(Start_time, "%H.%i")'], $tableName = 'elecsub_data'): array
    {
        $get = request::post('unit_id,substation_id,field,tableName', null);
        $value = array();
        $variable = array();

        if ($get['unit_id'] == null)
            $get['unit_id'] = $unit_id;


        if ($get['substation_id'] == null)
            $get['substation_id'] = $substation_id;

        if ($get['field'] == null)
            $get['field'] = $field;

        if ($get['tableName'] == null)
            $get['tableName'] = $tableName;

        $value[] = $get['unit_id'];
        $variable[] = 'unitId = ?';

        $value[] = $get['substation_id'];
        $variable[] = 'substation_id = ?';

        return self::json(parent::model(['ElectricalSubstation', $tableName])->getData($value, $variable, $get['field']));
    }
}