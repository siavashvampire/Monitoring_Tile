<?php


namespace App\api\controller;


use app;
use App\core\controller\httpErrorHandler;
use App\user\app_provider\api\user;
use paymentCms\component\cache;
use paymentCms\component\file;
use paymentCms\component\menu\menu;
use paymentCms\component\model;
use paymentCms\component\mold\Mold;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\security;
use paymentCms\component\strings;
use paymentCms\model\api;
use paymentCms\model\configuration;

/**
 * Created by Yeganehha .
 * User: Erfan Ebrahimi (http://ErfanEbrahimi.ir)
 * Date: 3/29/2019
 * Time: 3:52 PM
 * project : paymentCMS
 * virsion : 0.0.0.1
 * update Time : 3/29/2019 - 3:52 PM
 * Discription of this Page :
 */


if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

/**
 * Class innerController
 * @package App\api\controller
 *          [no-access]
 */


class innerController {

	protected static $jsonResponse = null ;
	protected static $api ;
	private static $mold;


	public static function __init(){
		if ( self::$jsonResponse == null ) {
			self::$mold = new Mold();
			self::$mold->offAutoCompile();
			/* @var api $api */
			if (strings::strFirstHas(app::getFullRequestUrl(), app::getBaseAppLink(null, 'api'))) {
				$requestedIp = request::serverOne('REMOTE_ADDR');
				self::$jsonResponse = true;
			} else {
				$requestedIp = 'local';
				self::$jsonResponse = false;
			}
			$api = self::model('api', ["%" . $requestedIp . "%"], ' ( allowIp Like ? or allowIp Like \'%*%\' ) and active = 1');
			if ($api->getApiId() == null) {
				self::jsonError('Access Denied !', 403);
				Response::redirect(App::getBaseAppLink('httpErrorHandler/403', 'core'));
				return false;
			}
			self::$api = $api;
			self::callHooks('apiStartToRun' , []);
		}
		return true ;
	}
	/**
	 * @param null   $model
	 * @param null   $searchVariable
	 * @param string $searchWhereClaus
	 *
	 * @return \App\model\model
	 *                         [no-access]
	 */
	protected static function model($modelName  , $searchVariable = null , $searchWhereClaus = null) {
		if ( is_array($modelName) and count($modelName) == 2 ) {
			$app = $modelName[0];
			$modelName = $modelName[1];
		}
		if ( empty(app::getAppProvider()) and ! isset($app))
			$model = 'App\\'. app::getApp().'\model\\'.$modelName ;
		elseif ( ! isset($app) )
			$model = 'App\\'. app::getAppProvider().'\model\\'.$modelName ;
		elseif ( isset($app))
			$model = 'App\\'.$app.'\model\\'.$modelName ;
		if (class_exists($model)) {
			if ($searchWhereClaus == null) return new $model($searchVariable); else
				return new $model($searchVariable, $searchWhereClaus);
		} else {
			$model = 'paymentCms\model\\' . $modelName;
			if (class_exists($model)) {
				if ($searchWhereClaus == null) return new $model($searchVariable); else
					return new $model($searchVariable, $searchWhereClaus);
			} else {
				httpErrorHandler::E500($model);
				exit;
			}
		}
	}




	protected static function setting($keyWord , $app = null){
		if ( empty(app::getAppProvider()) and ! isset($app))
			$app = app::getApp() ;
		elseif ( ! isset($app) )
			$app = app::getAppProvider() ;
		$data = cache::get( 'configurationTemp',$keyWord,  $app);
		if ( $data != null )
			return $data;

		/* @var configuration $model */
		$model = self::model('configuration' , [$keyWord,$app]);
		if ( $model->getValue() == null )
			return null ;
		if ( cache::hasLifeTime('configurationTemp' ,$app))
			cache::update('configurationTemp' ,$model->getKeyWord() , $model->getValue() , 30*24*60*60 , $app);
		else
			cache::save([$model->getKeyWord()=> $model->getValue() ] , 'configurationTemp',30*24*60*60 , $app);
		return $model->getValue();
	}

	/**
	 * @param       $hookName
	 * @param array $variable
	 *
	 * @param null  $app
	 *
	 * @return array
	 */
	protected static function callHooks($hookName,$variable = [] , $app = null){
		$files = [];
		$appsActives = cache::get('appStatus', null  ,'paymentCms');
		if ( is_array($appsActives) and ! empty($appsActives) ) {
			foreach ($appsActives as $appName => $appStatus) {
				if ($appStatus == 'active') {
					if ( $app == null or $appName == $app ) {
						if (is_file(payment_path . 'app' . DIRECTORY_SEPARATOR . $appName . DIRECTORY_SEPARATOR . 'hook.php')) {
							$files[] = ['aria' => 'app', 'controller' => $appName];
						}
					}
				}
			}
		}
		$pluginSActives = cache::get('pluginStatus', null  ,'paymentCms');
		if ( is_array($pluginSActives) and ! empty($pluginSActives) ) {
			foreach ($pluginSActives as $pluginName => $pluginStatus) {
				if ($pluginStatus == 'active') {
					if ( $app == null or $pluginName == $app ) {
						if (is_file(payment_path . 'plugins' . DIRECTORY_SEPARATOR . $pluginName . DIRECTORY_SEPARATOR . 'hook.php')) {
							$files[] = ['aria' => 'plugin', 'controller' => $pluginName];
						}
					}
				}
			}
		}
		$menu = new menu('api');
		$return = [] ;
		foreach ($files as $file) {
			$controller = $file['controller'];
			$aria = $file['aria'] ;
			$class = $aria.'\\'.$controller.'\hook';
			$method = '_'.$hookName;
			if ( method_exists($class,$method) ){
				/* @var Mold $mold */
				$mold = self::$mold;
				if ( $aria == 'plugin')
					$mold->path(null,$controller.':plugin');
				else
					$mold->path(null,$controller);
				$Object = new $class($mold,$menu);
				$return[$controller] = call_user_func_array([$Object,$method],$variable);
			}
		}
		return $return ;
	}


	protected static function jsonError($massage = null , $statusCode = 400){
		if ( self::$jsonResponse and ( ! isset($_SERVER['JsonOff']) and ! isset($_SERVER['JsonOffMultiCall'])))
			Response::jsonError($massage,$statusCode);
		return ['status'=> false , 'massage' => $massage ] ;
	}

	protected static function json($result){
		if ( self::$jsonResponse and ( ! isset($_SERVER['JsonOff']) and ! isset($_SERVER['JsonOffMultiCall'])))
			Response::json($result);
		return ['status'=> true , 'result' => $result ] ;
	}

	protected static function pagination($numberOfAll, $page, $perEachPage) {
		$total = ceil($numberOfAll / $perEachPage ) ;
		if ( $page > $total ) $page = $total ;
		if ( $page < 1 ) $page = 1 ;
		return ['start' => ($page -1 ) * $perEachPage , 'limit' => $perEachPage , 'total' => $total ,'perEachPage' => $perEachPage , 'currentPage' => $page];
	}

	/**\
	 * @return array |\paymentCms\model\user
	*/
	protected static function getUserApiFromToken() {
		$token = request::serverOne('HTTP_TOKEN');
		$token = ( $token == null ) ? '--' : $token;
		$userIds = security::getIdFromToken($token);
		if ( $userIds === false )
			return self::jsonError(rlang('accessDenied'),400);

		$userObject = user::getUserById($userIds['session']);
		if ( $userObject->getBlock() ){
			return self::jsonError(rlang('accessDenied'),400);
		}
		return $userObject;
	}

	protected function getRealIp(){
		if(!empty(request::serverOne('HTTP_CLIENT_IP'))){
			//ip from share internet
			$ip = request::serverOne('HTTP_CLIENT_IP');
		}elseif(!empty( request::serverOne('HTTP_X_FORWARDED_FOR') )){
			//ip pass from proxy
			$ip = request::serverOne('HTTP_X_FORWARDED_FOR');
		}else{
			$ip = request::serverOne('REMOTE_ADDR');
		}
		return $ip;
	}
}