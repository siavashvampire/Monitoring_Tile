<?php

namespace App\core\app_provider\api;

use App\api\controller\innerController;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class update extends innerController
{
    public static function index(): array
    {
        return self::json(parent::callHooks('should_update'));
    }
    public static function need_update(): bool
    {
        return True;
    }
}