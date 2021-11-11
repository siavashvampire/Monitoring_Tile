<?php

namespace App\LineMonitoring\app_provider\api;

use App\api\controller\innerController;
use App\LineMonitoring\model\CamSwitch;
use App\LineMonitoring\model\sensors;
use paymentCms\component\cache;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class line_monitoring_update extends innerController
{

    public static function sensor($value = array(), $variable = array(), $isVirtual = 0, $isStorage = 0, $page = 0, $perEachPage = 0)
    {
        $appName = ['LineMonitoring', 'sensors'];

        /** @var sensors $model */
        $model = parent::model($appName);

        $value = array();
        $variable = array();

        $value[] = 0;
        $variable[] = ' item.Sensor_plc_id <> ? ';

        cache::save('yes', 'is_sensor_update', 2592000, 'LineMonitoring');
        return self::json($model->getItems($value,$variable));
    }

    public static function cam_switch()
    {
        $appName = ['LineMonitoring', 'CamSwitch'];
        /** @var CamSwitch $model */
        $model = parent::model($appName);

        $value = array();
        $variable = array();

        $value[] = 0;
        $variable[] = ' item.Switch_plc_id <> ? ';

        cache::save('yes', 'is_switch_update', 2592000, 'LineMonitoring');
        return self::json($model->getItems($value, $variable));
    }

}