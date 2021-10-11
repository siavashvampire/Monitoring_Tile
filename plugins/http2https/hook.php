<?php


namespace plugin\http2https;


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
		$firstUrl = $requestUrl = app::getFullRequestUrl();
		$http2https = $this->setting('http2https' , 'http2https');
		$www2ww = $this->setting('www2ww' , 'http2https');
		if ( $http2https == rlang('http2https') )
			$requestUrl = str_replace('http://' , 'https://' , $requestUrl );
		elseif ($http2https == rlang('https2http') )
			$requestUrl = str_replace('https://' , 'http://' , $requestUrl );

		if ( $www2ww == rlang('www2ww') )
			$requestUrl = str_replace(['http://www.','https://www.'] , ['http://','https://'] , $requestUrl );
		elseif ( $www2ww == rlang('ww2www') and ( substr($requestUrl,0,11) != 'http://www.' and  substr($requestUrl,0,12) != 'https://www.' ) )
			$requestUrl = str_replace(['http://','https://'] , ['http://www.','https://www.'] , $requestUrl );

		if ( $requestUrl != $firstUrl )
			Response::redirect($requestUrl);

		return true ;
	}

}