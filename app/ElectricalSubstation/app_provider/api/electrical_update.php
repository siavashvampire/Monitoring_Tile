<?php

namespace App\ElectricalSubstation\app_provider\api;

use App\api\controller\innerController;
use App\ElectricalSubstation\model\substation_Device;
use paymentCms\component\cache;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');


class electrical_update extends innerController
{
    public static function device($substation_id = 0): array
    {
        /** @var substation_Device $model */
        $model = parent::model(['ElectricalSubstation', 'substation_Device']);

        cache::save('yes', 'isSubstation', 2592000, 'ElectricalSubstation');
        return self::json($model->getItems($substation_id));
    }
}