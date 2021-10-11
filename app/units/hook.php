<?php
namespace App\units ;

use app;
use pluginController;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class hook extends pluginController {
	public function _adminHeaderNavbar($vars2){
//        $this->menu->addChild('configurationManufactor', 'Units', 'واحد‌های کارخانه', app::getBaseAppLink('units', 'admin'), 'fa fa-columns', '',  'admin/units/index/units');
        $this->menu->after('users', 'Units', 'واحد‌های کارخانه', app::getBaseAppLink('units', 'admin'), 'fa fa-columns', '',  null,'admin/units/index/units');

    }
}