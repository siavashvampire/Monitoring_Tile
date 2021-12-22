<?php

namespace App\product\app_provider\admin;

use App\product\model\product;
use App\Sections\app_provider\admin\Sections;
use App\user\app_provider\api\checkAccess;
use App\user\app_provider\api\user;
use controller;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\validate;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class product_export extends controller
{
    private $item_label = "برند";
    private $log_name = 'product_brand';
    private $controller_name = 'product_brand';
    private $model_name = 'product_brand';
    private $app_name = 'product';
    private $active_menu = 'product_brand';
    private $html_file_path = 'product_brand.mold.html';

    public function index(): bool
    {

        /* @var product $model */
        $model = parent::model('product');
        $get['getPDF'] = 1;
        $search = $model->getItems();
        $header = [];
        $header[] = 'فاز';

        if (is_array($search) and count($search) > 0) {
            $this->mold->offAutoCompile();
            $GLOBALS['timeStart'] = '';
            if ($get['getPDF']) {
                $this->mold->path('default', 'product');
                $views = $this->mold->getViews();
                $this->mold->unshow($views);
                $this->mold->view('QC_Pdf.mold.html');
                $this->mold->set('headersTable', $header);
                $this->mold->set('datasTable', $search);
                $this->mold->unshow('footer.mold.html');
                $htmlpersian = $this->mold->render();
                show($htmlpersian);
                $this->callHooks('makePDF', ['htmlpersian' => $htmlpersian, 'nameOfFile' => date('Y-M-d H-i'), 'landscape' => true]);
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
        return false;
    }
}