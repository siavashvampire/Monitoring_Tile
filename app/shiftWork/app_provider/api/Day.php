<?php
namespace App\shiftWork\app_provider\api;

use App\api\controller\innerController;
use App\shiftWork\app_provider\api\shift;
use paymentCms\component\JDate;

if ( !defined( 'paymentCMS' ) ) die( '<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>' );

class Day extends innerController {
    public  static function index($DiffDay=0,$Time = null){
        if (isset($_SERVER['JsonOff']))
            $isSet = false;
        else
            $isSet = true;
        $_SERVER['JsonOff'] = true;
        if ( $Time == null )  $Time = time() - $DiffDay*86400 ;

        $shiftData = shift::index($Time)['result'];
        if ($shiftData["startTimeStamp"] < strtotime(date('Y-m-d'." 11:00:00" , $shiftData["startTimeStamp"]))){
            $shiftStart = $shiftData["startTime"];
            $shiftData = shift::index($Time + 43200)['result'];
            $shiftEnd = $shiftData["endTime"];
        }
        else{
            $shiftEnd = $shiftData["endTime"];
            $shiftData = shift::index($Time - 43200)['result'];
            $shiftStart = $shiftData["startTime"];
        }
        if ($isSet)
            unset($_SERVER['JsonOff']);
        return self::json([
            'dayStart' => $shiftStart,
            'jdayStart' => JDate::jdate('Y/m/d H:i:s' , strtotime($shiftStart)),
            'dayEnd' => $shiftEnd,
            'jdayEnd' => JDate::jdate('Y/m/d H:i:s' , strtotime($shiftEnd)),
        ]);
    }

}