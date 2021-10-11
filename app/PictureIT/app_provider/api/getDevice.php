<?php
namespace App\PictureIT\app_provider\api;

use App\api\controller\innerController;
use App\core\controller\fieldService;
use App\invoice\model\transactions;
use App\user\app_provider\api\user;
use paymentCms\component\cache;
use paymentCms\component\JDate;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\security;
use paymentCms\component\strings;
use paymentCms\component\validate;

if ( !defined( 'paymentCMS' ) ) die( '<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>' );

class getDevice extends innerController {
    public  static function devices() {
        return self::json( parent::model( ['PictureIT', 'devices'] )->getDevices());
    }
    public  static function quotes() {
        return self::json( parent::model( ['PictureIT', 'quotes'] )->getQuotes());
    }
}