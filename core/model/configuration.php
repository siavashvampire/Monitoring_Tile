<?php 



// *************************************************************************
// *                                                                       *
// * TableClass - The Complete Table To Class PHP Function                 *
// * Copyright (c) Erfan Ebrahimi. All Rights Reserved,                    *
// * BuildId: 1                                                            *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * website: https://paymentcms.ir - https://erfanebrahimi.ir             *
// * Email: support@paymentcms.ir                                          *
// * phone: 09361090413                                                    *
// *                                                                       *
// *                                                                       *
// *************************************************************************


namespace paymentCms\model;


use paymentCms\component\model ;

class configuration extends model implements modelInterFace  {

	private $primaryKey = ['keyWord','app'];
	private $primaryKeyShouldNotInsertOrUpdate = null;
	private $keyWord ;
	private $value ;
	private $app ;


	public function deleteApp($app){
		return self::deleteOnFullQuery($app , 'app = ? ');
	}
	public function setFromArray($result) {
		$this->keyWord = $result['keyWord'];
		$this->value = $result['value'];
		$this->app = $result['app'];
	}


	public function returnAsArray( ) {
		$array['keyWord'] = $this->keyWord;
		$array['value'] = $this->value;
		$array['app'] = $this->app;
		return $array ;
	}


	/**
	 * @return string
	 */
	public function getPrimaryKey() {
		return $this->primaryKey;
	}

	/**
	 * @return string
	 */
	public function getPrimaryKeyShouldNotInsertOrUpdate() {
		return $this->primaryKeyShouldNotInsertOrUpdate;
	}

	/**
	 * @return mixed
	 */
	public function getKeyWord() {
		return $this->keyWord;
	}

	/**
	 * @param mixed $keyWord
	 */
	public function setKeyWord($keyWord) {
		$this->keyWord = $keyWord;
	}

	/**
	 * @return mixed
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @param mixed $value
	 */
	public function setValue($value) {
		$this->value = $value;
	}

	/**
	 * @return mixed
	 */
	public function getApp() {
		return $this->app;
	}

	/**
	 * @param mixed $app
	 */
	public function setApp($app) {
		$this->app = $app;
	}


}
