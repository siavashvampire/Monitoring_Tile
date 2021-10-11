<?php
namespace App\weighbridge\app_provider\api;

use App\api\controller\innerController;
use App\core\controller\fieldService;
use App\invoice\model\transactions;
use app\LineMonitoring\model\data;
use app\LineMonitoring\model\sensors;
use App\user\app_provider\api\user;
use paymentCms\component\cache;
use paymentCms\component\JDate;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\security;
use paymentCms\component\strings;
use paymentCms\component\validate;

if ( !defined( 'paymentCMS' ) ) die( '<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>' );

class getWeighbridge extends innerController {
    public  static function Trucks($id = null) {

        $get = request::post( 'id' , null );
        $value = array();
        $variable = array();

        if ($get['id'] != null) {
            $value[] = $get['id'];
            $variable[] = 'item.id = ?';
        }
        else {
            if ($id != null) {
                $value[] = $id;
                $variable[] = 'item.id = ?';
            }
        }

        return self::json( parent::model( ['weighbridge', 'Truck'] )->getItems($value,$variable));
    }
}