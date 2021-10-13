<?php

namespace App\LineMonitoring\app_provider\api;

use App\api\controller\innerController;
use App\LineMonitoring\model\sensors;
use paymentCms\component\cache;
use paymentCms\component\request;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class sensor extends innerController
{
    public static function index($value = array(), $variable = array(), $isVirtual = 0, $isStorage = 0, $page = 0, $perEachPage = 0)
    {
        $get = request::post('unitId , phase', null);
        $appName = 'sensors';
        /** @var sensors $model */
        $model = parent::model($appName);

        $order = ['column' => 'item.showSort', 'type' => 'asc'];

        if (isset($_POST['unitId']) and $_POST['unitId'] != null) {
            $variable[] = ' item.unit IN ' . $_POST['unitId'];
        }
        if (isset($_POST['phase']) and $_POST['phase'] != null) {
            $value[] = $_POST['phase'];
            $variable[] = ' item.phase = ? ';
        }

        if ($isVirtual != -1) {
            $value[] = $isVirtual;
            $variable[] = ' item.isVirtual = ?';
        }

        if ($isVirtual != -1) {
            $value[] = $isStorage;
            $variable[] = ' item.isStorage = ?';
        }
        if (!$isStorage and !$isVirtual) {
            $value[] = 0;
            $variable[] = ' item.Sensor_plc_id <> ? ';
        }

//        $numberOfAll = ($model->search((array)$value, (count($variable) == 0) ? null : implode(' and ', $variable), 'item VS', 'COUNT(VS.Sensor_id) as co')) [0]['co'];
        if ($perEachPage != 0 and $page != 0) {
            $pagination = parent::pagination(parent::model($appName)->getCount($value, $variable), $page, $perEachPage);
            $page = [$pagination['start'], $pagination['limit']];
        } else
            $page = null;

        cache::save('yes', 'isTileKindUpdate', 2592000, 'LineMonitoring');
        return self::json($model->getItems($value, $variable, $order, $page));
    }
}