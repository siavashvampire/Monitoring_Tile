<?php


namespace App\core;

use app;
use paymentCms\component\cookie;
use paymentCms\component\request;
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
	private function __adminHeaderNavbar(){
		$this->mold->set('adminArea' , true);

        $this->menu->add('Reports', 'گزارش ها', "#", 'fa fa-file-excel-o', '', null, 'admin/export/Merge/LineMonitoring');
        $this->menu->after('Reports', 'alllogs', 'لاگ ها', "#", 'fa fa-history', '', null, 'admin/sensorlog/index/LineMonitoring');
        $this->menu->after('alllogs', 'configurationLine', 'تنظیمات خط تولید', "#", 'fa fa-cogs', '', null, 'admin/sensor/index/LineMonitoring');
        $this->menu->after('configurationLine', 'configurationManufactor', 'تنظیمات کارخانه', "#", 'fa fa-building-o ', '', null, 'admin/off_sensor_reasons/lists/LineMonitoring');

        $this->menu->add('plugins' , rlang('plugins' ) , app::getBaseAppLink('plugins/lists') , 'fa fa-puzzle-piece' ,'',null,'admin/plugins/lists');
		$this->menu->add('configuration' , rlang('configuration' ) , app::getBaseAppLink('configuration') , 'fa fa-cogs' ,'',null,'admin/configuration/index/core');
		if ( ! copyRightHidden )
			$this->menu->add('developer' , rlang('developer' ) , app::getBaseAppLink('developer') , 'fa fa-code');
		$this->menu->addChild('configuration' ,'configurations', rlang('configuration' ) , app::getBaseAppLink('configuration/core','admin') , 'fa fa-cogs' ,'','admin/configuration/core/core');
		$this->menu->addChild('configuration' ,'uniqueLinks', rlang('uniqueLinks' ) , app::getBaseAppLink('linksConfiguration','admin') , 'fa fa-link' ,'','admin/linksConfiguration/index/core');
//		$this->menu->addChild('configuration' ,'languages', rlang('languages' ) , \app::getBaseAppLink('languages','admin') , 'fa fa-language' ,'','admin/languages/index/core');

    }

	public function _controllerStartToRun(){
		if ( request::isGet('comeFromPuzzleyApp')){
			if ( request::getOne('comeFromPuzzleyApp',false) == 'true'){
				cookie::set('isFromApp','yes',365*24*60);
				$this->mold->set('isFromApp',true);
			}
		}
		if ( cookie::get('isFromApp') == 'yes'){
			cookie::set('isFromApp','yes',365*24*60);
			$this->mold->set('isFromApp',true);
		}

		$this->menu->add('dashboard', rlang('dashboard'), app::getBaseAppLink(), 'fa fa-home');
		if ( app::getApp() == 'admin' or app::getAppProvider() == 'admin' ) {
			//		$menu->add('otherFields' , rlang('fields' ) , app::getBaseAppLink('field/lists') , 'fa fa-wpforms' );
			$this->__adminHeaderNavbar();
			parent::callHooks('adminHeaderNavbar' , [1],null,$this->mold , $this->menu);
		} elseif ( app::getApp() == 'user' or app::getAppProvider() == 'user' ) {
			$this->menu->add('dashboard', rlang('dashboard'), app::getBaseAppLink(), 'fa fa-home');
			$this->menu->add('logout' , 'خروج' , app::getBaseAppLink('access/logout' , 'user') ,'mdi mdi-lock');
			parent::callHooks('clientMenu' , [],null,$this->mold , $this->menu );
		} elseif ( app::getApp() == 'home' or app::getAppProvider() == 'home' ) {
			$this->menu->add('dashboard', rlang('dashboard'), app::getBaseAppLink(), 'fa fa-home');
			parent::callHooks('homeMenu' , [] ,null,$this->mold , $this->menu);
		}

		parent::callHooks('userLoginDetails' , [],null,$this->mold , $this->menu );
	}
}