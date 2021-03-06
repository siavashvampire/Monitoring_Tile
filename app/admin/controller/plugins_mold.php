<?php


namespace App\admin\controller;


use App;
use paymentCms\component\cache;

/**
 * Created by Yeganehha .
 * User: Erfan Ebrahimi (http://ErfanEbrahimi.ir)
 * Date: 5/14/2019
 * Time: 11:43 PM
 * project : paymentCMS
 * virsion : 0.0.0.1
 * update Time : 5/14/2019 - 11:43 PM
 * Discription of this Page :
 */


if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

/**
 * Class plugins_mold
 * @package App\admin\controller
 *          [no-access]
 */
class plugins_mold {

	public function isAppActive($app,$version){
		$appStatus = cache::get('appStatus', $app  ,'paymentCms');
		if ( $appStatus == null ){
			return 'notInstallYet';
		} else {
			$info = App::appsListWithConfig($app);
			$appVersion = $info[$app]['version'];
			if ( version_compare($appVersion, $version, ">=") )
				return 'updated';
			else
				return 'needUpDate';
		}
	}
}