<?php

namespace App\weighbridge\app_provider\api;

use App\api\controller\innerController;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class payment_method extends innerController
{
    public static function index($id = null)
    {

        /** @var \App\weighbridge\model\payment_method $customers_model */
        $payment_method_model = parent::model('payment_method');
        $payment_method = $payment_method_model->getItems();

        return self::json($payment_method);
    }
}