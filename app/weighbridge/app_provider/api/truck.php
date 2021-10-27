<?php
namespace App\weighbridge\app_provider\api;

use App\api\controller\innerController;
use paymentCms\component\request;


if ( !defined( 'paymentCMS' ) ) die( '<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>' );

class index extends innerController {
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