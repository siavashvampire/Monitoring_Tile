<?php


namespace App\wallet\model;
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




use paymentCms\component\model;
use paymentCms\model\modelInterFace ;

class user_wallet extends model implements modelInterFace {

	private $primaryKey = 'userId';
	private $primaryKeyShouldNotInsertOrUpdate = null;
	private $userId ;
	private $affiliatedId ;
	private $wallet ;
	private $bankFName ;
	private $bankLName ;
	private $bankName ;
	private $shabaNumber ;

	public function setFromArray($result) {
		$this->userId = $result['userId'] ;
		$this->affiliatedId = $result['affiliatedId'] ;
		$this->wallet = $result['wallet'] ;
		$this->bankFName = $result['bankFName'] ;
		$this->bankLName = $result['bankLName'] ;
		$this->bankName = $result['bankName'] ;
		$this->shabaNumber = $result['shabaNumber'] ;
	}

	public function returnAsArray( ) {
		$array['userId'] = $this->userId ;
		$array['affiliatedId'] = $this->affiliatedId ;
		$array['wallet'] = $this->wallet ;
		$array['bankFName'] = $this->bankFName ;
		$array['bankLName'] = $this->bankLName ;
		$array['bankName'] = $this->bankName ;
		$array['shabaNumber'] = $this->shabaNumber ;
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
	public function getUserId() {
		return $this->userId;
	}

	/**
	 * @param mixed $userId
	 */
	public function setUserId($userId) {
		$this->userId = $userId;
	}

	/**
	 * @return mixed
	 */
	public function getAffiliatedId() {
		return $this->affiliatedId;
	}

	/**
	 * @param mixed $affiliatedId
	 */
	public function setAffiliatedId($affiliatedId) {
		$this->affiliatedId = $affiliatedId;
	}

	/**
	 * @return mixed
	 */
	public function getWallet() {
		return $this->wallet;
	}

	/**
	 * @param mixed $wallet
	 */
	public function setWallet($wallet) {
		$this->wallet = $wallet;
	}

	/**
	 * @return mixed
	 */
	public function getBankFName() {
		return $this->bankFName;
	}

	/**
	 * @param mixed $bankFName
	 */
	public function setBankFName($bankFName) {
		$this->bankFName = $bankFName;
	}

	/**
	 * @return mixed
	 */
	public function getBankLName() {
		return $this->bankLName;
	}

	/**
	 * @param mixed $bankLName
	 */
	public function setBankLName($bankLName) {
		$this->bankLName = $bankLName;
	}

	/**
	 * @param mixed $bankName
	 */
	public function setBankName($bankName) {
		$this->bankName = $bankName;
	}

	/**
	 * @return mixed
	 */
	public function getBankName() {
		return $this->bankName;
	}

	/**
	 * @return mixed
	 */
	public function getShabaNumber() {
		return $this->shabaNumber;
	}

	/**
	 * @param mixed $shabaNumber
	 */
	public function setShabaNumber($shabaNumber) {
		$this->shabaNumber = $shabaNumber;
	}


}
