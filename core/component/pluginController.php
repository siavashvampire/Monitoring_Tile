<?php
/**
 * Created by Yeganehha .
 * User: Erfan Ebrahimi (http://ErfanEbrahimi.ir)
 * Date: 3/24/2019
 * Time: 7:58 PM
 * project : paymentCMS
 * version : 0.0.0.1
 * update Time : 3/24/2019 - 7:58 PM
 * Description of this Page :
 */

use App\model\model;
use paymentCms\component\cache;
use paymentCms\component\menu\menu;
use paymentCms\component\mold\Mold;
use paymentCms\model\configuration;

if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');


class pluginController {

	protected $model ;
	protected $mold ;
	protected $menu ;

	public function __construct(&$mold,&$menu = null) {
		/* @var  paymentCms\component\mold\mold $mold */
		/* @var  paymentCms\component\menu\menu $menu */
		$this->mold = $mold;
		$this->menu = $menu;
	}

	protected function creatView(){
		$mold = new Mold();
		$mold->path('');
		$mold->cache(10);
		$mold->offAutoCompile();
		$mold->set('direction' , 'rtl');
		$mold->set('text_align' , 'right');
		$mold->set('float' , 'right');
		return $mold ;
	}



	protected function setting($keyWord , $plugin ,$isHook = false ){
		$data = cache::get( 'configurationTemp',$keyWord,  $plugin.(($isHook) ? '' : ':plugin'));
		if ( $data != null )
			return $data;

		/* @var configuration $model */
		$model = $this->model('configuration' , [$keyWord,(($isHook) ? '' : 'plugin_').$plugin]);
		if ( $model->getValue() == null )
			return null ;
		if ( cache::hasLifeTime('configurationTemp' ,$plugin.(($isHook) ? '' : ':plugin')))
			cache::update('configurationTemp' ,$model->getKeyWord() , $model->getValue() , 30*24*60*60 , $plugin.(($isHook) ? '' : ':plugin'));
		else
			cache::save([$model->getKeyWord()=> $model->getValue() ] , 'configurationTemp',30*24*60*60 , $plugin.(($isHook) ? '' : ':plugin'));
		return $model->getValue();
	}

	/**
	 * @param null   $model
	 * @param null   $searchVariable
	 * @param string $searchWhereClaus
	 *
	 * @return model
	 */
	protected function model($modelName = null , $searchVariable = null , $searchWhereClaus = null) {
		if ( is_array($modelName) and count($modelName) == 2 ) {
			$app = $modelName[0];
			$modelName = $modelName[1];
		}
		if ( $modelName == null )
			$modelName = $this->model;
		if ( empty(app::getAppProvider()) and ! isset($app))
			$model = 'App\\'. app::getApp().'\model\\'.$modelName ;
		elseif ( ! isset($app) )
			$model = 'App\\'. app::getAppProvider().'\model\\'.$modelName ;
		elseif ( isset($app))
			$model = 'App\\'.$app.'\model\\'.$modelName ;

		if (class_exists($model)) {
			if ( $searchWhereClaus == null )
				return new $model($searchVariable) ;
			else
				return new $model($searchVariable,$searchWhereClaus) ;
		} else {
			$model = 'paymentCms\model\\'.$modelName ;
			if (class_exists($model)) {
				if ( $searchWhereClaus == null )
					return new $model($searchVariable) ;
				else
					return new $model($searchVariable,$searchWhereClaus) ;
			} else {
				App\core\controller\httpErrorHandler::E500($model);
				exit;
			}
		}
	}


	/**
	 * @param       $hookName
	 * @param array $variable
	 *
	 * @param null  $app
	 *
	 * @return array
	 */
	protected static function callHooks($hookName,$variable = [] , $app = null , &$mold = null, &$menu = null){
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
		if ( $menu == null )
			$menu = new menu('plugins');
		$return = [] ;
		foreach ($files as $file) {
			$controller = $file['controller'];
			$aria = $file['aria'] ;
			$class = $aria.'\\'.$controller.'\hook';
			$method = '_'.$hookName;
			if ( method_exists($class,$method) ){
				/* @var Mold $mold */
				if ( $mold == null )
					$mold = new Mold();
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

}