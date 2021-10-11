<?php


namespace App\contract\model;
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


use paymentCms\component\browser;
use paymentCms\component\model;
use paymentCms\component\security;
use paymentCms\model\modelInterFace ;

class contracts extends model implements modelInterFace {

	private $primaryKey = ['contractId'];
	private $primaryKeyShouldNotInsertOrUpdate = 'contractId';
	private $contractId ;
	private $startDate ;
	private $endDate ;
	private $userId ;
	private $contractor ;
	private $contractGroup ;

	public function setFromArray($result) {
		$this->contractId = $result['contractId'] ;
		$this->startDate = $result['startDate'] ;
		$this->endDate = $result['endDate'] ;
		$this->userId = $result['userId'] ;
		$this->contractor = $result['contractor'] ;
		$this->contractGroup = $result['contractGroup'] ;
	}

	public function returnAsArray( ) {
		$array['contractId'] = $this->contractId ;
		$array['startDate'] = $this->startDate ;
		$array['endDate'] = $this->endDate ;
		$array['userId'] = $this->userId ;
		$array['contractor'] = $this->contractor ;
		$array['contractGroup'] = $this->contractGroup ;
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
	public function getContractId() {
		return $this->contractId;
	}

	/**
	 * @param mixed $contractId
	 */
	public function setContractId($contractId) {
		$this->contractId = $contractId;
	}

	/**
	 * @return mixed
	 */
	public function getStartDate() {
		return $this->startDate;
	}

	/**
	 * @return mixed
	 */
	public function getContractDays() {
		$date1=date_create($this->getStartDate());
		$date2=date_create($this->getEndDate());
		$diff=date_diff($date1,$date2);
//		show($diff);
		return $diff->days;
	}
	/**
	 * @return mixed
	 */
	public function getExpireDays() {
		$date1=date_create(date('Y-m-d 00:00:00'));
		$date2=date_create($this->getEndDate());
		$diff=date_diff($date1,$date2);
//		show($diff);
		return $diff->days;
	}

	/**
	 * @param mixed $startDate
	 */
	public function setStartDate($startDate) {
		$this->startDate = $startDate;
	}

	/**
	 * @return mixed
	 */
	public function getEndDate() {
		return $this->endDate;
	}

	/**
	 * @param mixed $endDate
	 */
	public function setEndDate($endDate) {
		$this->endDate = $endDate;
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
	public function getContractor() {
		return $this->contractor;
	}

	/**
	 * @param mixed $contractor
	 */
	public function setContractor($contractor) {
		$this->contractor = $contractor;
	}

	/**
	 * @return mixed
	 */
	public function getContractGroup() {
		return $this->contractGroup;
	}

	/**
	 * @param mixed $contractGroup
	 */
	public function setContractGroup($contractGroup) {
		$this->contractGroup = $contractGroup;
	}

}
