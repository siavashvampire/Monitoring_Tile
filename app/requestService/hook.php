<?php
namespace App\requestService ;

use app;
use pluginController;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class hook extends pluginController {
	public function _adminHeaderNavbar($vars2){
        $this->menu->after('users', 'requestServiceTab', 'درخواست خدمات', "#", 'fa fa-history', '', null, 'admin/requestService/index/requestService');
        $this->menu->addChild('requestServiceTab', 'requestServiceAdmin', 'درخواست خدمات جامع', app::getBaseAppLink('requestService/adminService', 'admin'), 'fa fa-briefcase', '',  'admin/requestService/adminService/requestService');

        $this->menu->addChild('requestServiceTab', 'requestServiceOptimal', 'درخواست خدمات بهینه', app::getBaseAppLink('requestService/OptimalService', 'admin'), 'fa fa-briefcase', '',  'admin/requestService/OptimalService/requestService');

        $this->menu->addChild('requestServiceTab', 'requestService', 'درخواست خدمات', app::getBaseAppLink('requestService', 'admin'), 'fa fa-briefcase', '',  'admin/requestService/index/requestService');

        $this->menu->addChild('requestServiceTab', 'requestServiceList_Send', 'نمایش خدمات ارسالی', app::getBaseAppLink('requestService/Send_lists', 'admin'), 'fa fa-briefcase', '',  'admin/requestService/Send_lists/requestService');

        $this->menu->addChild('requestServiceTab', 'requestServiceList_Received', 'نمایش خدمات دریافتی', app::getBaseAppLink('requestService/Received_lists', 'admin'), 'fa fa-briefcase', '',  'admin/requestService/Received_lists/requestService');

        $this->menu->addChild('requestServiceTab', 'Consumable_Parts', 'لیست قطعات مصرفی', app::getBaseAppLink('Consumable_Parts', 'admin'), 'fa fa-calendar', '',  'admin/requestService/index/requestService');

    }
}