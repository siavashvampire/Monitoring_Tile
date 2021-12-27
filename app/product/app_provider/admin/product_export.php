<?php

namespace App\product\app_provider\admin;


use App\LineMonitoring\app_provider\api\phases;
use App\product\model\product_qc as product_qcAlias;
use App\product\model\product_routine as product_routineAlias;
use App\shiftWork\app_provider\api\totalDate;
use App\units\app_provider\api\units;
use controller;
use paymentCms\component\JDate;
use paymentCms\component\request;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class product_export extends controller
{
    private $model_name = 'product_qc';
    private $app_name = 'product';
    private $model_name_routine = 'product_routine';

    public function main(): bool
    {
//        $get = request::post('unitId,phase,StartTime,EndTime,tile_kind,showField,shifts,getPDF=1,Shift,Day');
//
//        $_SERVER['JsonOff'] = true;
//        if ($get['StartTime'] != null) {
//            $shamsi = explode('/', $get['StartTime']);
//
//            $DayData = totalDate::Day(0, strtotime(JDate::jalali_to_gregorian($shamsi[0], $shamsi[1], $shamsi[2], '-')) + 43200);
//            $get['StartTime'] = $DayData["result"]["dayStart"];
//        }
//
//        if ($get['EndTime'] != null) {
//            $shamsi = explode('/', $get['EndTime']);
//            $DayData = totalDate::Day(0, strtotime(JDate::jalali_to_gregorian($shamsi[0], $shamsi[1], $shamsi[2], '-')) + 43200);
//            $get['EndTime'] = $DayData["result"]["dayEnd"];
//        }
//
//
//        if ($get['Shift'] != null) {
//            $shiftData = shift::index(time() - $get['Shift'] * 43200);
//
//            $get['StartTime'] = $shiftData["result"]["startTime"];
//            $get['EndTime'] = $shiftData["result"]["endTime"];
//        }
//        if ($get['Day'] != null) {
//
//            $DayData = totalDate::Day($get['Day']);
//
//            $get['StartTime'] = $DayData["result"]["dayStart"];
//            $get['EndTime'] = $DayData["result"]["dayEnd"];
//        }
//        unset($_SERVER['JsonOff']);
//
//        if (request::isPost() and is_array($get['showField']) and count($get['showField']) > 0) {
//            if (is_array($get['phase']) and count($get['phase']) > 0) {
//                $variable[] = ' arch1.phase IN( ' . implode(' , ', $get['phase']) . ' ) ';
//            }
//            if (is_array($get['unitId']) and count($get['unitId']) > 0) {
//                $variable[] = ' arch1.unit IN( ' . implode(' , ', $get['unitId']) . ' ) ';
//            }
//            if (is_array($get['tile_kind']) and count($get['tile_kind']) > 0) {
//                $variable[] = ' arch1.Tile_Kind IN( ' . implode(' , ', $get['tile_kind']) . ' ) ';
//            }
//            if (is_array($get['shifts']) and count($get['shifts']) > 0) {
//                $variable[] = ' arch1.Shift_id IN( ' . implode(' , ', $get['shifts']) . ' ) ';
//            }
//            if ($get['StartTime'] != null and $get['EndTime'] == null) {
//                $variable[] = ' arch1.Start_time > "' . date('Y-m-d H:i:s', $get['StartTime'] / 1000) . '"';
//            } elseif ($get['StartTime'] == null and $get['EndTime'] != null) {
//                $variable[] = ' arch1.Start_time < "' . date('Y-m-d H:i:s', $get['EndTime'] / 1000) . '"';
//            } elseif ($get['StartTime'] != null and $get['EndTime'] != null) {
//                $variable[] = ' (arch1.Start_time BETWEEN "' . date('Y-m-d H:i:s', $get['StartTime'] / 1000) . '" AND "' . date('Y-m-d H:i:s', $get['EndTime'] / 1000) . '") ';
//            }
//        }

        $this->mold->path('default', $this->app_name);
        $this->mold->view('export_qc.mold.html');
        $this->mold->setPageTitle('گزارش گیری');
        $this->mold->set('activeMenu', 'exportExcel2');

        $this->mold->set('units', units::index()["result"]);
        $this->mold->set('phases', phases::index()["result"]);
        $this->mold->set('shifts', parent::model(['shiftWork', 'shift_work'])->getShiftWork());
        return false;
    }

    public function index($product = null): bool
    {
        /* @var product_qcAlias $model */
        $model = parent::model($this->model_name);

        $value = array();
        $variable = array();

        if ($product != null) {
            $value[] = $product;
            $variable[] = 'item.product = ?';
        }

        $get = request::post('getPDF=1,Day');

        $_SERVER['JsonOff'] = true;
        if ($get['Day'] != null){

            $DayData = totalDate::Day($get['Day'])["result"];

            $get['StartTime'] = $DayData["dayStart"];
            $get['EndTime']   = $DayData["dayEnd"];
        }
        unset($_SERVER['JsonOff']);

        if ($get['StartTime'] != null and $get['EndTime'] == null) {
            $variable[] = ' item.qc_date > ?' ;
            $value[] = $get['StartTime'];
        } elseif ($get['StartTime'] == null and $get['EndTime'] != null) {
            $variable[] = ' item.qc_date < ?' ;
            $value[] = $get['EndTime'];
        } elseif ($get['StartTime'] != null and $get['EndTime'] != null) {
            $variable[] = ' item.qc_date BETWEEN ? AND ?' ;
            $value[] = $get['StartTime'];
            $value[] = $get['EndTime'];
        }

        $search = $model->getItemsForExport($value, $variable);

        $header = [];
        $header[] = 'شماره';
        $header[] = 'روز';
        $header[] = 'ماه';
        $header[] = 'سال';
        $header[] = 'فاز تولیدی';
        $header[] = 'سایز';
        $header[] = 'فرمول گرانول';
        $header[] = 'ضخامت';
        $header[] = 'نام طرح';
        $header[] = 'نوانس';
        $header[] = 'کد';
        $header[] = 'شماره پرونده';
        $header[] = 'کنترلر';
        $header[] = 'فرمول انگوب';
        $header[] = 'فرمول لعاب';
        $header[] = 'فرمول انگوب زیر';
        $header[] = 'توضیحات';

        if (is_array($search) and count($search) > 0) {
            $this->mold->offAutoCompile();
            $GLOBALS['timeStart'] = '';
            if ($get['getPDF']) {
                $this->mold->path('default', 'product');
                $views = $this->mold->getViews();
                $this->mold->unshow($views);
                $this->mold->view('QC_Pdf.mold.html');

                $this->mold->set('date', JDate::jdate('Y/m/d'));
                $this->mold->set('headersTable', $header);
                $this->mold->set('datasTable', $search);
                $this->mold->unshow('footer.mold.html');
                $htmlpersian = $this->mold->render();
                $file_name = "تولیدات";
                $file_name .= " - ";

                if ($get['Day'] != null){
                    $file_name .= date("d-m-Y", strtotime($DayData["jdayStart"]));
                }
                else
                    $file_name .= JDate::jdate(' Y');
                if ($product != null) {
                    $file_name .= " - ";
                    $file_name .= \App\product\app_provider\api\product::index($product)["result"][0]["label"];
                }
                $this->callHooks('makePDF', ['htmlpersian' => $htmlpersian, 'nameOfFile' => $file_name, 'landscape' => true]);
            } else {
                header('Content-Encoding: UTF-8');
                header('Content-type: text/csv; charset=UTF-8');
                header("Content-Disposition: attachment; filename=" . 'Export Log (' . date('Y-M-d H-i') . ').csv');
                header("Pragma: no-cache");
                header("Expires: 0");
                header('Content-Transfer-Encoding: binary');
                echo "\xEF\xBB\xBF";
                $fp = fopen('php://output', 'w');
                fputcsv($fp, $header);
                for ($i = 0; $i < count($search); $i++) {
                    fputcsv($fp, $search[$i]);
                }
                fclose($fp);
                return true;
            }
            return false;
        }
        $this->alert('danger','','نتیجه ای یافت نشد !');
        $this->mold->path('default', $this->app_name);
        $this->mold->view('export_qc.mold.html');
        $this->mold->setPageTitle('گزارش گیری');
        $this->mold->set('activeMenu', 'exportExcel2');

        $this->mold->set('units', units::index()["result"]);
        $this->mold->set('phases', phases::index()["result"]);
        $this->mold->set('shifts', parent::model(['shiftWork', 'shift_work'])->getShiftWork());
        return false;
    }

    public function routine($product = null): bool
    {
        /* @var product_routineAlias $model */
        $model = parent::model($this->model_name_routine);

        $value = array();
        $variable = array();

        if ($product != null) {
            $value[] = $product;
            $variable[] = 'item.product = ?';
        }
        $get = request::post('getPDF=1,Day');

        $_SERVER['JsonOff'] = true;
        if ($get['Day'] != null){

            $DayData = totalDate::Day($get['Day'])["result"];

            $get['StartTime'] = $DayData["dayStart"];
            $get['EndTime']   = $DayData["dayEnd"];
        }
        unset($_SERVER['JsonOff']);

        if ($get['StartTime'] != null and $get['EndTime'] == null) {
            $variable[] = ' item.routine_date > ?' ;
            $value[] = $get['StartTime'];
        } elseif ($get['StartTime'] == null and $get['EndTime'] != null) {
            $variable[] = ' item.routine_date < ?' ;
            $value[] = $get['EndTime'];
        } elseif ($get['StartTime'] != null and $get['EndTime'] != null) {
            $variable[] = ' item.routine_date BETWEEN ? AND ?' ;
            $value[] = $get['StartTime'];
            $value[] = $get['EndTime'];
        }

        $search = $model->getItemsForExport($value, $variable);

        $header = [];
        $header[] = 'شماره';
        $header[] = 'روز';
        $header[] = 'ماه';
        $header[] = 'سال';
        $header[] = 'شیفت';
        $header[] = 'فاز';
        $header[] = '(mm) سایز محصولات';
        $header[] = 'نام طرح';
        $header[] = 'ابعاد طول (mm)';
        $header[] = 'ابعاد عرض (mm)';
        $header[] = 'ابعاد ضخامت (mm)';
        $header[] = 'مقاومت (Kg/Cm2)';
        $header[] = 'گونیایی (mm)';
        $header[] = 'تاب قطر (mm)';
        $header[] = 'تاب مرکز (mm)';
        $header[] = 'تاب ضلع (mm)';
        $header[] = 'مستقیم بودن (mm)';
        $header[] = 'میانگین جذب آب';
        $header[] = 'دما (c)';
        $header[] = 'سیکل (min)';
        $header[] = 'فشار ویژه (Kg/Cm2)';
        if (is_array($search) and count($search) > 0) {
            $this->mold->offAutoCompile();
            $GLOBALS['timeStart'] = '';
            if ($get['getPDF']) {
                $this->mold->path('default', 'product');
                $views = $this->mold->getViews();
                $this->mold->unshow($views);
                $this->mold->view('Routine_Pdf.mold.html');

                $this->mold->set('date', JDate::jdate('Y/m/d'));
                $this->mold->set('headersTable', $header);
                $this->mold->set('datasTable', $search);
                $this->mold->unshow('footer.mold.html');
                $htmlpersian = $this->mold->render();
                $file_name = "روتین";
                $file_name .= " - ";

                if ($get['Day'] != null){
                    $file_name .= date("d-m-Y", strtotime($DayData["jdayStart"]));
                }
                else
                    $file_name .= JDate::jdate(' Y');
                if ($product != null) {
                    $file_name .= " - ";
                    $file_name .= \App\product\app_provider\api\product::index($product)["result"][0]["label"];
                }
                $this->callHooks('makePDF', ['htmlpersian' => $htmlpersian, 'nameOfFile' => $file_name, 'landscape' => true]);
            } else {
                header('Content-Encoding: UTF-8');
                header('Content-type: text/csv; charset=UTF-8');
                header("Content-Disposition: attachment; filename=" . 'Export Log (' . date('Y-M-d H-i') . ').csv');
                header("Pragma: no-cache");
                header("Expires: 0");
                header('Content-Transfer-Encoding: binary');
                echo "\xEF\xBB\xBF";
                $fp = fopen('php://output', 'w');
                fputcsv($fp, $header);
                for ($i = 0; $i < count($search); $i++) {
                    fputcsv($fp, $search[$i]);
                }
                fclose($fp);
                return true;
            }
            return false;
        }
        $this->alert('danger','','نتیجه ای یافت نشد !');
        $this->mold->path('default', $this->app_name);
        $this->mold->view('export_qc.mold.html');
        $this->mold->setPageTitle('گزارش گیری');
        $this->mold->set('activeMenu', 'exportExcel2');

        $this->mold->set('units', units::index()["result"]);
        $this->mold->set('phases', phases::index()["result"]);
        $this->mold->set('shifts', parent::model(['shiftWork', 'shift_work'])->getShiftWork());
        return false;
    }

    public function water_attraction($product = null): bool
    {
        /* @var product_routineAlias $model */
        $model = parent::model($this->model_name_routine);

        $value = array();
        $variable = array();

        if ($product != null) {
            $value[] = $product;
            $variable[] = 'item.product = ?';
        }

        $get = request::post('getPDF=1,Day');
        $_SERVER['JsonOff'] = true;
        if ($get['Day'] != null){

            $DayData = totalDate::Day($get['Day'])["result"];

            $get['StartTime'] = $DayData["dayStart"];
            $get['EndTime']   = $DayData["dayEnd"];
        }
        unset($_SERVER['JsonOff']);

        if ($get['StartTime'] != null and $get['EndTime'] == null) {
            $variable[] = ' item.routine_date > ?' ;
            $value[] = $get['StartTime'];
        } elseif ($get['StartTime'] == null and $get['EndTime'] != null) {
            $variable[] = ' item.routine_date < ?' ;
            $value[] = $get['EndTime'];
        } elseif ($get['StartTime'] != null and $get['EndTime'] != null) {
            $variable[] = ' item.routine_date BETWEEN ? AND ?' ;
            $value[] = $get['StartTime'];
            $value[] = $get['EndTime'];
        }

        $search = $model->getItemsForExport($value, $variable);
        $header = [];
        $header[] = 'شماره';
        $header[] = 'روز';
        $header[] = 'ماه';
        $header[] = 'سال';
        $header[] = 'فاز';
        $header[] = 'سایز طول (mm)';
        $header[] = 'سایز عرض (mm)';
        $header[] = 'دما بالا (c)';
        $header[] = 'دما پایین (c)';
        $header[] = 'سیکل (min)';
        $header[] = 'جذب آب بالا (c)';
        $header[] = 'جذب آب پایین (c)';
        $header[] = 'میانگین';
        $header[] = 'فشار ویژه';
        $header[] = 'توضیحات';

        if (is_array($search) and count($search) > 0) {
            $this->mold->offAutoCompile();
            $GLOBALS['timeStart'] = '';
            if ($get['getPDF']) {
                $this->mold->path('default', 'product');
                $views = $this->mold->getViews();
                $this->mold->unshow($views);
                $this->mold->view('water_attraction_pdf.mold.html');

                $this->mold->set('date', JDate::jdate('Y/m/d'));
                $this->mold->set('headersTable', $header);
                $this->mold->set('datasTable', $search);
                $this->mold->unshow('footer.mold.html');
                $htmlpersian = $this->mold->render();
                $file_name = "جذب آب";
                $file_name .= " - ";

                if ($get['Day'] != null){
                    $file_name .= date("d-m-Y", strtotime($DayData["jdayStart"]));
                }
                else
                    $file_name .= JDate::jdate(' Y');
                if ($product != null) {
                    $file_name .= " - ";
                    $file_name .= \App\product\app_provider\api\product::index($product)["result"][0]["label"];
                }

                $this->callHooks('makePDF', ['htmlpersian' => $htmlpersian, 'nameOfFile' => $file_name, 'landscape' => true]);
            } else {
                header('Content-Encoding: UTF-8');
                header('Content-type: text/csv; charset=UTF-8');
                header("Content-Disposition: attachment; filename=" . 'Export Log (' . date('Y-M-d H-i') . ').csv');
                header("Pragma: no-cache");
                header("Expires: 0");
                header('Content-Transfer-Encoding: binary');
                echo "\xEF\xBB\xBF";
                $fp = fopen('php://output', 'w');
                fputcsv($fp, $header);
                for ($i = 0; $i < count($search); $i++) {
                    fputcsv($fp, $search[$i]);
                }
                fclose($fp);
                return true;
            }
            return false;
        }

        $this->alert('danger','','نتیجه ای یافت نشد !');
        $this->mold->path('default', $this->app_name);
        $this->mold->view('export_qc.mold.html');
        $this->mold->setPageTitle('گزارش گیری');
        $this->mold->set('activeMenu', 'exportExcel2');

        $this->mold->set('units', units::index()["result"]);
        $this->mold->set('phases', phases::index()["result"]);
        $this->mold->set('shifts', parent::model(['shiftWork', 'shift_work'])->getShiftWork());
        return false;
    }
}