<?php
namespace App\weighbridge\app_provider\api;

use App\api\controller\innerController;
use App\weighbridge\model\customer;

if ( !defined( 'paymentCMS' ) ) die( '<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>' );

class customer_api extends innerController {
    public  static function index($id = null) {

        /** @var customer $customers */
        $customers = parent::model('customer')->getItems();

        return self::json($customers);
    }
}