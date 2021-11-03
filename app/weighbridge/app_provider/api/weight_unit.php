<?php

namespace App\weighbridge\app_provider\api;

use App\api\controller\innerController;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class weight_unit extends innerController
{
    public static function index($id = null)
    {

        /** @var \App\weighbridge\model\weight_unit $customers_model */
        $weight_unit_model = parent::model('weight_unit');
        $weight_unit = $weight_unit_model->getItems();

        return self::json($weight_unit);
    }
}