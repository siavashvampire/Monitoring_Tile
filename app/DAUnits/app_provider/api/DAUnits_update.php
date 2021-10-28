<?php

namespace App\DAUnits\app_provider\api;

use App\api\controller\innerController;
use paymentCms\component\cache;

class DAUnits_update extends innerController
{
    public static function DAUnits()
    {
        /** @var \App\DAUnits\model\DAUnits $model */
        $model = parent::model(['DAUnits', 'DAUnits']);

        cache::save('yes', 'is_DAUnits_update', 2592000, 'DAUnits');
        return self::json($model->getItems(array(), array(), ['column' => 'item.id', 'type' => 'asc'], [0, 99999999], true));
    }
}