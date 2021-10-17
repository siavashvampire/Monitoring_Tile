<?php

namespace App\requestService;

use app;
use App\user\app_provider\api\user;
use pluginController;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class hook extends pluginController
{
    public function _adminHeaderNavbar($vars2)
    {
        $this->menu->after('users', 'requestServiceTab', 'درخواست خدمات', "#", 'fa fa-history', '', null, 'admin/RS/index/requestService');
        $this->menu->addChild('requestServiceTab', 'requestServiceAdmin', 'درخواست خدمات جامع', app::getBaseAppLink('RS/adminService', 'admin'), 'fa fa-briefcase', '', 'admin/RS/adminService/requestService');

        $this->menu->addChild('requestServiceTab', 'requestServiceOptimal', 'درخواست خدمات بهینه', app::getBaseAppLink('RS/OptimalService', 'admin'), 'fa fa-briefcase', '', 'admin/RS/OptimalService/requestService');

        $this->menu->addChild('requestServiceTab', 'RS', 'درخواست خدمات', app::getBaseAppLink('RS', 'admin'), 'fa fa-briefcase', '', 'admin/RS/index/requestService');

        $this->menu->addChild('requestServiceTab', 'requestServiceList_Send', 'نمایش خدمات ارسالی', app::getBaseAppLink('RS/Send_lists', 'admin'), 'fa fa-briefcase', '', 'admin/RS/Send_lists/requestService');

        $this->menu->addChild('requestServiceTab', 'requestServiceList_Received', 'نمایش خدمات دریافتی', app::getBaseAppLink('RS/Received_lists', 'admin'), 'fa fa-briefcase', '', 'admin/RS/Received_lists/requestService');

        $this->menu->addChild('requestServiceTab', 'Consumable_Parts', 'لیست قطعات مصرفی', app::getBaseAppLink('Consumable_Parts', 'admin'), 'fa fa-calendar', '', 'admin/RS/index/requestService');

        $this->menu->addChild('Reports', 'RequestexportExcel', 'گزارش گیری خدمات', app::getBaseAppLink('requestService_export', 'admin'), 'fa fa-file-excel-o', '', 'admin/requestService_export/index/requestService');

    }

    public function _settingFooter()
    {
        $getPath = $this->mold->getPath();
        $this->mold->path('default', 'requestService');

        $Groups = user::getGroups()["result"];
        $fieldsOf = [];
        if (is_array($Groups)) {
            foreach ($Groups as $group) {
                $fieldsOf[] = ['name' => $group['name'], 'groupId' => $group['user_groupId']];
            }
        }
        $this->mold->set('listGroups', $fieldsOf);


        $this->mold->view('configuration.system.mold.html');
        $this->mold->path($getPath['folder'], $getPath['app']);
    }
}