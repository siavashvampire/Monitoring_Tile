<?php

namespace App\LineMonitoring\app_provider\api;

use App\api\controller\innerController;
use App\LineMonitoring\model\data_merge;
use App\shiftWork\app_provider\api\Day;
use DateTime;
use paymentCms\component\cache;
use paymentCms\component\JDate;
use paymentCms\component\model;
use paymentCms\component\request;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class chart extends innerController
{
    public static function Chart()
    {
        $sensors = request::postOne('sensors', null);
        $date = request::postOne('date', JDate::jdate('Y/m/d'));
        $Timing = request::postOne('Timing', "Hour");
        $Kind = request::postOne('Kind', "1");
        if ($sensors == "") {
            $sensors = array();
            $sensors[] = 2;
        }
        if ($date == "")
            $date = JDate::jdate('Y/m/d');

        $dateg = cache::get('chart ' . $Timing, null, 'LineMonitoring')['date'];
        if ($dateg == null)
            $dateg = array();

        if (!in_array($date, $dateg))
            $dateg[] = $date;

        if ($Timing == "Hour")
            $result = self::GetHourData($dateg, $sensors);
        elseif ($Timing == "Day")
            $result = self::GetDayData($dateg, $sensors);
        elseif ($Timing == "Month")
            $result = self::GetMonthData($dateg, $sensors);
        elseif ($Timing == "Year")
            $result = self::GetYearData($dateg, $sensors);
        elseif ($Timing == "Day_Week")
            $result = self::GetDay_WeekData($dateg, $sensors);


        if ($Kind == 2)
            foreach ($result['data']['series'] as $id => $data) {
                $SumTemp = 0;
                foreach ($result['data']['series'][$id]["data"] as $id2 => $data2) {
                    $SumTemp += $result['data']['series'][$id]["data"][$id2];
                    $result['data']['series'][$id]["data"][$id2] = $SumTemp;
                }
            }
        return self::json($result);
    }

    private static function GetHourData($dates, $sensors, $movAvgFlag = false, $movAvg = 5)
    {
//        $result['labels'] = (array) array_values((array)array_unique((array)array_column($search, 'h')));
        $result['labels'] = array();
        $result['labels'][] = -1;
        $result['labels'][] = 8;
        $result['labels'][] = 9;
        $result['labels'][] = 10;
        $result['labels'][] = 11;
        $result['labels'][] = 12;
        $result['labels'][] = 13;
        $result['labels'][] = 14;
        $result['labels'][] = 15;
        $result['labels'][] = 16;
        $result['labels'][] = 17;
        $result['labels'][] = 18;
        $result['labels'][] = 19;
        $result['labels'][] = 20;
        $result['labels'][] = 21;
        $result['labels'][] = 22;
        $result['labels'][] = 23;
        $result['labels'][] = 24;
        $result['labels'][] = 1;
        $result['labels'][] = 2;
        $result['labels'][] = 3;
        $result['labels'][] = 4;
        $result['labels'][] = 5;
        $result['labels'][] = 6;
        $result['labels'][] = 7;
        $result['series'] = array();

        foreach ($dates as $id => $date) {

            $BudgetFlag = 0;
            $BudgetPishFlag = 0;
            if ($id == 0) {
                $minDate = $date;
                $maxDate = $date;
                $BudgetFlag = 1;
                $BudgetPishFlag = 1;
            }
            $datas = self::GetHourSeries($date, $sensors, $result['labels'], $BudgetFlag, $BudgetPishFlag, $movAvgFlag, $movAvg);

            foreach ($datas as $data) {
                $result['series'][] = $data;
            }

            if ($date < $minDate)
                $minDate = $date;
            if ($date > $maxDate)
                $maxDate = $date;
        }
        $result['labels'][0] = 7;

        foreach ($result['labels'] as $id => $searchOne) {
            if ($searchOne == 24)
                $result['labels'][$id] = "00";
        }

        $_SERVER['JsonOff'] = true;
        $dateShamsi = explode('/', $minDate);
        $minDate = JDate::jalali_to_gregorian($dateShamsi[0], $dateShamsi[1], $dateShamsi[2], "-") . ' 12:59:59';
        $dateShamsi = explode('/', $maxDate);
        $maxDate = JDate::jalali_to_gregorian($dateShamsi[0], $dateShamsi[1], $dateShamsi[2], "-") . ' 12:59:59';
        $dayStart = Day::index(0, strtotime($minDate));
        $dayEnd = Day::index(0, strtotime($maxDate));
        unset($_SERVER['JsonOff']);

        return ['data' => $result, 'jtime' => JDate::jdate("l - H:i:s"), "dayStart" => $dayStart['result']['dayStart'], "dayEnd" => $dayEnd['result']['dayEnd'], "jdayStart" => $dayStart['result']['jdayStart'], "jdayEnd" => $dayEnd['result']['jdayEnd']];
    }

    private static function GetHourSeries($date, $sensors, $labels, $BudgetFlag = 0, $BudgetPishFlag = 0, $movAvgFlag = false, $movAvg = 5)
    {
        $series = null;
        $safety = 0;

        $dateShamsi = explode('/', $date);
        $dateFirst = JDate::jalali_to_gregorian($dateShamsi[0], $dateShamsi[1], $dateShamsi[2], "-") . ' 12:59:59';
        $dateStart = date_format(date_add(new DateTime($dateFirst), date_interval_create_from_date_string(-ceil($movAvg / 24) . ' days ' . -$safety . ' days')), 'Y-m-d');
        $dateEnd = date_format(date_add(new DateTime($dateFirst), date_interval_create_from_date_string($safety . ' days')), 'Y-m-d H:i:s');

        $_SERVER['JsonOff'] = true;
        $dayStart = Day::index(0, strtotime($dateStart))['result']['dayStart'];
        $dayEnd = Day::index(0, strtotime($dateEnd))['result']['dayEnd'];
        $dayFirst[] = Day::index(0, strtotime($dateFirst))['result']['dayStart'];
        $dayFirst[] = Day::index(0, strtotime($dateFirst))['result']['dayEnd'];
        unset($_SERVER['JsonOff']);
        if ($BudgetFlag or $BudgetPishFlag) {
            $Budgets = phases::Budget($dayStart);
            $Budgets = round($Budgets / 24);
        }

        $sensorText = '(' . implode(',', $sensors) . ')';
        $search = parent::model('data_merge_Hour')->getHourData($sensorText, $dayFirst, $dayStart, $dayEnd, $movAvgFlag, $movAvg);

        if (is_array($search)) {
            $series = self::extractData($search, $BudgetPishFlag, $Budgets, $BudgetFlag, $movAvgFlag, $date, $labels);
        }
        return $series;
    }

    private static function GetDayData($dates, $sensors, $MovAvgFlag = false, $movAvg = 5)
    {
        $result['labels'] = array();
        $result['labels'][] = 1;
        $result['labels'][] = 2;
        $result['labels'][] = 3;
        $result['labels'][] = 4;
        $result['labels'][] = 5;
        $result['labels'][] = 6;
        $result['labels'][] = 7;
        $result['labels'][] = 8;
        $result['labels'][] = 9;
        $result['labels'][] = 10;
        $result['labels'][] = 11;
        $result['labels'][] = 12;
        $result['labels'][] = 13;
        $result['labels'][] = 14;
        $result['labels'][] = 15;
        $result['labels'][] = 16;
        $result['labels'][] = 17;
        $result['labels'][] = 18;
        $result['labels'][] = 19;
        $result['labels'][] = 20;
        $result['labels'][] = 21;
        $result['labels'][] = 22;
        $result['labels'][] = 23;
        $result['labels'][] = 24;
        $result['labels'][] = 25;
        $result['labels'][] = 26;
        $result['labels'][] = 27;
        $result['labels'][] = 28;
        $result['labels'][] = 29;
        $result['labels'][] = 30;

        foreach ($dates as $id => $date)
            if ((int)(explode('/', $date)[1]) <= 6 and !array_search(31, $result['labels'])) {
                $result['labels'][] = 31;
                break;
            }

        $result['series'] = array();

        foreach ($dates as $id => $date) {
            $BudgetFlag = 0;
            $BudgetPishFlag = 0;
            if ($id == 0) {
                $BudgetFlag = 1;
                $BudgetPishFlag = 1;
            }

            $datas = self::GetDaySeries($date, $sensors, $result['labels'], $BudgetFlag, $BudgetPishFlag, $MovAvgFlag, $movAvg);
            foreach ($datas as $data) {
                $result['series'][] = $data;
            }
        }
        return ['data' => $result, 'jtime' => JDate::jdate("l - H:i:s"), "dayStart" => $day['result']['dayStart'], "dayEnd" => $day['result']['dayEnd'], "jdayStart" => $day['result']['jdayStart'], "jdayEnd" => $day['result']['jdayEnd']];
    }

    private static function GetDaySeries($date, $sensors, $labels, $BudgetFlag = 0, $BudgetPishFlag = 0, $movAvgFlag = false, $movAvg = 5)
    {
        $series = null;
        $safety = 5;

        $dateShamsi = explode('/', $date);
        $date = implode('/', [$dateShamsi[0], $dateShamsi[1]]);

        $dateFirst = JDate::jalali_to_gregorian($dateShamsi[0], $dateShamsi[1], 1, "-") . ' 12:59:59';
        $dateStart = date_format(date_add(new DateTime($dateFirst), date_interval_create_from_date_string(-$movAvg . ' days ' . -$safety . ' days')), 'Y-m-d');
        $dateEnd = date_format(date_add(new DateTime($dateFirst), date_interval_create_from_date_string(1 . ' month ' . $safety . ' days')), 'Y-m-d');

        $_SERVER['JsonOff'] = true;
        $dayStart = Day::index(0, strtotime($dateStart))['result']['dayStart'];
        $dayEnd = Day::index(0, strtotime($dateEnd))['result']['dayEnd'];
        unset($_SERVER['JsonOff']);

        if ($BudgetFlag or $BudgetPishFlag) {
            $Budgets = phases::Budget($dayStart);
        }

        $sensorText = '(' . implode(',', $sensors) . ')';
        $search = parent::model('data_merge')->getDayData($sensorText, $dateShamsi, $dayStart, $dayEnd, $movAvgFlag, $movAvg);


        if (is_array($search)) {
            $series = self::extractData($search, $BudgetPishFlag, $Budgets, $BudgetFlag, $movAvgFlag, $date, $labels);
        }

        return $series;
    }

    private static function GetMonthData($dates, $sensors, $MovAvgFlag = false, $movAvg = 5)
    {
        $result['labels'] = array();
        $result['labels'][] = 1;
        $result['labels'][] = 2;
        $result['labels'][] = 3;
        $result['labels'][] = 4;
        $result['labels'][] = 5;
        $result['labels'][] = 6;
        $result['labels'][] = 7;
        $result['labels'][] = 8;
        $result['labels'][] = 9;
        $result['labels'][] = 10;
        $result['labels'][] = 11;
        $result['labels'][] = 12;
        $result['series'] = array();

        foreach ($dates as $id => $date) {
            $BudgetFlag = 0;
            $BudgetPishFlag = 0;
            if ($id == 0) {
                $BudgetFlag = 1;
                $BudgetPishFlag = 1;
            }
            $datas = self::GetMonthSeries($date, $sensors, $result['labels'], $BudgetFlag, $BudgetPishFlag, $MovAvgFlag, $movAvg);

            foreach ($datas as $data) {
                $result['series'][] = $data;
            }
        }


        return ['data' => $result, 'jtime' => JDate::jdate("l - H:i:s"), "dayStart" => $day['result']['dayStart'], "dayEnd" => $day['result']['dayEnd'], "jdayStart" => $day['result']['jdayStart'], "jdayEnd" => $day['result']['jdayEnd']];
    }

    private static function GetMonthSeries($date, $sensors, $labels, $BudgetFlag = 0, $BudgetPishFlag = 0, $movAvgFlag = false, $movAvg = 5)
    {
        $series = null;
        $safety = 3;
        $dateShamsi = explode('/', $date);
        $date = implode('/', [$dateShamsi[0]]);

        $dateFirst = JDate::jalali_to_gregorian((int)$dateShamsi[0], 1, 1, "-") . ' 12:59:59';
        $dateStart = date_format(date_add(new DateTime($dateFirst), date_interval_create_from_date_string(-$movAvg . ' month ' . -$safety . ' days')), 'Y-m-d');
        $dateEnd = date_format(date_add(new DateTime($dateFirst), date_interval_create_from_date_string(12 . ' month ' . $safety . ' days')), 'Y-m-d');

        $_SERVER['JsonOff'] = true;
        $dayStart = Day::index(0, strtotime($dateStart))['result']['dayStart'];
        $dayEnd = Day::index(0, strtotime($dateEnd))['result']['dayEnd'];
        unset($_SERVER['JsonOff']);

        if ($BudgetFlag or $BudgetPishFlag) {
            $Budgets = phases::Budget($dayStart) * 30;
        }
        $sensorText = '(' . implode(',', $sensors) . ')';
        $search = parent::model('data_merge')->getMonthData($sensorText, $dateShamsi, $dayStart, $dayEnd, $movAvgFlag, $movAvg);
//        $search = $model->search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), 'data_merge data', 'SUM(data.counter) as counter, sensors.sensors , data.Sensor_id as id , jmonth(data.Start_time) as Day', [['column' => 'data.Start_time', 'type' => 'asc']], null, 'jyear(`Start_time`), jmonth(`Start_time`) , data.Sensor_id');

        if (is_array($search)) {
            $series = self::extractData($search, $BudgetPishFlag, $Budgets, $BudgetFlag, $movAvgFlag, $date, $labels);
        }
        return $series;
    }

    private static function GetYearData($dates, $sensors)
    {
        $result['labels'] = array();
        $result['labels'][] = 1399;
        $result['labels'][] = 1400;
        $result['labels'][] = 1401;
        $result['series'] = array();

        foreach ($dates as $id => $date) {
            $BudgetFlag = 0;
            $BudgetPishFlag = 0;
            if ($id == 0) {
                $BudgetFlag = 1;
                $BudgetPishFlag = 1;
            }
            $datas = self::GetYearSeries($date, $sensors, $result['labels'], $BudgetFlag, $BudgetPishFlag);

            foreach ($datas as $data) {
                $result['series'][] = $data;
            }
        }


        return ['data' => $result, 'jtime' => JDate::jdate("l - H:i:s"), "dayStart" => $day['result']['dayStart'], "dayEnd" => $day['result']['dayEnd'], "jdayStart" => $day['result']['jdayStart'], "jdayEnd" => $day['result']['jdayEnd']];
    }

    private static function GetYearSeries($date, $sensors, $labels, $BudgetFlag = 0, $BudgetPishFlag = 0)
    {
        $dateShamsi = explode('/', $date);
        $dateStart = JDate::jalali_to_gregorian($dateShamsi[0], 1, 1, "-") . ' 12:59:59';
        $dateEnd = JDate::jalali_to_gregorian($dateShamsi[0], 12, 29, "-") . ' 12:59:59';

        $date = implode('/', [$dateShamsi[0]]);

        $_SERVER['JsonOff'] = true;
        $dayStart = Day::index(0, strtotime($dateStart))['result']['dayStart'];
        $dayEnd = Day::index(0, strtotime($dateEnd))['result']['dayEnd'];
        unset($_SERVER['JsonOff']);
        if ($BudgetFlag or $BudgetPishFlag) {
            $Budgets = phases::Budget($dayStart) * 365;
        }
        if (is_array($sensors)) {
            $value = $sensors;
            $variable[] = ' data.Sensor_id IN ( ' . substr(str_repeat('? ,', count($sensors)), 0, -1) . ')  ';
        }

        $model = parent::model('data_merge');
        model::join('sensors sensors', 'data.Sensor_id = sensors.id');
        $search = $model->search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), 'data_merge data', 'SUM(data.counter) as counter, sensors.label , data.Sensor_id as id , jyear(data.Start_time) as Day', [['column' => 'data.Start_time', 'type' => 'asc']], null, 'jyear(`Start_time`) , data.Sensor_id');
        $movAvgFlag = false;
        if (is_array($search)) {
            $series = self::extractData($search, $BudgetPishFlag, $Budgets, $BudgetFlag, $movAvgFlag, $date, $labels);
        }
        return $series;
    }

    private static function GetDay_WeekData($dates, $sensors)
    {
        $result['labels'] = array();
        $result['labels'][] = 1;
        $result['labels'][] = 2;
        $result['labels'][] = 3;
        $result['labels'][] = 4;
        $result['labels'][] = 5;
        $result['labels'][] = 6;
        $result['labels'][] = 7;
        $result['series'] = array();

        foreach ($dates as $id => $date) {
            $BudgetFlag = 0;
            $BudgetPishFlag = 0;
            if ($id == 0) {
                $BudgetFlag = 1;
                $BudgetPishFlag = 1;
            }
            $datas = self::GetDay_WeekSeries($date, $sensors, $result['labels'], $BudgetFlag, $BudgetPishFlag);

            foreach ($datas as $data) {
                $result['series'][] = $data;
            }
        }

        $result['labels'][0] = "شنبه";
        $result['labels'][1] = "یک شنبه";
        $result['labels'][2] = "دوشنبه";
        $result['labels'][3] = "سه شنبه";
        $result['labels'][4] = "چهارشنبه";
        $result['labels'][5] = "پنج شنبه";
        $result['labels'][6] = "جمعه";

        return ['data' => $result, 'jtime' => JDate::jdate("l - H:i:s"), "dayStart" => $day['result']['dayStart'], "dayEnd" => $day['result']['dayEnd'], "jdayStart" => $day['result']['jdayStart'], "jdayEnd" => $day['result']['jdayEnd']];
    }

    private static function GetDay_WeekSeries($date, $sensors, $labels, $BudgetFlag = 0, $BudgetPishFlag = 0)
    {
        $dateShamsi = explode('/', $date);
        $dateStart = JDate::jalali_to_gregorian($dateShamsi[0], $dateShamsi[1], 1, "-") . ' 12:59:59';
        $dateEnd = JDate::jalali_to_gregorian($dateShamsi[0], $dateShamsi[1], 30, "-") . ' 12:59:59';
//        if($dateShamsi[2] != null)

        $date = implode('/', [$dateShamsi[0], $dateShamsi[1]]);

        $_SERVER['JsonOff'] = true;
        $dayStart = Day::index(0, strtotime($dateStart))['result']['dayStart'];
        $dayEnd = Day::index(0, strtotime($dateEnd))['result']['dayEnd'];
        unset($_SERVER['JsonOff']);
        if ($BudgetFlag or $BudgetPishFlag) {
            $Budgets = phases::Budget($dayStart);
        }

        if (is_array($sensors)) {
            $value = $sensors;
            $variable[] = ' data.Sensor_id IN ( ' . substr(str_repeat('? ,', count($sensors)), 0, -1) . ')  ';
        }

        $value[] = $dayStart;
        $value[] = $dayEnd;

        $variable[] = ' data.Start_time BETWEEN  ? and ?  ';

        /** @var data_merge $model */
        $model = parent::model('data_merge');
        $model->join('sensors sensors', 'data.Sensor_id = sensors.id');
        $search = $model->search((array)$value, ((count($variable) == 0) ? null : implode(' and ', $variable)), 'data_merge data', 'CEIL(SUM(data.counter)/CEIL(SUM(1)/2)) as counter , sensors.label , data.Sensor_id as id , data.Shift_group_id as Day', [['column' => 'data.Start_time', 'type' => 'asc']], null, 'data.Shift_group_id, data.Sensor_id');

        $i = 0;
        if ($BudgetFlag) {
            $series[$i]["name"] = "بودجه" . " " . $date;
            foreach ($labels as $id => $data) {
                $series[$i]["data"][$id] = $Budgets;
            }
            $i++;
        }

        if (is_array($search)) {
            if ($BudgetPishFlag) {
                $resultCheck = [];
                $Sum = 0;
                $SumCount = 0;
                foreach ($search as $searchOne) {
                    if (!isset($resultCheck[$searchOne['id']])) {
                        $resultCheck[$searchOne['id']] = true;
                        foreach ($search as $numTwoId => $searchTwo) {
                            if ($searchOne['id'] == $searchTwo['id']) {
                                if ($searchTwo['counter'] > $Budgets) {
                                    $Sum += $searchTwo['counter'];
                                    $SumCount++;
                                }
                            }
                        }
                    }
                }


                $series[$i]["name"] = "بودجه پیشنهادی" . " " . $date;
                foreach ($labels as $id => $data) {
                    if ($SumCount != 0)
                        $series[$i]["data"][$id] = round($Sum / $SumCount);
                    else
                        $series[$i]["data"][$id] = round($Budgets);
                }
                $i++;
            }

            $resultCheck = [];
            foreach ($search as $searchOne) {
                if (!isset($resultCheck[$searchOne['id']])) {
                    $series[$i]["name"] = $searchOne['sensors'] . " " . $date;
                    $resultCheck[$searchOne['id']] = true;
                    foreach ($labels as $id => $data) {
                        $series[$i]["data"][$id] = 0;
                    }
                    foreach ($search as $numTwoId => $searchTwo) {
                        if ($searchOne['id'] == $searchTwo['id']) {
                            $id = array_search($searchTwo['Day'], $labels);
                            $series[$i]["data"][$id] = (int)$searchTwo['counter'];
                            unset($search[$numTwoId]);
                        }
                    }
                    $i++;
                }
            }
        }
        return $series;
    }

    public static function resetCompare()
    {
        $Timing = request::postOne('Timing', "Hour");
        cache::clear('chart ' . $Timing, 'LineMonitoring');
    }

    public static function addCompare()
    {
        $Timing = request::postOne('Timing', "Hour");
        $date = request::postOne('date', JDate::jdate('Y/m/d'));
        if ($date == "")
            $date = JDate::jdate('Y/m/d');

        $dateg = cache::get('chart ' . $Timing, null, 'LineMonitoring')['date'];
        if ($dateg == null)
            $dateg = array();

        if (!in_array($date, $dateg))
            $dateg[] = $date;
        cache::save(['date' => $dateg], 'chart ' . $Timing, 100 * 365 * 48 * 60 * 60, 'LineMonitoring');
        return self::json($dateg);
    }

    public static function ChartGoogle()
    {
        $sensors = request::postOne('sensors', null);
        $date = request::postOne('date', JDate::jdate('Y/m/d'));
        $Timing = request::postOne('Timing', "Day");
        $Kind = request::postOne('Kind', "1");
        $movAvg = parent::setting('movAvg');

        if ($movAvg == null)
            $movAvg = 3;
        else
            $movAvg = (int)$movAvg;

        if ($sensors == "") {
            $sensors = array();
            $sensors[] = 2;
        }

        if (count($sensors) == 1 and ($Timing == "Day" or $Timing == "Month" or $Timing == "Hour"))
            $MovAvgFlag = true;
        else
            $MovAvgFlag = false;

        if ($date == "")
            $date = JDate::jdate('Y/m/d');

        $dateg = cache::get('chart ' . $Timing, null, 'LineMonitoring')['date'];
        if ($dateg == null)
            $dateg = array();

        if (!in_array($date, $dateg))
            $dateg[] = $date;

        if ($Timing == "Hour")
            $result = self::GetHourData($dateg, $sensors, $MovAvgFlag, $movAvg);
        elseif ($Timing == "Day")
            $result = self::GetDayData($dateg, $sensors, $MovAvgFlag, $movAvg);
        elseif ($Timing == "Month")
            $result = self::GetMonthData($dateg, $sensors, $MovAvgFlag, $movAvg);
        elseif ($Timing == "Year")
            $result = self::GetYearData($dateg, $sensors);
        elseif ($Timing == "Day_Week")
            $result = self::GetDay_WeekData($dateg, $sensors);

        $dataFinal = $result;

        if ($Kind == 2 | $Kind == 4)
            foreach ($result['data']['series'] as $id => $data) {
                $SumTemp = 0;
                foreach ($result['data']['series'][$id]["data"] as $id2 => $data2) {
                    $SumTemp += $result['data']['series'][$id]["data"][$id2];
                    $result['data']['series'][$id]["data"][$id2] = $SumTemp;
                }
            }

        $dataFinal['data'] = self::Convert2GoogleData($result['data'], $Timing, $MovAvgFlag);
        $dataFinal['MovAvg'] = $MovAvgFlag;
        return self::json($dataFinal);
    }

    private static function Convert2GoogleData($result, $Timing, $MovAvgFlag)
    {

        $series = $result['series'];
        $label = $result['labels'];

        $annotationFlag = false;
        if (count($series) == 3 or ($MovAvgFlag and count($series) == 4))
            $annotationFlag = true;

        if ($annotationFlag) {
            $series = self::addAnnotation($series, 2);
            if ($MovAvgFlag)
                $series = self::addAnnotation($series, 4);
        }

        $Name = array_column($series, 'name');
        $inData = array_column($series, 'data');
        $data = array();
        $data[] = array();
        $data[0][] = $Timing;

        foreach ($Name as $searchOne) {
            $data[0][] = $searchOne;
        }

        foreach ($label as $id => $dataLabel) {
            $data[] = array();
            $data[$id + 1][] = (string)$dataLabel;
            foreach ($inData as $searchOne)
                $data[$id + 1][] = $searchOne[$id];
        }
        return $data;
    }

    private static function shortFormat($data)
    {
        if ($data >= 1000)
            return (string)(round($data / 1000, 1)) . 'k';
        elseif ($data < 1000 and $data != null)
            return (string)$data;
        else
            return null;
    }

    private static function addAnnotation($series, $id)
    {
        $annotation['name'] = (object)array('role' => 'annotation');
        $annotation['data'] = array();
        foreach ($series[$id]['data'] as $searchOne2) {
            $annotation['data'][] = self::shortFormat($searchOne2);
        }
        array_splice($series, $id + 1, 0, $annotation['name']);
        $series[$id + 1] = $annotation;
        return $series;
    }

    private static function extractData($search, $BudgetPishFlag, $Budgets, $BudgetFlag, $movAvgFlag, $date, $labels)
    {
        $series = null;
        $i = 0;

        if ($BudgetFlag) {
            $series[$i]["name"] = "بودجه" . " " . $date;
            foreach ($labels as $id => $data) {
                $series[$i]["data"][$id] = $Budgets;
            }
        }
        $i++;

        if ($BudgetPishFlag) {
            $resultCheck = [];
            $Sum = 0;
            $SumCount = 0;
            foreach ($search as $searchOne) {
                if (!isset($resultCheck[$searchOne['id']])) {
                    $resultCheck[$searchOne['id']] = true;
                    foreach ($search as $numTwoId => $searchTwo) {
                        if ($searchOne['id'] == $searchTwo['id']) {
                            if ($searchTwo['counter'] > $Budgets) {
                                $Sum += $searchTwo['counter'];
                                $SumCount++;
                            }
                        }
                    }
                }
            }

            $series[$i]["name"] = "بودجه پیشنهادی" . " " . $date;
            foreach ($labels as $id => $data) {
                if ($SumCount != 0)
                    $series[$i]["data"][$id] = round($Sum / $SumCount);
                else
                    $series[$i]["data"][$id] = round($Budgets);
            }
            $i++;
        }

        $resultCheck = [];
        foreach ($search as $searchOne) {
            if (!isset($resultCheck[$searchOne['id']])) {
                $series[$i]["name"] = $searchOne['sensors'] . " " . $date;
                if ($movAvgFlag)
                    $series[$i + 1]["name"] = "میانگین متحرک " . $searchOne['sensors'] . " " . $date;
                $resultCheck[$searchOne['id']] = true;
                foreach ($labels as $id => $data) {
                    $series[$i]["data"][$id] = null;
                    if ($movAvgFlag)
                        $series[$i + 1]["data"][$id] = null;
                }
                foreach ($search as $numTwoId => $searchTwo) {
                    if ($searchOne['id'] == $searchTwo['id']) {
                        $id = array_search((int)$searchTwo['Day'], $labels);
                        $series[$i]["data"][$id] = (int)$searchTwo['counter'];
                        if ($movAvgFlag)
                            $series[$i + 1]["data"][$id] = (int)$searchTwo['MovingAvg'];
                        unset($search[$numTwoId]);
                    }
                }
                $i++;
                if ($movAvgFlag)
                    $i++;
            }
        }
        return $series;
    }

    private static function tr_num($str, $mod = 'en')
    {
        $num_a = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $key_a = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        return ($mod == 'fa') ? str_replace($num_a, $key_a, $str) : str_replace($key_a, $num_a, $str);
    }
}