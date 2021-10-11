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

class wallet_action extends model implements modelInterFace {

	private $primaryKey = 'actionId';
	private $primaryKeyShouldNotInsertOrUpdate = 'actionId';
	private $actionId ;
	private $userId ;
	private $invoiceId ;
	private $status ;
	private $price ;
	private $dateAction ;
	private $timeAction ;
	private $description ;
	private $ip ;

	public function setFromArray($result) {
		$this->actionId = $result['actionId'] ;
		$this->userId = $result['userId'] ;
		$this->invoiceId = $result['invoiceId'] ;
		$this->status = $result['status'] ;
		$this->price = $result['price'] ;
		$this->dateAction = $result['dateAction'] ;
		$this->timeAction = $result['timeAction'] ;
		$this->description = $result['description'] ;
		$this->ip = $result['ip'] ;
	}

	public function returnAsArray( ) {
		$array['actionId'] = $this->actionId ;
		$array['userId'] = $this->userId ;
		$array['invoiceId'] = $this->invoiceId ;
		$array['status'] = $this->status ;
		$array['price'] = $this->price ;
		$array['dateAction'] = $this->dateAction ;
		$array['timeAction'] = $this->timeAction ;
		$array['description'] = $this->description ;
		$array['ip'] = $this->ip ;
		return $array ;
	}

	/**
	 * @return array
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
	public function getActionId() {
		return $this->actionId;
	}

	/**
	 * @param mixed $actionId
	 */
	public function setActionId($actionId) {
		$this->actionId = $actionId;
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
	public function getInvoiceId() {
		return $this->invoiceId;
	}

	/**
	 * @param mixed $invoiceId
	 */
	public function setInvoiceId($invoiceId) {
		$this->invoiceId = $invoiceId;
	}

	/**
	 * @return mixed
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @param mixed $status
	 */
	public function setStatus($status) {
		$this->status = $status;
	}

	/**
	 * @return mixed
	 */
	public function getPrice() {
		return $this->price;
	}

	/**
	 * @param mixed $price
	 */
	public function setPrice($price) {
		$this->price = $price;
	}

	/**
	 * @return mixed
	 */
	public function getDateAction() {
		return $this->dateAction;
	}

	/**
	 * @param mixed $dateAction
	 */
	public function setDateAction($dateAction) {
		$this->dateAction = $dateAction;
	}

	/**
	 * @return mixed
	 */
	public function getTimeAction() {
		return $this->timeAction;
	}

	/**
	 * @param mixed $timeAction
	 */
	public function setTimeAction($timeAction) {
		$this->timeAction = $timeAction;
	}

	/**
	 * @return mixed
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param mixed $description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * @return mixed
	 */
	public function getIp() {
		return $this->ip;
	}

	/**
	 * @param mixed $ip
	 */
	public function setIp($ip) {
		$this->ip = $ip;
	}


}
