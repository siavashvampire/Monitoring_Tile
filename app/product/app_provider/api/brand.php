<?php
namespace App\product\app_provider\api;

use App\api\controller\innerController;
use App\product\model\product_brand;

if ( !defined( 'paymentCMS' ) ) die( '<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>' );

class brand extends innerController {
    public  static function index() {
        /** @var product_brand $model */
        $model = parent::model( ['product', 'product_brand'] );
        return self::json($model->getItems());
    }
    public  static function getByUsersId($UserId) {
        /** @var product_brand $model */
        $model = parent::model( ['product', 'product_brand'] );
        return self::json($model->getByUsersId($UserId));
    }
}