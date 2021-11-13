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
            $get = request::post('section,phase,giver_section,send_phase,StartTime,EndTime,line,Day,Shift,month,getPDF');
            $_SERVER['JsonOff'] = true;
            if ($get['StartTime'] != null) {
                $shamsi = explode('/', $get['StartTime']);
                $DayData = totalDate::Day(0, strtotime(JDate::jalali_to_gregorian($shamsi[0], $shamsi[1], $shamsi[2], '-') . ' 12:00:00'))["result"];
                $get['StartTime'] = $DayData["dayStart"];
            }
            if ($get['EndTime'] != null) {
                $shamsi = explode('/', $get['EndTime']);
                $DayData = totalDate::Day(0, strtotime(JDate::jalali_to_gregorian($shamsi[0], $shamsi[1], $shamsi[2], '-') . ' 12:00:00'))["result"];
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
//                $value = array_merge($value, $get['section']);
            }
            if (is_array($get['giver_section']) and count($get['giver_section']) > 0) {
                $variable[] = ' rs.WorkerSection IN( ' . implode(' , ', $get['giver_section']) . ' ) ';
//                $value = array_merge($value, $get['giver_section']);
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
                $header = [
                    'ردیف',
                    'بخش درخواست کننده',
                    'بخش انجام دهنده',
                    'فاز',
                    'درصد',
                ];

                if ($get['getPDF']) {
                    $data = $model->getMonthExportData($value, $variable);
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
                    $this->mold->set('headersTableWidth', [20, 20, 20, 20, 20]);
                    $file_name = "گزارش ";
                    if ($get['section']) {
                        $unitlabel = sections::index($get['section'])["result"][0]["label"];
                        $file_name .= "درخواست دهنده واحد " . $unitlabel ;
                    } else {
                        $unitlabel = sections::index($get['giver_section'])["result"][0]["label"];
                        $file_name .= "انجام دهنده واحد " . $unitlabel ;
                    }

                    $file_name .= " ";

                    $this->mold->set('unitLabel', $unitlabel);
                    $this->mold->set('nowTime', JDate::jdate('Y/m/d'));
                    $this->mold->set('startTime', $monthData['justDateStart']);
                    $this->mold->set('endTime', $monthData['justDateEnd']);
                    $this->mold->set('time_diff_all', $time_diff_all);
                    $this->mold->set('count_all', $count_all);
                    $this->mold->set('datasTable', $search);
                    $this->mold->setPageTitle('گزارش گیری خدمات');
                    $this->mold->unshow('footer.mold.html');
                    $htmlpersian = $this->mold->render();
//                    show($htmlpersian);
                    $this->callHooks('makePDF', ['htmlpersian' => $htmlpersian, 'nameOfFile' => $file_name . JDate::jdate('F Y'), 'landscape' => true]);
                } else {
                    echo "\xEF\xBB\xBF";
                    $model->getMonthExportCSV($value, $variable, $header);
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