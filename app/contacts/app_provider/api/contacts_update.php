<?php

namespace App\contacts\app_provider\api;

use App\api\controller\innerController;
use paymentCms\component\cache;

class contacts_update extends innerController
{
    public static function Phones()
    {
        /** @var \App\contacts\model\phone $model */
        $model = parent::model(['contacts', 'phone']);

        cache::save('yes', 'is_contacts_update', 2592000, 'contacts');
        return self::json($model->getItems());
    }
}