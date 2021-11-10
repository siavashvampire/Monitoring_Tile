<?php
namespace App\shiftWork ;

use app;
use pluginController;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class hook extends pluginController {
	public function _adminHeaderNavbar($vars2){
        $this->menu->after('users', 'shiftWork', 'شیفت‌های کاری', app::getBaseAppLink('shiftWork', 'admin'), 'fa fa-calendar', '',  null,'admin/shiftWork/index/shiftWork');
    }
    public function _logField(){
	    return [["value" => "Shifts" , "label" => "تغییرات شیفت ها"]];
    }
}
