<?php
namespace App\contacts ;

use app;
use pluginController;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class hook extends pluginController {
	public function _adminHeaderNavbar($vars2){
        $this->menu->after('users' ,'contacts', rlang('contacts') , app::getBaseAppLink('contacts','admin') , 'fa fa-history' ,'',null,'admin/contacts/index/contacts');
        $this->menu->after('contacts' ,'contactsList', rlang('contactsList') , app::getBaseAppLink('contacts/List','admin') , 'fa fa-history' ,'',null,'admin/contacts/index/contacts');
    }
    public function _should_update()
    {
        $should_update = array();

//        $data = cache::get('isSubstation', null, 'ElectricalSubstation');
//
//        if ($data !== 'yes')
//            $should_update[] = "TileKindUpdate";

        if (count($should_update) == 0)
            return null;

        return $should_update;
    }
}