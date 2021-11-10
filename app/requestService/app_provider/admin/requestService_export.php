<?php

namespace App\requestService\app_provider\admin;

use App\core\controller\fieldService;
use App\LineMonitoring\app_provider\api\phases;
use App\requestService\model\requestService;
use App\Sections\app_provider\api\sections;
use App\shiftWork\app_provider\api\Day;
use App\shiftWork\app_provider\api\shift;
use App\user\app_provider\api\user;
use controller;
use paymentCms\component\JDate;
use paymentCms\component\model;
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
            $get = request::post('section,phase,giver_section,send_phase,StartTime,EndTime,line,Day,Shift');
            $get = null;
            $_SERVER['JsonOff'] = true;
            if ($get['StartTime'] != null) {
                $shamsi = explode('/', $get['StartTime']);
                $DayData = Day::index(0, strtotime(JDate::jalali_to_gregorian($shamsi[0], $shamsi[1], $shamsi[2], '-') . ' 12:00:00'));
                $get['StartTime'] = $DayData["result"]["dayStart"];
            }
            if ($get['EndTime'] != null) {
                $shamsi = explode('/', $get['EndTime']);
                $DayData = Day::index(0, strtotime(JDate::jalali_to_gregorian($shamsi[0], $shamsi[1], $shamsi[2], '-') . ' 12:00:00'));
                $get['EndTime'] = $DayData["result"]["dayEnd"];
            }


            if ($get['Shift'] != null) {
                $shiftData = shift::index(time() - $get['Shift'] * 43200);

                $get['StartTime'] = $shiftData["result"]["startTime"];
                $get['EndTime'] = $shiftData["result"]["endTime"];
            }
            if ($get['Day'] != null) {

                $DayData = Day::index($get['Day']);

                $get['StartTime'] = $DayData["result"]["dayStart"];
                $get['EndTime'] = $DayData["result"]["dayEnd"];
            }
            unset($_SERVER['JsonOff']);

            if ($get['section'] === "0" or $get['giver_section'] === "0") {
                $user = user::getUserLogin(false);

                $fields = fieldService::showFilledOutFormWithAllFields($user['user_group_id'], 'user_register', $user['userId'], 'user_register', true);
                $section = false;
                $phase = false;
                if (is_array($fields['result'])) {
                    foreach ($fields['result'] as $index => $fields) {
                        if ($fields['type'] == 'fieldCall_Sections_sections') {
                            $section = $fields['value'];
                        } elseif ($fields['type'] == 'fieldCall_LineMonitoring_phase') {
                            $phase = $fields['value'];
                        }
                        if ($section and $phase) break;
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
                $variable[] = ' rs.Time_Send > ?';
                $value[] = $get['StartTime'];
            } elseif ($get['StartTime'] == null and $get['EndTime'] != null) {
                $variable[] = ' rs.Time_Send < ?';
                $value[] = $get['EndTime'];
            } elseif ($get['StartTime'] != null and $get['EndTime'] != null) {
                $variable[] = ' (rs.Time_Send BETWEEN ? AND ?) ';
                $value[] = $get['StartTime'];
                $value[] = $get['EndTime'];
            }

            $header = [
                'تاریخ درخواست',
                'شماره درخواست',
                'ساعت درخواست',
                'واحد درخواست کننده',
                'فاز',
                'نام دستگاه/تجهیز',
                'حالت تعمیرات',
                'مدت توقف',
                'واحد مجری',
                'ساعت شروع',
                'ساعت اتمام',
                'زمان کارکرد(دقیقه)',
                'شرح خرابی و عملیات انجام شده',
                'نفر کارکرد',
                'نفر ساعت',
            ];
            $requestservice_worktitles = $model->search(null, ' 1 ', 'requestservice_worktitle');
            if (is_array($requestservice_worktitles)) {
                for ($i = 0; $i < count($requestservice_worktitles); $i++) {
                    $header[] = $requestservice_worktitles[$i]['label'];
                }
            }


            $this->mold->offAutoCompile();
            $GLOBALS['timeStart'] = '';
            echo "\xEF\xBB\xBF";

            $model->getDayExport($value,$variable);

        }


        $this->mold->path('default', 'requestService');
        $this->mold->view('RSExport.mold.html');
        $this->mold->setPageTitle('گزارش گیری خدمات');
        $this->mold->set('activeMenu', 'RequestexportExcel');

        $this->mold->set('sections', sections::index() ["result"]);
        $this->mold->set('phases', phases::index()["result"]);
    }

}