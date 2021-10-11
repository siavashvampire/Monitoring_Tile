<?php

namespace paymentCms\component\mold;

use paymentCms\component\cache;
use paymentCms\component\menu\menu;
use paymentCms\component\session;

/**
 * Created by Yeganehha .
 * User: Erfan Ebrahimi (http://ErfanEbrahimi.ir)
 * Date: 3/23/2019
 * Time: 12:48 PM
 * project : paymentCms
 * virsion : 0.0.0.1
 * update Time : 3/23/2019 - 12:48 PM
 * Discription of this Page :
 */

class MoldData {

	private $data = [] ;
	private $moldBlock = [] ;
	public function __construct() {

	}

	public function reset(){
		$this->data = [] ;
	}
	public function setMoldData($moldVersion){
//		$session = session::get();
		$session = [];
		$this->set('Mold' , [
			'now' => time() ,
			'get' => $_GET ,
			'post' => $_POST ,
			'cookies' => $_COOKIE ,
			'server' => $_SERVER ,
			'session' => $session ,
			'version' => $moldVersion ,
		]);
	}
	private function validateName($name){
		return  str_replace(['\\','/','~','.','-','>','<','$',' ','*','+','!','@','#','%','^','&','(',')','{',',','}','[',']',';','\'','"'] , '_' , $name );
	}

	public function set(){
		// get number of parameter that call with this method.
		$numberOfParameterCallWithMethod = func_num_args();

		// get all parameters that call with this method.
		$ParametersCallWithMethod = func_get_args();

		// check user call multi set or set with number of variable to set.
		if ( $numberOfParameterCallWithMethod == 2) {

			if ( is_string($ParametersCallWithMethod[0]) and strlen($ParametersCallWithMethod[0]) > 0 )
				// push new variable to data stack or edit exist variable in stack
				$this->data[ $this->validateName($ParametersCallWithMethod[0]) ] =  $ParametersCallWithMethod[1];

		} else {

			// check is multi variable
			if (is_array( $ParametersCallWithMethod[0] )) {

				// push each new variable to data stack or edit exist variable in stack
				foreach ($ParametersCallWithMethod[0] as $variableName => $value) {
					if ( is_string($variableName)  and strlen($variableName) > 0  )
						$this->data[ $this->validateName($variableName) ] = $value;
				}
			}
		}
	}

	public function remove() {
		$ParametersCallWithMethod = func_get_args();
		if (is_array( $ParametersCallWithMethod )  && count($ParametersCallWithMethod) > 1 ) {
			foreach ($ParametersCallWithMethod as $keyIndex => $key) {
				$key = $this->validateName($key);
				if ( is_string($key)  and strlen($key) > 0  )
					if ( isset($this->data[$key] ) )
						unset($this->data[$key]);
			}
		} elseif ( is_array( $ParametersCallWithMethod ) && count($ParametersCallWithMethod) == 1  )  {
			$ParametersCallWithMethod[0] = $this->validateName($ParametersCallWithMethod[0]);
			if ( is_string($ParametersCallWithMethod[0])  and strlen($ParametersCallWithMethod[0]) > 0  )
				if ( isset($this->data[$ParametersCallWithMethod[0]] ) )
					unset($this->data[$ParametersCallWithMethod[0]]);
		}

	}

	public function get() {
		$returnData = null ;
		$ParametersCallWithMethod = func_get_args();
		if (is_array( $ParametersCallWithMethod ) && count($ParametersCallWithMethod) > 1 ) {
			foreach ($ParametersCallWithMethod as $keyIndex => $key) {
				$key = $this->validateName($key);
				if ( is_string($key)  and strlen($key) > 0  )
					if ( isset($this->data[$key] ) )
						$returnData[$key] = $this->data[$key];
			}
		} elseif ( is_array( $ParametersCallWithMethod ) && count($ParametersCallWithMethod) == 1  )  {
			$ParametersCallWithMethod[0] = $this->validateName($ParametersCallWithMethod[0]);
			if ( is_string($ParametersCallWithMethod[0])  and strlen($ParametersCallWithMethod[0]) > 0  )
				if ( isset($this->data[$ParametersCallWithMethod[0]] ) )
					$returnData = $this->data[$ParametersCallWithMethod[0]];
		} elseif ( $ParametersCallWithMethod == null ) {
			$returnData = $this->data;
		}
		return $returnData ;
	}

	public function d() {
		return $this->data;
	}

	public function setMoldBlock($name , $data) {
		$this->moldBlock[$name][] =  $data;
	}


	public function getMoldBlock($name ) {
		return ( count($this->moldBlock[$name])  > 0 ? $this->moldBlock[$name] : array() ) ;
	}

	public function CallUserFunction($class,$method,$data){
		if ( class_exists($class) ){
			$object = new $class();
			if ( method_exists($object,$method) and is_callable([$object,$method])){
				return call_user_func_array([$object,$method],$data);
			}
		}
		return 'Function Error!';
	}

	public function CallHook($appName,$hookName,$variable){
		$appsActives = cache::get('appStatus', $appName  ,'paymentCms');
		if ( $appsActives == 'active') {
			if (is_file(payment_path . 'app' . DIRECTORY_SEPARATOR . $appName . DIRECTORY_SEPARATOR . 'hook.php')) {
				$file = ['aria' => 'app', 'controller' => $appName];
			}
		}
		$pluginSActives = cache::get('pluginStatus', $appName  ,'paymentCms');
		if ($pluginSActives == 'active') {
			if (is_file(payment_path . 'plugins' . DIRECTORY_SEPARATOR . $appName . DIRECTORY_SEPARATOR . 'hook.php')) {
				$file = ['aria' => 'plugin', 'controller' => $appName];
			}
		}

		$menu = new menu('temp');
		$controller = $file['controller'];
		$aria = $file['aria'] ;
		$class = $aria.'\\'.$controller.'\hook';
		$method = '_'.$hookName;
		if ( method_exists($class,$method) ){
			/* @var Mold $mold */
			$mold = $this;
			$Object = new $class($mold,$menu);
			return call_user_func_array([$Object,$method],$variable);
		}
		return 'Function Error!';
	}
}