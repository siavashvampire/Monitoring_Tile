<?php

namespace App\LineMonitoring\app_provider\api;

use App\api\controller\innerController;
use App\LineMonitoring\model\CamSwitch;
use paymentCms\component\cache;
use paymentCms\component\request;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class cam_switch extends innerController
{
    public static function index($value = array(), $variable = array(), $page = 0, $perEachPage = 0)
    {
        $get = request::post('unitId , phase', null);
        $appName = ['LineMonitoring', 'CamSwitch'];
        /** @var CamSwitch $model */
        $model = parent::model($appName);

        $order = ['column' => 'item.id', 'type' => 'asc'];

        if (isset($_POST['unitId']) and $_POST['unitId'] != null) {
            $variable[] = ' item.unitId IN ' . $_POST['unitId'];
        }
        if (isset($_POST['phase']) and $_POST['phase'] != null) {
            $value[] = $_POST['phase'];
            $variable[] = ' item.phase = ? ';

        }

        $value[] = 0;
        $variable[] = ' item.Switch_plc_id <> ? ';

//        $numberOfAll = ($model->search((array)$value, (count($variable) == 0) ? null : implode(' and ', $variable), 'item VS', 'COUNT(VS.Sensor_id) as co')) [0]['co'];
        if ($perEachPage != 0 and $page != 0) {
            $pagination = parent::pagination(parent::model($appName)->getCount($value, $variable), $page, $perEachPage);
            $page = [$pagination['start'], $pagination['limit']];
        }
        else
            $page = null;

        cache::save('yes', 'isSwitchUpdate', 2592000, 'LineMonitoring');
        return self::json($model->getItems($value, $variable, $order, $page));
    }
}