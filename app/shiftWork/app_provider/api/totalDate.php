<?php

namespace App\shiftWork\app_provider\api;

use App\api\controller\innerController;
use DateTime;
use paymentCms\component\JDate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class totalDate extends innerController
{
    public static function Day($Diff = 0, $Time = null): array
    {
        if (isset($_SERVER['JsonOff']))
            $isSet = false;
        else
            $isSet = true;
        $_SERVER['JsonOff'] = true;
        if ($Time == null) $Time = time();

        $Time -= $Diff * 86400;

        $shiftData = shift::index($Time)['result'];
        if ($shiftData["startTimeStamp"] < strtotime(date('Y-m-d' . " 11:00:00", $shiftData["startTimeStamp"]))) {
            $shiftStart = $shiftData["startTime"];
            $shiftData = shift::index($Time + 43200)['result'];
            $shiftEnd = $shiftData["endTime"];
        } else {
            $shiftEnd = $shiftData["endTime"];
            $shiftData = shift::index($Time - 43200)['result'];
            $shiftStart = $shiftData["startTime"];
        }
        if ($isSet)
            unset($_SERVER['JsonOff']);

        $shiftStartTime = strtotime($shiftStart);
        $shiftEndTime = strtotime($shiftEnd);

        return self::json([
            'dayStart' => $shiftStart,
            'jdayStart' => JDate::jdate('Y/m/d H:i:s', $shiftStartTime),
            'dayStartTime' => $shiftStartTime,
            'dayEnd' => $shiftEnd,
            'jdayEnd' => JDate::jdate('Y/m/d H:i:s', $shiftEndTime),
            'dayEndTime' => $shiftEndTime,
        ]);
    }

    public static function Month($Diff = 0, $Time = null): array
    {
        if (isset($_SERVER['JsonOff']))
            $isSet = false;
        else
            $isSet = true;
        $_SERVER['JsonOff'] = true;

        if ($Time == null) $Time = time() - $Diff * 86400 * 30;

        $year = (int)JDate::jdate('Y');
        $month = (int)JDate::jdate('m') - $Diff;

        $yearMonth = self::correctMonthYear($month, $year);

        $dateStart = JDate::jmktime(12, 0, 0, $yearMonth[0], 1, $yearMonth[1]);
        $yearMonth = self::correctMonthYear($month+1, $year);
        $dateEnd = JDate::jmktime(12, 0, 0, $yearMonth[0], 0, $yearMonth[1]);
        $justDateStart = JDate::jdate('Y/m/d',$dateStart);
        $dateStart = self::Day(0, $dateStart)["result"];
        $justDateEnd = JDate::jdate('Y/m/d',$dateEnd);
        $dateEnd = self::Day(0, $dateEnd)["result"];

        if ($isSet)
            unset($_SERVER['JsonOff']);

        return self::json([
            'monthStart' => $dateStart["dayStart"],
            'jmonthStart' => $dateStart["jdayStart"],
            'monthEnd' => $dateEnd["dayEnd"],
            'jmonthEnd' => $dateEnd["jdayEnd"],
            'justDateStart' => $justDateStart,
            'justDateEnd' => $justDateEnd,
        ]);
    }

    private static function correctMonthYear($month, $year)
    {

        $yearDiff = floor(($month) / 12);
        $year += $yearDiff;
        $month -= $yearDiff * 12;

        if ($month == 0) {
            $month = 12;
            $year -= 1;
        }
        return [$month, $year];
    }
}