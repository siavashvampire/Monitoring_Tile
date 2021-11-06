<?php
namespace App\product\app_provider\api;

use App\api\controller\innerController;
use App\product\model\product_kind;

if ( !defined( 'paymentCMS' ) ) die( '<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>' );

class tiles extends innerController {
    public  static function index() {
        /** @var product_kind $model */
        $model = parent::model( ['product', 'tile_kind'] );
        return self::json( $model->getItems());
    }
}