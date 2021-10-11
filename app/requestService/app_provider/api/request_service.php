<?php

namespace App\requestService\app_provider\api;

use App\api\controller\innerController;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class request_service extends innerController
{
    public static function buginfluence(): array
    {

        return self::json(parent::model('requestService_buginfluence')->getBuginfluence());
    }

    public static function worktitle(): array
    {

        return self::json(parent::model('requestService_worktitle')->getWorktitle());

    }

    public static function system_status(): array
    {

        return self::json(parent::model('requestService_system_status')->getSystem_status());
    }

    public static function cost(): array
    {

        return self::json(parent::model('requestService_cost')->getCost());
    }

    public static function failure(): array
    {

        return self::json(parent::model('requestService_failure')->getFailure());
    }

    public static function doneWork(): array
    {

        return self::json(parent::model('requestService_doneWork')->getDoneWork());
    }

    public static function latency(): array
    {

        return self::json(parent::model('requestService_latency')->getLatency());
    }

}