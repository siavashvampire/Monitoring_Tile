<?php


namespace App\core\app_provider\admin;


use app;
use controller;
use paymentCms\component\cache;
use paymentCms\component\model;
use paymentCms\component\request;
use paymentCms\component\Response;
use paymentCms\component\strings;
use paymentCms\component\validate;
use paymentCms\model\api;
use paymentCms\model\apps_link;
use paymentCms\model\invoice;

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


class configuration extends controller {
	public function index($app = 'core' , $action = null){
		if ( $app == '' ) $app = 'core';
		if ( $action == 'editDone')
			$this->alert('success', null,rlang(['edit','successfully','was']));
		$apps = app::appsList();
		$plugins = app::pluginsList();
		if ( is_array($plugins) ){
			$apps = array_merge($apps,array_map(function($value) { return 'plugin_'.$value; }, $plugins));
		}

		/* @var apps_link $model */
		$model = parent::model('configuration' );
		$valuesDb = $model->search($apps,'app in ( '.substr(str_repeat(', ? ' , count($apps)),1).' ) ');
		$values = [];
		if ( is_array($valuesDb) ){
			foreach ($valuesDb as $key => $record ){
				$values[$record['app']][ $record['keyWord'] ] = $record['value'];
			}
		}

		$this->mold->set('appShow' , $app);
		$appsList= [];
		foreach ($apps as $app ){
			if ( strings::strFirstHas($app,'plugin_') )
				$appsInfo =  require (payment_path.'plugins'.DIRECTORY_SEPARATOR.substr($app,7).DIRECTORY_SEPARATOR.'info.php');
			else
				$appsInfo =  require (payment_path.'app'.DIRECTORY_SEPARATOR.$app.DIRECTORY_SEPARATOR.'info.php');
			if ( isset($appsInfo['configuration']) and $appsInfo['configuration'] != null ) {
				$appsList[$app]['name'] = $appsInfo['info']['name'];
				$appsList[$app]['customField'] = $appsInfo['configuration'];
			}
		}
		$this->mold->set('values' , $values);
		$this->mold->set('apps' , $appsList);
		$this->mold->path('default', 'core');
		$this->mold->view('configuration.mold.html');
		$this->mold->set('activeMenu' , 'configurations');
		$this->mold->setPageTitle(rlang('configuration'));
		$this->callHooks('settingFooter');
	}

	public function edit($app){
		/* @var \paymentCms\model\configuration $model */
		$model = parent::model('configuration' );
		model::transaction();
		$model->deleteApp($app);
		$model->setApp($app);
		$form = request::post('setting');
		if ( is_array($form['setting']) ){
			foreach ($form['setting'] as $keyWord => $value ){
				$model->setKeyWord($keyWord);
				if ( is_array($value) ){
					$value = implode(',',$value);
				}
				$model->setValue($value);
				$result = $model->insertToDataBase();
				if ( $result == false ){
					model::rollback();
					$this->alert('danger' ,'' , rlang('cantUpdateSetting'));
					$this->index($app);
					return false;
				}
			}
		}
		model::commit();
		$this->clearCache($app);
		$this->index($app,'editDone');
		return true;
	}



	private function clearCache($app){
		if ( strings::strFirstHas($app,'plugin_'))
			return cache::clear('configurationTemp' , substr($app,7).':plugin');
		return cache::clear( 'configurationTemp',  $app);
	}

}