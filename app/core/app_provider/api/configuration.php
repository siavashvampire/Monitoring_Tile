<?php


namespace App\core\app_provider\api;


use app;
use App\api\controller\innerController;
use paymentCms\component\cache;
use paymentCms\component\strings;


/**
 * Created by Yeganehha .
 * User: Erfan Ebrahimi (http://ErfanEbrahimi.ir)
 * Date: 3/24/2019
 * Time: 10:15 AM
 * project : paymentCMS
 * virsion : 0.0.0.1
 * update Time : 3/24/2019 - 10:15 AM
 * Discription of this Page :
 */


if (!defined('paymentCMS')) die('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css"><div class="container" style="margin-top: 20px;"><div id="msg_1" class="alert alert-danger"><strong>Error!</strong> Please do not set the url manually !! </div></div>');

/**
 * Class configuration
 * @package App\core\app_provider\api
 *          [no-access]
 */
class configuration extends innerController {

	/**
	 * @param      $name
	 * @param      $value
	 * @param null $app
	 *                 [no-access]
	 *
	 * @return bool
	 */
	public static function set($name , $value , $app = null ) {
		if ( empty(app::getAppProvider()) and ! isset($app))
			$app = app::getApp() ;
		elseif ( ! isset($app) )
			$app = app::getAppProvider() ;

		/* @var \paymentCms\model\configuration $model */
		$model = parent::model('configuration', [$name, $app]);
		if ($model->getKeyWord() == $name) {
			if ($value == null) {
				$result = $model->deleteFromDataBase();
			} else {
				$result = $model->upDateDataBase();
			}
		} else {
			if ($value != null) {
				$result = $model->insertToDataBase();
			} else
				$result = true;
		}
		if ($result) {
			self::clearCache($app);
			return true;
		} else
			return false;
	}

	public static function get($keyWord , $app = null){
		if ( empty(app::getAppProvider()) and ! isset($app))
			$app = app::getApp() ;
		elseif ( ! isset($app) )
			$app = app::getAppProvider() ;
		$data = cache::get( 'configurationTemp',$keyWord,  $app);
		if ( $data != null )
			return $data;

		/* @var \paymentCms\model\configuration $model */
		$model = parent::model('configuration' , [$keyWord,$app]);
		if ( $model->getValue() == null )
			return null ;
		if ( cache::hasLifeTime('configurationTemp' ,$app))
			cache::update('configurationTemp' ,$model->getKeyWord() , $model->getValue() , 30*24*60*60 , $app);
		else
			cache::save([$model->getKeyWord()=> $model->getValue() ] , 'configurationTemp',30*24*60*60 , $app);
		return $model->getValue();
	}

	private static function clearCache($app){
		if ( strings::strFirstHas($app,'plugin_'))
			return cache::clear('configurationTemp' , substr($app,7).':plugin');
		return cache::clear( 'configurationTemp',  $app);
	}

}