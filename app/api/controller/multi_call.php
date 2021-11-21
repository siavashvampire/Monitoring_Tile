<?php

namespace App\api\controller;


use App\core\app_provider\api\update;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class multi_call extends innerController
{

    public function index()
    {
        $DataArray = json_decode($_POST['DataArray'], true);
        $response = [];
        if (isset($DataArray) and is_array($DataArray)) {
            $_SERVER['JsonOffMultiCall'] = true;
            foreach ($DataArray as $index => $_dataSTD) {
                if (isset($_dataSTD['class']) and isset($_dataSTD['app']) and isset($_dataSTD['method'])) {
                    $className = 'App\\' . $_dataSTD['app'] . '\app_provider\\api\\' . $_dataSTD['class'];
                    if (class_exists($className) and method_exists($className, $_dataSTD['method'])) {
                        $class = new $className();
                        $_REQUEST = $_POST = $_dataSTD['data'];
                        $response[$index] = call_user_func_array([$class, $_dataSTD['method']], (array)$_dataSTD['data']);
                    } else
                        $response[$index] = ["result" => false, "message" => "class " . $_dataSTD['class'] . " or method " . $_dataSTD['method'] . " not fount"];

                } else
                    $response[$index] = ["result" => false, "message" => "class " . $_dataSTD['class'] . " or method " . $_dataSTD['method'] . " not set"];
            }
            if (update::need_update()["result"])
                $need_update = true;
            else
                $need_update = false;

            unset($_SERVER['JsonOffMultiCall'], $_SERVER['JsonOff']);
            parent::json(["status" => true, "result" => $response, "need_update" => $need_update]);
        } else {
            unset($_SERVER['JsonOffMultiCall'], $_SERVER['JsonOff']);
            parent::jsonError(["status" => false, 'result' => "data not set"], 500);
        }
    }
}