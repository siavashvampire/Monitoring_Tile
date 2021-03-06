<?php


namespace App\invoice;

use app;
use pluginController;

/**
 * Created by Yeganehha .
 * User: Erfan Ebrahimi (http://ErfanEbrahimi.ir)
 * Date: 4/16/2019
 * Time: 11:16 AM
 * project : paymentCMS
 * virsion : 0.0.0.1
 * update Time : 4/16/2019 - 11:16 AM
 * Discription of this Page :
 */




if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');


class hook extends pluginController {

	public function _adminHeaderNavbar($vars2){
		$this->menu->after('dashboard','invoices' , rlang('invoices' ) , app::getBaseAppLink('invoices/lists' ,'admin') , 'fa fa-file-text-o' );
		$this->menu->addChild('invoices' , 'allinvoices' , rlang('invoices' ) , app::getBaseAppLink('invoices/lists' ,'admin')  );
		$this->menu->add('paidinvoices' , rlang(['invoicesOf','success'] ) , app::getBaseAppLink('invoices/lists/paid' ,'admin') ,null,null,'invoices' );
		$this->menu->add('failedinvoices' , rlang(['invoicesOf','fail'] ) , app::getBaseAppLink('invoices/lists/failed' ,'admin') ,null,null,'invoices' );
		$this->menu->add('pendinginvoices' , rlang(['invoicesOf','pending'] ) , app::getBaseAppLink('invoices/lists/pending' ,'admin') ,null,null,'invoices' );
		//$this->menu->after('invoices','services' , rlang('services' ) , \app::getBaseAppLink('service/lists','admin') , 'fa fa-shopping-cart' );

	}

	public function _clientMenu(){
		$this->menu->before('logout','invoices' , rlang('invoices' ) , app::getBaseAppLink('invoices/lists' ,'user') ,'mdi mdi-credit-card-multiple' );
	}
}