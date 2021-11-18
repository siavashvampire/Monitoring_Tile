<?php

namespace App\requestService\app_provider\admin;

use App\core\controller\fieldService;
use App\LineMonitoring\app_provider\api\phases;
use App\requestService\model\requestService;
use App\Sections\app_provider\api\sections;
use App\shiftWork\app_provider\api\totalDate;
use App\shiftWork\app_provider\api\shift;
use App\user\app_provider\api\user;
use controller;
use paymentCms\component\arrays;
use paymentCms\component\JDate;
use paymentCms\component\request;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class requestService_export extends controller
{
    public function index()
    {
        $variable = array();

        /** @var requestservice $model */
        $model = parent::model('requestService');

        $value = [];
        if (request::isPost()) {
            $get = request::post('showField,formType,section,phase,giver_section,send_phase,StartTime,EndTime,line,Day,Shift,month,getPDF');
            $_SERVER['JsonOff'] = true;
            if ($get['StartTime'] != null) {
                $shamsi = explode('/', $get['StartTime']);
                $DayData = totalDate::Day(0, strtotime(JDate::jalali_to_gregorian($shamsi[0], $shamsi[1], $shamsi[2], '-') . ' 12:00:00'))["result"];

                $startTimeForview = $get['StartTime'];
                $get['StartTime'] = $DayData["dayStart"];

            }
            if ($get['EndTime'] != null) {
                $shamsi = explode('/', $get['EndTime']);
                $DayData = totalDate::Day(0, strtotime(JDate::jalali_to_gregorian($shamsi[0], $shamsi[1], $shamsi[2], '-') . ' 12:00:00'))["result"];

                $endTimeForview = $get['EndTime'];
                $get['EndTime'] = $DayData["dayEnd"];

            }


            if ($get['Shift'] != null) {
                $shiftData = shift::index(time() - $get['Shift'] * 43200)["result"];

                $get['StartTime'] = $shiftData["startTime"];
                $get['EndTime'] = $shiftData["endTime"];
            }
            if ($get['Day'] != null) {
                $DayData = totalDate::Day($get['Day'])["result"];

                $get['StartTime'] = $DayData["dayStart"];
                $get['EndTime'] = $DayData["dayEnd"];
            }
            if ($get['month'] != null) {
                $monthData = totalDate::Month($get['month'])["result"];

                $get['StartTime'] = $monthData["monthStart"];
                $get['EndTime'] = $monthData["monthEnd"];

                $startTimeForview = $monthData['justDateStart'];
                $endTimeForview = $monthData['justDateEnd'];
            }

            if ($get['formType'] != null) {
                if ($get['formType'] == 'monthly') {
                    $get['month'] = "0";
                    $get['getPDF'] = "1";
                }
            }

            unset($_SERVER['JsonOff']);

            if ($get['section'] === "0" or $get['giver_section'] === "0") {
                $user = user::getUserLogin(false);

                $fields = fieldService::showFilledOutFormWithAllFields($user['user_group_id'], 'user_register', $user['userId'], 'user_register', true);
                $section = false;
                if (is_array($fields['result'])) {
                    foreach ($fields['result'] as $index => $fields) {
                        if ($fields['type'] == 'fieldCall_Sections_sections') {
                            $section = $fields['value'];
                        }
                        if ($section) break;
                    }
                }
                if ($section) {
                    if ($get['section'] === "0")
                        $get['section'] = [$section];

                    if ($get['giver_section'] === "0")
                        $get['giver_section'] = [$section];
                }

            }

            if (is_array($get['phase']) and count($get['phase']) > 0) {
                $variable[] = ' rs.phase IN( ' . implode(' , ', $get['phase']) . ' ) ';
                $value = array_merge($value, $get['phase']);
            }
            if (is_array($get['section']) and count($get['section']) > 0) {
                $variable[] = ' rs.section IN( ' . implode(' , ', $get['section']) . ' ) ';
                $get['showField'] = ["workerSections", "phase", "percent", "time_diff", "count"];
            }
            if (is_array($get['giver_section']) and count($get['giver_section']) > 0) {
                $variable[] = ' rs.WorkerSection IN( ' . implode(' , ', $get['giver_section']) . ' ) ';
                $get['showField'] = ["section", "phase", "percent", "time_diff", "count"];
            }
            if (is_array($get['line']) and count($get['line']) > 0) {
                $variable[] = ' rs.Line IN( ' . implode(' , ', $get['line']) . ' ) ';
//                $value = array_merge($value, $get['line']);
            }
            if ($get['StartTime'] != null and $get['EndTime'] == null) {
                $variable[] = ' rs.Time_Start > ?';
                $value[] = $get['StartTime'];
            } elseif ($get['StartTime'] == null and $get['EndTime'] != null) {
                $variable[] = ' rs.Time_Start < ?';
                $value[] = $get['EndTime'];
            } elseif ($get['StartTime'] != null and $get['EndTime'] != null) {
                $variable[] = ' (rs.Time_Start BETWEEN ? AND ?) ';
                $value[] = $get['StartTime'];
                $value[] = $get['EndTime'];
            }

            $this->mold->offAutoCompile();
            $GLOBALS['timeStart'] = '';

            if ($get['Day'] != null or $get['Shift'] != null)
                $model->getDayExport($value, $variable);

            if ($get['month'] != null) {
                $header = [];
                $header[] = 'ردیف';
                for ($i = 0; $i < count($get['showField']); $i++) {
                    if ($get['showField'][$i] == "section")
                        $header[] = 'بخش درخواست کننده';
                    elseif ($get['showField'][$i] == "workerSections")
                        $header[] = 'بخش انجام دهنده';
                    elseif ($get['showField'][$i] == "phase")
                        $header[] = 'فاز';
                    elseif ($get['showField'][$i] == "percent")
                        $header[] = 'درصد(بر حسب نفر ساعت)';
                    elseif ($get['showField'][$i] == "time_diff")
                        $header[] = 'نفرساعت خدمات';
                    elseif ($get['showField'][$i] == "count")
                        $header[] = 'تعداد خدمات';
                }
                if ($get['getPDF']) {
                    $data = $model->getMonthExportData($value, $variable, $get['showField']);
                    $search = $data['data'];
                    $time_diff_all = $data['time_diff_all'];
                    $count_all = $data['count_all'];

                    for ($i = 0; $i < count($search); $i++) {
                        $search[$i] = array_merge([$i + 1], $search[$i]);
                    }

                    $this->mold->path('default', 'requestService');
                    $views = $this->mold->getViews();
                    $this->mold->unshow($views);
                    $this->mold->view('exportPdf.mold.html');
                    $this->mold->set('headersTable', $header);
                    $this->mold->set('headersTableWidth', [16.666, 16.666, 16.666, 16.666, 16.666, 16.667]);

                    $file_name = "بخش ";

                    if ($get['section']) {
                        $unitlabel = sections::index($get['section'])["result"][0]["label"];
                        $file_name .= $unitlabel;
                        $file_name .= " - ";
                        $file_name .= "گزارش ماهانه درخواست دهنده";
                    } else {
                        $unitlabel = sections::index($get['giver_section'])["result"][0]["label"];
                        $file_name .= $unitlabel;
                        $file_name .= " - ";
                        $file_name .= "گزارش ماهانه انجام دهنده";
                    }

                    $file_name .= " - ";
                    $file_name .= JDate::jdate('F Y');

                    $this->mold->set('unitLabel', $unitlabel);
                    $this->mold->set('nowTime', JDate::jdate('Y/m/d'));
                    $this->mold->set('startTime', $startTimeForview);
                    $this->mold->set('endTime', $endTimeForview);
                    $this->mold->set('time_diff_all', $time_diff_all);
                    $this->mold->set('count_all', $count_all);
                    $this->mold->set('datasTable', $search);
                    $this->mold->setPageTitle('گزارش گیری خدمات');
                    $this->mold->unshow('footer.mold.html');
                    $htmlpersian = $this->mold->render();
//                    show($htmlpersian);
                    $this->callHooks('makePDF', ['htmlpersian' => $htmlpersian, 'nameOfFile' => $file_name, 'landscape' => true]);
                } else {
                    echo "\xEF\xBB\xBF";
                    $model->getMonthExportCSV($value, $variable, $header, $get['showField']);
                }
            }
        }
        $this->mold->path('default', 'requestService');
        $this->mold->view('RSExport.mold.html');
        $this->mold->setPageTitle('گزارش گیری خدمات');
        $this->mold->set('activeMenu', 'RequestexportExcel');

        $this->mold->set('sections', sections::index() ["result"]);
        $this->mold->set('phases', phases::index()["result"]);
    }

}