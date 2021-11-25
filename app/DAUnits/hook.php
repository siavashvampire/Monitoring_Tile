<?php
namespace App\DAUnits ;

use app;
use paymentCms\component\cache;
use pluginController;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class hook extends pluginController {
	public function _adminHeaderNavbar($vars2){
        $this->menu->addChild('configurationLine' ,'DAUnitsList', rlang('DAUnits') , app::getBaseAppLink('DAUnits/List','admin') , 'fa fa-info' ,'','admin/DAUnits/index/DAUnits');
    }
    public function _should_update()
    {
        $should_update = array();

        $data = cache::get('is_DAUnits_update', null, 'DAUnits');

        if ($data !== 'yes')
            $should_update[] = "DAUnits";

        if (count($should_update) == 0)
            return null;

        return $should_update;
    }
}