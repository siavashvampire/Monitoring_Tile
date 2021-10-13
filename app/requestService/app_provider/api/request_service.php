<?php

namespace App\requestService\app_provider\api;

use App\api\controller\innerController;
use App\requestService\model\consumable_Parts;
use App\requestService\model\requestService_buginfluence;
use App\requestService\model\requestService_cost;
use App\requestService\model\requestService_doneWork;
use App\requestService\model\requestService_failure;
use App\requestService\model\requestService_latency;
use App\requestService\model\requestService_system_status;
use App\requestService\model\requestService_worktitle;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class request_service extends innerController
{
    public static function buginfluence(): array
    {

        /** @var requestService_buginfluence $model */
        $model = parent::model('requestService_buginfluence');
        return self::json($model->getItems());
    }

    public static function worktitle(): array
    {
        /** @var requestService_worktitle $model */
        $model = parent::model('requestService_worktitle');
        return self::json($model->getItems());

    }

    public static function system_status(): array
    {
        /** @var requestService_system_status $model */
        $model = parent::model('requestService_system_status');
        return self::json($model->getItems());
    }

    public static function cost(): array
    {

        /** @var requestService_cost $model */
        $model = parent::model('requestService_cost');
        return self::json($model->getItems());
    }

    public static function failure(): array
    {
        /** @var requestService_failure $model */
        $model = parent::model('requestService_failure');
        return self::json($model->getItems());
    }

    public static function doneWork(): array
    {
        /** @var requestService_doneWork $model */
        $model = parent::model('requestService_doneWork');
        return self::json($model->getItems());
    }

    public static function latency(): array
    {
        /** @var requestService_latency $model */
        $model = parent::model('requestService_latency');
        return self::json($model->getItems());
    }
    public static function consumable_Parts(): array
    {
        /** @var consumable_Parts $model */
        $model = parent::model('consumable_Parts');
        return self::json($model->getItems());

    }

}