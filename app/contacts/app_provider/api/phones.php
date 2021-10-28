<?php

namespace App\contacts\app_provider\api;

use App\api\controller\innerController;
use App\core\controller\fieldService;
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

class phones extends innerController
{
    public static function index()
    {
        /** @var \App\contacts\model\phone $model */
        $model = parent::model(['contacts', 'phone']);
        return self::json($model->getItems());
    }

    public static function SmsItems()
    {
        /** @var \App\contacts\model\phone $model */
        $model = parent::model(['contacts', 'phone']);

        return self::json($model->getSmsItems());
    }

    public static function BaleItems()
    {
        /** @var \App\contacts\model\phone $model */
        $model = parent::model(['contacts', 'phone']);

        return self::json($model->getBaleItems());
    }
}