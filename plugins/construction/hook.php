<?php


namespace plugin\construction;


use app;
use App\invoice\app_provider\api\invoice;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\model\configuration;
use pluginController;
use function Sodium\increment;

/**
 * Created by Yeganehha .
 * User: Erfan Ebrahimi (http://ErfanEbrahimi.ir)
 * Date: 3/26/2019
 * Time: 3:20 PM
 * project : paymentCMS
 * virsion : 0.0.0.1
 * update Time : 3/26/2019 - 3:20 PM
 * Discription of this Page :
 */


if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');


class hook extends pluginController {


	public function _controllerStartToRun(){
		$constructionIsActive = $this->setting('constructionIsActive' , 'construction');
		if ( $constructionIsActive == rlang('yes') ){
			$requestUrl = $requestUrl = app::getFullRequestUrl();
			$constructionLink = $this->setting('constructionLink' , 'construction');
			$constructionCookie = $this->setting('constructionCookie' , 'construction');
			$constructionIsActiveDebug = $this->setting('constructionIsActiveDebug' , 'construction');
			if ( ! isset($_COOKIE[$constructionCookie]) ){
				if ( $requestUrl != $constructionLink) {
					Response::redirect($constructionLink);
				} else {
					if ( $constructionIsActiveDebug == rlang('required') ){
						error_reporting(0);
						ini_set('display_startup_errors', 0);
						ini_set('display_errors', false);
					}
				}
			}
		}
		return true ;
	}

}