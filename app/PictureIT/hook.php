<?php
namespace App\PictureIT ;

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
        $this->menu->after('users' ,'Devices', rlang('Devices') , app::getBaseAppLink('Device/List','admin') , 'fa fa-history' ,'',null,'admin/Device/index/PictureIT');
        $this->menu->after('Devices' ,'quotes', rlang('quotes') , app::getBaseAppLink('quotes/List','admin') , 'fa fa-history' ,'',null,'admin/quotes/index/PictureIT');
	}
}