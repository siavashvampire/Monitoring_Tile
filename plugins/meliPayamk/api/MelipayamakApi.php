<?php
namespace plugin\meliPayamk\api;

class MelipayamakApi
{

	protected $username;

	protected $password;

	private $namespace = 'plugin\meliPayamk\api\\';

	public function __construct($username,$password)
	{


		if (is_null($username)||is_null($password)) {

			die('username/password is empty');

			exit;

		}

		$this->username = $username;

		$this->password = $password;

	}

	public function __call($name,$arguments)
	{

		$method = 'rest';
		$class = $this->namespace.ucfirst($name);
		$type = '';

		if($name == 'sms') {

			if(isset($arguments[0])) {
				if($arguments[0] == 'soap')
					$method = 'soap';
				else if($arguments[0] == 'async')
					$type = 'async';
			}

			if(isset($arguments[1])){
				if($arguments[1] == 'async')
					$type = 'async';
			}

			$class .= ucfirst($method);
			$class .= ucfirst($type);
		}
		else if(isset($arguments[0])) {
			$class .= ucfirst('async');
		}

		if(class_exists($class )){
			$test =  new $class($this->username,$this->password);
			return $test;
		}

	}

}
