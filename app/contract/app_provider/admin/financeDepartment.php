<?php


namespace App\LineMonitoring\app_provider\admin;


use controller;


if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');


class financeDepartment extends controller
{
    public function index()
    {
        $this->mold->path('default', 'LineMonitoring');
        $this->mold->view('financeDepartment.mold.html');
        $this->mold->setPageTitle('نظرسنجی امور مالی');
        $this->mold->set('activeMenu', 'financeDepartment');
    }
}