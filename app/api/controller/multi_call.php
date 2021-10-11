<?php
namespace App\api\controller;



if ( !defined( 'paymentCMS' ) ) die( '<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>' );

class multi_call extends innerController {

    public function index(){
        $DataArray = json_decode($_POST['calls']);
        $lastIndex = -1 ;
        $response = [];
        if ( isset($DataArray) and is_array($DataArray) ){
            foreach ($DataArray  as $index => $_dataSTD ){
               if ( isset($_dataSTD['class']) and isset($_dataSTD['app']) and  isset($_dataSTD['method']) ){
                   $className = 'App\\' . $_dataSTD['app'] . '\app_provider\\api\\' . $_dataSTD['class'];
                   if (class_exists($className) and method_exists($_dataSTD['class'], $_dataSTD['method'])) {
                       $class = new $className();
                       $_REQUEST = $_POST = $_dataSTD['data'];
                       $_SERVER['JsonOff'] = true;
                       $response[$index] = call_user_func_array([$class, $_dataSTD['method']], (array)$_dataSTD['params']);
                       $lastIndex = $index ;
                   } else {
                       unset($_SERVER['JsonOff']);
                       parent::jsonError( [ 'lastIndex' => $lastIndex , 'result' => $response] , 500 );
                   }
               } else {
                   unset($_SERVER['JsonOff']);
                   parent::jsonError( [ 'lastIndex' => $lastIndex , 'result' => $response] , 500 );
               }
            }
            unset($_SERVER['JsonOff']);
            parent::json( $response );
        } else {
            unset($_SERVER['JsonOff']);
            parent::jsonError( [ 'lastIndex' => $lastIndex , 'result' => $response] , 500 );
        }
    }
}