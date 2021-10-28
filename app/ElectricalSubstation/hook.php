<?php

namespace App\ElectricalSubstation;

use app;
use App\core\controller\fieldService;
use App\ElectricalSubstation\app_provider\api\electrical;
use App\LineMonitoring\model\data;
use App\user\app_provider\api\user;
use paymentCms\component\cache;
use paymentCms\component\file;
use paymentCms\component\model;
use pluginController;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class hook extends pluginController
{
    public function _adminHeaderNavbar($vars2)
    {
        $this->menu->after('users', 'Substation', rlang('Substations'), app::getBaseAppLink('Substation/List', 'admin'), 'fa fa-history', '', null, 'admin/Substation/index/ElectricalSubstation');
    }

    public function _should_update()
    {
        $should_update = array();

        $data = cache::get('isSubstation', null, 'ElectricalSubstation');

        if ($data !== 'yes')
            $should_update[] = "Substation";

        if (count($should_update) == 0)
            return null;

        return $should_update;
    }

    public function _need_plc()
    {
        return (electrical::SubstationForDAUnits()["result"]);
    }
}