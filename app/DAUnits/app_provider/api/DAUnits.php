<?php

namespace App\DAUnits\app_provider\api;

use App\api\controller\innerController;


if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class DAUnits extends innerController
{
    public static function index()
    {
        /** @var \App\DAUnits\model\DAUnits $model */
        $model = parent::model(['DAUnits', 'DAUnits']);
        return self::json($model->getItems(array(), array(), ['column' => 'item.id', 'type' => 'asc'], [0, 99999999], true));
    }
}