<?php
namespace App\log ;

use App;
use App\log\model\log;
use App\user\app_provider\api\user;
use paymentCms\component\request;
use pluginController;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

class hook extends pluginController {

	public function _adminHeaderNavbar($vars2){
		$this->menu->addChild('Reports' ,'logs', rlang('logs' ) , app::getBaseAppLink('logs','admin') , 'fa fa-history' ,'','admin/logs/index/log');
    }

	public function _controllerStartToRun(){
		/* @var log $log */
		$log = $this->model(['log','log']);
		$log->setMethod(App::getMethod());
		$log->setAppProvider(App::getAppProvider());
		$log->setApp(App::getApp());
		$log->setController(App::getController());
		$log->setCurrentUrl(App::getFullRequestUrl());
		$log->setPreviousPage( request::serverOne('HTTP_REFERER','-'));
		$log->setLogName('view_webSite_page');
		$log->setDescription(rlang('view_webSite_page'));
		$userId = user::getUserLogin(true);
		$log->setUserId( $userId !== false ? $userId : null );
		$log->setBrowser();
		$log->setIp();
		$log->setActivityTime();
		$log->insertToDataBase();
	}



	public function _addLog($description , $log_name){
		/* @var log $log */
		$log = $this->model(['log','log']);
		$log->setMethod(App::getMethod());
		$log->setAppProvider(App::getAppProvider());
		$log->setApp(App::getApp());
		$log->setController(App::getController());
		$log->setCurrentUrl(App::getFullRequestUrl());
		$log->setPreviousPage( request::serverOne('HTTP_REFERER','-'));
		$log->setLogName($log_name);
		$log->setDescription($description);
		$userId = user::getUserLogin(true);
		$log->setUserId( $userId !== false ? $userId : null );
		$log->setBrowser();
		$log->setIp();
		$log->setActivityTime();
		$log->insertToDataBase();
	}
    public function _logField(): array
    {
        return [["value" => "view_webSite_page" , "label" => "نمایش صفحاتی که بازدید شده"]];
    }


}