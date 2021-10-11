<?php
namespace App\weighbridge ;

use app;
use App\core\controller\fieldService;
use App\LineMonitoring\model\data;
use App\user\app_provider\api\user;
use paymentCms\component\cache;
use paymentCms\component\file;
use paymentCms\component\model;
use pluginController;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class hook extends pluginController {
	public function _adminHeaderNavbar($vars2){
        $this->menu->after('users' ,'Truck', rlang('Truck') , app::getBaseAppLink('Truck/List','admin') , 'fa fa-history' ,'',null,'admin/Truck/index/weighbridge');
        $this->menu->after('Truck' ,'Truck_Kind', rlang('Truck_Kind') , app::getBaseAppLink('Truck_Kind/List','admin') , 'fa fa-history' ,'',null,'admin/Truck_Kind/index/weighbridge');
        $this->menu->after('Truck' ,'customer', rlang('customer') , app::getBaseAppLink('customer/List','admin') , 'fa fa-history' ,'',null,'admin/customer/index/weighbridge');
	}
}